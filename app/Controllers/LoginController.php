<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;

class LoginController
{
    public function login(): View
    {
        return View::make('login');
    }

    public function userLogin(): View
    {
        return View::make('users/userLogin');
    }


}