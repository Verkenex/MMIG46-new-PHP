<?php
namespace MMIG46\Controllers;
use MMIG46\Core\View; use MMIG46\Core\DB; use MMIG46\Core\Security; use MMIG46\Core\Session; use MMIG46\Models\User;
final class AuthController {
    public function login(): string { return View::render('auth/login'); }
    public function doLogin(): string { Security::verifyCsrf(); $email=trim($_POST['email']??''); $ip=$_SERVER['REMOTE_ADDR']??''; $pdo=DB::pdo();
    $q = $pdo->prepare(
        'SELECT COUNT(*) c
        FROM login_attempts
        WHERE success = 0
        AND attempted_at > DATE_SUB(NOW(), INTERVAL 15 MINUTE)
        AND (ip_address = ? OR email = ?)'
    );
    $q->execute([$ip, $email]);

    if ((int) $q->fetch()['c'] >= 8) {
        Session::flash('error', 'Zu viele Loginversuche. Bitte später erneut versuchen.');
        header('Location:/login');
        exit;
    }
            $user=User::findByEmail($email); $ok=$user && $user['email_verified_at'] && password_verify($_POST['password']??'', $user['password_hash']);
        $pdo->prepare('INSERT INTO login_attempts(email,ip_address,success) VALUES(?,?,?)')->execute([$email,$ip,$ok?1:0]);
        if(!$ok){Session::flash('error','Login fehlgeschlagen oder E-Mail nicht verifiziert.'); header('Location:/login'); exit;}
        session_regenerate_id(true);
$_SESSION['user'] = [
    'id' => $user['id'],
    'name' => $user['name'],
    'email' => $user['email'],
    'role' => $user['role'],
];

if (($user['role'] ?? '') === 'admin') {
    header('Location:/verwaltung');
} else {
    header('Location:/forum');
}
exit;}
    public function logout(): string
    {
        Security::verifyCsrf();

        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'] ?? '/',
                $params['domain'] ?? '',
                (bool) ($params['secure'] ?? false),
                (bool) ($params['httponly'] ?? true)
            );
        }

        session_destroy();

        header('Location:/');
        exit;
    }
}
