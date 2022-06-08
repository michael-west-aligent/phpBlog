<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;

class CommentControllers {

    protected $commentModel;

    public function __construct()
    {
        $this->postModel = new Post();
        $this->userModel = new User();
        $this->commentModel = new Comment();
    }

    public function addBlogComment(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data = [
                'user_id'=> $_SESSION['user_id'],
                'post_id' => $_POST['post_id'],
                'created_at' =>$_POST['created_at'],
                'body' => $_POST['body']
                ];
            $this->commentModel->addComment($data);

        }
    }
}