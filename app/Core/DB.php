<?php

declare(strict_types=1);

namespace MMIG46\Core;

use PDO;
use PDOException;

final class DB
{
    private static ?PDO $pdo = null;

    public static function pdo(): PDO
    {
        if (self::$pdo instanceof PDO) {
            return self::$pdo;
        }

        $host = Env::get('DB_HOST', 'localhost');
        $port = Env::get('DB_PORT', '3306');
        $socket = Env::get('DB_SOCKET', '');
        $database = Env::get('DB_NAME', '');
        $user = Env::get('DB_USER', 'root');
        $password = Env::get('DB_PASS', '');
        $charset = Env::get('DB_CHARSET', 'utf8mb4');

        if ($database === '') {
            throw new PDOException('DB_NAME is not configured.');
        }

        if ($socket !== '') {
            $dsn = sprintf(
                'mysql:unix_socket=%s;dbname=%s;charset=%s',
                $socket,
                $database,
                $charset
            );
        } else {
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=%s',
                $host,
                $port,
                $database,
                $charset
            );
        }

        self::$pdo = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);

        return self::$pdo;
    }
}