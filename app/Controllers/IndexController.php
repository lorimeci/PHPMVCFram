<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Core\Request;
use Core\Response;
use Core\Validator;

class IndexController
{

  public Category $category;
  public Post $post;
  public User $user;
  public Response $response;
  public Request $request;
  public Validator $validator;
  public Comment $comment;


  public function __construct(
    Category $category,
    Post $post,
    Request $request,
    Validator $validate,
    User $user,
    Comment $comment)
  {
    $this->category = $category;
    $this->post = $post;
    $this->request = $request;
    $this->validator = $validate;
    $this->user = $user;
    $this->comment = $comment;
  }
  public function home()
  {
    $limit = 4;
    $recentPosts = $this->post->getByCondition([],[],['date' =>'DESC'], $limit, []);
    $posts =  $this->post->getByCondition([], [],[], $limit);
    
    $userIds = [];
    $categoryIds = [];
    foreach ($posts as $post) {
      $userIds[] = $post['user_id'];
      $categoryIds[] = $post['category_id'];
    }
    $userIds = array_unique($userIds);
    $users = $this->user->getByCondition(['id' => $userIds]);
    $usersName = [];
    foreach ($users as $user) {
      $usersName[$user['id']] = $user['firstname'] .' ' .$user['lastname'];
    }

    $categories = $this->category->getByCondition(['id' => $categoryIds]);
    $categoriesName = [];
    foreach ($categories as $category) {
      $categoriesName[$category['id']] = $category['title'];
    }

    return renderOnlyView('home', [
      'categories' => $this->category->getAll(),
      'posts' => $posts,
      'users' => $usersName,
      'categoriesName' => $categoriesName,
      'recentPosts' => $recentPosts,
    ]);
  }

  public function profile()
  {
    $id = $this->request->getBody()['id'];
    setLayout('main');
    return renderOnlyView('admin/users/profile');
  }

    public function search()
    {
      $data = $this->request->getBody();
      $page = $this->request->getBody()['page'] ?? $page = 1;
      $limit = 2;
      $allPosts = $this->post->getByCondition([],['title'=> $data['search'], 'description'=> $data['search']]);
      $allPosts = $this->post->rowCount();
      $totalPages = ceil($allPosts / $limit);
      $offset = ($page - 1) * $limit;


      $posts = $this->post->getByCondition([],['title'=>$data['search'], 'description'=> $data['search']],[], $limit, $offset);
      foreach ($posts as &$post) {
        $user = $this->user->getById($post['user_id']);
        $post['author'] = $user['firstname'] . ' ' . $user['lastname'];
        $category = $this->category->getById($post['category_id']);
        $post['name'] = $category['title'];
      }  
      return renderOnlyView('search',[
        'posts' => $posts,
        'categories' => $this->category->getAll(),
        'search'=> $data['search'],
        'currentpage' => $page,
        'totalPages' => $totalPages,
      ]);     
    }
}
