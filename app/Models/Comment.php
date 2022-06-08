<?php
namespace  App\Models;
use App\Config\App;

class Comment {
    public $db;

    public function __construct()
    {
        $this->db = App::db();
    }

    public function getCommentsById($id)
    {
        $commentsOnBlog = $this->db->prepare('SELECT body, username, comments.created_at, approved
                                                    FROM comments
                                                    INNER JOIN users
                                                    ON comments.user_id = users.id
                                                    WHERE post_id = ?;');
        $commentsOnBlog->execute([$id]);
        $dataRow = $commentsOnBlog->fetchAll();
        return $dataRow;
    }

//    public function addComment($data){
//        $newComment = $this->db->prepare('INSERT INTO comments (username, body, post_id, created_at) VALUES(?, ?, ?, ?, NOW()); ');
//        $newComment->execute([$data['username'], $data['post_id'], $data['body'], $data['post_id']]);
//        return true;
//    }

    public function addComment($user_id, $body, $post_id)
    {
        $newComment = $this->db->prepare('INSERT INTO comments (user_id, body, post_id, created_at) VALUES(?, ?, ?, ?, NOW()); ');
        $newComment->execute('user_id', 'body', 'post_id');
        return true;
    }
}