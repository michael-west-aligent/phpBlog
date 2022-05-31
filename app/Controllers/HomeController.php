<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use mysql_xdevapi\Executable;
use PDO;

class HomeController
{
    public function home()
    {
//        /** THIS TRY CATCH HANDLES PDO CONNECTIon  */
//    try {
//        $db = new PDO('mysql:host=db;dbname=blogDB', 'root', 'root');
//    } catch (\PDOException $e) {
//        throw new \PDOException($e->getMessage(), (int)$e->getCode());
//    }
//
//        $username = 'Michael6';
//        $email = 'Michael@email.com';
//        $password = 'abc123';
//        $is_admin = 1 ;
//        $title = 'NewTitle';
//
//
//        $created_at = date('Y-m-d H:m:i', strtotime('07/11/2021 9:00pm'));
//        $query = 'INSERT INTO users(username, email, password, is_admin, created_at)
//        VALUES (:username, :email, :password, :admin, :date)';
//
//        $newUserStmt = $db->prepare(
//            'INSERT INTO users (username, email, password, is_admin, created_at)
//VALUES (?, ?, ?, 1, NOW())'
//        );
//
//        $newPostStmt = $db->prepare(
//            'INSERT INTO posts (user_id, title, blody_bod, created_at)
//                    VALUES (?, ?, ? NOW()');
//
//        $newUserStmt->execute([$username, $email]);
//
//        $userId = (int)$db->lastInsertId();
//
//        $newPostStmt->execute([$title, $userId]);
//
//
//        $stmt = $db->prepare($query);
//
//        $stmt->bindValue('username', $username);
//        $stmt->bindValue('email', $email);
//        $stmt->bindValue('password', $password);
//        $stmt->bindValue('date', $created_at);
//        $stmt->bindParam('admin', $is_admin, PDO::PARAM_BOOL);
//
//        $is_admin = 0;
//        $name= 'foo bar';
//
//        $stmt->execute();
//
//        $id = (int) $db->lastInsertId();
//
//        $user = $db->query('SELECT * FROM users WHERE id =' . $id)->fetch();
//
//            echo '<pre>';
//            var_dump($user);
//            echo '</pre>';
//
//    } catch(\PDOException $e) {
//        throw new \PDOException($e->getMessage(), (int) $e->getCode());
//    }
        return View::make('index');
    }
}