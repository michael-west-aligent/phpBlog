<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;

class SignUpController
{
    public function signUp(): View
    {
        return View::make('signup');
    }

}