<?php
namespace App\Models;

use Core\Model;
use Core\Request;
use Core\Validator;

class Post extends Model
{
    public $tableName = 'posts';
    public $primaryKey = 'id';

    public Comment $comment;
    public User $user;
    public Request $request;
    public Category $category;

    public function __construct(
        Comment $comment,
        Request $request, 
        User $user, 
        Category $category)
    {
        $this->comment = $comment;
        $this->request = $request;
        $this->user = $user;
        $this->category = $category;
        parent::__construct();
    }

    public function rulesPost()
    {
        return [
            "title" => [Validator::RULE_REQUIRED,[Validator::RULE_MIN, 'min'=> 3]],
            "description" => [Validator::RULE_REQUIRED,[Validator::RULE_MIN, 'min'=>10]],
            "image" =>[[Validator::RULE_IMAGE, 'require'=>true, 'size'=> 1000000, 'extention' => ['image/jpg','image/png','image/jpeg','image/gif']]],
            "category_id" =>[Validator::RULE_REQUIRED],
        ];
    }

    public function rulesUpdatePost()
    {
        return [
            "title" => [Validator::RULE_REQUIRED,[Validator::RULE_MIN, 'min'=>3]],
            "description" => [Validator::RULE_REQUIRED,[Validator::RULE_MIN, 'min'=>10]],
            "image" =>[[Validator::RULE_IMAGE, 'require'=>false, 'size'=> 1000000, 'extention' => ['image/jpg','image/png','image/jpeg','image/gif']]],
            "category_id" =>[Validator::RULE_REQUIRED],

        ];
    }

    public function getSinglePost($postId)
    {
        $post = $this->getById($postId);
        if (!$post['id']) {
            setFlash('error', 'Post with this id does NOT exists');
            redirect('/');
        }
        $category = $this->category->getById($post['category_id']);

        $comments = $this->comment->getByCondition(['parent_id' => 0, 'status' => 1, 'post_id' => $postId]);
        if (count($comments) > 0) {
            foreach ($comments as &$comment) {
                $user = $this->user->getById($comment['user_id']);
                $comment['author'] = $user['firstname'] . ' ' . $user['lastname'];
                $replies = $this->comment->getByCondition(['parent_id' => $comment['id'], 'status' => 1, 'post_id' => $postId]);
                if (count($replies) > 0) {
                    foreach ($replies as &$reply) {
                        $replyAuthor = $this->user->getById($reply['user_id']);
                        $countReply = count($reply);
                        $reply['replyAuthor'] = $replyAuthor['firstname'] . ' ' . $replyAuthor['lastname'];
                        $reply['count'] = $countReply;
                    }
                }
                $comment['replies'] = $replies;
            }
        }
        return [
            'comments'=> $comments,
            'post' => $post,
            'category' => $category,
        ];
    }
}