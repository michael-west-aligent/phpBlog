<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;

class CommentControllers
{
    const REQUEST_METHOD = 'POST';
    protected Comment $commentModel;
    protected User $userModel;
    protected Post $postModel;


    public function __construct()
    {
        $this->postModel = new Post();
        $this->userModel = new User();
        $this->commentModel = new Comment();
    }




    /**
     * Add a new blog comment
     * make sure comment is validated and meets criteria i.e. less than 50 characters
     * @return View|void
     */
    public function addBlogComment()
    {
//        const $REQUEST_METHOD = 'POST';
        if ($_SERVER['REQUEST_METHOD'] == self::REQUEST_METHOD)
        {
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
                //VALIDATE body length
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
                    die('Unable to add a new Blog Comments');
                }
            } else {
                $postModel = new Post();
                $post = $postModel->getPostById($data['post_id']);
                $_user = $this->userModel->getUserById($post['user_id']);
                $post['username'] = $_user['username'];
                $post['comment_error'] = $data['comment_error'];
                return View::make('blogs/show', $post);
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
            return View::make('/blogs/show', $data);
        }
    }



    /**
     * function that allows an admin user to approve comments before they can be seen
     * @return void
     */
    public function adminApproved()
    {
        $data = [
            'comment_id' => $_POST['comment_id'],
            'approved' => $_POST['approved'],
            'post_id' => $_POST['post_id']
        ];
        $this->commentModel->adminApproved($data);
    }

    /**
     * function for admin that allows them to delete comments
     * @return void
     */
    public function adminDeleteBlogComment()
    {
        if ($_SERVER['REQUEST_METHOD'] == self::REQUEST_METHOD) {
            if ($this->commentModel->adminDeleteComment($_POST['comment_id'],)) {
                header('location: ' . 'http://localhost:8000/admin/home');
            } else {
                die('admin is unable to delete blog Comment');
            }
        }
    }

}