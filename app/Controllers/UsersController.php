<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
/** This was formally in SignUpController but got moved to UsersController */
class UsersController
{
    public function __construct(){
    }

/** REGISTER A NEW USER  */
    public function register(){
        //CHECK for POST
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
//            die('submit');
             //SANITIZE POST DATE
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
//            if(empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
//          if(empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
//          if(empty($this->params['email_err']) && empty($this->params['name_err']) && empty($this->params['password_err']) && empty($this->params['confirm_password_err'])){
          if(empty($this->data['email_err']) && empty($this->data['name_err']) && empty($this->data['password_err']) && empty($this->data['confirm_password_err'])){
                //VALIDATED
                die('SUCCESS');
            } else {
                //LOAD VIEW WITH ERRORS
                //$this->view('users/register', $data);
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

    /** LOGIN AS AN EXISTING USER  */
    public function userLogin(){
        //CHECK for POST
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            //PROCESS FORM
            $data =[
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => '',
            ];


            //Validate Email
            if(empty($data['email'])){
                $data['email_err'] = 'Please enter an email';
            }

            //Validate Password
            if(empty($data['password'])){
                $data['password_err'] = 'Please enter a password';
            }
            //MAKE SURE ERRORS ARE EMPTY
            if(empty($this->data['email_err']) && empty($this->data['password_err'])){
                //VALIDATED
                die('SUCCESS');
            } else {
                //LOAD VIEW WITH ERRORS
                //$this->view('users/register', $data);
                return View::make('users/usersLogin', $data);
            }



//            die('login');
            //PROCESS FORM
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