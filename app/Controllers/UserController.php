<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Core\Request;
use App\Models\User;
use Core\Validator;

class UserController
{
    public User $user;
    public Validator $validator;
    public Request $request;
    public Category $category;
    public Post $post;
    public Comment $comment;

    public function __construct(
        User $user,
        Validator $validator,
        Request $request,
        Category $category,
        Post $post,
        Comment $comment)
    {
        $this->user = $user;
        $this->validator = $validator;
        $this->request = $request;
        $this->category = $category;
        $this->post = $post;
        $this->comment = $comment;
    }

    public function register()
    {
        setLayout('auth');
        return renderOnlyView('register');
    }

    public function signup()
    {
        $data = $this->request->getBody();

        if ($this->validator->validate($data, $this->user->rulesRegister(), User::class)) {
            unset($data['confirmPassword']);
            if ($this->user->saveUsers($data)) {
                setFlash('success', 'You are registred');
                redirect('/login');
            }
            setFlash('error', 'Something went wrong!');
            return renderOnlyView('register');
        }
        setLayout('auth');
        return renderOnlyView('register', [
            'validator' => $this->validator,
            'data' => $data,
        ]);
    }

    public function login()
    {
        setLayout('auth');
        return renderOnlyView('login');
    }

    public function loginUser()
    {
        $data = $this->request->getBody();

        if ($this->validator->validate($data, $this->user->rulesLogin(), User::class)) {
            $user = $this->user->findOne(['email' => $data['email']]);
            if (!$user) {
                $this->validator->addError('email', 'User does not exist with this email');
                setLayout('auth');
                return renderOnlyView('login', [
                    'validator' => $this->validator,
                    'errors' => $this->validator->errors,
                ]);
            }
            if (!password_verify($data['password'], $user['password'])) {
                $this->validator->addError('password', 'Password is incorrect');
            }
            if (empty($this->validator->errors)) {
                set('user', $user['id']);
                if (isAdmin() || isCreator()) {
                    setFlash('success', ' Welcome ' . '' .getUser()['firstname'] . ' ' .getUser()['lastname']);
                    redirect('/dashboard');
                }
                setFlash('success', ' Welcome ' . '' .getUser()['firstname'] . ' ' .getUser()['lastname']);
                redirect('/');
            }
        }
        setLayout('auth');
        return renderOnlyView('login', [
            'validator' => $this->validator,
            'errors' => $this->validator->errors,
            'user' => $this->user->getAll(),
        ]);
    }

    public function logout()
    {
        remove('user');
        redirect('/');
    }

    public function dashboard()
    {
        setLayout('dashboard');
        if(isAdmin()){
            return renderOnlyView('dashboard',[
                'users' => $this->user->count(),
                'categories' =>$this->category->count(),
                'posts' =>$this->post->count(),
                'comments' => $this->comment->count(),
            ]);
        }
        $posts = $this->post->getByCondition(['user_id' => getUser()['id']],[]);
        $posts = $this->post->rowCount();

        return renderOnlyView('dashboard',[
            'posts' => $posts,
        ]);
    }

    public function users()
    {
        $page = $this->request->getBody()['page'] ?? $page = 1;
        $allUsers =  $this->user->count();
        $limit = 5;
        $totalPages = ceil($allUsers / $limit);
        $offset = ($page - 1) * $limit;

        $users = $this->user->getByCondition([], [], [], $limit, $offset);
        if(count($users)){
            if($page > $totalPages){
                setFlash('error', 'Something went wrong.');
                redirect('/admin/users');
            }
        }

        setLayout('dashboard');
        return renderOnlyView('admin/users/index', [
            'users' => $users,
            'currentpage' => $page,
            'totalPages' => $totalPages,
        ]);
    }

    public function create()
    {
        setLayout('dashboard');
        return renderOnlyView('admin/users/create');
    }

    public function store()
    {
        $data = $this->request->getBody();

        if ($this->validator->validate($data, $this->user->rulesAddUser(), User::class)) {
            if ($this->user->saveUsers($data)) {
                setFlash('success', 'User is saved.');
                redirect('/admin/users');
            }
            setFLash('error', 'User is not saved');
            redirect('/admin/users');
        }
        setLayout('dashboard');
        return renderOnlyView('admin/users/create', [
            'validator' => $this->validator
        ]);
    }

    public function edit()
    {
        $id = $this->request->getBody()['id'];
        if (!$id) {
            setFlash('error', 'Something went wrong.');
            redirect('/admin/users');
        }

        $user = $this->user->getById($id);
        if (!$user['id']) {
            setFlash('error', 'Id of this user does not exist.');
            redirect('/admin/users');
        }
        setLayout('dashboard');
        return renderOnlyView('admin/users/edit', [
            'user' => $user
        ]);
    }

    public function update()
    {
        $data = $this->request->getBody();
        $id = $data['id'];
        if (!$id) {
            setFlash('error', 'Something went wrong.');
            redirect('/admin/users');
        }
        
        $user = $this->user->getById($id);
        if (!$user['id']) {
            setFlash('error', 'Id of this user does not exist.');
            redirect('/admin/users');
        }

        if (empty($data['password'])) {
            $data['password'] = $user['password'];
        }
        if (empty($data['confirmPassword'])) {
            unset($data['confirmPassword']);
        }
        if ($this->validator->validate($data, $this->user->rulesUpdateUser(), User::class)) {
            unset($data['confirmPassword']);
            if ($this->user->update($id, $data)) {
                setFlash('success', 'User is updated.');
                redirect('/admin/users');
            }
            setFLash('error', 'User is not updated.');
            redirect('/admin/users');
        }
        setLayout('dashboard');
        return renderOnlyView('admin/users/edit', [
            'validator' => $this->validator,
            'user' => $user,
        ]);
    }

    public function delete()
    {
        $id = $this->request->getBody()['id'];
        if (!$id) {
            setFlash('error', 'Something went wrong');
            redirect('/admin/users');
        }

        $user = $this->user->getById($id);
        if (!$user['id']) {
            setFlash('error', 'Id of this user does not exist');
            redirect('/admin/users');
        }
        $this->user->delete($id);
        setFlash('success', 'User is deleted');
        redirect('/admin/users');
    }
}
