<?php

declare(strict_types=1);

namespace MMIG46\Core;

final class Database
{
    public static function pdo(): \PDO
    {
        return DB::pdo();
    }
}