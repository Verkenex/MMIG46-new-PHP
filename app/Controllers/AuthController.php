<?php
namespace MMIG46\Controllers;
use MMIG46\Core\View; use MMIG46\Core\DB; use MMIG46\Core\Security; use MMIG46\Core\Session; use MMIG46\Models\User;
final class AuthController {
    public function login(): string { return View::render('auth/login'); }
    public function doLogin(): string { Security::verifyCsrf(); $email=trim($_POST['email']??''); $ip=$_SERVER['REMOTE_ADDR']??''; $pdo=DB::pdo();
        $q=$pdo->prepare('SELECT COUNT(*) c FROM login_attempts WHERE ip_address=? AND attempted_at > DATE_SUB(NOW(), INTERVAL 15 MINUTE)'); $q->execute([$ip]); if((int)$q->fetch()['c']>=8){Session::flash('error','Zu viele Loginversuche. Bitte spaeter erneut versuchen.'); header('Location:/login'); exit;}
        $user=User::findByEmail($email); $ok=$user && $user['email_verified_at'] && password_verify($_POST['password']??'', $user['password_hash']);
        $pdo->prepare('INSERT INTO login_attempts(email,ip_address,success) VALUES(?,?,?)')->execute([$email,$ip,$ok?1:0]);
        if(!$ok){Session::flash('error','Login fehlgeschlagen oder E-Mail nicht verifiziert.'); header('Location:/login'); exit;}
        session_regenerate_id(true); $_SESSION['user']=['id'=>$user['id'],'name'=>$user['name'],'email'=>$user['email'],'role'=>$user['role']]; header('Location:/forum'); exit; }
    public function logout(): string { session_destroy(); header('Location:/'); exit; }
}
