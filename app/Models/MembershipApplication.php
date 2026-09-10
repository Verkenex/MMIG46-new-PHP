<?php
declare(strict_types=1);
namespace MMIG46\Models;
use MMIG46\Core\DB;

final class MembershipApplication
{
    public static function createPending(array $data, string $language, string $token): array
    {
        $pdo = DB::pdo();
        $idempotencyHash = hash('sha256', $token);
        $duplicateHash = self::duplicateHash($data);
        $pdo->beginTransaction();
        try {
            $existing = self::findByHash($idempotencyHash, $duplicateHash);
            if ($existing) { $pdo->commit(); return $existing; }
            $email = strtolower(trim((string) $data['private_email']));
            $conflicts = [];
            foreach (['users' => 'Benutzerkonto', 'members' => 'Mitglied'] as $table => $label) {
                $stmt = $pdo->prepare("SELECT id FROM {$table} WHERE LOWER(email)=? LIMIT 1");
                $stmt->execute([$email]);
                if ($stmt->fetchColumn()) $conflicts[] = "E-Mail ist bereits einem {$label} zugeordnet.";
            }
            $status = $conflicts === [] ? 'pending' : 'manual_review';
            $columns = ['membership_type','invoice_name','street','postal_city_country','last_name','first_name','birthday','occupation','copilot_spouse','total_time','time_in_type','license_ratings','flying_since','aviation_history','registered_owner','callsign','model','serial_number','aircraft_year','modifications','home_base','office_phone','office_email','home_phone','private_email','mobile'];
            $values = array_map(fn(string $key): ?string => self::value($data, $key), $columns);
            $payload = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
            $sql = 'INSERT INTO membership_applications (language,idempotency_hash,duplicate_hash,status,conflict_reason,' . implode(',', $columns) . ',consent,ip_address,payload_json) VALUES (' . implode(',', array_fill(0, count($columns) + 8, '?')) . ')';
            $pdo->prepare($sql)->execute(array_merge([
                in_array($language, ['de','en'], true) ? $language : 'de', $idempotencyHash, $duplicateHash,
                $status, $conflicts === [] ? null : implode(' ', $conflicts),
            ], $values, [1, $_SERVER['REMOTE_ADDR'] ?? null, $payload]));
            $applicationId = (int) $pdo->lastInsertId();
            $name = trim((string) $data['first_name'] . ' ' . (string) $data['last_name']);
            $pdo->prepare("INSERT INTO members (application_id,status,name,email,aircraft,base,member_type,invoice_name,street,phone,internal_notes,is_public,sort_order) VALUES (?, 'pending', ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, 100)")
                ->execute([$applicationId,$name,$email,self::value($data,'model'),self::value($data,'home_base'),self::value($data,'membership_type'),self::value($data,'invoice_name'),self::value($data,'street'),self::value($data,'mobile'),'Automatisch aus Mitgliedsantrag #' . $applicationId . ' angelegt.']);
            $memberId = (int) $pdo->lastInsertId();
            MailOutbox::queueInTransaction('membership_admin','support@mmig46.org','Neuer MMIG46-Mitgliedsantrag',['application_id'=>$applicationId,'language'=>$language,'data'=>$data],'membership_application',$applicationId,'application-admin-' . $applicationId);
            MailOutbox::queueInTransaction('membership_copy',$email,$language === 'en' ? 'Your MMIG46 membership application' : 'Ihr MMIG46-Mitgliedsantrag',['application_id'=>$applicationId,'language'=>$language,'data'=>$data],'membership_application',$applicationId,'application-copy-' . $applicationId);
            $pdo->commit();
            return ['id'=>$applicationId,'member_id'=>$memberId,'status'=>$status,'reused'=>false];
        } catch (\PDOException $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            if ((string) $e->getCode() === '23000' && ($existing = self::findByHash($idempotencyHash, $duplicateHash))) return $existing;
            throw $e;
        } catch (\Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            throw $e;
        }
    }

    public static function all(): array
    {
        return DB::pdo()->query('SELECT a.*,m.id AS member_id,m.status AS member_status,ub.name AS board_admin_name,up.name AS payment_admin_name,ud.name AS decision_admin_name FROM membership_applications a LEFT JOIN members m ON m.application_id=a.id LEFT JOIN users ub ON ub.id=a.board_confirmed_by LEFT JOIN users up ON up.id=a.payment_confirmed_by LEFT JOIN users ud ON ud.id=a.decided_by ORDER BY a.created_at DESC')->fetchAll();
    }

    private static function findByHash(string $idempotencyHash, string $duplicateHash): ?array
    {
        $stmt = DB::pdo()->prepare('SELECT a.id,a.status,m.id AS member_id,1 AS reused FROM membership_applications a LEFT JOIN members m ON m.application_id=a.id WHERE a.idempotency_hash=? OR a.duplicate_hash=? LIMIT 1');
        $stmt->execute([$idempotencyHash,$duplicateHash]);
        return $stmt->fetch() ?: null;
    }

    private static function duplicateHash(array $data): string
    {
        $keys = ['private_email','first_name','last_name','birthday','callsign'];
        return hash('sha256', implode('|', array_map(fn(string $key): string => mb_strtolower(trim((string)($data[$key] ?? '')), 'UTF-8'), $keys)));
    }

    private static function value(array $data, string $key): ?string
    {
        $value = trim((string)($data[$key] ?? ''));
        return $value === '' ? null : $value;
    }
}
