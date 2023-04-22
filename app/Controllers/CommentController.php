<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Core\Request;
use Core\Response;
use Core\Validator;

class CommentController
{
    public Comment $comment;
    public Post $post;
    public User $user;
    public Response $response;
    public Request $request;
    public Validator $validator;
    public Category $category;

    public function __construct(
        Comment $comment,
        Post $post, 
        Request $request, 
        Validator $validate, 
        User $user, 
        Category $category)
    {
        $this->comment = $comment;
        $this->post = $post;
        $this->request = $request;
        $this->validator = $validate;
        $this->user = $user;
        $this->category = $category;
    }

    public function index()
    {
        $page = $this->request->getBody()['page'] ?? $page = 1;

        $allComments = $this->comment->count();
        $limit = 5;
        $totalPages = ceil($allComments / $limit);
        $offset = ($page - 1) * $limit;

        $comments = $this->comment->getByCondition([], [], ['id'=>'DESC'], $limit, $offset);
        if(count($comments)){
            if($page > $totalPages){
                setFlash('error', 'Something went wrong.');
                redirect('/admin/comments');
            }
            $userIds = [];
            $postIds = [];
            foreach ($comments as $comment) {
                $userIds[] = $comment['user_id'];
                $postIds[] = $comment['post_id'];
            }
            $userIds = array_unique($userIds);
            $postIds =  array_unique($postIds);
            $users = $this->user->getByCondition(['id' => $userIds]);
            $usersName = [];
            foreach ($users as $user) {
                $usersName[$user['id']] = $user['firstname']. ' ' .$user['lastname'];
            }
            $posts = $this->post->getByCondition(['id' => $postIds]);
            $postsTitle = [];
            foreach ($posts as $post) {
                $postsTitle[$post['id']] = $post['title'];
            }
        }
 

        setLayout('dashboard');
        return renderOnlyView('admin/comments/index', [
            'comments' => $comments,
            'currentpage' => $page,
            'totalPages' => $totalPages,
            'postTitle' => $postsTitle ?? '',
            'userName' => $usersName ?? '',
        ]);
    }

    public function edit()
    {
        $id = $this->request->getBody()['id'];
        if (!$id) {
            setFlash('error', 'Something went wrong.');
            redirect('/admin/comments');
        }
        $comment = $this->comment->getById($id);
        if (!isset($comment['id'])) {
            setFlash('error', 'Does not exist!!');
            redirect('/admin/comments');
        }
        setLayout('dashboard');
        return renderOnlyView('admin/comments/edit', [
            'comment' => $comment,
        ]);
    }

    public function update()
    {
        $data = $this->request->getBody();
        $id = $data['id'];

        $comment = $this->comment->getById($id);
        if (!$id) {
            setFlash('error', 'Something went wrong.');
            redirect('/admin/comments');
        }
        if (!isset($comment['id'])) {
            setFlash('error', 'Does not exist!!');
            redirect('/admin/comments');
        }
        if ($this->validator->validate($data, $this->comment->rulesComment())) {
            if ($this->comment->update($id, $data)) {
                setFlash('success', 'Comment is updated.');
                redirect('/admin/comments');
            }
            setFlash('error', 'Comment is not updated.');
            redirect('/admin/comments');
        }
        setLayout('dashboard');
        return renderOnlyView('admin/comments/edit', [
            'validator' => $this->validator,
            'comment' => $comment,
        ]);
    }

    public function delete()
    {
        $id = $this->request->getBody()['id'];
        if (!$id) {
            setFlash('error', 'Something went wrong');
            redirect('/admin/comments');
        }

        $this->comment->delete($id);
        setFlash('success', 'Comment is deleted');
        redirect('/admin/comments');
    }

    public function comment()
    {
        $data = $this->request->getBody();
        $id = $data['post_id'];
        if (!$id) {
            setFLash('error', 'Something went wrong');
            redirect('/');
        }
        
        if ($this->validator->validate($data, $this->comment->rulesComment(), Comment::class)) {
            if ($this->comment->insert($data)) {
                setFlash('success', 'Your comment is pending. As soon as the comment gets approved you will see it.');
                redirect('/post?id=' . $data['post_id']);
            }
            setFlash('error', 'Something went wrong!');
            return  redirect('/post?id=' . $data['post_id']);
        }
        
        $data = $this->post->getSinglePost($id);

        return renderOnlyView('singlePost', [
            'validator' => $this->validator,
            'post' => $data['post'],
            'category' =>  $data['category']['title'] ?? '',
            'categories' => $this->category->getAll(),
            'comments' => $data['comments'],
            'parent_id' => $data['parent_id'] ?? 0,
        ]);
    }
}
