<?php

declare(strict_types=1);

namespace MMIG46\Models;

use MMIG46\Core\DB;
use MMIG46\Core\Security;

final class ContactRequest
{
    public static function all(int $limit = 200): array
    {
        $stmt = DB::pdo()->prepare('SELECT id, name, email, message, created_at, handled_at FROM contact_requests ORDER BY handled_at IS NULL DESC, created_at DESC LIMIT ?');
        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function markHandled(int $id): void
    {
        DB::pdo()->prepare('UPDATE contact_requests SET handled_at = COALESCE(handled_at, NOW()) WHERE id = ?')->execute([$id]);
    }

    public static function create(string $name, string $email, string $message): void
    {
        $stmt = DB::pdo()->prepare(
            'INSERT INTO contact_requests (name, email, message, ip_address)
             VALUES (?, ?, ?, ?)'
        );

        $stmt->execute([
            $name,
            $email,
            $message,
            Security::clientFingerprint(),
        ]);
    }
}
