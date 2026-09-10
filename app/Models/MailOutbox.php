<?php
declare(strict_types=1);
namespace MMIG46\Models;
use MMIG46\Core\DB;

final class MailOutbox
{
    public static function queueInTransaction(string $type,string $recipient,string $subject,array $payload,?string $relatedType,?int $relatedId,string $dedupeKey): void
    {
        DB::pdo()->prepare('INSERT INTO mail_outbox (message_type,recipient,subject,payload_json,related_type,related_id,dedupe_key) VALUES (?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE dedupe_key=VALUES(dedupe_key)')
            ->execute([$type,$recipient,$subject,json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR),$relatedType,$relatedId,$dedupeKey]);
    }
    public static function forApplication(int $id): array
    {
        $stmt=DB::pdo()->prepare("SELECT * FROM mail_outbox WHERE related_type='membership_application' AND related_id=? ORDER BY id"); $stmt->execute([$id]); return $stmt->fetchAll();
    }
    public static function forUser(int $id): array
    {
        $stmt=DB::pdo()->prepare("SELECT * FROM mail_outbox WHERE related_type='user' AND related_id=? ORDER BY id DESC"); $stmt->execute([$id]); return $stmt->fetchAll();
    }
    public static function claim(int $id): ?array
    {
        $pdo=DB::pdo(); $pdo->beginTransaction();
        try { $stmt=$pdo->prepare('SELECT * FROM mail_outbox WHERE id=? FOR UPDATE'); $stmt->execute([$id]); $row=$stmt->fetch();
            if (!$row || $row['status']==='sent') { $pdo->commit(); return null; }
            $pdo->prepare("UPDATE mail_outbox SET status='sending',attempts=attempts+1,last_error=NULL WHERE id=?")->execute([$id]); $pdo->commit(); return $row;
        } catch (\Throwable $e) { if ($pdo->inTransaction()) $pdo->rollBack(); throw $e; }
    }
    public static function finish(int $id,bool $sent,?string $error=null): void
    {
        DB::pdo()->prepare('UPDATE mail_outbox SET status=?,sent_at=?,last_error=? WHERE id=?')->execute([$sent?'sent':'failed',$sent?date('Y-m-d H:i:s'):null,$sent?null:mb_substr((string)$error,0,1000),$id]);
    }
}
