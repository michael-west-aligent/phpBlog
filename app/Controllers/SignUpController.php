<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;

/** THIS ALL GOT MOVED TO A CONTROLLER CALLED
    UsersController.php
 */

class SignUpController
{
    public function signUp(): View
    {
        return View::make('signup');
    }

    public function userRegister(): View
    {
        return View::make('users/userRegister');
    }

}