<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;

class PostControllers
{
    const REQUEST_METHOD_POST = 'POST';
    protected Post $postModel;
    protected User $userModel;
    protected Comment $commentModel;

    public function __construct()
    {
        $this->postModel = new Post();
        $this->userModel = new User();
        $this->commentModel = new Comment();
    }

    /**
     * get All Blog Post Data.
     * @return View
     */
    public function blogPosts(): View
    {
        $posts = $this->postModel->getAllBlogPosts();
        $data = [
            'posts' => $posts,
        ];
        return View::make('/blogs/home', $data);
    }

    /**
     * admin to see blog posts in admin homepage
     * @return View
     */
    public function adminSeeBlogs(): View
    {
        $posts = $this->postModel->adminBlogInfoHome();
        $blogData = [
            'posts' => $posts
        ];
        return View::make('/admin/home', $blogData);
    }

    public function addBlog()
    {
        if ($_SERVER['REQUEST_METHOD'] == self::REQUEST_METHOD_POST) {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'title' => trim($_POST['title']),
                'blog_body' => trim($_POST['blog_body']),
                'user_id' => $_SESSION['user_id'],
            ];
            $isValid = $this->postModel->validate($data);
            if ($isValid) {
                if ($this->postModel->addPost($data)) {
                    header('location: ' . 'http://localhost:8000/blogPosts');
                }
            } else {
                $data['error_message'] = $this->postModel->validationError($data);
                return View::make('/blogs/addBlog', $data);
            }
        } else {
            $data = [
                'title' => '',
                'blog_body' => '',
                'title_err' => '',
                'blog_body_err' => '',
                'error_message' => ''
            ];
            return View::make('/blogs/addBlog', $data);
        }
    }


    /**
     * a user to be able to edit their blog, and to make sure it is filled in if they do edit.
     * @return View|void
     */
    public function editBlog()
    {
        $userId = $_SESSION['user_id'];
        if ($_SERVER['REQUEST_METHOD'] == self::REQUEST_METHOD_POST) {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'id' => $_POST['id'],
                'title' => trim($_POST['title']),
                'blog_body' => trim($_POST['blog_body']),
                'user_id' => $userId,
            ];
            $isValid = $this->postModel->validate($data);
            if ($isValid) {
                if ($this->postModel->updatePost($data)) {
                    header('location: ' . 'ttp://localhost:8000/blogPosts');
                }
            } else {
                $data['error_message'] = $this->postModel->validationError($data);
                return View::make('admin/editBlog', $data);
            }
        } else {
            $id = explode('?', $_SERVER['REQUEST_URI'])[1];
            $post = $this->postModel->getPostById($id);
            $user = $this->userModel->getUserById($userId);
            if ($post['user_id'] != $userId) {
                header('location: ' . 'http://localhost:8000/blogPosts');
            }
            $data = [
                'id' => $post['id'],
                'title' => $post['title'],
                'blog_body' => $post['blog_body'],
                'is_admin' => $user['is_admin'],
                'title_err' => '',
                'blog_body_err' => '',
            ];
            return View::make('/admin/editBlog', $data);
        }
    }


    /**
     * user to update post based on their postID
     * @return View|void
     */
    public function updatePost()
    {
        if ($_SERVER['REQUEST_METHOD'] == self::REQUEST_METHOD_POST) {
            $postId = $_POST['post_id'];
        }
        $post = $this->postModel->getPostById($postId);
        if (isset($_POST['blog_body'])) {
            $post['blog_body'] = $_POST['blog_body'];
            $post['title'] = $_POST['title'];
            $isValid = $this->postModel->validate($post);
            if ($isValid) {
                if ($this->postModel->updateEditPost($post)) {
                    header('location: ' . 'http://localhost:8000/admin/home');
                }
            }
            $post['error_message'] = $this->postModel->validationError($post);
        }
        $post['is_admin'] = $_SESSION['is_admin'];
        return View::make('admin/editBlog', $post);
    }

    /**
     * user to delete a blog if they are the owner of it
     * @return void
     */
    public function deleteBlog()
    {
        if ($_SERVER['REQUEST_METHOD'] == self::REQUEST_METHOD_POST) {
            if ($this->postModel->deletePost($_POST['postId'])) {
                header('location: ' . 'http://localhost:8000/blogPosts');
            } else {
                die('Could not delete blog post ');
            }
        }
    }

    /**
     * single blog, when user clicks on view full blog.
     * @return View
     */
    public function showSingleBlog()
    {
        $id = explode('?', $_SERVER['REQUEST_URI'])[1];
        $post = $this->postModel->getPostById($id);
        $user = $this->userModel->getUserById($post['user_id']);
        $comment = $this->commentModel->getCommentsById($post['id']);
        $data = [
            'post_id' => $post['id'],
            'title' => $post['title'],
            'blog_body' => $post['blog_body'],
            'user_id' => $post['user_id'],
            'created_at' => $post['created_at'],
            'username' => $user['username'],
            'comments' => $comment,
            'comment_error' => ''
        ];
        return View::make('blogs/show', $data);
    }

    /**
     * admin can edit any blog title and blog body from admin homepage.
     * @return View|void
     */
    public function adminEditBlog()
    {
        if ($_SERVER['REQUEST_METHOD'] == self::REQUEST_METHOD_POST) {
            $id = $_POST['id'];
        } else {
            $id = explode('?', $_SERVER['REQUEST_URI'])[1];
        }
        if ($id) {
            $post = $this->postModel->getPostById($id);
            if ($post === false) {
                return View::make('error/404');
            }
            $isValid = $this->blogValidation($post);
            if ($isValid) {
                $data = [
                    'id' => $post['id'],
                    'title' => $post['title'],
                    'blog_body' => $post['blog_body'],
                    'user_id' => $_SESSION['user_id'],
                    'title_err' => '',
                    'blog_body_err' => '',
                ];
                return View::make('admin/editBlog', $data);
            } else {
                die('Something went wrong');
            }
        }
        return View::make('admin/editBlog');
    }


    /**
     * validate blog Data
     * @param $data
     */
    public function blogValidation($data)
    {
        if (empty($data['title'])) {
            $data['title_err'] = 'Please enter a blog title';
        }
        if (empty($data['blog_body'])) {
            $data['blog_body_err'] = 'Please enter a blog body';
        } elseif (strlen($data['blog_body']) > 76) {
            $data['blog_body_err'] = 'Blog body must be less than 76 characters';
        }
        return $data;
    }


    /**
     * admin to see full blog including comments waiting to be approved
     * @return View
     */
    public function adminFullBlog()
    {
        $id = explode('?', $_SERVER['REQUEST_URI'])[1];
        $post = $this->postModel->getPostById($id);
        $user = $this->userModel->getUserById($post['user_id']);
        $comment = $this->commentModel->getCommentsById($post['id']);
        $data = [
            'id' => $post['id'],
            'title' => $post['title'],
            'blog_body' => $post['blog_body'],
            'user_id' => $post['user_id'],
            'created_at' => $post['created_at'],
            'username' => $user['username'],
            //THIS NOW GETS THE FULL COMMENTS array.
            'comments' => $comment,
        ];
        return View::make('admin/approveComments', $data);
    }


    /**
     * admin user to delete any blog
     * @return void
     */
    public function adminDeleteBlog()
    {
        if ($_SERVER['REQUEST_METHOD'] == self::REQUEST_METHOD_POST) {
            if ($this->postModel->adminDeleteBlog($_POST['post_id'],)) {
                header('location: ' . 'http://localhost:8000/admin/home');
            } else {
                die('Could not delete blog post');
            }
        }
    }
}