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
//                'username'=> $_POST['username'],
                'post_id' => $_POST['post_id'],
//                'created_at' =>$comment['created_at'],
                'body' => $_POST['body']
                ];

            $postId = $data['post_id'];
            $post = $this->postModel->getPostById($postId);
            $user =  $this->userModel->getUserById($post['user_id']);
            $data['username'] = $user['username'];
            $comment = $this->commentModel->getCommentsById($post['id']);
            $this->commentModel->addComment($data);
            header('location: ' . 'http://localhost:8000/blog/show?' . $_POST['post_id']);

        }
    }
}