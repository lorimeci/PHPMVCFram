<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Core\Request;
use Core\Validator;

class PostController
{

    public Post $post;
    public User $user;
    public Category $category;
    public Request $request;
    public Validator $validator;
    public Comment $comment;

    public function __construct(
        Post $post,
        Request $request,
        Validator $validate,
        User $user,
        Category $category,
        Comment $comment)
    {
        $this->post = $post;
        $this->request = $request;
        $this->validator = $validate;
        $this->user = $user;
        $this->category = $category;
        $this->comment = $comment;
    }

    public function index()
    {
        $where = [];
        if (isCreator()) {
            $where = ['user_id' => getUser()['id']];
        } elseif (isAdmin()) {
            $where = [];
        }
        $page = $this->request->getBody()['page'] ?? $page = 1;
        $allPosts = $this->post->getByCondition($where, []);
        $allPosts = $this->post->rowCount();
        $limit = 3;
        $totalPages = ceil($allPosts / $limit);
        $offset = ($page - 1) * $limit;


        $posts =  $this->post->getByCondition($where, [], [], $limit, $offset);
        if(count($posts) > 0){
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
                $usersName[$user['id']] = $user['firstname'].' '.$user['lastname'];
            }
            $categories = $this->category->getByCondition(['id' => $categoryIds]);
            $categoriesName = [];
            foreach ($categories as $category) {
                $categoriesName[$category['id']] = $category['title'];
            }
            if($page > $totalPages){
                setFlash('error', 'Something went wrong.');
                redirect('/admin/posts');
            }
        }
        setLayout('dashboard');
        return renderOnlyView('admin/posts/index', [
            'posts' => $posts,
            'users' => $usersName ?? '',
            'categories' => $categoriesName ?? ' ',
            'currentpage' => $page,
            'totalPages' => $totalPages,
        ]); 
    }

    public function create()
    {
        setLayout('dashboard');
        return renderOnlyView('admin/posts/create', [
            'categories' => $this->category->getAll()
        ]);
    }

    public function store()
    {
        $data = $this->request->getBody();
        $data['date'] = new \DateTimeImmutable("now");
        $data['date'] = $data['date']->format('Y-m-d H-i-s');
        if ($this->validator->validate($data, $this->post->rulesPost(), Post::class)) {
            $target_dir = "uploads/";
            $fileName = basename($data["image"]["name"]);
            $dirSaved =  $target_dir . $fileName;
            if (move_uploaded_file($data["image"]["tmp_name"], $dirSaved)) {
                $data['image'] =  $fileName;
                if ($this->post->insert($data)) {
                    setFlash('success', 'Post is saved.');
                    redirect('/admin/posts');
                }
            }
            setFlash('error', 'Post is not saved.');
            redirect('/admin/posts');
        }
        setLayout('dashboard');
        return renderOnlyView('admin/posts/create', [
            'validator' => $this->validator,
            'user' => $this->user->getAll(),
            'categories' => $this->category->getAll()
        ]);
    }

    public function edit()
    {
        $id = $this->request->getBody()['id'];
        $post = $this->post->getById($id);

        if (!$id) {
            setFlash('error', 'Something went wrong.');
            redirect('/admin/posts');
        }
        if (!$post['id']) {
            setFlash('error', 'Post with this id does exists.');
            redirect('/admin/posts');
        }

        $category = $this->category->getById($post['category_id']);
        $post['category_title'] = [];
        $post['category_title'] = $category['title'];

        setLayout('dashboard');
        return renderOnlyView('admin/posts/edit', [
            'post' => $post,
            'categories' => $this->category->getAll(),
            'validator' => $this->validator,
        ]);
    }

    public function update()
    {
        $data = $this->request->getBody();
        $data['date'] = new \DateTimeImmutable("now");
        $data['date'] = $data['date']->format('Y-m-d H-i-s');
        $id = $data['id'];

        $post = $this->post->getById($id);
        $category = $this->category->getById($post['category_id']);
        $post['category_title'] = [];
        $post['category_title'] = $category['title'];
        if (!$id) {
            setFlash('error', 'Something went wrong.');
            redirect('/admin/posts');
        }
        if (!$post['id']) {
            setFlash('error', 'Post with this id does exists');
            redirect('/admin/posts');
        }
        if (empty($data['image']['tmp_name'])) {
            unset($data['image']);
        }
        
        if ($this->validator->validate($data, $this->post->rulesUpdatePost(), Post::class)) {
            if (isset($data['image'])) {
                $target_dir = "uploads/";
                $fileName = basename($data["image"]["name"]);
                $dirSaved =  $target_dir . $fileName;
                if(move_uploaded_file($data["image"]["tmp_name"], $dirSaved)){
                    $data['image'] =  $fileName;
                }
            }
            if ($this->post->update($id, $data)) {
                setFlash('success', 'Post is updated.');
                redirect('/admin/posts');
            } else {
                setFlash('error', 'Post is not updated.');
                redirect('/admin/posts');
            }
        }
        setLayout('dashboard');
        return renderOnlyView('admin/posts/edit', [
            'validator' => $this->validator,
            'post' => $post,
            'categories' => $this->category->getAll(),
        ]);
    }

    public function delete()
    {
        $id = $this->request->getBody()['id'];
        if (!$id) {
            setFlash('error', 'Something went wrong.');
            redirect('/admin/posts');
        }
        $user = getUser();
        $post = $this->post->getById($id);
        if(isCreator()){
            if(!$user && ($post['user_id'] != $user['id'])){
                setFlash('error', 'Something went wrong.');
                redirect('/admin/posts');
            }
        }

        $this->post->delete($id);
        setFlash('success', 'Post is deleted.');
        redirect('/admin/posts');
    }

    public function singlePost()
    {
        $data = $this->request->getBody();
        $id = $data['id'];
        if (!$id) {
            setFLash('error', 'Something went wrong.');
            redirect('/');
        }

        $data = $this->post->getSinglePost($id);

        return renderOnlyView('singlePost', [
            'validator' => $this->validator,
            'post' => $data['post'],
            'category' =>  $data['category']['title'],
            'categories' => $this->category->getAll(),
            'comments' => $data['comments'],
            'parent_id' => $data['parent_id'] ?? 0,
        ]);
    }
}

