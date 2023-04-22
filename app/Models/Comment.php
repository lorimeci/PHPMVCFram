<?php
namespace App\Models;

use Core\Model;
use Core\Validator;

class Comment extends Model
{
    public $tableName = 'comments';
    public $primaryKey = 'id';

    public function rulesComment()
    {
        return[
            "message" => [Validator::RULE_REQUIRED,[Validator::RULE_MIN, 'min'=>10]],
        ];
    }

    public function rulesReply()
    {
        return[
            "message" => [Validator::RULE_REQUIRED],
        ];
    }
}