<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use App\Models\User;


class UsersController
{
    CONST REQUEST_METHOD_POST = 'POST';
    protected User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /** validate user inputs
     * @param $data
     * @return mixed
     */
    public function validateUser($data): mixed
    {
        if (empty($data['email'])) {
            $data['email_err'] = 'Please enter an email';
        } else {
            if ($this->userModel->findUserByEmail($data)) {
                $data['email_err'] = "Email being used";
            }
        }
        if (empty($data['name'])) {
            $data['name_err'] = 'Please enter a name';
        } else {
            if($this->userModel->finderUserByUsername($data)) {
                $data['name_err'] = "Username being used";
            }
        }
        if (empty($data['password'])) {
            $data['password_err'] = 'Please enter a password';
        } elseif (strlen($data['password']) < 6) {
            $data['password_err'] = 'Password must be at least 6 characters';
        }
        if (empty($data['confirm_password'])) {
            $data['confirm_password_err'] = 'Please confirm password';
        } else {
            if ($data['password'] != $data['confirm_password']) {
                $data['confirm_password_err'] = 'Passwords do not match, try again';
            }
        }
        return $data;
    }

    /**
     * register a new user
     * @return View|void
     */
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == self::REQUEST_METHOD_POST) {
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
            $data2 = $this->validateUser($data);
            if (empty($data2['email_err']) && empty($data2['name_err']) && empty($data2['password_err']) && empty($data2['confirm_password_err'])) {
                $data2['password'] = password_hash($data2['password'], PASSWORD_DEFAULT);
                if ($this->userModel->newRegister($data2)) {
                    header('location: ' . 'http://localhost:8000/users/login');
                }
            } else {
                return View::make('users/userRegister', $data2);
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

    /**
     * user login to blog page
     * @return View|void
     */
    public function userLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] == self::REQUEST_METHOD_POST) {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => '',
            ];
            $dataRow = $this->userModel->findUserByEmail($data);
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter an email';
            } else {
                if (!$dataRow) {
                    $data['email_err'] = 'Invalid attempt';
                }
            }
            if(!empty($dataRow)) {
                $hashed_password = $dataRow['password'];
            } else {$hashed_password = '';
            }
                if (empty($data['password'])) {
                    $data['password_err'] = 'Please enter a password';
                } elseif (!password_verify($data['password'], $hashed_password)) {
                    $data['password_err'] = 'Invalid attempt';
                }
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
                return View::make('users/userLogin', $data);
        }
    }

    /**
     *direct where to go once logged in based on admin status
     * @return View|void
     */
    public function adminHome()
    {
        if ($_SESSION != null) {
            if ($_SESSION['is_admin'] == 1) {
                $users = $this->userModel->getUserinfo();
                $data = [
                    'users' => $users,
                ];
                return View::make('/admin/home', $data);
            } else if ($_SESSION['is_admin'] == 0) {
                header('location: ' . 'http://localhost:8000/blogPosts');
            }
        } else {
            header('location: ' . 'http://localhost:8000/users/login');
        }
    }

    /**
     * logged in admin to create a new user
     * @return View|void
     */
    public function adminAddUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == self::REQUEST_METHOD_POST) {
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
            $data2 = $this->validateUser($data);
            if (empty($data2['email_err']) && empty($data2['name_err']) && empty($data2['password_err']) && empty($data2['confirm_password_err']) && empty($data2['is_admin_err'])) {
                $data2['password'] = password_hash($data2['password'], PASSWORD_DEFAULT);
                        if ($this->userModel->adminUserAdd($data2)) {
            header('location: ' . 'http://localhost:8000/admin/home');
        }
            } else {
                return View::make('admin/addUser', $data2);
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
            return View::make('admin/addUser', $data);
        }
    }



    public function adminUpdateUser(): View
    {
            $data = [
                'user_id' => (intval($_POST['id'])),
                'is_admin' => (intval($_POST['is_admin'])),
            ];
            return View::make('admin/updateUser', $data);
    }

    public function adminUpdateUser2(): void
    {
        $data = [
            'user_id' => (intval($_POST['user_id'])),
            'is_admin' => isset($_POST['is_admin']),
        ];
        $this->userModel->adminUpdate($data);
    }

    /**
     * delete user
     * @return void
     */
    public function removeUser(): void
    {
        if($_SERVER['REQUEST_METHOD'] == self::REQUEST_METHOD_POST)
        {
            $id = explode('?', $_SERVER['REQUEST_URI'])[1];
            if($this->userModel->adminRemove($id))
            {
                header('location: ' . 'http://localhost:8000/admin/home');
            } else {
                die('Unable to delete User ');
            }
        }
    }

    /**
     * create a userSession
     * @param $user
     * @return void
     */
    public function createUserSession($user): void
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_username'] = $user['username'];
        $_SESSION['is_admin'] = $user['is_admin'];
    }

    /**
     * logout and destroy session
     * @return View
     */
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