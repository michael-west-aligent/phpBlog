<?php

namespace App\Models;

use App\Config\App;

class Post {

    //use the DB
    public $db;


    public function __construct()
    {
        $this->db = App::db();
    }

    //GET ALL THE BLOG POTS FROM DB
    public function getAllBlogPosts()
    {
        $postStatement = $this->db->query('SELECT * FROM posts');
        //THIS SHOULD RETURN AN ARRAY OF OBJECT BACK
        $results = $postStatement->fetchAll();
        return $results;
    }
}