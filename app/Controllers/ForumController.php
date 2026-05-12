<?php
namespace MMIG46\Controllers;
use MMIG46\Core\View; use MMIG46\Core\Security; use MMIG46\Models\Post;
final class ForumController {
    public function index(): string { return View::render('forum/index', ['posts'=>Post::all()]); }
    public function create(): string { Security::requireRole(['admin','moderator','member']); return View::render('forum/create'); }
    public function store(): string { Security::requireRole(['admin','moderator','member']); Security::verifyCsrf(); Post::create((int)$_SESSION['user']['id'], trim($_POST['title']??''), trim($_POST['body']??'')); header('Location:/forum'); exit; }
}
