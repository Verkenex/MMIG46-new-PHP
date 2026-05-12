<?php
namespace MMIG46\Controllers;
use MMIG46\Core\View; use MMIG46\Core\Security; use MMIG46\Core\DB; use MMIG46\Core\Session; use MMIG46\Models\User; use MMIG46\Models\Member;
final class AdminController {
    private function guard(): void { Security::requireRole(['admin']); }
    public function dashboard(): string { $this->guard(); return View::render('admin/dashboard', ['users'=>User::all(), 'members'=>Member::all()]); }
    public function storeUser(): string { $this->guard(); Security::verifyCsrf(); $p=$_POST['password']??''; if(!Security::passwordOk($p)){Session::flash('error','Passwort muss mindestens 8 Zeichen haben.'); header('Location:/verwaltung'); exit;} $hash=password_hash($p,PASSWORD_DEFAULT); DB::pdo()->prepare('INSERT INTO users(name,email,password_hash,role,email_verified_at) VALUES(?,?,?,?,?)')->execute([$_POST['name'],$_POST['email'],$hash,$_POST['role']??'member', date('Y-m-d H:i:s')]); header('Location:/verwaltung'); exit; }
    public function storeMember(): string { $this->guard(); Security::verifyCsrf(); DB::pdo()->prepare('INSERT INTO members(name,email,aircraft,base,role_label,is_public) VALUES(?,?,?,?,?,?)')->execute([$_POST['name'],$_POST['email'],$_POST['aircraft'],$_POST['base'],$_POST['role_label'], isset($_POST['is_public'])?1:0]); header('Location:/verwaltung'); exit; }
}
