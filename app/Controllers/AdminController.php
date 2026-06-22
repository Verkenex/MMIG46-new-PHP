<?php

namespace MMIG46\Controllers;

use MMIG46\Core\DB;
use MMIG46\Core\Security;
use MMIG46\Core\Session;
use MMIG46\Core\View;
use MMIG46\Models\Member;
use MMIG46\Models\NewsItem;
use MMIG46\Models\TravelItem;
use MMIG46\Models\User;

class AdminController
{
    private function guard(): void
    {
        if (empty($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
            header('Location:/login');
            exit;
        }
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

        return View::render('admin/dashboard', [
            'users' => User::all(),
            'members' => Member::all(),
            'news' => NewsItem::all(200),
            'travels' => TravelItem::published(),
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
                'INSERT INTO members(name, email, aircraft, base, role_label, member_type, website, is_public, sort_order)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
            )
            ->execute([
                trim($_POST['name'] ?? ''),
                trim($_POST['email'] ?? ''),
                trim($_POST['aircraft'] ?? ''),
                trim($_POST['base'] ?? ''),
                trim($_POST['role_label'] ?? ''),
                trim($_POST['member_type'] ?? ''),
                trim($_POST['website'] ?? ''),
                isset($_POST['is_public']) ? 1 : 0,
                (int)($_POST['sort_order'] ?? 100),
            ]);

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
}