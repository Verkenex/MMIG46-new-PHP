<?php

namespace MMIG46\Controllers;

use MMIG46\Core\DB;
use MMIG46\Core\Security;
use MMIG46\Core\Session;
use MMIG46\Core\View;
use MMIG46\Models\Member;
use MMIG46\Models\MembershipApplication;
use MMIG46\Models\MailOutbox;
use MMIG46\Models\NewsItem;
use MMIG46\Models\TravelItem;
use MMIG46\Models\User;
use MMIG46\Models\ContactRequest;
use MMIG46\Models\TrainingRegistration;
use MMIG46\Services\MembershipWorkflow;
use MMIG46\Services\OutboxDelivery;
use MMIG46\Core\Seo;

class AdminController
{
    private function guard(): void
    {
        Security::requireRole(['admin']);
    }

    private function fail(string $message): string
    {
        Session::flash('error', $message);
        header('Location:/verwaltung');
        exit;
    }

    private function cleanText(string $value): string
    {
        return trim($value);
    }

    private function required(string $value, string $label): string
    {
        $value = trim($value);

        if ($value === '') {
            $this->fail($label . ' darf nicht leer sein.');
        }

        return $value;
    }

    private function validEmailOrNull(string $value): ?string
    {
        $value = trim($value);

        if ($value === '') {
            return null;
        }

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->fail('E-Mail-Adresse ist ungültig.');
        }

        return $value;
    }

    private function requiredEmail(string $value): string
    {
        $value = trim($value);

        if ($value === '') {
            $this->fail('E-Mail-Adresse darf nicht leer sein.');
        }

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->fail('E-Mail-Adresse ist ungültig.');
        }

        return $value;
    }

    private function cleanSlug(string $value): string
    {
        $value = trim($value);
        $value = mb_strtolower($value, 'UTF-8');

        $map = [
            'ä' => 'ae',
            'ö' => 'oe',
            'ü' => 'ue',
            'ß' => 'ss',
        ];

        $value = strtr($value, $map);
        $value = preg_replace('/[^a-z0-9]+/', '-', $value);
        $value = trim((string) $value, '-');

        return $value;
    }

    private function requiredSlug(string $slug, string $fallbackTitle): string
    {
        $slug = $this->cleanSlug($slug);

        if ($slug === '') {
            $slug = $this->cleanSlug($fallbackTitle);
        }

        if ($slug === '') {
            $this->fail('Slug darf nicht leer sein.');
        }

        if (strlen($slug) > 100) {
            $this->fail('Slug darf maximal 100 Zeichen lang sein.');
        }

        return $slug;
    }

    private function validLang(string $value): string
    {
        $value = strtolower(trim($value));

        if (!in_array($value, ['de', 'en'], true)) {
            return 'de';
        }

        return $value;
    }

    private function validDateOrNull(string $value, string $label): ?string
    {
        $value = trim($value);

        if ($value === '') {
            return null;
        }

        $date = \DateTime::createFromFormat('Y-m-d', $value);
        $errors = \DateTime::getLastErrors();

        if (!$date || ($errors !== false && ($errors['warning_count'] > 0 || $errors['error_count'] > 0))) {
            $this->fail($label . ' ist ungültig. Erwartetes Format: YYYY-MM-DD.');
        }

        return $date->format('Y-m-d');
    }

    private function validDateTimeOrNow(string $value): string
    {
        $value = trim($value);

        if ($value === '') {
            return date('Y-m-d H:i:s');
        }

        $date = \DateTime::createFromFormat('Y-m-d H:i:s', $value);
        $errors = \DateTime::getLastErrors();

        if (!$date || ($errors !== false && ($errors['warning_count'] > 0 || $errors['error_count'] > 0))) {
            $date = \DateTime::createFromFormat('Y-m-d\TH:i', $value);
            $errors = \DateTime::getLastErrors();
        }

        if (!$date || ($errors !== false && ($errors['warning_count'] > 0 || $errors['error_count'] > 0))) {
            $this->fail('Veröffentlichungsdatum ist ungültig.');
        }

        return $date->format('Y-m-d H:i:s');
    }

    private function validUrlOrNull(string $value, string $label): ?string
    {
        $value = trim($value);

        if ($value === '') {
            return null;
        }

        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            $this->fail($label . ' ist keine gültige URL.');
        }

        return $value;
    }

    private function cleanNullablePath(string $value): ?string
    {
        $value = trim($value);

        return $value === '' ? null : $value;
    }

    public function dashboard(): string
    {
        $this->guard();

        $applications = MembershipApplication::all();
        $outbox = [];
        foreach ($applications as $application) {
            $outbox[(int)$application['id']] = MailOutbox::forApplication((int)$application['id']);
        }

        $users = User::all();
        $userOutbox = [];
        foreach ($users as $user) $userOutbox[(int)$user['id']] = MailOutbox::forUser((int)$user['id']);
        return View::render('admin/dashboard', [
            'users' => $users,
            'members' => Member::all(),
            'news' => NewsItem::all(200),
            'travels' => TravelItem::all(200),
            'applications' => $applications,
            'applicationOutbox' => $outbox,
            'userOutbox' => $userOutbox,
            'contactRequests' => ContactRequest::all(),
            'trainingRegistrations' => TrainingRegistration::all(),
        ]);
    }

    public function storeUser(): string {
        $this->guard();
        Security::verifyCsrf();

        $name = $this->required((string) ($_POST['name'] ?? ''), 'Name');
        $email = $this->requiredEmail((string) ($_POST['email'] ?? ''));

        $role = strtolower(trim((string) ($_POST['role'] ?? 'member')));
        $allowedRoles = ['admin', 'member'];

        if (!in_array($role, $allowedRoles, true)) {
            Session::flash('error', 'Ungültige Benutzerrolle.');
            header('Location:/verwaltung');
            exit;
        }

        $password = (string) ($_POST['password'] ?? '');

        if (strlen($password) < 12) {
            Session::flash('error', 'Passwort muss mindestens 12 Zeichen haben.');
            header('Location:/verwaltung');
            exit;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        try {
            DB::pdo()
                ->prepare('INSERT INTO users(name, email, password_hash, role, email_verified_at) VALUES (?, ?, ?, ?, ?)')
                ->execute([
                    $name,
                    $email,
                    $hash,
                    $role,
                    date('Y-m-d H:i:s'),
                ]);

            Session::flash('success', 'Benutzer wurde angelegt.');
        } catch (\PDOException $e) {
            Session::flash('error', 'Benutzer konnte nicht angelegt werden. Möglicherweise existiert die E-Mail-Adresse bereits.');
        }

        header('Location:/verwaltung');
        exit;
    }

    public function storeMember(): string
    {
        $this->guard();
        Security::verifyCsrf();

        DB::pdo()
            ->prepare(
                'INSERT INTO members(name, email, aircraft, base, role_label, member_type, website,
                    invoice_name, street, postal_code, city, country, phone, internal_notes, is_public, public_consent_at, sort_order)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
            )
            ->execute([
                trim($_POST['name'] ?? ''),
                trim($_POST['email'] ?? ''),
                trim($_POST['aircraft'] ?? ''),
                trim($_POST['base'] ?? ''),
                trim($_POST['role_label'] ?? ''),
                trim($_POST['member_type'] ?? ''),
                trim($_POST['website'] ?? ''),
                trim($_POST['invoice_name'] ?? ''),
                trim($_POST['street'] ?? ''),
                trim($_POST['postal_code'] ?? ''),
                trim($_POST['city'] ?? ''),
                trim($_POST['country'] ?? ''),
                trim($_POST['phone'] ?? ''),
                trim($_POST['internal_notes'] ?? ''),
                $public = isset($_POST['is_public']) && isset($_POST['public_consent_confirmed']) ? 1 : 0,
                $public ? date('Y-m-d H:i:s') : null,
                (int)($_POST['sort_order'] ?? 100),
            ]);

        header('Location:/verwaltung');
        exit;
    }

    public function updateMember(string $id): string
    {
        $this->guard();
        Security::verifyCsrf();

        $memberId = (int) $id;
        if ($memberId <= 0) {
            return $this->fail('Ungültiges Mitglied.');
        }

        $name = $this->required((string) ($_POST['name'] ?? ''), 'Name');
        $email = $this->validEmailOrNull((string) ($_POST['email'] ?? ''));
        $website = $this->validUrlOrNull((string) ($_POST['website'] ?? ''), 'Website');

        $statement = DB::pdo()->prepare(
            'UPDATE members SET name = ?, email = ?, aircraft = ?, base = ?, role_label = ?,
                member_type = ?, website = ?, invoice_name = ?, street = ?, postal_code = ?,
                city = ?, country = ?, phone = ?, internal_notes = ?, is_public = ?,
                public_consent_at = CASE WHEN ? = 1 THEN COALESCE(public_consent_at, NOW()) ELSE NULL END,
                sort_order = ?
             WHERE id = ?'
        );
        $statement->execute([
            $name,
            $email,
            trim((string) ($_POST['aircraft'] ?? '')),
            trim((string) ($_POST['base'] ?? '')),
            trim((string) ($_POST['role_label'] ?? '')),
            trim((string) ($_POST['member_type'] ?? '')),
            $website,
            trim((string) ($_POST['invoice_name'] ?? '')),
            trim((string) ($_POST['street'] ?? '')),
            trim((string) ($_POST['postal_code'] ?? '')),
            trim((string) ($_POST['city'] ?? '')),
            trim((string) ($_POST['country'] ?? '')),
            trim((string) ($_POST['phone'] ?? '')),
            trim((string) ($_POST['internal_notes'] ?? '')),
            $public = isset($_POST['is_public']) && isset($_POST['public_consent_confirmed']) ? 1 : 0,
            $public,
            (int) ($_POST['sort_order'] ?? 100),
            $memberId,
        ]);

        Session::flash('success', 'Mitgliedsdaten wurden aktualisiert.');
        header('Location:/verwaltung');
        exit;
    }
    public function storeNews(): string
    {
        $this->guard();
        Security::verifyCsrf();

        $title = $this->required((string) ($_POST['title'] ?? ''), 'Titel');
        $slug = $this->requiredSlug((string) ($_POST['slug'] ?? ''), $title);
        $lang = $this->validLang((string) ($_POST['lang'] ?? 'de'));

        $category = $this->cleanText((string) ($_POST['category'] ?? ''));
        $imagePath = $this->cleanNullablePath((string) ($_POST['image_path'] ?? ''));
        $commentCount = max(0, (int) ($_POST['comment_count'] ?? 0));
        $teaser = $this->cleanText((string) ($_POST['teaser'] ?? ''));
        $body = $this->required((string) ($_POST['body'] ?? ''), 'Text');
        $publishedAt = $this->validDateTimeOrNow((string) ($_POST['published_at'] ?? ''));
        $isPublished = isset($_POST['is_published']) ? 1 : 0;

        DB::pdo()
            ->prepare(
                'INSERT INTO news_items
                (lang, title, slug, category, image_path, comment_count, teaser, body, published_at, is_published)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE
                title = VALUES(title),
                category = VALUES(category),
                image_path = VALUES(image_path),
                comment_count = VALUES(comment_count),
                teaser = VALUES(teaser),
                body = VALUES(body),
                published_at = VALUES(published_at),
                is_published = VALUES(is_published)'
            )
            ->execute([
                $lang,
                $title,
                $slug,
                $category !== '' ? $category : null,
                $imagePath,
                $commentCount,
                $teaser !== '' ? $teaser : null,
                $body,
                $publishedAt,
                $isPublished,
            ]);

        Session::flash('success', 'News wurde gespeichert.');
        header('Location:/verwaltung');
        exit;
    }

public function storeTravel(): string
{
    $this->guard();
    Security::verifyCsrf();

    $title = $this->required((string) ($_POST['title'] ?? ''), 'Titel');
    $slug = $this->requiredSlug((string) ($_POST['slug'] ?? ''), $title);
    $lang = $this->validLang((string) ($_POST['lang'] ?? 'de'));

    $imagePath = $this->cleanNullablePath((string) ($_POST['image_path'] ?? ''));
    $location = $this->cleanText((string) ($_POST['location'] ?? ''));
    $startsOn = $this->validDateOrNull((string) ($_POST['starts_on'] ?? ''), 'Startdatum');
    $endsOn = $this->validDateOrNull((string) ($_POST['ends_on'] ?? ''), 'Enddatum');

    if ($startsOn !== null && $endsOn !== null && $endsOn < $startsOn) {
        $this->fail('Enddatum darf nicht vor dem Startdatum liegen.');
    }

    $status = (string) ($_POST['status'] ?? 'planned');

    if (!in_array($status, ['planned', 'completed', 'archived'], true)) {
        $status = 'planned';
    }

    $teaser = $this->cleanText((string) ($_POST['teaser'] ?? ''));
    $ctaLabel = $this->cleanText((string) ($_POST['cta_label'] ?? ''));
    $legacyPdfUrl = $this->validUrlOrNull((string) ($_POST['legacy_pdf_url'] ?? ''), 'Legacy-PDF-URL');
    $legacyPdfPath = $this->cleanNullablePath((string) ($_POST['legacy_pdf_path'] ?? ''));
    $body = $this->required((string) ($_POST['body'] ?? ''), 'Text');
    $isPublished = isset($_POST['is_published']) ? 1 : 0;

    DB::pdo()
        ->prepare(
            'INSERT INTO travel_items
             (lang, title, slug, image_path, location, starts_on, ends_on, status, teaser, cta_label, legacy_pdf_url, legacy_pdf_path, body, is_published)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
             ON DUPLICATE KEY UPDATE
             title = VALUES(title),
             image_path = VALUES(image_path),
             location = VALUES(location),
             starts_on = VALUES(starts_on),
             ends_on = VALUES(ends_on),
             status = VALUES(status),
             teaser = VALUES(teaser),
             cta_label = VALUES(cta_label),
             legacy_pdf_url = VALUES(legacy_pdf_url),
             legacy_pdf_path = VALUES(legacy_pdf_path),
             body = VALUES(body),
             is_published = VALUES(is_published)'
        )
        ->execute([
            $lang,
            $title,
            $slug,
            $imagePath,
            $location !== '' ? $location : null,
            $startsOn,
            $endsOn,
            $status,
            $teaser !== '' ? $teaser : null,
            $ctaLabel !== '' ? $ctaLabel : null,
            $legacyPdfUrl,
            $legacyPdfPath,
            $body,
            $isPublished,
        ]);

    Session::flash('success', 'Reise wurde gespeichert.');
    header('Location:/verwaltung');
    exit;
}

    public function approveApplication(string $id): string
    {
        $this->guard(); Security::verifyCsrf();
        try {
            MembershipWorkflow::approve((int)$id,(int)$_SESSION['user']['id'],isset($_POST['board_confirmed']),isset($_POST['payment_confirmed']),isset($_POST['link_existing_user']));
            foreach (MailOutbox::forApplication((int)$id) as $message) OutboxDelivery::deliver((int)$message['id']);
            Session::flash('success','Antrag wurde freigegeben; der Passwort-Link wurde über die Outbox verarbeitet.');
        } catch (\Throwable $e) { Session::flash('error','Freigabe nicht möglich: '.$e->getMessage()); }
        header('Location:/verwaltung'); exit;
    }

    public function rejectApplication(string $id): string
    {
        $this->guard(); Security::verifyCsrf();
        if (($_POST['confirmation'] ?? '') !== 'ABLEHNEN') return $this->fail('Serverseitige Bestätigung ABLEHNEN fehlt.');
        try { MembershipWorkflow::reject((int)$id,(int)$_SESSION['user']['id'],($_POST['decision']??'')==='cancelled'?'cancelled':'rejected'); Session::flash('success','Antrag wurde abgelehnt/storniert.'); }
        catch (\Throwable $e) { Session::flash('error','Vorgang fehlgeschlagen: '.$e->getMessage()); }
        header('Location:/verwaltung'); exit;
    }

    public function retryOutbox(string $id): string
    {
        $this->guard(); Security::verifyCsrf();
        $sent = OutboxDelivery::deliver((int)$id);
        Session::flash($sent ? 'success' : 'error', $sent ? 'E-Mail wurde versendet.' : 'E-Mail-Versand ist erneut fehlgeschlagen.');
        header('Location:/verwaltung'); exit;
    }

    public function markContactHandled(string $id): string
    {
        $this->guard();
        Security::verifyCsrf();
        ContactRequest::markHandled((int) $id);
        Session::flash('success', 'Kontaktanfrage wurde als bearbeitet markiert.');
        header('Location:/verwaltung');
        exit;
    }

    public function updateUser(string $id): string
    {
        $this->guard(); Security::verifyCsrf(); $userId=(int)$id;
        $name=$this->required((string)($_POST['name']??''),'Name'); $email=$this->requiredEmail((string)($_POST['email']??''));
        $role=(string)($_POST['role']??'member'); if(!in_array($role,['admin','moderator','member','guest'],true)) return $this->fail('Ungültige Rolle.');
        $user=User::find($userId); if(!$user) return $this->fail('Benutzer nicht gefunden.');
        if($user['role']==='admin' && $role!=='admin' && $this->adminCount()<=1) return $this->fail('Der letzte Administrator darf nicht herabgestuft werden.');
        try { DB::pdo()->prepare('UPDATE users SET name=?,email=?,role=? WHERE id=?')->execute([$name,$email,$role,$userId]); Session::flash('success','Benutzer wurde aktualisiert.'); }
        catch(\PDOException $e){ Session::flash('error','Benutzer konnte nicht aktualisiert werden; die E-Mail ist möglicherweise vergeben.'); }
        header('Location:/verwaltung'); exit;
    }

    public function resetUserPassword(string $id): string
    {
        $this->guard(); Security::verifyCsrf(); $user=User::find((int)$id); if(!$user) return $this->fail('Benutzer nicht gefunden.');
        $token=bin2hex(random_bytes(32)); $pdo=DB::pdo(); $pdo->beginTransaction();
        try { $pdo->prepare('UPDATE users SET reset_token_hash=?,reset_expires_at=? WHERE id=?')->execute([hash('sha256',$token),date('Y-m-d H:i:s',time()+86400),(int)$id]);
            MailOutbox::queueInTransaction('password_link',(string)$user['email'],'MMIG46-Passwort zurücksetzen',['url'=>Seo::absoluteUrl('/passwort-setzen?token='.rawurlencode($token)),'language'=>'de'],'user',(int)$id,'password-reset-'.(int)$id.'-'.hash('sha256',$token)); $outboxId=(int)$pdo->lastInsertId(); $pdo->commit();
            $sent=OutboxDelivery::deliver($outboxId); Session::flash($sent?'success':'error',$sent?'Passwort-Reset-Link wurde versendet.':'Passwort-Reset-Link wurde gespeichert; Versand fehlgeschlagen und kann erneut versucht werden.');
        } catch(\Throwable $e){if($pdo->inTransaction())$pdo->rollBack();Session::flash('error','Reset fehlgeschlagen: '.$e->getMessage());}
        header('Location:/verwaltung'); exit;
    }

    public function deleteUser(string $id): string
    {
        $this->guard(); Security::verifyCsrf(); $userId=(int)$id;
        if(($_POST['confirmation']??'')!=='BENUTZER LÖSCHEN') return $this->fail('Serverseitige Löschbestätigung fehlt.');
        if($userId===(int)$_SESSION['user']['id']) return $this->fail('Selbstlöschung ist nicht erlaubt.');
        $user=User::find($userId); if(!$user) return $this->fail('Benutzer nicht gefunden.');
        if($user['role']==='admin' && $this->adminCount()<=1) return $this->fail('Der letzte Administrator darf nicht gelöscht werden.');
        $stmt=DB::pdo()->prepare('SELECT (SELECT COUNT(*) FROM forum_topics WHERE user_id=?)+(SELECT COUNT(*) FROM forum_posts WHERE user_id=?)+(SELECT COUNT(*) FROM members WHERE user_id=?)'); $stmt->execute([$userId,$userId,$userId]);
        if((int)$stmt->fetchColumn()>0) return $this->fail('Löschen gesperrt: Es bestehen Forum- oder Mitgliedsverknüpfungen.');
        $stmt=DB::pdo()->prepare('SELECT COUNT(*) FROM invoices WHERE created_by=? OR updated_by=? OR finalized_by=? OR sent_by=? OR paid_by=? OR cancelled_by=?');
        $stmt->execute([$userId,$userId,$userId,$userId,$userId,$userId]);
        if((int)$stmt->fetchColumn()>0) return $this->fail('Löschen gesperrt: Der Benutzer ist mit mindestens einer Rechnung verknüpft.');
        try { DB::pdo()->prepare('DELETE FROM users WHERE id=?')->execute([$userId]); Session::flash('success','Benutzer wurde gelöscht.'); }
        catch(\PDOException $e) { return $this->fail('Benutzer konnte wegen bestehender Datenverknüpfungen nicht gelöscht werden.'); }
        header('Location:/verwaltung'); exit;
    }

    public function deleteMember(string $id): string
    {
        $this->guard(); Security::verifyCsrf(); $memberId=(int)$id;
        if(($_POST['confirmation']??'')!=='MITGLIED LÖSCHEN') return $this->fail('Serverseitige Löschbestätigung fehlt.');
        $stmt=DB::pdo()->prepare('SELECT user_id,application_id FROM members WHERE id=?');$stmt->execute([$memberId]);$links=$stmt->fetch();if(!$links)return $this->fail('Mitglied nicht gefunden.');
        if(!empty($links['application_id'])) return $this->fail('Mitglied ist mit einem Antrag verknüpft. Antrag zuerst nachvollziehbar bearbeiten; Benutzer wird nie automatisch gelöscht.');
        DB::pdo()->prepare('DELETE FROM members WHERE id=?')->execute([$memberId]);Session::flash('success','Mitglied wurde gelöscht; ein Benutzerkonto blieb unberührt.');header('Location:/verwaltung');exit;
    }

    private function adminCount(): int { return (int)DB::pdo()->query("SELECT COUNT(*) FROM users WHERE role='admin'")->fetchColumn(); }
}
