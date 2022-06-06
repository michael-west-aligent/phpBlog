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
    //METHOD(i.e get) -ROUTE i.e (/) - CONTROLLER (i.e HOMECONTROLLER)  -FUNCTION NAME FOUND IN CONTROLLER (i.e HOME)
    ->get('/', [\App\Controllers\HomeController::class, 'home'])
    ->get('/users/login', [\App\Controllers\UsersController::class, 'userLogin'])
    ->get('/users/register', [\App\Controllers\UsersController::class, 'register'])
    ->post('/users/register', [\App\Controllers\UsersController::class, 'register'])
    ->post('/users/userLogin', [\App\Controllers\UsersController::class, 'userLogin'])
    ->get('/users/logout', [\App\Controllers\UsersController::class, 'logout'])
    ->get('/users/blogPosts', [\App\Controllers\UsersController::class, 'userLogin'])
    ->get('/blogPosts', [\App\Controllers\PostControllers::class, 'blogPosts'])
    ->get('/blog/addBlog', [\App\Controllers\PostControllers::class, 'addBlog'])
    ->post('/blog/addBlog', [\App\Controllers\PostControllers::class, 'addBlog'])
    ->get('/blog/show', [\App\Controllers\PostControllers::class, 'showSingleBlog'])
    //HERE
    ->post('/blog/edit', [\App\Controllers\PostControllers::class, 'editBlog'])
    ->get('/blog/edit', [\App\Controllers\PostControllers::class, 'editBlog'])
    ->post('/blog/submitEdit', [\App\Controllers\PostControllers::class, 'updatePost']);




(new App(
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
    new \App\Config\Config($_ENV)
))->run();


