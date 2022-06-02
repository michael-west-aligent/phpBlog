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
        $userStatement = $this->db->prepare('SELECT * FROM users WHERE email = ?');
        $userStatement->execute([$data['email']]);

        $dataRow = $userStatement->fetch();
        $hashed_password = $dataRow['password'];
        if(password_verify($data['password'], $hashed_password)) {
             return $dataRow;
         }else{
             return false;
         }
    }

    public function findUserByEmail($data) {
        $userStatement = $this->db->prepare('SELECT * FROM users WHERE email =?');
        $userStatement->execute([$data['email']]);
        $dataRow = $userStatement->fetch();
        return $dataRow;
    }




}