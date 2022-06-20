<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use mysql_xdevapi\Executable;
use PDO;

class HomeController
{
    public function home()
    {
        return View::make('homepage');
    }

}