<?php

namespace MMIG46\Models;

use MMIG46\Core\DB;

class SiteSetting
{
    public static function get(string $key, ?string $default = null): ?string
    {
        $stmt = DB::pdo()->prepare('SELECT setting_value FROM site_settings WHERE setting_key = ?');
        $stmt->execute([$key]);
        $row = $stmt->fetch();

        return $row['setting_value'] ?? $default;
    }

    public static function allKeyValue(): array
    {
        $rows = DB::pdo()->query('SELECT setting_key, setting_value FROM site_settings')->fetchAll();

        $settings = [];
        foreach ($rows as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }

        return $settings;
    }
}