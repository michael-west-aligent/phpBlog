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
//            die('submitted');

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
            if(empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
                //VALIDATED
                die('SUCCESS');
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

//            die('login');
            //PROCESS FORM
        }else {
//            echo 'load form';
            //LOAD FORM
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