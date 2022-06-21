<?php

namespace App\Models;

use App\Config\App;

class Post
{
    public $db;

    public function __construct()
    {
        $this->db = App::db();
    }

    //GET ALL THE BLOG POTS FROM DB
//    public function getAllBlogPosts()
//    {
//        $postStatement = $this->db->query('SELECT *,
//                                                    posts.id as postId,
//                                                    users.id as userId,
//                                                    posts.created_at as postCreated,
//                                                    users.created_at as userCreated
//                                                    FROM posts
//                                                    INNER JOIN users
//                                                    ON posts.user_id = users.id
//                                                    ORDER BY posts.created_at DESC');
//        $results = $postStatement->fetchAll();
//        return $results;
//    }

    public function getAllBlogPosts()
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
        foreach ($results as &$result ) {
            $result['postComments'] = $this->numberofComments($result['postId']);
        }
        return $results;
    }

        public function numberofComments($postId){
        $statement = $this->db->prepare('SELECT COUNT(post_id) as postComments from comments WHERE post_id = ?;');
            $statement->bindParam(1, $postId);
        $statement->execute();

        return   $statement->fetch();
    }


    public function adminBlogInfoHome()
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
        $results = $postInfo->fetchAll();
        return $results;
    }

    //set bloghome page limit to 4 blogs
    public function blogsPostsForHomePage()
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

    public function addPost($data)
    {
        $newBlogPost = $this->db->prepare('INSERT INTO posts  (title, user_id, blog_body, created_at) VALUES(?,?,?, NOW())');
        $newBlogPost->execute([$data['title'], $data['user_id'], $data['blog_body']]);
        return true;
        header('location: ' . 'http://localhost:8000/blogPosts');
    }

    public function adminUpdateBlog($data)
    {
        $adminUpdateBlog = $this->db->prepare('UPDATE posts SET title = ?, blog_body = ?, created_at = NOW() WHERE id = ?');
        $adminUpdateBlog->execute([$data[0], $data[1], $data[2]]);
        header('location: ' . 'http://localhost:8000/admin/home');
        return true;
    }

    public function updatePost($data)
    {
        $newBlogPost = $this->db->prepare('UPDATE posts SET title = ?, blog_body = ?, created_at = NOW() WHERE id = ?');
        $newBlogPost->execute([$data[0], $data[1], $data[2]]);
        header('location: ' . 'http://localhost:8000/blogPosts');
        return true;
    }

    public function updateEditPost($data)
    {
        $newBlogPost = $this->db->prepare('UPDATE posts SET title = ?, blog_body = ?, created_at = NOW() WHERE id = ?');
        $newBlogPost->execute([$data['title'], $data['blog_body'], $data['id']]);
        header('location: ' . 'http://localhost:8000/blogPosts');
        return true;
    }

    public function getPostById($id)
    {
        $singleBlog = $this->db->prepare('SELECT * FROM posts WHERE id = ?');
        $singleBlog->execute([$id]);
        $results = $singleBlog->fetch();
        return $results;
    }

    public function deletePost($postId)
    {
        $deleteBlogPost = $this->db->prepare('DELETE FROM posts WHERE id = ?');
        $deleteBlogPost->execute([$postId]);
        return true;
    }

}