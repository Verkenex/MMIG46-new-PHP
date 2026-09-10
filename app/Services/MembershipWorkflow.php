<?php
declare(strict_types=1);
namespace MMIG46\Services;
use MMIG46\Core\DB;
use MMIG46\Core\Seo;
use MMIG46\Models\MailOutbox;

final class MembershipWorkflow
{
    public static function approve(int $applicationId, int $adminId, bool $board, bool $payment, bool $linkExisting = false): int
    {
        if (!$board || !$payment) throw new \InvalidArgumentException('Vorstandsaufnahme und Zahlungseingang müssen bestätigt werden.');
        $pdo=DB::pdo(); $pdo->beginTransaction();
        try {
            $stmt=$pdo->prepare('SELECT * FROM membership_applications WHERE id=? FOR UPDATE'); $stmt->execute([$applicationId]); $app=$stmt->fetch();
            if (!$app || !in_array($app['status'], ['pending','manual_review'], true)) throw new \RuntimeException('Antrag ist nicht freigabefähig.');
            $stmt=$pdo->prepare('SELECT * FROM members WHERE application_id=? FOR UPDATE'); $stmt->execute([$applicationId]); $member=$stmt->fetch();
            if (!$member || $member['status'] !== 'pending') throw new \RuntimeException('Pending-Mitglied fehlt oder ist nicht freigabefähig.');
            $email=strtolower(trim((string)$app['private_email']));
            $stmt=$pdo->prepare('SELECT * FROM users WHERE LOWER(email)=? LIMIT 1 FOR UPDATE'); $stmt->execute([$email]); $existingUser=$stmt->fetch();
            $token=bin2hex(random_bytes(32)); $expires=date('Y-m-d H:i:s', time()+86400);
            if ($existingUser) {
                if (!$linkExisting) throw new \RuntimeException('Zu dieser E-Mail existiert ein Benutzer. Die ausdrückliche Verknüpfung wurde nicht bestätigt.');
                $stmt=$pdo->prepare('SELECT id FROM members WHERE user_id=? AND id<>? LIMIT 1'); $stmt->execute([$existingUser['id'],$member['id']]);
                if ($stmt->fetchColumn()) throw new \RuntimeException('Der Benutzer ist bereits einem anderen Mitglied zugeordnet. Keine automatische Zusammenführung.');
                $userId=(int)$existingUser['id'];
                $newRole=in_array($existingUser['role'],['admin','moderator','member'],true)?$existingUser['role']:'member';
                $pdo->prepare('UPDATE users SET role=?,reset_token_hash=?,reset_expires_at=? WHERE id=?')->execute([$newRole,hash('sha256',$token),$expires,$userId]);
            } else {
                $hash=password_hash(bin2hex(random_bytes(32)), PASSWORD_DEFAULT);
                $pdo->prepare("INSERT INTO users(name,email,password_hash,role,reset_token_hash,reset_expires_at) VALUES (?,?,?,'member',?,?)")->execute([trim($app['first_name'].' '.$app['last_name']),$email,$hash,hash('sha256',$token),$expires]);
                $userId=(int)$pdo->lastInsertId();
            }
            $now=date('Y-m-d H:i:s');
            $pdo->prepare("UPDATE members SET user_id=?,status='active',is_public=0 WHERE id=?")->execute([$userId,$member['id']]);
            $pdo->prepare("UPDATE membership_applications SET status='approved',board_confirmed_at=?,board_confirmed_by=?,payment_confirmed_at=?,payment_confirmed_by=?,decided_at=?,decided_by=? WHERE id=?")
                ->execute([$now,$adminId,$now,$adminId,$now,$adminId,$applicationId]);
            $url=Seo::absoluteUrl('/passwort-setzen?token=' . rawurlencode($token));
            MailOutbox::queueInTransaction('password_link',$email,$app['language']==='en'?'Set your MMIG46 password':'Ihr MMIG46-Passwort festlegen',['url'=>$url,'language'=>$app['language']],'membership_application',$applicationId,'approval-password-' . $applicationId);
            $pdo->commit(); return $userId;
        } catch (\Throwable $e) { if ($pdo->inTransaction()) $pdo->rollBack(); throw $e; }
    }

    public static function reject(int $applicationId,int $adminId,string $status='rejected'): void
    {
        if (!in_array($status,['rejected','cancelled'],true)) throw new \InvalidArgumentException('Ungültiger Status.');
        $pdo=DB::pdo(); $pdo->beginTransaction();
        try {
            $stmt=$pdo->prepare('SELECT status FROM membership_applications WHERE id=? FOR UPDATE'); $stmt->execute([$applicationId]); $current=$stmt->fetchColumn();
            if (!$current || $current==='approved') throw new \RuntimeException('Freigegebene Anträge können hier nicht abgelehnt werden.');
            $now=date('Y-m-d H:i:s');
            $pdo->prepare('UPDATE membership_applications SET status=?,decided_at=?,decided_by=? WHERE id=?')->execute([$status,$now,$adminId,$applicationId]);
            $pdo->prepare("UPDATE members SET status='rejected',is_public=0 WHERE application_id=? AND status='pending'")->execute([$applicationId]);
            $pdo->commit();
        } catch (\Throwable $e) { if ($pdo->inTransaction()) $pdo->rollBack(); throw $e; }
    }
}
