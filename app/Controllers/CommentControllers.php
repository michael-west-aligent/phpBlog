<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;

class CommentControllers
{
    const REQUEST_METHOD_POST = 'POST';
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
     * @return View|false
     */
    public function addBlogComment()
    {
        $postId = $_POST['post_id'];
        $post = $this->postModel->getPostById($postId);
        $user = $this->userModel->getUserById($post['user_id']);
        //this var dump shows the entire post (id, userid, title, blog_body, created_at
//        var_dump($post);
        if (!$post) {
            // If not post - error - abort!
            return false;
        }
        //check the logged in User by checking the session userID
        $loggedInUser = $this->userModel->getUserById($_SESSION['user_id']);
//        var_dump($_SESSION);
        //this var dump shows the current session user (user_id, user_email, user_username, is_admin)
        if (!$loggedInUser) {
            //if no logged in user - error - abort!
            return false;
        }
//        ALL OF THE ABOVE MAKES SENSE SO FAR

        //set data array that is  accessible.
        $newComment = [
            'user_id' => $post['user_id'],
            'post_id' => $post['id'],
            'body' => $_POST['blog_body'],
            'title' => $post['title'],
            'username' => $user['username'],
            'created_at' => $post['created_at'],
            'blog_body' => $post['blog_body'],
            'comment_error' => '',
        ];
        $isCommentValid = $this->commentModel->validate($newComment);
        //if the comment is NOT valid, error message using validationError
        if (!$isCommentValid) {
            $errormessage = $this->commentModel->validationError($newComment);
            // send this message back via appropriate view
            $newComment['comment_error'] = $errormessage;
        } else {
            $this->commentModel->addComment($newComment);
            // redirect somewhere
        }
        return View::make('blogs/show', $newComment);
    }

    /**
     * Add a new blog comment
     * make sure comment is validated and meets criteria i.e. less than 50 characters
     * @return View|void
     */
    public function oldAddBlogComment()
    {
        if ($_SERVER['REQUEST_METHOD'] == self::REQUEST_METHOD_POST)
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
//                header('location: ' . 'http://localhost:8000/blog/show?' . $data['post_id']);
//                echo("\n Blogs show");
                return View::make('blogs/show', $post);
            }
        } else {
            // does this ever happen?
            $id = explode('?', $_SERVER['REQUEST_URI'])[1];
            $post = $this->postModel->getPostById($id);

            $data = [
                'id' => $post['id'],
                'title' => $post['title'],
                'blog_body' => $post['blog_body'],
                'comment_error' => ''
            ];
            return View::make('/blog/show', $data);
        }
    }

    /**
     * allows an admin user to approve comments before they can be seen
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
     * allow admin to delete comments
     * @return void
     */
    public function adminDeleteBlogComment()
    {
        if ($_SERVER['REQUEST_METHOD'] == self::REQUEST_METHOD_POST) {
            if ($this->commentModel->adminDeleteComment($_POST['comment_id'],)) {
                header('location: ' . 'http://localhost:8000/admin/home');
            } else {
                die('admin is unable to delete blog Comment');
            }
        }
    }

}