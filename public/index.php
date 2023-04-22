<?php
use Core\Container;
use Core\Response;
use Core\Request;
use Core\Router;
use Core\Session;
use Core\View;
use App\Controllers\CategoryController;
use App\Controllers\CommentController;
use App\Controllers\UserController;
use App\Controllers\IndexController;
use App\Controllers\PostController;
use App\Middleware\AuthMiddleware;
use App\Middleware\CreatorMiddleware;
use App\Middleware\AdminMiddleware;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Container;

$app->singleton(Request::class, Request::class);
$app->singleton(Response::class, Response::class);
$app->singleton(View::class, View::class);
$app->singleton(Session::class, Session::class); 

$response = $app->get(Response::class);
$request = $app->get(Request::class);
$router = $app->get(Router::class);


$router->get('/', [IndexController::class, 'home']);
$router->get('/register', [UserController::class, 'register']);
$router->post('/register', [UserController::class, 'signup']);
$router->get('/login', [UserController::class, 'login']);
$router->post('/login', [UserController::class, 'loginUser']);
$router->get('/logout', [UserController::class, 'logout'])->addMiddleware([AuthMiddleware::class]);
$router->get('/profile', [IndexController::class, 'profile'])->addMiddleware([AuthMiddleware::class]);
$router->get('/search', [IndexController::class, 'search']);


$router->get('/dashboard', [UserController::class, 'dashboard'])->addMiddleware([AuthMiddleware::class]);
$router->get('/admin/users', [UserController::class, 'users'])->addMiddleware([AdminMiddleware::class]);
$router->get('/admin/user/create', [UserController::class, 'create'])->addMiddleware([AdminMiddleware::class]);
$router->post('/admin/user/create', [UserController::class, 'store'])->addMiddleware([AdminMiddleware::class]);
$router->get('/admin/user/edit', [UserController::class, 'edit'])->addMiddleware([AdminMiddleware::class]);
$router->post('/admin/user/edit', [UserController::class, 'update'])->addMiddleware([AdminMiddleware::class]);
$router->get('/admin/user/delete', [UserController::class, 'delete'])->addMiddleware([AdminMiddleware::class]);

$router->get('/admin/categories', [CategoryController::class, 'index'])->addMiddleware([AdminMiddleware::class]);
$router->get('/admin/category/create', [CategoryController::class, 'create'])->addMiddleware([AdminMiddleware::class]);
$router->post('/admin/category/create', [CategoryController::class, 'store'])->addMiddleware([AdminMiddleware::class]);
$router->get('/admin/category/edit', [CategoryController::class, 'edit'])->addMiddleware([AdminMiddleware::class]);
$router->post('/admin/category/edit', [CategoryController::class, 'update'])->addMiddleware([AdminMiddleware::class]);
$router->get('/admin/category/delete', [CategoryController::class, 'delete'])->addMiddleware([AdminMiddleware::class]);
$router->get('/category', [CategoryController::class, 'category']);

$router->get('/admin/posts', [PostController::class, 'index'])->addMiddleware([CreatorMiddleware::class]);
$router->get('/admin/post/create', [PostController::class, 'create'])->addMiddleware([CreatorMiddleware::class]);
$router->post('/admin/post/create', [PostController::class, 'store'])->addMiddleware([CreatorMiddleware::class]);
$router->get('/admin/post/edit', [PostController::class, 'edit'])->addMiddleware([CreatorMiddleware::class]);
$router->post('/admin/post/edit', [PostController::class, 'update'])->addMiddleware([CreatorMiddleware::class]);
$router->get('/admin/post/delete', [PostController::class, 'delete'])->addMiddleware([CreatorMiddleware::class]);
$router->get('/post', [PostController::class, 'singlePost']);
$router->post('/post', [CommentController::class, 'comment']);

$router->get('/admin/comments', [CommentController::class, 'index'])->addMiddleware([AdminMiddleware::class]);
$router->get('/admin/comment/edit', [CommentController::class, 'edit'])->addMiddleware([AdminMiddleware::class]);
$router->post('/admin/comment/edit', [CommentController::class, 'update'])->addMiddleware([AdminMiddleware::class]);
$router->get('/admin/comment/delete', [CommentController::class, 'delete'])->addMiddleware([AdminMiddleware::class]);

$router->run();
$response->send();
