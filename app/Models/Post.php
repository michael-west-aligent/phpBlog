<?php

namespace App\Models;

use App\Config\App;
use App\View;


class Post
{
    public $db;

    public function __construct()
    {
        $this->db = App::db();
    }

    /**
     * get all blog information
     * @return array|false
     */
    public function getAllBlogPosts(): bool|array
    {
        $postStatement = $this->db->query('SELECT *,
                                                    posts.id as postId,
                                                    users.id as userId,
                                                    posts.created_at as postCreated,
                                                    users.created_at as userCreated
                                                    FROM posts
                                                    INNER JOIN users
                                                    ON posts.user_id = users.id
                                                    ORDER BY posts.created_at DESC');
        $results = $postStatement->fetchAll();
        foreach ($results as &$result) {
            $result['postComments'] = $this->numberofComments($result['postId']);
        }
        return $results;
    }

    /**
     * get number of comments on a post
     * @param $postId
     * @return mixed
     */
    public function numberofComments($postId): mixed
    {
        $statement = $this->db->prepare('SELECT COUNT(post_id) as postComments from comments WHERE post_id = ?;');
        $statement->bindParam(1, $postId);
        $statement->execute();

        return $statement->fetch();
    }

    /**
     * get neccessary data for admin home page
     * @return array|false
     */
    public function adminBlogInfoHome(): bool|array
    {
        $postInfo = $this->db->query('SELECT *,
       posts.id as postId,
       users.id as userId,
       posts.created_at as postCreated,
       users.created_at as userCreated
FROM posts
         INNER JOIN users
                    ON posts.user_id = users.id
ORDER BY posts.created_at DESC;');
        return $postInfo->fetchAll();
    }

    /**
     * set the number of blogs to homepage as 4,
     * @return array|false
     */
    public function blogsPostsForHomePage(): bool|array
    {
        $postStatement = $this->db->query('SELECT *,
                                                    posts.id as postId, 
                                                    users.id as userId, 
                                                    posts.created_at as postCreated,
                                                    users.created_at as userCreated
                                                    FROM posts
                                                    INNER JOIN users
                                                    ON posts.user_id = users.id
                                                    ORDER BY posts.created_at DESC limit 4');
        $results = $postStatement->fetchAll();
        return $results;
    }

    /**
     * get info so new post can be added
     * @param $data
     * @return bool|void
     */
    public function addPost($data)
    {
        try {
            $newBlogPost = $this->db->prepare('INSERT INTO posts  (title, user_id, blog_body, created_at) VALUES(?,?,?, NOW())');
            $newBlogPost->execute([$data['title'], $data['user_id'], $data['blog_body']]);
            header('location: ' . 'http://localhost:8000/blogPosts');
            return true;
        } catch (\Exception $e) {
            echo View::make('error/404', (array)$e);
        }    }

    /**
     * admin can update Blog based on id
     * @param $data
     * @return bool
     */
    public function adminUpdateBlog($data): bool
    {
        $adminUpdateBlog = $this->db->prepare('UPDATE posts SET title = ?, blog_body = ?, created_at = NOW() WHERE id = ?');
        $adminUpdateBlog->execute([$data[0], $data[1], $data[2]]);
//        header('location: ' . 'http://localhost:8000/admin/home');
        return true;
    }

    /**
     * updatePost based on id
     * @param $data
     * @return bool
     */
    public function updatePost($data): bool
    {
        $newBlogPost = $this->db->prepare('UPDATE posts SET title = ?, blog_body = ?, created_at = NOW() WHERE id = ?');
        $newBlogPost->execute([$data[0], $data[1], $data[2]]);
//        header('location: ' . 'http://localhost:8000/blogPosts');
        return true;
    }


    /** updating the edited post
     * @param $data
     * @return bool
     */
    public function updateEditPost($data): bool
    {
        $newBlogPost = $this->db->prepare('UPDATE posts SET title = ?, blog_body = ?, created_at = NOW() WHERE id = ?');
        $newBlogPost->execute([$data['title'], $data['blog_body'], $data['id']]);
//        header('location: ' . 'http://localhost:8000/blogPosts');
        return true;
    }

    /**
     * select all data for specfic post based on id
     * @param $id
     * @return mixed
     */
    public function getPostById($id): mixed
    {
        $singleBlog = $this->db->prepare('SELECT * FROM posts WHERE id = ?');
        $singleBlog->execute([$id]);
        $results = $singleBlog->fetch();
        return $results;
    }

    /**
     * delete blogpost based on id
     * @param $postId
     * @return bool
     */
    public function deletePost($postId): bool
    {
        $deleteBlogPost = $this->db->prepare('DELETE FROM posts WHERE id = ?');
        $deleteBlogPost->execute([$postId]);
        return true;
    }

    /**
     * validate post data
     * @param $data
     * @return bool
     */
    public function validate($data)
    {
        if (empty($data['title'])) {
            return false;
        }
        if (empty($data['blog_body'])) {
            return false;
        } elseif (strlen($data['blog_body']) > 76) {
            return false;
        }
        return true;
    }

    /**
     * check for validation errors
     * @param $data
     * @return string
     */
    public function validationError($data) : string
    {
        if (empty($data['title'])) {
            return 'Please enter a blog title';
        }
        if (empty($data['blog_body'])) {
            return 'Please enter a blog body';
        } elseif (strlen($data['blog_body']) > 76) {
            return 'Blog body must be less than 76 characters';
        }
        return '';
    }








}