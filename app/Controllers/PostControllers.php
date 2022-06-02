<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use App\Models\Post;

class PostControllers{

    protected $postModel;

    public function __construct()
    {
        $this->postModel = new Post();
    }


    public function blogPosts(){
        //GET ALL POSTS
        $posts = $this->postModel->getAllBlogPosts();

            $data = [
                'posts' => $posts
            ];
        //RETURN IS MAKING THE FILE IN VIEW FOLDER > POSTS FOLDER > INDEX.php
        return View::make('/posts/index', $data);
    }

    public function addBlog() {
        $data = [
            'title' => '',
            'body' => '',
        ];
        //RETURN IS MAKING THE FILE IN VIEW FOLDER > POSTS FOLDER > INDEX.php
        return View::make('/posts/addBlog', $data);
    }


}