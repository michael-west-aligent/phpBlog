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
                'user_id' => $_SESSION['user_id'],
                'post_id' => $_POST['post_id'],
                'body' => $_POST['body']
                ];
            $postId = $data['post_id'];
            $post = $this->postModel->getPostById($postId);
            $user =  $this->userModel->getUserById($post['user_id']);
            $data['username'] = $user['username'];
            $this->commentModel->getCommentsById($post['id']);
            $this->commentModel->addComment($data);
            header('location: ' . 'http://localhost:8000/blog/show?' . $_POST['post_id']);

        }
    }

    public function approveComment()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

        }

    }

}