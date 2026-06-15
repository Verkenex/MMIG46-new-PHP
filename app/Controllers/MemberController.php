<?php

namespace MMIG46\Controllers;

use MMIG46\Core\View;
use MMIG46\Models\Member;

final class MemberController
{
    public function index(): string
    {
        return View::render('memberlist/index', [
            'members' => Member::publicMembers(),
        ]);
    }
}