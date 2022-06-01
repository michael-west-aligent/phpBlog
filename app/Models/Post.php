<?php

namespace App\Models;

use App\Config\App;

class Posts {

    public $db;


    public function __construct()
    {
        $this->db = App::db();
    }


    public function getAllBlogPosts()
    {
        $this->db->query('SELECT * FROM posts');

        $results
    }
}