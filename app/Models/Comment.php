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
//        $commentsOnBlog = $this->db->prepare('SELECT * FROM comments WHERE post_id = ?');
        $commentsOnBlog = $this->db->prepare('SELECT body, username, comments.created_at, approved
                                                    FROM comments
                                                    INNER JOIN users
                                                    ON comments.user_id = users.id
                                                    WHERE post_id = ?;');
        $commentsOnBlog->execute([$id]);
        $dataRow = $commentsOnBlog->fetchAll();
        return $dataRow;
    }

}