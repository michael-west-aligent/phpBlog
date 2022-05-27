<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
/** This was formally in SignUpController but got moved to UsersController */
class UsersController
{
    public function __construct(){
    }


    public function userRegister(): View
    {
        return View::make('users/userRegister');
    }

    public function register(){
        //CHECK for POST
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //PROCESS FORM
        }else {
//            echo 'load form';
            //LOAD FORM
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
}