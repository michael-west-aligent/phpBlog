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
        $post = $this->postModel->getPostById();
        $user =  $this->userModel->getUserById($post['user_id']);
        $comment = $this->commentModel->getCommentsById($post['id']);
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data = [
                'user_id' => $_SESSION['user_id'],
                'username'=> $user['username'],
                'id' => $post['id'],
                'created_at' =>$comment['created_at'],
                'body' => $comment['body']
                ];
            $this->commentModel->addComment($user['username'], $comment['body'], $post['id']);

        }
    }
}