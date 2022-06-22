<?php

declare(strict_types=1);

namespace App\Controllers;


use App\View;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;

class PostControllers
{
    protected $postModel;

    public function __construct()
    {
        $this->postModel = new Post();
        $this->userModel = new User();
        $this->commentModel = new Comment();
    }

    //Get All Blog Posts
    public function blogPosts()
    {
        $posts = $this->postModel->getAllBlogPosts();
        $data = [
            'posts' => $posts,
        ];
        return View::make('/blogs/home', $data);
    }

    //admin homepage see blogs
    public function adminSeeBlogs()
    {
        $posts = $this->postModel->adminBlogInfoHome();
        $blogData = [
            'posts' => $posts
        ];
        return View::make('/admin/home', $blogData);
    }

    public function blogValidation($data)
    {
        //VALIDATE data
        if (empty($data['title'])) {
            $data['title_err'] = 'Please enter a blog title';
        }
        if (empty($data['blog_body'])) {
            $data['blog_body_err'] = 'Please enter a blog body';
        } elseif (strlen($data['blog_body']) > 76) {
            $data['blog_body_err'] = 'Blog body must be less than 76 characters';
        }
    }

    public function addBlog()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'title' => trim($_POST['title']),
                'blog_body' => trim($_POST['blog_body']),
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'blog_body_err' => '',
            ];

            $this->blogValidation($data);
            //VALIDATE data
//            if (empty($data['title'])) {
//                $data['title_err'] = 'Please enter a blog title';
//            }
//            if (empty($data['blog_body'])) {
//                $data['blog_body_err'] = 'Please enter a blog body';
//            } elseif (strlen($data['blog_body']) > 76) {
//                $data['blog_body_err'] = 'Blog body must be less than 76 characters';
//            }
            //Make SURE NO ERRORS
            if (empty($data['title_err']) && empty($data['blog_body_err'])) {
                //VALIDATED
                if ($this->postModel->addPost($data)) {
                    //REDIRECT TO ALL BLOG POSTS
                    header('location: ' . 'http://localhost:8000/blogPosts');
                } else {
                    die('Something went wrong');
                }
            } else {
                //LOAD VIEWS WITH ERRORS
                return View::make('blogs/addBlog', $data);
            }
        } else {
            $data = [
                'title' => '',
                'blog_body' => '',
                'title_err' => '',
                'blog_body_err' => '',
            ];
            return View::make('/blogs/addBlog', $data);
        }
    }

    public function adminEditBlog()
    {
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = [
                    'id' => $_POST['postId'],
                    'title' => ($_POST['title']),
                    'blog_body' => ($_POST['blog_body']),
                    'user_id' => $_SESSION['user_id'],
                    'title_err' => '',
                    'blog_body_err' => '',
                ];

                $this->blogValidation($data);
                //VALIDATE data
//                if (empty($data['title'])) {
//                    $data['title_err'] = 'Please enter a title';
//                }
//                //validate body length
//                if (empty($data['blog_body'])) {
//                    $data['blog_body_err'] = 'Please enter a blog body';
//                } elseif (strlen($data['blog_body']) > 76) {
//                    $data['blog_body_err'] = 'Blog body must be less than 76 characters';
//                }
                //Make sure no errors
                if (empty($data['title_err']) && empty($data['blog_body_err'])) {
                    //VALIDATED
                    if ($this->postModel->updatePost($data)) {
                        header('location: ' . 'http://localhost:8000/blogPosts');
                    } else {
                        die('Something went wrong');
                    }
                } else {
                    //LOAD VIEWS WITH ERRORS
                    return View::make('admin/editBlog', $data);
                }
            } else {
                $id = explode('?', $_SERVER['REQUEST_URI'])[1];
                $post = $this->postModel->getPostById($id);
                $data = [
                    'id' => $post['id'],
                    'title' => $post['title'],
                    'blog_body' => $post['blog_body'],
                    'title_err' => '',
                    'blog_body_err' => '',
                ];
                return View::make('/admin/editBlog', $data);
            }
        }
        return View::make('admin/editBlog');
    }

    public function editBlog()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'id' => $_POST['id'],
                'title' => trim($_POST['title']),
                'blog_body' => trim($_POST['blog_body']),
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'blog_body_err' => '',
            ];

            $this->blogValidation($data);
            //VALIDATE TITLE
//            if (empty($data['title'])) {
//                $data['title_err'] = 'Please enter a blog title';
//            }
//            //VALIDATE body length
//            if (empty($data['blog_body'])) {
//                $data['blog_body_err'] = 'Please enter a blog body';
//            } elseif (strlen($data['blog_body']) > 76) {
//                $data['blog_body_err'] = 'Blog body must be less than 76 characters';
//            }
            if (empty($data['title_err']) && empty($data['blog_body_err'])) {
                if ($this->postModel->updatePost($data)) {
                    header('location: ' . 'http://localhost:8000/blogPosts');
                } else {
                    die('Something went wrong');
                }
            } else {
                //LOAD VIEWS WITH ERRORS
                return View::make('blogs/editBlog', $data);
            }
        } else {
            $id = explode('?', $_SERVER['REQUEST_URI'])[1];
            $post = $this->postModel->getPostById($id);
            //CHECK THE OWNER
            if ($post['user_id'] != $_SESSION['user_id']) {
                header('location: ' . 'http://localhost:8000/blogPosts');
            }
            $data = [
                'id' => $post['id'],
                'title' => $post['title'],
                'blog_body' => $post['blog_body'],
                'title_err' => '',
                'blog_body_err' => '',
            ];
            return View::make('/blogs/editBlog', $data);
        }
    }

    public function updatePost()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'id' => $_POST['post_id'],
                'title' => trim($_POST['title']),
                'blog_body' => trim($_POST['blog_body']),
                'title_err' => '',
                'blog_body_err' => '',
            ];
            //Validate the title
            if (empty($data['title'])) {
                $data['title_err'] = 'Please enter a blog title';
            }
            //Validate the blog_body length
            if (empty($data['blog_body'])) {
                $data['blog_body_err'] = 'Please enter a blog body';
            } elseif (strlen($data['blog_body']) > 76) {
                $data['blog_body_err'] = 'Blog body must be less than 76 characters';
            }
            //if no error updateEditPost and redirect to blogPosts
            if (empty($data['title_err']) && empty($data['blog_body_err'])) {
                if ($this->postModel->updateEditPost($data)) {
                    header('location: ' . 'http://localhost:8000/blogPosts');
                }
            } else {
                //LOAD VIEWS WITH ERRORS
                return View::make('blogs/editBlog', $data);
            }
        } else {
            $id = explode('?', $_SERVER['REQUEST_URI'])[1];
            $post = $this->postModel->getPostById($id);
            //Check the owner
            if ($post['user_id'] != $_SESSION['user_id']) {
                header('location: ' . 'http://localhost:8000/blogPosts');
            }
            $data = [
                'id' => $post['id'],
                'title' => $post['title'],
                'blog_body' => $post['blog_body'],
                'title_err' => '',
                'blog_body_err' => '',
            ];
            return View::make('/blogs/editBlog', $data);
        }
        $this->postModel->updatePost([$_POST['title'], $_POST['blog_body'], $_POST['post_id']]);
        $this->postModel->adminUpdateBlog([$_POST['title'], $_POST['blog_body'], $_POST['post_id']]);
    }

    //SHOW A SINGLE BLOG BASED ON ITS POT ID
    public function showSingleBlog()
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
            'comments' => $comment,
            'comment_error' => ''
        ];
        return View::make('blogs/show', $data);
    }

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

    public function deleteBlog()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->postModel->deletePost($_POST['postId'])) {
                header('location: ' . 'http://localhost:8000/blogPosts');
            } else {
                die('something is not working ');
            }
        }
    }

    public function adminDeleteBlog()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->postModel->deletePost($_POST['postId'],)) {
                header('location: ' . 'http://localhost:8000/admin/home');
            } else {
                die('something is not working ');
            }
        }
    }
}