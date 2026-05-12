<?php
namespace MMIG46\Controllers;
use MMIG46\Core\View; use MMIG46\Core\DB; use MMIG46\Core\Security; use MMIG46\Core\Session; use MMIG46\Core\Env; use MMIG46\Services\Mailer;
final class PageController {
    public function home(): string { return View::render('pages/home'); }
    public function staticPage(): string { $path=trim(parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH),'/') ?: 'home'; return View::render('pages/'.$path); }
    public function contact(): string { return View::render('pages/kontakt', ['a'=>rand(2,9),'b'=>rand(2,9)]); }
    public function sendContact(): string { Security::verifyCsrf(); if (((int)($_POST['captcha']??0)) !== ((int)($_POST['a']??0)+(int)($_POST['b']??0))) { Session::flash('error','Captcha falsch.'); header('Location: /kontakt'); exit; }
        $s=DB::pdo()->prepare('INSERT INTO contact_requests(name,email,message,ip_address) VALUES(?,?,?,?)'); $s->execute([$_POST['name']??'',$_POST['email']??'',$_POST['message']??'',$_SERVER['REMOTE_ADDR']??'']);
        Mailer::send(Env::get('CONTACT_TO','dr.gerecht@mmig46.org'), 'Kontaktanfrage MMIG46', "Name: ".($_POST['name']??'')."\nE-Mail: ".($_POST['email']??'')."\n\n".($_POST['message']??''));
        Session::flash('ok','Anfrage gespeichert und versendet.'); header('Location: /kontakt'); exit; }
}
