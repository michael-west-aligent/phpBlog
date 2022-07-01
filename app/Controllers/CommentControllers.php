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
        if (!$post) {
            return false;
        }
        $loggedInUser = $this->userModel->getUserById($_SESSION['user_id']);
        if (!$loggedInUser) {
            return false;
        }
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
        if (!$isCommentValid) {
            $errormessage = $this->commentModel->validationError($newComment);
            $newComment['comment_error'] = $errormessage;
        } else {
            $this->commentModel->addComment($newComment);
        }
        return View::make('blogs/show', $newComment);
    }


    /**
     * allows an admin user to approve comments before they can be seen
     * @return void
     */
    public function approveComment()
    {
        $data = [
            'comment_id' => $_POST['comment_id'],
            'approved' => $_POST['approved'],
            'post_id' => $_POST['post_id']
        ];
        $this->commentModel->approveComment($data);
    }

    /**
     * allow admin to delete comments
     * @return void
     */
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] == self::REQUEST_METHOD_POST) {
            if ($this->commentModel->delete($_POST['comment_id'],)) {
                header('location: ' . 'http://localhost:8000/admin/home');
            } else {
                die('admin is unable to delete blog Comment');
            }
        }
    }

}