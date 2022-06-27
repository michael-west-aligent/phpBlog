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

    /**
     * validate blog Data
     * @param $data
     * @return void
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
     * add Blog and make sure all input areas are filled in
     * @return View|void
     */
    public function addBlog()
    {
        if ($_SERVER['REQUEST_METHOD'] == self::REQUEST_METHOD_POST) {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'title' => trim($_POST['title']),
                'blog_body' => trim($_POST['blog_body']),
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'blog_body_err' => '',
            ];
            $data2 = $this->blogValidation($data);
            if (empty($data2['title_err']) && empty($data2['blog_body_err'])) {
                if ($this->postModel->addPost($data2)) {
                    header('location: ' . 'http://localhost:8000/blogPosts');
                } else {
                    die('Something went wrong');
                }
            } else {
                return View::make('blogs/addBlog', (array)$data2);
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

    /**
     * admin can edit any blog title and blog body from admin homepage.
     * @return View|void
     */
    public function adminEditBlog()
    {
        // work out how we've got to this controller = POST or GET
        if ($_SERVER['REQUEST_METHOD'] == self::REQUEST_METHOD_POST) {
            $id = $_POST['id'];
        }
        else {
            $id = explode('?', $_SERVER['REQUEST_URI'])[1];
        }
        // if there is an ID passed
        if ($id) {
            //use the ID to find the post
            $post = $this->postModel->getPostById($id);
            if($post === false){
                return View::make('error/404');
            }
            // what happens if no post is found? >>>>> RETURN A 404


            $isValid = $this->blogValidation($post);  // change this!

            if ($isValid) {
                // populate data array
                $data = [
                    'id' => $post['id'],
                    'title' => $post['title'],
                    'blog_body' => $post['blog_body'],
                    'user_id' => $_SESSION['user_id'],
                    'title_err' => '',
                    'blog_body_err' => '',
                ];
                return View::make('admin/editBlog', $data);
            }
            else {
                die('Something went wrong');
            }
        }
        return View::make('admin/editBlog');
    }







//        {
//            if ($_SERVER['REQUEST_METHOD'] == self::REQUEST_METHOD_POST) {
//                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
//                $data = [
//                    'id' => $_POST['id'],
//                    'title' => ($_POST['title']),
//                    'blog_body' => ($_POST['blog_body']),
//                    'user_id' => $_SESSION['user_id'],
//                    'title_err' => '',
//                    'blog_body_err' => '',
//                ];
//                $this->blogValidation($data);
//                if (empty($data['title_err']) && empty($data['blog_body_err'])) {
//                    if ($this->postModel->updatePost($data)) {
//                        header('location: ' . 'http://localhost:8000/blogPosts');
//                    } else {
//                        die('Something went wrong');
//                    }
//                } else {
//                    return View::make('admin/editBlog', $data);
//                }
//            } else {
//                $id = explode('?', $_SERVER['REQUEST_URI'])[1];
//                $post = $this->postModel->getPostById($id);
//                $data = [
//                    'id' => $post['id'],
//                    'title' => $post['title'],
//                    'blog_body' => $post['blog_body'],
//                    'title_err' => '',
//                    'blog_body_err' => '',
//                ];
//                return View::make('/admin/editBlog', $data);
//            }
//        }
//        return View::make('admin/editBlog');
//    }




    /**
     * a user to be able to edit their blog, and to make sure it is filled in if they do edit.
     * @return View|void
     */
    public function editBlog()
    {
        if ($_SERVER['REQUEST_METHOD'] == self::REQUEST_METHOD_POST) {
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
            if (empty($data['title_err']) && empty($data['blog_body_err'])) {
                if ($this->postModel->updatePost($data)) {
                    header('location: ' . 'http://localhost:8000/blogPosts');
                } else {
                    die('Something went wrong');
                }
            } else {
                return View::make('blogs/editBlog', $data);
            }
        } else {
            $id = explode('?', $_SERVER['REQUEST_URI'])[1];
            $post = $this->postModel->getPostById($id);
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

    /**
     * user to update post based on their postID
     * @return View|void
     */
    public function updatePost()
    {
        if ($_SERVER['REQUEST_METHOD'] == self::REQUEST_METHOD_POST) {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'id' => $_POST['post_id'],
                'title' => trim($_POST['title']),
                'blog_body' => trim($_POST['blog_body']),

            ];
            $isValid = $this->postModel->validate($data);
            if ($isValid) {
                if ($this->postModel->updateEditPost($data)) {
                    header('location: ' . 'http://localhost:8000/blogPosts');
                }
            } else {
                $data['error_message'] = $this->postModel->validationError($data);
                return View::make('blogs/editBlog', $data);
            }
        } else {
            $id = explode('?', $_SERVER['REQUEST_URI'])[1];
            $post = $this->postModel->getPostById($id);
            if ($post['user_id'] != $_SESSION['user_id']) {
                header('location: ' . 'http://localhost:8000/blogPosts');
            }
            $data = [
                'id' => $post['id'],
                'title' => $post['title'],
                'blog_body' => $post['blog_body'],

            ];
            return View::make('/blogs/editBlog', $data);
        }
        $this->postModel->updatePost([$_POST['title'], $_POST['blog_body'], $_POST['post_id']]);
        $this->postModel->adminUpdateBlog([$_POST['title'], $_POST['blog_body'], $_POST['post_id']]);
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
     * admin user to delete any blog
     * @return void
     */
    public function adminDeleteBlog()
    {
        if ($_SERVER['REQUEST_METHOD'] == self::REQUEST_METHOD_POST) {
            if ($this->postModel->deletePost($_POST['postId'],)) {
                header('location: ' . 'http://localhost:8000/admin/home');
            } else {
                die('Could not delete blog post  ');
            }
        }
    }
}