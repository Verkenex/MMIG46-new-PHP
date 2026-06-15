<?php

namespace MMIG46\Controllers;

use MMIG46\Core\DB;
use MMIG46\Core\Security;
use MMIG46\Core\Session;
use MMIG46\Core\View;
use MMIG46\Models\ContentPage;
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
            'pages' => ContentPage::all(),
            'news' => NewsItem::published(100),
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

    public function storePage(): string
    {
        $this->guard();
        Security::verifyCsrf();

        ContentPage::upsert([
            'slug' => trim($_POST['slug'] ?? ''),
            'title' => trim($_POST['title'] ?? ''),
            'teaser' => trim($_POST['teaser'] ?? ''),
            'body' => trim($_POST['body'] ?? ''),
            'meta_title' => trim($_POST['meta_title'] ?? ''),
            'meta_description' => trim($_POST['meta_description'] ?? ''),
            'is_published' => isset($_POST['is_published']),
        ]);

        header('Location:/verwaltung');
        exit;
    }
}