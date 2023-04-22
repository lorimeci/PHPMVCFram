<?php 

namespace App\Models;

use Core\Model;
use Core\Validator;

class Category extends Model
{
    
    public $tableName = 'category';
    public $primaryKey = 'id'; 

    public function rulesCategory()
    {
        return[
           "title" => [Validator::RULE_REQUIRED,[Validator::RULE_MIN, 'min'=>3],[Validator::RULE_UNIQUE,'field'=>'title']],
            "description" => [Validator::RULE_REQUIRED,[Validator::RULE_MIN, 'min'=>10]],
        ];
    }

    public function rulesUpdateCategory()
    {
        return[
            "title" => [Validator::RULE_REQUIRED,[Validator::RULE_MIN, 'min'=>3],[Validator::RULE_UNIQUE,'field'=>'title']],
             "description" => [Validator::RULE_REQUIRED,[Validator::RULE_MIN, 'min'=>10]],
         ]; 
    }
}