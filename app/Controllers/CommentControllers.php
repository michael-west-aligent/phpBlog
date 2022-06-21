<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;

class CommentControllers
{

    protected $commentModel;

    public function __construct()
    {
        $this->postModel = new Post();
        $this->userModel = new User();
        $this->commentModel = new Comment();
    }

    public function addBlogComment()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'user_id' => $_SESSION['user_id'],
                'post_id' => $_POST['post_id'],
                'body' => $_POST['blog_body'],
                'comment_error' => '',
            ];
            if (empty($data['body'])) {
                $data['comment_error'] = 'Please enter a comment';
            }
            if (strlen($data['body']) > 50) {
                //Validate body length
                $data['comment_error'] = 'Blog body must be less than 50 characters';
            }
            $postId = $data['post_id'];
            $post = $this->postModel->getPostById($postId);
            $user = $this->userModel->getUserById($post['user_id']);
            $data['username'] = $user['username'];
            $this->commentModel->getCommentsById($post['id']);
            if (empty($data['comment_error'])) {
                if ($this->commentModel->addComment($data)) {
                    header('location: ' . 'http://localhost:8000/blogPosts');
                } else {
                    die('Something went wrong');
                }
            } else {
                $postModel = new Post();
                $post = $postModel->getPostById($data['post_id']);
                $_user = $this->userModel->getUserById($post['user_id']);
                $post['username'] = $_user['username'];
                $post['comment_error'] = $data['comment_error'];
                return View::make('posts/show', $post);
            }
        } else {
            $id = explode('?', $_SERVER['REQUEST_URI'])[1];
            $post = $this->postModel->getPostById($id);
            $data = [
                'id' => $post['id'],
                'title' => $post['title'],
                'blog_body' => $post['blog_body'],
                'comment_error' => ''
            ];
            return View::make('/posts/show', $data);
        }
    }

    //THIS WAS ADDED FROM POST CONTROLLER
    public function adminApproved()
    {
        $data = [
            'comment_id' => $_POST['comment_id'],
            'approved' => $_POST['approved'],
            'post_id' => $_POST['post_id']
        ];
        $this->commentModel->adminApproved($data);
    }


    public function adminDeleteBlogComment()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->commentModel->adminDeleteComment($_POST['comment_id'],)) {
                header('location: ' . 'http://localhost:8000/admin/home');
            } else {
                die('something is not working ');
            }
        }
    }

}