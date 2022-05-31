<?php

namespace App\Models;

use App\Config\App;
use App\Controllers\UsersController;


class User {

    public $db;

    public function __construct()
    {

        $this->db = App::db();
    }

    //Register a user
    public function newRegister ($data) {

        $newUser = $this->db->prepare('INSERT INTO users (username, email, password) VALUES(?,?,?)');
        $newUser->execute([$data['name'], $data['email'], $data['password']]);

        return true;
    }

    //Login as a user
    public function currentUser($data){
        $userToLogin = $this->db->prepare('SELECT * FROM users WHERE email = ?');
        $userToLogin->execute([$data['email']]);

        //if statement, to check result of select statement

//        $row = $this->db->fetch();
//        $hashed_password = $row->password;
        if(password_verify($data['password'], $hashed_password)) {
             return $row;
         }else{
             return false;
         }
    }

    public function findUserByEmail(mixed $email)
    {
    }
}