<?php

declare(strict_types=1);

namespace MMIG46\Models;

use MMIG46\Core\DB;

final class ContactRequest
{
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
            $_SERVER['REMOTE_ADDR'] ?? null,
        ]);
    }
}