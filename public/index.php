<?php

//require_once '../app/bootstrap.php';
session_start();
require_once __DIR__ . '/../vendor/autoload.php';


use App\Config\App;
use App\Config\Config;
use App\Routers\Router;
use App\Controllers\HomeController;
use App\Config\DB;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

const VIEW_PATH = __DIR__ . '/../app/Views';

$router = new Router();


$router
    ->get('/', [\App\Controllers\HomeController::class, 'home'])
    ->get('/users/login', [\App\Controllers\UsersController::class, 'userLogin'])
    ->get('/users/register', [\App\Controllers\UsersController::class, 'register'])
    ->post('/users/register', [\App\Controllers\UsersController::class, 'register'])
    ->post('/users/userLogin', [\App\Controllers\UsersController::class, 'userLogin'])
    ->get('/users/logout', [\App\Controllers\UsersController::class, 'logout'])
    ->get('/users/blogPosts', [\App\Controllers\UsersController::class, 'userLogin'])
    ->get('/blogPosts', [\App\Controllers\PostControllers::class, 'blogPosts'])
    //GET NUMBER OF COMMENTS
     ->get('/blogComments', [\App\Controllers\PostControllers::class, 'getBlogComments'])
    ->get('/blog/addBlog', [\App\Controllers\PostControllers::class, 'addBlog'])
    ->post('/blog/addBlog', [\App\Controllers\PostControllers::class, 'addBlog'])
    ->get('/blog/show', [\App\Controllers\PostControllers::class, 'showSingleBlog'])
    ->post('/blog/edit', [\App\Controllers\PostControllers::class, 'editBlog'])
    ->get('/blog/edit', [\App\Controllers\PostControllers::class, 'editBlog'])
    ->post('/blog/submitEdit', [\App\Controllers\PostControllers::class, 'updatePost'])
    ->post('/blog/delete', [\App\Controllers\PostControllers::class, 'deleteBlog'])
    ->post('/blog/addComment', [\App\Controllers\CommentControllers::class, 'addBlogComment'])
    ->get('/admin/home', [\App\Controllers\UsersController::class, 'adminHome'])
    ->get('/admin/addUser', [\App\Controllers\UsersController::class, 'adminAddUser'])
    ->post('/admin/addUser', [\App\Controllers\UsersController::class, 'adminAddUser'])
    ->post('/admin/updateUser', [\App\Controllers\UsersController::class, 'adminUpdateUser2'])
    ->get('/admin/updateUser', [\App\Controllers\UsersController::class, 'adminUpdateUser'])
    ->post('/admin/userStatus', [\App\Controllers\UsersController::class, 'adminUpdateUser'])
    ->post('/admin/delete', [\App\Controllers\UsersController::class, 'removeUser'])
    ->post('/admin/home', [\App\Controllers\PostControllers::class,'adminSeeBlogs'])
    ->post('/admin/editBlog', [\App\Controllers\PostControllers::class, 'adminEditBlog'])
    ->get('/admin/editBlog', [\App\Controllers\PostControllers::class, 'adminEditBlog'])
    ->post('/admin/deleteBlog', [\App\Controllers\PostControllers::class, 'adminDeleteBlog'])
    ->post('/admin/submitEditBlog', [\App\Controllers\PostControllers::class, 'updatePost'])
    ->get('/admin/approveBlogComment', [\App\Controllers\PostControllers::class, 'adminFullBlog'])
    ->post('/admin/approvedComment', [\App\Controllers\CommentControllers::class, 'adminApproved'])
    ->post('/admin/deleteBlogComment', [\App\Controllers\CommentControllers::class, 'adminDeleteBlogComment']);

(new App(
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
    new \App\Config\Config($_ENV)
))->run();


