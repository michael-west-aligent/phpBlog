<?php

namespace App\Models;

use App\Config\App;

class User {
    public $db;

    public function __construct()
    {
        $this->db = App::db();
    }

    public function newRegister ($data): bool
    {
        $newUser = $this->db->prepare('INSERT INTO users (username, email, password) VALUES(?,?,?)');
        $newUser->execute([$data['name'], $data['email'], $data['password']]);
        return true;
    }

    public function adminUserAdd($data): bool
    {
        $newUser = $this->db->prepare('INSERT INTO users (username, email, password, is_admin) VALUES(?,?,?,?)');
        $newUser->execute([$data['name'], $data['email'], $data['password'], $data['is_admin']]);
        return true;
    }

    public function adminUpdate($data): bool
    {
        $updateUserDetails = $this->db->prepare('UPDATE users SET is_admin = ? WHERE id = ? ');
        $updateUserDetails->execute([$data['is_admin'], $data['user_id']]);
        header('location: ' . 'http://localhost:8000/admin/home');
        return true;
    }

    public function adminRemove($id): bool
    {
        $deleteUser = $this->db->prepare('DELETE FROM users where id = ?');
        $id = explode('?', $_SERVER['REQUEST_URI'])[1];
        $deleteUser->execute([$id]);
        return true;
    }

    public function currentUser($email, $password){
        $userStatement = $this->db->prepare('SELECT * FROM users WHERE email = ?');
        $userStatement->execute([$email]);

        $dataRow = $userStatement->fetch();
        if(!is_bool($dataRow)) {
            $hashed_password = $dataRow['password'];
        } else {$hashed_password = ''; }
        if(password_verify($password, $hashed_password)) {
             return $dataRow;
         }else{
             return false;
         }
    }

    public function findUserByEmail($data) {
        $userStatement = $this->db->prepare('SELECT username, email, password FROM users WHERE email =?');
        $userStatement->execute([$data['email']]);
        $dataRow = $userStatement->fetch();
        return is_bool($dataRow) ? [] : $dataRow;
    }

    public function finderUserByUsername($data) {
        $userStatement = $this->db->prepare('SELECT username FROM users WHERE username =?');
        $userStatement->execute([$data['name']]);
        $dataRow = $userStatement->fetch();
        return $dataRow;
    }

    public function getUserById($id) {
        $userStatement = $this->db->prepare('SELECT * FROM users WHERE id = ?');
        $userStatement->execute([$id]);
        $dataRow = $userStatement->fetch();
        return $dataRow;
    }

    public function getUserinfo(){
        $adminUserStatement = $this->db->prepare('SELECT id, username, email, is_admin, created_at, password from users;');
        $adminUserStatement->execute();
        $dataRow = $adminUserStatement->fetchAll();
        return $dataRow;
    }

}