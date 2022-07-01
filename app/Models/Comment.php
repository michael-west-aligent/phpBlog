<?php
namespace  App\Models;
use App\Config\App;

class Comment {
    public $db;

    public function __construct()
    {
        $this->db = App::db();
    }

    /**
     * @param $id
     * @return bool|array
     */
    public function getCommentsById($id): bool|array
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

    /**
     * @param $data
     * @return bool
     */
    public function addComment($data): bool
    {
        $newComment = $this->db->prepare('INSERT INTO comments (user_id, body, post_id, created_at, approved) VALUES(?, ?, ?, NOW(), FALSE); ');
        $newComment->execute([$data['user_id'], $data['body'], $data['post_id']]);
        return true;
    }

    /**
     * @param $data
     * @return bool
     */
    public function approveComment($data): bool
    {
        $adminUpdateBlog = $this->db->prepare('UPDATE comments SET  approved = ?  WHERE id = ?');
        $adminUpdateBlog->execute([$data['approved'], $data['comment_id']]);
        header('location: ' . 'http://localhost:8000/admin/approveBlogComment?' . $data['post_id']);
        return true;
    }

    /**
     * @param $comment_id
     * @return bool
     */
    public function delete($comment_id): bool
    {
        $deleteBlogPostComment = $this->db->prepare('DELETE FROM comments WHERE id = ?');
        $deleteBlogPostComment->execute([$comment_id]);
        return true;
    }

    /**
     * @param $data
     * @return bool
     */
    public function validate($data)
    {
        if (empty($data['body'])) {
            return false;
        }
        if (strlen($data['body']) > 50) {
            return false;
        }
        return true;
    }

    /**
     * @param $data
     * @return string
     */
    public function validationError($data): string
    {
        $error = '';
        if (empty($data['body'])) {
            $error = 'Please enter a comment';
        }
        else if (strlen($data['body']) > 50) {
            $error = 'Blog body must be less than 50 characters';
        }
        return $error;
    }
}


