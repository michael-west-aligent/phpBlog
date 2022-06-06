<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use App\Models\Post;
//THIS WAS ADDED to get the USER DATA - STEP 1
use App\Models\User;


class PostControllers{

    protected $postModel;

    public function __construct()
    {
        //NOT WORKING
//        if(!isLoggedIn()){
//            header('location: ' . 'http://localhost:8000/users/login');
//        }

        $this->postModel = new Post();
        //THIS WAS ADDED - STEP 2
        //LOADING THE USER MODEL
        //IN CONSTRUCTOR SO IT CAN BE USED EVERYWHERE
        $this->userModel = new User();
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
                //USER_ID IS COMING FROM CURRENT LOGGED IN USER.
                'user_id' => $_SESSION['user_id'],
                //ERROR VARIABLES
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
            //RETURN IS MAKING THE FILE IN VIEW FOLDER > POSTS FOLDER > INDEX.php
            return View::make('/posts/addBlog', $data);
        }
    }



        //SHOW A SINGLE BLOG BASED ON ITS POT ID
    public function showSingleBlog()
    {
        $posts = $this->postModel->getPostById();
//        $user =  $this->userModel->getUserById($posts);
        $user =  $this->userModel->getUserById($posts);
        //since we have posts we have access to user_id filed in post table

        //THIS WAS ADDED
//        $data = [
//            'posts' => $posts
//        ];
//      $getBlogId = $_GET['id'];


        $data = [
//            'id' => $posts['id'],
            'title' => $posts['title'],
            'blog_body' => $posts['blog_body'],
            'user_id' => $posts['user_id'],
            'created_at' =>$posts['created_at'],
            'username' => $user['username']

            //THIS WAS ADDED
//            'users' =>$user['users']
//            //THIS WAS ADDED

        ];

        var_dump($user);
        var_dump($data);

        return View::make ('posts/show', $data);
    }

    private function isLoggedIn()
    {
    }
}