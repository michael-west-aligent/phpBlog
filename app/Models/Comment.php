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
        $commentsOnBlog = $this->db->prepare('SELECT body, username, comments.created_at, approved, comments.id
                                                    FROM comments
                                                    INNER JOIN users
                                                    ON comments.user_id = users.id
                                                    WHERE post_id = ?;');
        $commentsOnBlog->execute([$id]);
        $dataRow = $commentsOnBlog->fetchAll();
        return is_bool($dataRow) ? [] : $dataRow;
    }

    public function addComment($data)
    {
        $newComment = $this->db->prepare('INSERT INTO comments (user_id, body, post_id, created_at) VALUES(?, ?, ?, NOW()); ');
        $newComment->execute([$data['user_id'], $data['body'], $data['post_id']]);
        return true;
    }

    public function adminApproved($data) {
        $adminUpdateBlog = $this->db->prepare('UPDATE comments SET  approved = ?  WHERE id = ?');
        $adminUpdateBlog->execute([$data['approved'], $data['comment_id']]);
        header('location: ' . 'http://localhost:8000/admin/approveBlogComment?' . $data['post_id']);
        return true;
    }

    public function adminDeleteComment($comment_id){
        $deleteBlogPostComment = $this->db->prepare('DELETE FROM comments WHERE id = ?');
        $deleteBlogPostComment->execute([$comment_id]);
        return true;
    }
}


