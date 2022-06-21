<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use App\Models\User;


class UsersController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
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
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter an email';
            } else {
                //Check the DB for email, if exists display validation warning.
                if ($this->userModel->findUserByEmail($data)) {
                    $data['email_err'] = "Email being used";
                }
            }
            //Validate Name
            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter a name';
            } else {
                if($this->userModel->finderUserByUsername($data)) {
                    $data['name_err'] = "Username being used";
                }
            }
            //Validate Password
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter a password';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }
            //Validate Confirm Password
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm password';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match, try again';
                }
            }
            //Make sure there are no errors and then hashpassword
            if (empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                //HASH PASSWORD
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                //REGISTER USER and direct to login page
                if ($this->userModel->newRegister($data)) {
                    header('location: ' . 'http://localhost:8000/users/login');
                }
            } else {
                return View::make('users/userRegister', $data);
            }
        }
        else {
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
            return View::make('users/userRegister', $data);
        }
    }

    public function userLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
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
                if (!$dataRow) {
                    $data['email_err'] = 'No user with that email ';
                }
            }
            if(!empty($dataRow)) {
                $hashed_password = $dataRow['password'];
            } else {$hashed_password = '';
            }
                if (empty($data['password'])) {
                    $data['password_err'] = 'Please enter a password';
                }

                elseif (!password_verify($data['password'], $hashed_password)) {
                    $data['password_err'] = 'Password does not match';
                }
                //Make sure errors are empty, if empty of error create a new user
                if (empty($data['email_err']) && empty($data['password_err'])) {
                    $currentUser = $this->userModel->currentUser($data['email'], $data['password']);
                    if ($currentUser) {
                        $this->createUserSession($currentUser);
                    }
                }
                $user = $this->userModel->currentUser($data['email'], $data['password']);
                if ($user != null) {
                    if ($user['is_admin'] == 1) {
                        //if logged in as an admin direct to admin homepage
                        header('location: ' . 'http://localhost:8000/admin/home');
                    }
                    if ($user['is_admin'] == 0) {
                        //if logged in a general user direct to blogPosts homepage.
                        header('location: ' . 'http://localhost:8000/blogPosts');
                    }
                } else {
                    return View::make('users/userLogin', $data);
                }
            } else {
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

    public function adminHome()
    {
        if ($_SESSION != null) {
            if ($_SESSION['is_admin'] == 1) {
                $users = $this->userModel->getUserinfo();
                $data = [
                    'users' => $users,
                ];
                return View::make('/admin/home', $data);
                //if not an admin redirect to blogPosts homepage
            } else if ($_SESSION['is_admin'] == 0) {
                header('location: ' . 'http://localhost:8000/blogPosts');
            }
        } else {
            header('location: ' . 'http://localhost:8000/users/login');
        }
    }

    public function adminAddUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'is_admin' => isset($_POST['is_admin']),
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            //Validate Email
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter an email';
            } else {
                //CHECK EMAIL IS NOT ALREADY IN DB
                if ($this->userModel->findUserByEmail($data)) {
                    $data['email_err'] = "Email being used";
                }
            }
            //Validate name
            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter a name';
            } else {
                if($this->userModel->finderUserByUsername($data)) {
                    $data['name_err'] = "name being used";
                }
            }
            //Validate Password
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter a password';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }
            //Validate Confirm Password
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm password';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match, try again';
                }
            }
            //Make sure errors are empty
            if (empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err']) && empty($data['is_admin_err'])) {
                //HASH PASSWORD
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            } else {
                //LOAD VIEW WITH ERRORRs
                return View::make('admin/addUser', $data);
            }
        } else {
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'is_admin' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'is_admin_err' => '',
            ];
            //LOAD VIEW FILE
            return View::make('admin/addUser', $data);
        }
        if ($this->userModel->adminUserAdd($data)) {
            header('location: ' . 'http://localhost:8000/admin/home');
        }
    }

    public function adminUpdateUser()
    {
            $data = [
                'user_id' => (intval($_POST['id'])),
                'is_admin' => (intval($_POST['is_admin'])),
            ];
            return View::make('admin/updateUser', $data);
    }

    public function adminUpdateUser2(){
        $data = [
            'user_id' => (intval($_POST['user_id'])),
            'is_admin' => isset($_POST['is_admin']),
        ];
        $this->userModel->adminUpdate($data);
    }

    public function removeUser() {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $id = explode('?', $_SERVER['REQUEST_URI'])[1];
            if($this->userModel->adminRemove($id))
            {
                header('location: ' . 'http://localhost:8000/admin/home');
            } else {
                die('something is not working');
            }
        }
    }

    public function createUserSession($user)
    {
        // user ID is coming from currentUser function in User controller, from dataRow as it is getting all data from any row
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_username'] = $user['username'];
        $_SESSION['is_admin'] = $user['is_admin'];
    }

    public function logout()
    {
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

}