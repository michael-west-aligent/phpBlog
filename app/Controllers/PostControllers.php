<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
//use App\Models\Posts; THIS IS NOT DONE YET.


class PostControllers{



    public function blogPosts(){
        //RETURN IS MAKING THE FILE IN VIEW FOLDER > POSTS FOLDER > INDEX.php
        return View::make('/posts/index');
    }

}