<?php

namespace MMIG46\Controllers;

use MMIG46\Core\DB;
use MMIG46\Core\Security;
use MMIG46\Core\Session;
use MMIG46\Core\View;
use MMIG46\Models\Member;
use MMIG46\Models\NewsItem;
use MMIG46\Models\TravelItem;
use MMIG46\Models\User;

class AdminController
{
    private function guard(): void
    {
        if (empty($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
            header('Location:/login');
            exit;
        }
    }

    public function dashboard(): string
    {
        $this->guard();

        return View::render('admin/dashboard', [
            'users' => User::all(),
            'members' => Member::all(),
            'news' => NewsItem::all(200),
            'travels' => TravelItem::published(),
        ]);
    }

    public function storeUser(): string
    {
        $this->guard();
        Security::verifyCsrf();

        $password = $_POST['password'] ?? '';

        if (!Security::passwordOk($password)) {
            Session::flash('error', 'Passwort muss mindestens 8 Zeichen haben.');
            header('Location:/verwaltung');
            exit;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        DB::pdo()
            ->prepare('INSERT INTO users(name, email, password_hash, role, email_verified_at) VALUES (?, ?, ?, ?, ?)')
            ->execute([
                trim($_POST['name'] ?? ''),
                trim($_POST['email'] ?? ''),
                $hash,
                $_POST['role'] ?? 'member',
                date('Y-m-d H:i:s'),
            ]);

        header('Location:/verwaltung');
        exit;
    }

    public function storeMember(): string
    {
        $this->guard();
        Security::verifyCsrf();

        DB::pdo()
            ->prepare(
                'INSERT INTO members(name, email, aircraft, base, role_label, member_type, website, is_public, sort_order)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
            )
            ->execute([
                trim($_POST['name'] ?? ''),
                trim($_POST['email'] ?? ''),
                trim($_POST['aircraft'] ?? ''),
                trim($_POST['base'] ?? ''),
                trim($_POST['role_label'] ?? ''),
                trim($_POST['member_type'] ?? ''),
                trim($_POST['website'] ?? ''),
                isset($_POST['is_public']) ? 1 : 0,
                (int)($_POST['sort_order'] ?? 100),
            ]);

        header('Location:/verwaltung');
        exit;
    }

    public function storeNews(): string
{
    $this->guard();
    Security::verifyCsrf();

    $slug = trim($_POST['slug'] ?? '');
    $publishedAt = trim($_POST['published_at'] ?? '');

    if ($publishedAt === '') {
        $publishedAt = date('Y-m-d H:i:s');
    }

    DB::pdo()
        ->prepare(
            'INSERT INTO news_items
             (title, slug, category, image_path, comment_count, teaser, body, published_at, is_published)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
             ON DUPLICATE KEY UPDATE
             title = VALUES(title),
             category = VALUES(category),
             image_path = VALUES(image_path),
             comment_count = VALUES(comment_count),
             teaser = VALUES(teaser),
             body = VALUES(body),
             published_at = VALUES(published_at),
             is_published = VALUES(is_published)'
        )
        ->execute([
            trim($_POST['title'] ?? ''),
            $slug,
            trim($_POST['category'] ?? ''),
            trim($_POST['image_path'] ?? ''),
            (int)($_POST['comment_count'] ?? 0),
            trim($_POST['teaser'] ?? ''),
            trim($_POST['body'] ?? ''),
            $publishedAt,
            isset($_POST['is_published']) ? 1 : 0,
        ]);

    header('Location:/verwaltung');
    exit;
}

public function storeTravel(): string
{
    $this->guard();
    Security::verifyCsrf();

    DB::pdo()
        ->prepare(
            'INSERT INTO travel_items
             (title, slug, image_path, location, starts_on, ends_on, status, teaser, cta_label, body, is_published)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
             ON DUPLICATE KEY UPDATE
             title = VALUES(title),
             image_path = VALUES(image_path),
             location = VALUES(location),
             starts_on = VALUES(starts_on),
             ends_on = VALUES(ends_on),
             status = VALUES(status),
             teaser = VALUES(teaser),
             cta_label = VALUES(cta_label),
             body = VALUES(body),
             is_published = VALUES(is_published)'
        )
        ->execute([
            trim($_POST['title'] ?? ''),
            trim($_POST['slug'] ?? ''),
            trim($_POST['image_path'] ?? ''),
            trim($_POST['location'] ?? ''),
            ($_POST['starts_on'] ?? '') !== '' ? $_POST['starts_on'] : null,
            ($_POST['ends_on'] ?? '') !== '' ? $_POST['ends_on'] : null,
            $_POST['status'] ?? 'planned',
            trim($_POST['teaser'] ?? ''),
            trim($_POST['cta_label'] ?? ''),
            trim($_POST['body'] ?? ''),
            isset($_POST['is_published']) ? 1 : 0,
        ]);

    header('Location:/verwaltung');
    exit;
}
}