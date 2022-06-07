<?php

namespace  App\Models;

use App\Config\App;

class Comment {

    public $db;

    public function __construct()
    {
        $this->db = App::db();
    }


}