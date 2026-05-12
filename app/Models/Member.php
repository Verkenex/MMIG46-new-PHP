<?php
namespace MMIG46\Models;
use MMIG46\Core\DB;
final class Member {
    public static function publicList(): array { return DB::pdo()->query('SELECT name, aircraft, base, role_label FROM members WHERE is_public=1 ORDER BY name')->fetchAll(); }
    public static function all(): array { return DB::pdo()->query('SELECT * FROM members ORDER BY name')->fetchAll(); }
}
