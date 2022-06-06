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
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
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
                //HASH PASSWORD
              $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
              //REGISTER USER
              if($this->userModel->newRegister($data)){
                  header('location: ' . 'http://localhost:8000/users/blogPosts');
              }
            } else {
                //LOAD VIEW WITH ERRORs
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
            $dataRow = $this->userModel->findUserByEmail($data);
            //Validate Email
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter an email';
            } else {
                if (!$dataRow){
                    $data['email_err'] = 'No user with that email ';
                }
            }
            $hashed_password = $dataRow['password'];
            //Validate Password
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter a password';
            } elseif(!password_verify($data['password'], $hashed_password)) {
                $data['password_err'] = 'Password no matchy match';
            }
            //MAKE SURE ERRORS ARE EMPTY
            if (empty($data['email_err']) && empty($data['password_err'])) {
                //VALIDATED
                $currentUser = $this->userModel->currentUser($data);
                if($currentUser){
                    $this->createUserSession($currentUser);
                }
            } else {
                //LOAD VIEW WITH ERRORS
                return View::make('users/userLogin', $data);
            }
            //CHECK IF CURRENT USER DATA EXISTS
            if ($this->userModel->currentUser($data)) {
                header('location: ' . 'http://localhost:8000/blogPosts');
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
            return View::make('users/userLogin', $data);
        }
    }

    public function createUserSession($user){
        // user ID is coming from currentUser function in User controller, from dataRow as it is getting all data from any row
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_username'] = $user['username'];
        header('location: '. '/users/blogPosts');
    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_username']);
        $data = [
            'email' => '',
            'password' => '',
            'email_err' => '',
            'password_err' => '',
        ];
        session_destroy();
        return View::make('users/userLogin', $data);
    }

    public function isLoggedIn(){
        if($_SESSION['user_id']) {
            return true;
        } else {
            return false;
        }
    }
}