<?php

declare(strict_types=1);

namespace MMIG46\Models;

use MMIG46\Core\DB;

final class MembershipApplication
{
    public static function create(array $data): int
    {
        $payloadJson = json_encode(
            $data,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );

        if ($payloadJson === false) {
            $payloadJson = null;
        }

        $stmt = DB::pdo()->prepare(
            'INSERT INTO membership_applications (
                membership_type,

                invoice_name,
                street,
                postal_city_country,

                last_name,
                first_name,
                birthday,
                occupation,
                copilot_spouse,

                total_time,
                time_in_type,
                license_ratings,
                flying_since,
                aviation_history,

                registered_owner,
                callsign,
                model,
                serial_number,
                aircraft_year,
                modifications,
                home_base,

                office_phone,
                office_email,
                home_phone,
                private_email,
                mobile,

                consent,
                ip_address,
                payload_json
            ) VALUES (
                :membership_type,

                :invoice_name,
                :street,
                :postal_city_country,

                :last_name,
                :first_name,
                :birthday,
                :occupation,
                :copilot_spouse,

                :total_time,
                :time_in_type,
                :license_ratings,
                :flying_since,
                :aviation_history,

                :registered_owner,
                :callsign,
                :model,
                :serial_number,
                :aircraft_year,
                :modifications,
                :home_base,

                :office_phone,
                :office_email,
                :home_phone,
                :private_email,
                :mobile,

                :consent,
                :ip_address,
                :payload_json
            )'
        );

        $stmt->execute([
            ':membership_type' => self::value($data, 'membership_type'),

            ':invoice_name' => self::value($data, 'invoice_name'),
            ':street' => self::value($data, 'street'),
            ':postal_city_country' => self::value($data, 'postal_city_country'),

            ':last_name' => self::value($data, 'last_name'),
            ':first_name' => self::value($data, 'first_name'),
            ':birthday' => self::value($data, 'birthday'),
            ':occupation' => self::value($data, 'occupation'),
            ':copilot_spouse' => self::value($data, 'copilot_spouse'),

            ':total_time' => self::value($data, 'total_time'),
            ':time_in_type' => self::value($data, 'time_in_type'),
            ':license_ratings' => self::value($data, 'license_ratings'),
            ':flying_since' => self::value($data, 'flying_since'),
            ':aviation_history' => self::value($data, 'aviation_history'),

            ':registered_owner' => self::value($data, 'registered_owner'),
            ':callsign' => self::value($data, 'callsign'),
            ':model' => self::value($data, 'model'),
            ':serial_number' => self::value($data, 'serial_number'),
            ':aircraft_year' => self::value($data, 'aircraft_year'),
            ':modifications' => self::value($data, 'modifications'),
            ':home_base' => self::value($data, 'home_base'),

            ':office_phone' => self::value($data, 'office_phone'),
            ':office_email' => self::value($data, 'office_email'),
            ':home_phone' => self::value($data, 'home_phone'),
            ':private_email' => self::value($data, 'private_email'),
            ':mobile' => self::value($data, 'mobile'),

            ':consent' => ($data['consent'] ?? '') === 'yes' ? 1 : 0,
            ':ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
            ':payload_json' => $payloadJson,
        ]);

        return (int) DB::pdo()->lastInsertId();
    }

    private static function value(array $data, string $key): ?string
    {
        $value = trim((string) ($data[$key] ?? ''));

        return $value === '' ? null : $value;
    }
}