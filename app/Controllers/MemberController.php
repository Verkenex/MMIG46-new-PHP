<?php

declare(strict_types=1);

namespace MMIG46\Controllers;

use MMIG46\Core\I18n;
use MMIG46\Core\Session;
use MMIG46\Core\View;
use MMIG46\Models\Member;

final class MemberController
{
    public function index(): string
    {
        $user = $_SESSION['user'] ?? null;
        $role = is_array($user)
            ? (string) ($user['role'] ?? '')
            : '';

        if (
            !is_array($user)
            || !in_array($role, ['member', 'moderator', 'admin'], true)
        ) {
            Session::flash('error', I18n::t('members.access_denied'));
            header('Location: ' . I18n::url('/login'));
            exit;
        }

        return View::render('memberlist/index', [
            'members' => Member::publicMembers(),
            'lang' => I18n::current(),
        ]);
    }
}
