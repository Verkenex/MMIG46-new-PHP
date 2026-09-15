<?php

declare(strict_types=1);

namespace MMIG46\Models;

use MMIG46\Core\DB;
use MMIG46\Core\Security;

final class TrainingRegistration
{
    public static function all(int $limit = 200): array
    {
        $stmt = DB::pdo()->prepare('SELECT id, language, name, email, callsign, aircraft_model, participants, elements_json, notes, organizer_mail_status, copy_mail_status, created_at FROM training_registrations ORDER BY created_at DESC LIMIT ?');
        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function create(array $data, string $token): int
    {
        $pdo = DB::pdo();
        $hash = hash('sha256', $token);
        $stmt = $pdo->prepare('SELECT id FROM training_registrations WHERE idempotency_hash = ? LIMIT 1');
        $stmt->execute([$hash]);
        $existing = $stmt->fetchColumn();
        if ($existing) {
            return (int) $existing;
        }

        try {
            $stmt = $pdo->prepare(
                'INSERT INTO training_registrations
                 (idempotency_hash, language, name, email, callsign, aircraft_model, participants, elements_json, notes, privacy_consent, ip_address)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
            );
            $stmt->execute([
                $hash,
                $data['language'],
                $data['name'],
                strtolower((string) $data['email']),
                $data['callsign'],
                $data['aircraft_model'] !== '' ? $data['aircraft_model'] : null,
                $data['participants'],
                json_encode($data['elements'], JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR),
                $data['notes'] !== '' ? $data['notes'] : null,
                $data['privacy_consent'] ? 1 : 0,
                Security::clientFingerprint(),
            ]);
            return (int) $pdo->lastInsertId();
        } catch (\PDOException $exception) {
            if ((string) $exception->getCode() !== '23000') {
                throw $exception;
            }
            $lookup = $pdo->prepare('SELECT id FROM training_registrations WHERE idempotency_hash = ? LIMIT 1');
            $lookup->execute([$hash]);
            $id = $lookup->fetchColumn();
            if (!$id) {
                throw $exception;
            }
            return (int) $id;
        }
    }

    public static function markOrganizerMail(int $id, bool $sent): void
    {
        DB::pdo()->prepare('UPDATE training_registrations SET organizer_mail_status = ?, organizer_sent_at = ? WHERE id = ?')
            ->execute([$sent ? 'sent' : 'failed', $sent ? date('Y-m-d H:i:s') : null, $id]);
    }

    public static function markCopyMail(int $id, bool $sent): void
    {
        DB::pdo()->prepare('UPDATE training_registrations SET copy_mail_status = ?, copy_sent_at = ? WHERE id = ?')
            ->execute([$sent ? 'sent' : 'failed', $sent ? date('Y-m-d H:i:s') : null, $id]);
    }
}
