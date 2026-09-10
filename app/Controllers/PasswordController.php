<?php
declare(strict_types=1);
namespace MMIG46\Controllers;
use MMIG46\Core\DB;
use MMIG46\Core\I18n;
use MMIG46\Core\Security;
use MMIG46\Core\Session;
use MMIG46\Core\View;

final class PasswordController
{
    public function form(): string { return View::render('auth/set-password',['token'=>(string)($_GET['token']??''),'lang'=>I18n::current()]); }
    public function save(): string
    {
        Security::verifyCsrf(); $token=(string)($_POST['token']??''); $password=(string)($_POST['password']??'');
        if (strlen($password)<12 || $password !== (string)($_POST['password_confirmation']??'')) { Session::flash('error',I18n::current()==='en'?'Passwords must match and contain at least 12 characters.':'Die Passwörter müssen übereinstimmen und mindestens 12 Zeichen lang sein.'); header('Location:'.I18n::url('/passwort-setzen',null,['token'=>$token])); exit; }
        $pdo=DB::pdo(); $pdo->beginTransaction();
        try { $stmt=$pdo->prepare('SELECT id FROM users WHERE reset_token_hash=? AND reset_expires_at>NOW() FOR UPDATE'); $stmt->execute([hash('sha256',$token)]); $id=(int)$stmt->fetchColumn();
            if ($id<=0) throw new \RuntimeException('invalid');
            $pdo->prepare('UPDATE users SET password_hash=?,email_verified_at=COALESCE(email_verified_at,NOW()),reset_token_hash=NULL,reset_expires_at=NULL WHERE id=?')->execute([password_hash($password,PASSWORD_DEFAULT),$id]); $pdo->commit();
        } catch (\Throwable $e) { if($pdo->inTransaction())$pdo->rollBack(); Session::flash('error',I18n::current()==='en'?'The link is invalid or expired.':'Der Link ist ungültig oder abgelaufen.'); header('Location:'.I18n::url('/passwort-setzen')); exit; }
        Session::flash('ok',I18n::current()==='en'?'Your password has been set. You can now sign in.':'Ihr Passwort wurde festgelegt. Sie können sich jetzt anmelden.'); header('Location:'.I18n::url('/login')); exit;
    }
}
