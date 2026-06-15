<?php

namespace MMIG46\Models;

use MMIG46\Core\DB;

class Member
{
    public static function publicMembers(): array
    {
        return DB::pdo()
            ->query(
                'SELECT name, aircraft, base, role_label, member_type, website
                 FROM members
                 WHERE is_public = 1
                 ORDER BY sort_order, name'
            )
            ->fetchAll();
    }

    public static function all(): array
    {
        return DB::pdo()
            ->query('SELECT * FROM members ORDER BY sort_order, name')
            ->fetchAll();
    }
}