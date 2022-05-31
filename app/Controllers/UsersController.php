<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use App\Models\User;

class UsersController
{
    protected $userModel;

    public function __construct(){
        $this->userModel = new User();
    }
/** REGISTER A NEW USER  */
    public function register(){
        //CHECK for POST REQUEST
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
             //SANITIZE POST DATA
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            //PROCESS FORM
            $data =[
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            //Validate Email
            if(empty($data['email'])){
                $data['email_err'] = 'Please enter an email';
            } else {

                //CHECK EMAIL IS NOT ALREADY IN DB
                if($this->userModel->findUserByEmail($data)){
                    $data['email_err'] = "Email being used";
                }
//            if($this->userModel->currentUser($data)){
//                $data['email_err'] = "Email being used";
            }

            //Validate Name
            if(empty($data['name'])){
                $data['name_err'] = 'Please enter a name';
            }

            //Validate Password
            if(empty($data['password'])){
                $data['password_err'] = 'Please enter a password';
            } elseif(strlen($data['password']) <6 ){
                $data['password_err'] = 'Password must be at least 6 characters';
            }

            //Validate Confirm Password
            if(empty($data['confirm_password'])){
                $data['confirm_password_err'] = 'Please confirm password';
            } else {
                if($data['password'] != $data['confirm_password']){
                    $data['confirm_password_err'] = 'Passwords do not match, try again';
                }
            }



            //Make sure errors are empty
          if(empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
                //VALIDATED

                //HASH PASSWORD
              $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

              //REGISTER USER
              if($this->userModel->newRegister($data)){
//                  echo('You are registerd');
                  //FUTURE NOTE: return to blpgPost. if registered //
                  header('location: ' . 'http://localhost:8000/users/blogPosts');
              }
            } else {
                //LOAD VIEW WITH ERRORS
//                $this->view('users/register', $data);
//              var_dump($data);
                return View::make('users/userRegister', $data);

            }
        }else {
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            //LOAD VIEW FILE
//            $this->view('users/userRegister.php', $data);
            return View::make('users/userRegister', $data);
        }
    }

    /** LOGIN AS AN EXISTING USER ------------------------------------------------------------ */
    public function userLogin(){
        //CHECK for POST
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            //PROCESS FORM
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => '',
            ];

            //Validate Email
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter an email';
            } else {
                if ($this->userModel->findUserByEmail($data)){
                    //USER FOUND
                } else {
                    $data['email_err'] = 'No user with that email ';
                }
            }

            //Validate Password
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter a password';
            }

            //MAKE SURE ERRORS ARE EMPTY
            if (empty($data['email_err']) && empty($data['password_err'])) {
                //VALIDATED

                //Check and set logged in User /** STEP 2 here logged in user takes in email and password  */
//                $loggedInUser = $this->userModel->login($data['email'], $data['password']);
//
//                if($loggedInUser) {
//                    //Create Session
//                } else {
//                    $data['password_err'] = 'Password incorrect';
//                }
//                return View::make('users/usersLogin', $data);

            } else {
                //LOAD VIEW WITH ERRORS
                return View::make('user/userLogin', $data);
            }


            //CHECK IF CURRENT USER DATA EXISTS
            if ($this->userModel->currentUser($data)) {
                header('location: ' . 'http://localhost:8000/users/blogPosts');
            } else {
                return View::make('users/userLogin');
            }
        }else {
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => '',
            ];
            //LOAD VIEW FILE
//            $this->view('users/userRegister.php', $data);
            return View::make('users/userLogin', $data);
        }
    }
}