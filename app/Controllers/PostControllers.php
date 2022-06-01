<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
//use App\Models\Posts; THIS IS NOT DONE YET.

class PostControllers{

    public function blogPosts(){
        return View::make('/posts/index');
    }

}