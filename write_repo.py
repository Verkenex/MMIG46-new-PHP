from pathlib import Path
root=Path('/mnt/data/mmig46-php-modernized')

def w(p,s):
    path=root/p
    path.parent.mkdir(parents=True,exist_ok=True)
    path.write_text(s.strip()+"\n",encoding='utf-8')

w('composer.json', r'''
{
  "name": "mmig46/modernized-php",
  "description": "Produktionsnahe PHP/MariaDB-Website fuer MMIG46 auf all-inkl/KAS.",
  "type": "project",
  "require": {
    "php": ">=8.1",
    "phpmailer/phpmailer": "^6.9",
    "erusev/parsedown": "^1.7"
  },
  "autoload": { "psr-4": { "MMIG46\\": "app/" } },
  "config": { "optimize-autoloader": true, "sort-packages": true }
}
''')

w('.gitignore', r'''
/vendor/
/.env
/storage/logs/*.log
/storage/uploads/*
!/storage/uploads/.gitkeep
.DS_Store
''')
w('storage/uploads/.gitkeep','')
w('storage/logs/.gitkeep','')

w('.env.example', r'''
APP_ENV=production
APP_URL=https://mmig46.org
APP_KEY=CHANGE_ME_TO_A_64_CHAR_RANDOM_STRING
DB_HOST=localhost
DB_NAME=MMIG46_Datenbank
DB_USER=d02fb2e5
DB_PASS=CHANGE_ME
DB_CHARSET=utf8mb4
MAIL_DRIVER=smtp
MAIL_HOST=w019cf33.kasserver.com
MAIL_PORT=465
MAIL_ENCRYPTION=ssl
MAIL_USERNAME=dr.gerecht@mmig46.org
MAIL_PASSWORD=CHANGE_ME
MAIL_FROM=dr.gerecht@mmig46.org
MAIL_FROM_NAME="MMIG46"
CONTACT_TO="info@mmig46.org,dr.gerecht@mmig46.org"
SESSION_NAME=mmig46_session
''')

w('public/index.php', r'''
<?php
declare(strict_types=1);
require dirname(__DIR__) . '/app/bootstrap.php';
use MMIG46\Core\Router;
$router = new Router();
require dirname(__DIR__) . '/config/routes.php';
$router->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/');
''')

w('app/bootstrap.php', r'''
<?php
declare(strict_types=1);
$root = dirname(__DIR__);
if (file_exists($root . '/vendor/autoload.php')) { require $root . '/vendor/autoload.php'; }
spl_autoload_register(function ($class) use ($root) {
    $prefix = 'MMIG46\\';
    if (strncmp($class, $prefix, strlen($prefix)) !== 0) return;
    $relative = substr($class, strlen($prefix));
    $file = $root . '/app/' . str_replace('\\', '/', $relative) . '.php';
    if (file_exists($file)) require $file;
});
MMIG46\Core\Env::load($root . '/.env');
MMIG46\Core\Session::start();
set_exception_handler(function(Throwable $e) {
    error_log($e);
    http_response_code(500);
    $message = MMIG46\Core\Env::get('APP_ENV') === 'production' ? 'Interner Serverfehler.' : $e->getMessage();
    echo MMIG46\Core\View::render('errors/500', ['message' => $message]);
});
''')

w('app/Core/Env.php', r'''
<?php
namespace MMIG46\Core;
final class Env {
    public static function load(string $file): void {
        if (!is_file($file)) return;
        foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) continue;
            [$key, $value] = explode('=', $line, 2);
            $value = trim($value, " \t\n\r\0\x0B\"'");
            $_ENV[trim($key)] = $value;
            putenv(trim($key) . '=' . $value);
        }
    }
    public static function get(string $key, ?string $default=null): ?string { return $_ENV[$key] ?? getenv($key) ?: $default; }
}
''')

w('app/Core/DB.php', r'''
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
''')

w('app/Core/Router.php', r'''
<?php
namespace MMIG46\Core;
final class Router {
    private array $routes = [];
    public function get(string $path, array $handler): void { $this->map('GET',$path,$handler); }
    public function post(string $path, array $handler): void { $this->map('POST',$path,$handler); }
    private function map(string $method,string $path,array $handler): void { $this->routes[$method][$path] = $handler; }
    public function dispatch(string $method, string $uri): void {
        $path = rtrim($uri, '/') ?: '/';
        $handler = $this->routes[$method][$path] ?? null;
        if (!$handler) { http_response_code(404); echo View::render('errors/404'); return; }
        [$class,$action] = $handler; echo (new $class())->$action();
    }
}
''')

w('app/Core/View.php', r'''
<?php
namespace MMIG46\Core;
final class View {
    public static function render(string $view, array $data=[]): string {
        extract($data, EXTR_SKIP);
        ob_start();
        require dirname(__DIR__) . '/Views/' . $view . '.php';
        $content = ob_get_clean();
        ob_start(); require dirname(__DIR__) . '/Views/layouts/main.php'; return ob_get_clean();
    }
    public static function partial(string $view, array $data=[]): string {
        extract($data, EXTR_SKIP); ob_start(); require dirname(__DIR__) . '/Views/' . $view . '.php'; return ob_get_clean();
    }
}
''')

w('app/Core/Session.php', r'''
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
''')

w('app/Core/Security.php', r'''
<?php
namespace MMIG46\Core;
final class Security {
    public static function csrf(): string { if (empty($_SESSION['_csrf'])) $_SESSION['_csrf'] = bin2hex(random_bytes(32)); return $_SESSION['_csrf']; }
    public static function verifyCsrf(): void { if ($_SERVER['REQUEST_METHOD']==='POST' && !hash_equals($_SESSION['_csrf'] ?? '', $_POST['_csrf'] ?? '')) { http_response_code(419); exit('CSRF-Token ungueltig.'); } }
    public static function e(?string $v): string { return htmlspecialchars((string)$v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
    public static function requireRole(array $roles): void { $role = $_SESSION['user']['role'] ?? 'guest'; if (!in_array($role,$roles,true)) { header('Location: /login'); exit; } }
    public static function passwordOk(string $p): bool { return strlen($p) >= 8; }
}
''')

w('app/Models/User.php', r'''
<?php
namespace MMIG46\Models;
use MMIG46\Core\DB;
final class User {
    public static function findByEmail(string $email): ?array { $s=DB::pdo()->prepare('SELECT * FROM users WHERE email=? LIMIT 1'); $s->execute([$email]); return $s->fetch() ?: null; }
    public static function find(int $id): ?array { $s=DB::pdo()->prepare('SELECT * FROM users WHERE id=?'); $s->execute([$id]); return $s->fetch() ?: null; }
    public static function all(): array { return DB::pdo()->query('SELECT id,name,email,role,email_verified_at,created_at FROM users ORDER BY name')->fetchAll(); }
}
''')

w('app/Models/Post.php', r'''
<?php
namespace MMIG46\Models;
use MMIG46\Core\DB;
final class Post {
    public static function all(): array { return DB::pdo()->query('SELECT p.*, u.name AS author FROM forum_posts p JOIN users u ON u.id=p.user_id ORDER BY p.pinned DESC, p.created_at DESC')->fetchAll(); }
    public static function create(int $uid,string $title,string $body): void { $s=DB::pdo()->prepare('INSERT INTO forum_posts(user_id,title,body) VALUES(?,?,?)'); $s->execute([$uid,$title,$body]); }
}
''')

w('app/Models/Member.php', r'''
<?php
namespace MMIG46\Models;
use MMIG46\Core\DB;
final class Member {
    public static function publicList(): array { return DB::pdo()->query('SELECT name, aircraft, base, role_label FROM members WHERE is_public=1 ORDER BY name')->fetchAll(); }
    public static function all(): array { return DB::pdo()->query('SELECT * FROM members ORDER BY name')->fetchAll(); }
}
''')

w('app/Services/Mailer.php', r'''
<?php
namespace MMIG46\Services;
use MMIG46\Core\Env;
use PHPMailer\PHPMailer\PHPMailer;
final class Mailer {
    public static function send(string $to, string $subject, string $body): bool {
        if (class_exists(PHPMailer::class)) {
            $mail = new PHPMailer(true);
            $mail->isSMTP(); $mail->Host=Env::get('MAIL_HOST',''); $mail->SMTPAuth=true; $mail->Username=Env::get('MAIL_USERNAME',''); $mail->Password=Env::get('MAIL_PASSWORD',''); $mail->SMTPSecure=Env::get('MAIL_ENCRYPTION','ssl'); $mail->Port=(int)Env::get('MAIL_PORT','465');
            $mail->setFrom(Env::get('MAIL_FROM','dr.gerecht@mmig46.org'), Env::get('MAIL_FROM_NAME','MMIG46'));
            foreach (array_map('trim', explode(',', $to)) as $addr) if ($addr) $mail->addAddress($addr);
            $mail->Subject=$subject; $mail->Body=$body; return $mail->send();
        }
        return mail($to, $subject, $body, 'From: '.Env::get('MAIL_FROM','dr.gerecht@mmig46.org'));
    }
}
''')

w('app/Services/Markdown.php', r'''
<?php
namespace MMIG46\Services;
final class Markdown {
    public static function render(string $text): string {
        if (class_exists('Parsedown')) { $p = new \Parsedown(); $p->setSafeMode(true); return $p->text($text); }
        return nl2br(htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'));
    }
}
''')

w('app/Controllers/PageController.php', r'''
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
''')

w('app/Controllers/AuthController.php', r'''
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
''')

w('app/Controllers/ForumController.php', r'''
<?php
namespace MMIG46\Controllers;
use MMIG46\Core\View; use MMIG46\Core\Security; use MMIG46\Models\Post;
final class ForumController {
    public function index(): string { return View::render('forum/index', ['posts'=>Post::all()]); }
    public function create(): string { Security::requireRole(['admin','moderator','member']); return View::render('forum/create'); }
    public function store(): string { Security::requireRole(['admin','moderator','member']); Security::verifyCsrf(); Post::create((int)$_SESSION['user']['id'], trim($_POST['title']??''), trim($_POST['body']??'')); header('Location:/forum'); exit; }
}
''')

w('app/Controllers/MemberController.php', r'''
<?php
namespace MMIG46\Controllers;
use MMIG46\Core\View; use MMIG46\Models\Member;
final class MemberController { public function index(): string { return View::render('memberlist/index', ['members'=>Member::publicList()]); } }
''')

w('app/Controllers/AdminController.php', r'''
<?php
namespace MMIG46\Controllers;
use MMIG46\Core\View; use MMIG46\Core\Security; use MMIG46\Core\DB; use MMIG46\Core\Session; use MMIG46\Models\User; use MMIG46\Models\Member;
final class AdminController {
    private function guard(): void { Security::requireRole(['admin']); }
    public function dashboard(): string { $this->guard(); return View::render('admin/dashboard', ['users'=>User::all(), 'members'=>Member::all()]); }
    public function storeUser(): string { $this->guard(); Security::verifyCsrf(); $p=$_POST['password']??''; if(!Security::passwordOk($p)){Session::flash('error','Passwort muss mindestens 8 Zeichen haben.'); header('Location:/verwaltung'); exit;} $hash=password_hash($p,PASSWORD_DEFAULT); DB::pdo()->prepare('INSERT INTO users(name,email,password_hash,role,email_verified_at) VALUES(?,?,?,?,?)')->execute([$_POST['name'],$_POST['email'],$hash,$_POST['role']??'member', date('Y-m-d H:i:s')]); header('Location:/verwaltung'); exit; }
    public function storeMember(): string { $this->guard(); Security::verifyCsrf(); DB::pdo()->prepare('INSERT INTO members(name,email,aircraft,base,role_label,is_public) VALUES(?,?,?,?,?,?)')->execute([$_POST['name'],$_POST['email'],$_POST['aircraft'],$_POST['base'],$_POST['role_label'], isset($_POST['is_public'])?1:0]); header('Location:/verwaltung'); exit; }
}
''')

w('config/routes.php', r'''
<?php
use MMIG46\Controllers\PageController; use MMIG46\Controllers\AuthController; use MMIG46\Controllers\ForumController; use MMIG46\Controllers\MemberController; use MMIG46\Controllers\AdminController;
$router->get('/', [PageController::class,'home']);
foreach(['/news','/reisen','/verein','/impressum','/datenschutz','/agb'] as $p) $router->get($p,[PageController::class,'staticPage']);
$router->get('/kontakt',[PageController::class,'contact']); $router->post('/kontakt',[PageController::class,'sendContact']);
$router->get('/login',[AuthController::class,'login']); $router->post('/login',[AuthController::class,'doLogin']); $router->post('/logout',[AuthController::class,'logout']);
$router->get('/forum',[ForumController::class,'index']); $router->get('/forum/neu',[ForumController::class,'create']); $router->post('/forum/neu',[ForumController::class,'store']);
$router->get('/memberlist',[MemberController::class,'index']);
$router->get('/verwaltung',[AdminController::class,'dashboard']); $router->post('/verwaltung/users',[AdminController::class,'storeUser']); $router->post('/verwaltung/members',[AdminController::class,'storeMember']);
''')

w('app/Views/layouts/main.php', r'''
<?php use MMIG46\Core\Security; use MMIG46\Core\Session; ?>
<!doctype html><html lang="de"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>MMIG46</title><link rel="stylesheet" href="/assets/css/app.css"><script defer src="/assets/js/app.js"></script></head>
<body><header class="site-header"><a class="brand" href="/"><span class="logo">✦</span><span>MMIG46</span></a><button class="nav-toggle" data-nav>Menü</button><nav><a href="/news">News</a><a href="/reisen">Reisen</a><a href="/verein">Verein</a><a href="/memberlist">Memberlist</a><a href="/forum">Forum</a><a href="/kontakt">Kontakt</a><?php if(!empty($_SESSION['user'])): ?><a href="/verwaltung">Verwaltung</a><form method="post" action="/logout" class="inline"><input type="hidden" name="_csrf" value="<?=Security::csrf()?>"><button>Logout</button></form><?php else: ?><a href="/login">Login</a><?php endif; ?></nav></header>
<main><?php if($m=Session::flash('ok')): ?><div class="flash ok"><?=Security::e($m)?></div><?php endif; ?><?php if($m=Session::flash('error')): ?><div class="flash error"><?=Security::e($m)?></div><?php endif; ?><?= $content ?></main>
<footer><p>© <?=date('Y')?> MMIG46 · <a href="/impressum">Impressum</a> · <a href="/datenschutz">Datenschutz</a></p></footer><div id="cookie" class="cookie"><p>Wir verwenden nur notwendige Session-Cookies. Tracking/Marketing ist vorbereitet, aber standardmäßig deaktiviert.</p><button data-cookie>Verstanden</button></div></body></html>
''')

w('app/Views/pages/home.php', r'''
<section class="hero"><div><p class="eyebrow">Modern Aviation Community</p><h1>MMIG46 – Jetprop, Himmel, Austausch.</h1><p>Eine moderne Vereinsplattform für Forum, Mitgliederliste, Reisen und Kontakt – gebaut für klassisches PHP/MariaDB-Hosting.</p><div class="actions"><a class="btn primary" href="/forum">Forum öffnen</a><a class="btn" href="/verein">Verein ansehen</a></div></div><div class="orb"><span>PA-46</span></div></section>
<section class="grid"><article><h2>Fliegen</h2><p>Fokus auf Piper, Jetprop, Reisen und Erfahrungsaustausch.</p></article><article><h2>Forum</h2><p>Öffentlich lesbar, Beiträge nur für registrierte Mitglieder.</p></article><article><h2>Memberlist</h2><p>Schlanke Liste, öffentlich gefiltert und intern verwaltbar.</p></article></section>
''')
for page,title,text in [('news','News','Aktuelle Hinweise und Vereinsmeldungen. Inhalte können später in Markdown ausgelagert werden.'),('reisen','Reisen','Berichte, Routen und Eindrücke rund um Himmel, Wolken und Jetprop.'),('verein','Verein','Informationen zur MMIG46, ihren Zielen und dem gemeinsamen Austausch.'),('agb','AGB','Platzhalter gemäß Repository-Entwurf. Bitte final juristisch prüfen.'),('impressum','Impressum','Impressumsdaten aus dem bestehenden Entwurf übernehmen und vor Livegang final prüfen.'),('datenschutz','Datenschutz','Datenschutzerklärung an PHP/MariaDB, Session-Cookies, Kontaktformular und SMTP-Versand anpassen.')]:
    w(f'app/Views/pages/{page}.php', f'<section class="page"><h1>{title}</h1><p>{text}</p></section>')

w('app/Views/pages/kontakt.php', r'''
<?php use MMIG46\Core\Security; ?><section class="page narrow"><h1>Kontakt</h1><form method="post" class="card"><input type="hidden" name="_csrf" value="<?=Security::csrf()?>"><input type="hidden" name="a" value="<?=$a?>"><input type="hidden" name="b" value="<?=$b?>"><label>Name<input name="name" required></label><label>E-Mail<input name="email" type="email" required></label><label>Nachricht<textarea name="message" required></textarea></label><label>Captcha: <?=$a?> + <?=$b?> = <input name="captcha" inputmode="numeric" required></label><button class="btn primary">Senden</button></form></section>
''')

w('app/Views/auth/login.php', r'''
<?php use MMIG46\Core\Security; ?><section class="page narrow"><h1>Login</h1><form method="post" class="card"><input type="hidden" name="_csrf" value="<?=Security::csrf()?>"><label>E-Mail<input type="email" name="email" required></label><label>Passwort<input type="password" name="password" required></label><button class="btn primary">Einloggen</button></form></section>
''')

w('app/Views/forum/index.php', r'''
<?php use MMIG46\Core\Security; use MMIG46\Services\Markdown; ?><section class="page"><div class="split"><h1>Forum</h1><?php if(in_array($_SESSION['user']['role'] ?? 'guest',['admin','moderator','member'],true)): ?><a class="btn primary" href="/forum/neu">Beitrag erstellen</a><?php endif; ?></div><?php foreach($posts as $p): ?><article class="card post"><h2><?=Security::e($p['title'])?></h2><p class="meta">Von <?=Security::e($p['author'])?> · <?=Security::e($p['created_at'])?></p><div class="markdown"><?=Markdown::render($p['body'])?></div></article><?php endforeach; ?></section>
''')
w('app/Views/forum/create.php', r'''
<?php use MMIG46\Core\Security; ?><section class="page narrow"><h1>Neuer Beitrag</h1><form method="post" class="card"><input type="hidden" name="_csrf" value="<?=Security::csrf()?>"><label>Titel<input name="title" required></label><label>Text/Markdown<textarea name="body" rows="10" required></textarea></label><button class="btn primary">Veröffentlichen</button></form></section>
''')
w('app/Views/memberlist/index.php', r'''
<?php use MMIG46\Core\Security; ?><section class="page"><h1>Memberlist</h1><div class="table"><table><thead><tr><th>Name</th><th>Aircraft</th><th>Base</th><th>Rolle</th></tr></thead><tbody><?php foreach($members as $m): ?><tr><td><?=Security::e($m['name'])?></td><td><?=Security::e($m['aircraft'])?></td><td><?=Security::e($m['base'])?></td><td><?=Security::e($m['role_label'])?></td></tr><?php endforeach; ?></tbody></table></div></section>
''')
w('app/Views/admin/dashboard.php', r'''
<?php use MMIG46\Core\Security; ?><section class="page"><h1>Verwaltung</h1><div class="grid two"><form method="post" action="/verwaltung/users" class="card"><h2>Account anlegen</h2><input type="hidden" name="_csrf" value="<?=Security::csrf()?>"><label>Name<input name="name" required></label><label>E-Mail<input type="email" name="email" required></label><label>Passwort<input type="password" name="password" minlength="8" required></label><label>Rolle<select name="role"><option>member</option><option>moderator</option><option>admin</option></select></label><button class="btn primary">Speichern</button></form><form method="post" action="/verwaltung/members" class="card"><h2>Mitglied eintragen</h2><input type="hidden" name="_csrf" value="<?=Security::csrf()?>"><label>Name<input name="name" required></label><label>E-Mail<input type="email" name="email"></label><label>Aircraft<input name="aircraft" placeholder="Piper Meridian / Jetprop"></label><label>Base<input name="base"></label><label>Rolle<input name="role_label" placeholder="Mitglied"></label><label><input type="checkbox" name="is_public" checked> Öffentlich anzeigen</label><button class="btn primary">Speichern</button></form></div><h2>Nutzer</h2><pre><?php foreach($users as $u) echo Security::e($u['name'].' · '.$u['email'].' · '.$u['role'])."\n"; ?></pre><h2>Mitglieder</h2><pre><?php foreach($members as $m) echo Security::e($m['name'].' · '.$m['aircraft'])."\n"; ?></pre></section>
''')
w('app/Views/errors/404.php','<section class="page"><h1>404</h1><p>Seite nicht gefunden.</p></section>')
w('app/Views/errors/500.php','<section class="page"><h1>500</h1><p><?=MMIG46\\Core\\Security::e($message ?? "Interner Fehler")?></p></section>')

w('public/assets/css/app.css', r'''
:root{--bg:#07111f;--panel:#0d1c31;--text:#f6f8fb;--muted:#a8b3c7;--accent:#ff6b2b;--blue:#38a4ff;--line:rgba(255,255,255,.12)}*{box-sizing:border-box}body{margin:0;font-family:Inter,ui-sans-serif,system-ui,-apple-system,Segoe UI,sans-serif;background:radial-gradient(circle at 15% 10%,#153d73 0,#07111f 32%,#050914 100%);color:var(--text);min-height:100vh}a{color:inherit}.site-header{position:sticky;top:0;z-index:5;display:flex;justify-content:space-between;align-items:center;padding:18px clamp(18px,4vw,64px);backdrop-filter:blur(18px);background:rgba(7,17,31,.72);border-bottom:1px solid var(--line)}.brand{display:flex;gap:10px;align-items:center;text-decoration:none;font-weight:800}.logo{display:grid;place-items:center;width:38px;height:38px;border-radius:14px;background:linear-gradient(135deg,var(--blue),var(--accent))}nav{display:flex;gap:18px;align-items:center}nav a{text-decoration:none;color:var(--muted)}button,.btn{border:1px solid var(--line);background:rgba(255,255,255,.06);color:var(--text);border-radius:999px;padding:11px 16px;text-decoration:none;cursor:pointer}.primary{background:linear-gradient(135deg,var(--blue),var(--accent));border:0;color:white;font-weight:700}main{padding:clamp(24px,5vw,72px)}.hero{display:grid;grid-template-columns:1.2fr .8fr;gap:40px;align-items:center;min-height:62vh}.hero h1{font-size:clamp(42px,8vw,92px);line-height:.95;margin:0 0 18px}.hero p{font-size:20px;color:var(--muted);max-width:680px}.eyebrow{color:var(--accent)!important;text-transform:uppercase;letter-spacing:.18em;font-weight:800;font-size:13px!important}.actions{display:flex;gap:12px;flex-wrap:wrap}.orb{aspect-ratio:1;border-radius:48px;background:linear-gradient(150deg,rgba(56,164,255,.28),rgba(255,107,43,.28));border:1px solid var(--line);display:grid;place-items:center;box-shadow:0 40px 100px rgba(0,0,0,.35)}.orb span{font-size:clamp(42px,8vw,90px);font-weight:900;color:rgba(255,255,255,.9)}.grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}.grid.two{grid-template-columns:repeat(2,1fr)}article,.card{background:rgba(255,255,255,.065);border:1px solid var(--line);border-radius:28px;padding:24px;box-shadow:0 24px 80px rgba(0,0,0,.2)}.page{max-width:1160px;margin:auto}.narrow{max-width:720px}.split{display:flex;justify-content:space-between;gap:16px;align-items:center}label{display:block;margin:12px 0;color:var(--muted)}input,textarea,select{width:100%;margin-top:6px;padding:13px;border-radius:14px;border:1px solid var(--line);background:#07111f;color:var(--text)}textarea{min-height:150px}.flash{margin:0 auto 20px;max-width:980px;padding:14px 18px;border-radius:16px}.ok{background:#123b2f}.error{background:#4a1720}.table{overflow:auto}.table table{width:100%;border-collapse:collapse;background:rgba(255,255,255,.05);border-radius:22px;overflow:hidden}.table th,.table td{padding:14px;border-bottom:1px solid var(--line);text-align:left}.meta{color:var(--muted);font-size:14px}.inline{display:inline}.cookie{position:fixed;left:18px;right:18px;bottom:18px;display:none;gap:16px;align-items:center;justify-content:space-between;background:#0d1c31;border:1px solid var(--line);padding:16px;border-radius:22px}.cookie.show{display:flex}.nav-toggle{display:none}@media(max-width:780px){.hero,.grid,.grid.two{grid-template-columns:1fr}nav{display:none;position:absolute;top:74px;left:0;right:0;background:#07111f;padding:20px;flex-direction:column;align-items:flex-start}.site-header.open nav{display:flex}.nav-toggle{display:block}.hero{min-height:auto}.orb{border-radius:30px}main{padding:24px 16px}}
''')

w('public/assets/js/app.js', r'''
document.querySelector('[data-nav]')?.addEventListener('click',()=>document.querySelector('.site-header')?.classList.toggle('open'));
const cookie=document.getElementById('cookie'); if(cookie && !localStorage.getItem('mmig46_cookie_ok')) cookie.classList.add('show');
document.querySelector('[data-cookie]')?.addEventListener('click',()=>{localStorage.setItem('mmig46_cookie_ok','1'); cookie.classList.remove('show');});
''')

w('public/.htaccess', r'''
Options -Indexes
RewriteEngine On
RewriteCond %{HTTPS} !=on
RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [QSA,L]
<FilesMatch "\.(env|sql|md|lock|json)$">
  Require all denied
</FilesMatch>
Header always set X-Content-Type-Options "nosniff"
Header always set Referrer-Policy "strict-origin-when-cross-origin"
Header always set X-Frame-Options "SAMEORIGIN"
''')
w('.htaccess', r'''
Options -Indexes
RewriteEngine On
RewriteRule ^$ public/ [L]
RewriteCond %{REQUEST_URI} !^/public/
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ public/$1 [L]
<FilesMatch "^(\.env|composer\.(json|lock)|README\.md|INSTALLATION\.md)$">
  Require all denied
</FilesMatch>
''')
