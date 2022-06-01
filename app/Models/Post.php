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
        $postStatement = $this->db->query('SELECT *,
                                                    posts.id as postId, 
                                                    users.id as userId
                                                    FROM posts
                                                    INNER JOIN users
                                                    ON posts.user_id = users.id
                                                    ORDER BY posts.created_at DESC');
        //THIS SHOULD RETURN AN ARRAY OF OBJECT BACK
        $results = $postStatement->fetchAll();
        return $results;
    }
}