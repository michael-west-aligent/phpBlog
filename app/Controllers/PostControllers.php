<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use App\Models\Post;

class PostControllers{

    protected $postModel;

    public function __construct()
    {
        $this->postModel = new Post();
    }


    public function blogPosts(){
        //GET ALL POSTS
        $posts = $this->postModel->getAllBlogPosts();

            $data = [
                'posts' => $posts
            ];
        //RETURN IS MAKING THE FILE IN VIEW FOLDER > POSTS FOLDER > INDEX.php
        return View::make('/posts/index', $data);
    }

    public function addBlog() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
//            die('submit');
        //IF IT IS SUBMITTED SANITIZE THE POST ARRAY
            //CREATE NEW VARIABLE CALLED POST
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'title' => trim($_POST['title']),
                'blog_body' => trim($_POST['blog_body']),
//                'created_at' => trim($_POST['postCreated]),




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
//                    die('success');
                    //VALIDATED
                    if($this->postModel->addPost($data)){
                        header('location' . '/blogPosts');
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
}