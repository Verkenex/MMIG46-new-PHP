<?php

declare(strict_types=1);

namespace MMIG46\Controllers;

use MMIG46\Core\DB;
use MMIG46\Core\I18n;
use MMIG46\Core\Security;
use MMIG46\Core\Session;
use MMIG46\Core\View;
use MMIG46\Models\User;

final class AuthController
{
    public function login(): string
    {
        return View::render('auth/login', [
            'lang' => I18n::current(),
        ]);
    }

    public function doLogin(): string
    {
        Security::verifyCsrf();

        $lang = I18n::current();
        $email = trim((string) ($_POST['email'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');
        $ip = (string) ($_SERVER['REMOTE_ADDR'] ?? '');
        $pdo = DB::pdo();

        $query = $pdo->prepare(
            'SELECT COUNT(*) AS c
             FROM login_attempts
             WHERE success = 0
               AND attempted_at > DATE_SUB(NOW(), INTERVAL 15 MINUTE)
               AND (ip_address = ? OR email = ?)'
        );
        $query->execute([$ip, $email]);

        if ((int) ($query->fetch()['c'] ?? 0) >= 8) {
            Session::flash('error', I18n::t('auth.too_many_attempts'));
            header('Location: ' . I18n::url('/login', $lang));
            exit;
        }

        $user = User::findByEmail($email);

        $valid = $user
            && !empty($user['email_verified_at'])
            && password_verify($password, (string) $user['password_hash']);

        $pdo->prepare(
            'INSERT INTO login_attempts (email, ip_address, success)
             VALUES (?, ?, ?)'
        )->execute([$email, $ip, $valid ? 1 : 0]);

        if (!$valid) {
            Session::flash('error', I18n::t('auth.failed'));
            header('Location: ' . I18n::url('/login', $lang));
            exit;
        }

        session_regenerate_id(true);

        $_SESSION['user'] = [
            'id' => (int) $user['id'],
            'name' => (string) $user['name'],
            'email' => (string) $user['email'],
            'role' => (string) $user['role'],
        ];

        $target = (($user['role'] ?? '') === 'admin')
            ? '/verwaltung'
            : '/forum';

        header('Location: ' . I18n::url($target, $lang));
        exit;
    }

    public function logout(): string
    {
        Security::verifyCsrf();

        $lang = I18n::current();
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

        header('Location: ' . I18n::url('/', $lang));
        exit;
    }
}
