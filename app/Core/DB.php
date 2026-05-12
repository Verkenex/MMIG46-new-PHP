<?php
namespace MMIG46\Core;
use PDO;
final class DB {
    private static ?PDO $pdo = null;
    public static function pdo(): PDO {
        if (self::$pdo) return self::$pdo;
        $host = Env::get('DB_HOST','localhost'); $db = Env::get('DB_NAME','MMIG46_Datenbank'); $charset = Env::get('DB_CHARSET','utf8mb4');
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        self::$pdo = new PDO($dsn, Env::get('DB_USER',''), Env::get('DB_PASS',''), [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
        return self::$pdo;
    }
}
