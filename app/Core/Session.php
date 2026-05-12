<?php
namespace MMIG46\Core;
final class Session {
    public static function start(): void {
        if (session_status() === PHP_SESSION_ACTIVE) return;
        session_name(Env::get('SESSION_NAME','mmig46_session'));
        session_set_cookie_params(['lifetime'=>0,'path'=>'/','secure'=>!empty($_SERVER['HTTPS']),'httponly'=>true,'samesite'=>'Lax']);
        session_start();
    }
    public static function flash(string $key, ?string $value=null): ?string { if ($value!==null){$_SESSION['_flash'][$key]=$value;return null;} $v=$_SESSION['_flash'][$key]??null; unset($_SESSION['_flash'][$key]); return $v; }
}
