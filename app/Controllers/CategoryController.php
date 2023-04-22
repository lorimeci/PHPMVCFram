<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Core\Request;
use Core\Validator;

class CategoryController
{
    public Category $category;
    public Request $request;
    public Validator $validator;
    public User $user;
    public Post $post;

    public function __construct(
        Category $category,
        Request $request,
        Validator $validate,
        Post $post,
        User $user)
    {
        $this->category = $category;
        $this->request = $request;
        $this->validator = $validate;
        $this->post = $post;
        $this->user = $user;
    }

    public function index()
    {
        $page = $this->request->getBody()['page'] ?? $page = 1;

        $allCategory = $this->category->count();
        $limit = 5;
        $totalPages = ceil ($allCategory / $limit);
        $offset = ($page - 1) * $limit;

        $category = $this->category->getByCondition([],[],[],$limit,$offset);
        if(count($category) > 0){
            if($page > $totalPages){
                setFlash('error', 'Something went wrong.');
                redirect('/admin/comments');
            }
        }
        setLayout('dashboard');
        return renderOnlyView('admin/category/index',[
            'categories' => $category,
            'currentpage' => $page,
            'totalPages' => $totalPages,
        ]);
    }

    public function create()
    {
        setLayout('dashboard');
        return renderOnlyView('admin/category/create');
    }

    public function store()
    {
        $data = $this->request->getBody();
        $category = $this->category->getById($data['id']);
        
        if ($this->validator->validate($data, $this->category->rulesCategory(), Category::class)) {
            if ($this->category->insert($data)) {
                setFlash('success','Category is saved.');
                redirect('/admin/categories');
            }
            setFlash('error','Category is not saved.');
            redirect('/admin/categories');
        }
        setLayout('dashboard');
        return renderOnlyView('admin/category/create', [
            'validator' => $this->validator,
            'category' => $category
        ]);
    }

    public function edit()
    {
        $id = $this->request->getBody()['id'];
        if (!$id) {
            setFlash('error','Something went wrong');
            redirect('/admin/categories');
        }

        $category = $this->category->getById($id);
        if (!$category) {
            setFlash('error','Id of this category does not exist.');
            redirect('/admin/categories');
        }

        setLayout('dashboard');
        return renderOnlyView('admin/category/edit',[
            'category'=>$category 
        ]);
    }

    public function update()
    {
        $data = $this->request->getBody();
        $id = $data['id'];
        if (!$id) {
            setFlash('error','Something went wrong');
            redirect('/admin/categories');
        }

        $category = $this->category->getById($id);
        if (!$category) {
            setFlash('error','Id of this category does not exist');
            redirect('/admin/categories');
        }

        if ($this->validator->validate($data, $this->category->rulesUpdateCategory(), Category::class)){
            if ($this->category->update($id, $data)) {
                setFlash('success','Category is updated.');
                redirect('/admin/categories');
            }
            setFlash('error','Category is not updated.');
            redirect('/admin/categories');
        }
        setLayout('dashboard');
        return renderOnlyView('admin/category/edit', [
            'validator' => $this->validator,
            'category'=>$category, 
        ]);
    }
  
    public function delete()
    {
        $id = $this->request->getBody()['id'];
        $category = $this->category->getById($id);

        if (!$id) {
            setFlash('error','Something went wrong');
            redirect('/admin/categories');
        }
        if (!$category) {
            setFlash('error','Id of this category does not exist');
            redirect('/admin/categories');
        }

        $this->category->delete($id); 
        setFlash('success','Category is deleted.');
        redirect('/admin/categories');        
    }

    public function category()
    {
        $data = $this->request->getBody();
        $id = $data['id'];
        $page = $this->request->getBody()['page'] ?? $page = 1;

        if (!$id) {
            setFlash('error', 'Something went wrong.');
            redirect('/');
        }

        $category =  $this->category->getById($id);
        if(!$category['id']){
            setFlash('error','Id of this category does not exist.');
            redirect('/');
        }

        if(isset($data['search']) && $data['search'] != ''){
            $search = $data['search'];
            $likeCon = ['title'=>$data['search'], 'description'=> $data['search']];
        }else{
            $search = '';
            $likeCon = [];
        }
        $posts = $this->post->getByCondition(['category_id'=> $id], $likeCon);
        $posts = $this->post->rowCount();
        $limit = 2;
        $totalPages = ceil($posts / $limit);

        $offset = ($page - 1) * $limit;
    
        $posts = $this->post->getByCondition(['category_id' => $id], $likeCon,[], $limit, $offset);
        if(count($posts) == 0){
            return renderOnlyView('category', [
                'post' => $posts,
                'category' => $category,
                'search' => $search,
                'categories' => $this->category->getAll(),
            ]);
        }  
        $userIds = [];
        $categoryIds = [];
        foreach ($posts as $post) {
            $userIds[] = $post['user_id'];
            $categoryIds[] = $post['category_id'];
        }
        $userIds = array_unique($userIds);
        $usersName = [];
        if (count($userIds) > 0) {
            $users = $this->user->getByCondition(['id' => $userIds]);
            foreach ($users as $user) {
            $usersName[$user['id']] = $user['firstname']. ' ' .$user['lastname'];
            }
        }

        return renderOnlyView('category', [
            'post' => $posts,
            'users' => $usersName,
            'currentpage' => $page,
            'totalPages' => $totalPages,
            'category' => $category,
            'search' => $search,
            'categories' => $this->category->getAll()
        ]);
    }
}