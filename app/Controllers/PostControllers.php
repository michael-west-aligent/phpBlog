<?php

declare(strict_types=1);

namespace App\Controllers;


use App\View;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;

class PostControllers{

    protected $postModel;

    public function __construct()
    {
        //NOT WORKING
//        if(!isLoggedIn()){
//            header('location: ' . 'http://localhost:8000/users/login');
//        }
        $this->postModel = new Post();
        $this->userModel = new User();
        $this->commentModel = new Comment();
    }

    //GET ALL POSTS
    public function blogPosts(){
        $posts = $this->postModel->getAllBlogPosts();
            $data = [
                'posts' => $posts
            ];
        return View::make('/posts/index', $data);
    }

    public function addBlog() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
        //IF IT IS SUBMITTED SANITIZE THE POST ARRAY
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'title' => trim($_POST['title']),
                'blog_body' => trim($_POST['blog_body']),
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'blog_body_err' => '',
                ];

                //VALIDATE data
                if(empty($data['title'])) {
                    $data['title_err'] = 'Please enter a title';
                }
                 if(empty($data['blog_body'])) {
                $data['blog_body_err'] = 'Please enter a blog body';
                 }

                 //Make SURE NO ERRORS
                if(empty($data['title_err']) && empty($data['blog_body_err'])){
                    //VALIDATED
                    if($this->postModel->addPost($data)){
                        //REDIRECT TO ALL BLOG POSTS
                        header('location: ' . 'http://localhost:8000/blogPosts');
                    } else {
                        die('Something went wrong');
                    }
                }else {
                    //LOAD VIEWS WITH ERRORS
                    return View::make('posts/addBlog', $data);
                }
        } else {
            $data = [
                'title' => '',
                'blog_body' => '',
                'title_err' => '',
                'blog_body_err' => '',
            ];
            return View::make('/posts/addBlog', $data);
        }
    }


    public function editBlog() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'id' => $_POST['id'],
                'title' => trim($_POST['title']),
                'blog_body' => trim($_POST['blog_body']),
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'blog_body_err' => '',
            ];
            //VALIDATE data
            if(empty($data['title'])) {
                $data['title_err'] = 'Please enter a title';
            }
            if(empty($data['blog_body'])) {
                $data['blog_body_err'] = 'Please enter a blog body';
            }
            //Make sure no errors
            if(empty($data['title_err']) && empty($data['blog_body_err'])){
                //VALIDATED
                if($this->postModel->updatePost($data)){
                    echo('tes');
//                    REDIRECT TO ALL BLOG POSTS
                    header('location: ' . 'http://localhost:8000/blogPosts');
                } else {
                    die('Something went wrong');
                }
            }else {
                //LOAD VIEWS WITH ERRORS
                return View::make('posts/editBlog', $data);
            }
        } else {
            //GET EXISITING POST FROM MODEL
            $post = $this->postModel->getPostById();
            //CHECK THE OWNER
            if($post['user_id'] != $_SESSION['user_id'])
            {
                header('location: ' . 'http://localhost:8000/blogPosts');
            }
            $data = [
                'id' => $post['id'],
                'title' => $post['title'],
                'blog_body' => $post['blog_body'],
                'title_err' => '',
                'blog_body_err' => '',

            ];
            return View::make('/posts/editBlog', $data);
        }
    }

    public function updatePost(){
        $this->postModel->updatePost([$_POST['title'], $_POST['blog_body'], $_POST['post_id']]);
    }

        //SHOW A SINGLE BLOG BASED ON ITS POT ID
    public function showSingleBlog()
    {
        $id = explode('?', $_SERVER['REQUEST_URI'])[1];
        $post = $this->postModel->getPostById($id);
        $user =  $this->userModel->getUserById($post['user_id']);
        $comment = $this->commentModel->getCommentsById($post['id']);
        $data = [
            'id' => $post['id'],
            'title' => $post['title'],
            'blog_body' => $post['blog_body'],
            'user_id' => $post['user_id'],
            'created_at' =>$post['created_at'],
            'username' => $user['username'],
//THIS NOW GETS THE FULL COMMENTS array.
            'comments' =>$comment,
        ];
        return View::make ('posts/show', $data);
    }

    /** DELETE WORK STARTS HERE  */
    public function deleteBlog(){
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($this->postModel->deletePost())
            {
                header('location: ' . 'http://localhost:8000/blogPosts');
            } else {
                die('something is not working ');
            }
        }
    }
}