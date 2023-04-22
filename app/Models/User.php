<?php
namespace App\Models;

use Core\Model;
use Core\Validator;

class User extends Model 
{ 
    public $tableName = 'users';
    public $primaryKey = 'id';

    public function rulesRegister()
    {
        return[
           "firstname" => [Validator::RULE_REQUIRED,[Validator::RULE_MIN, 'min'=>2]],
            "lastname" => [Validator::RULE_REQUIRED,[Validator::RULE_MIN, 'min'=>2]],
            "email" => [Validator::RULE_REQUIRED, [Validator::RULE_EMAIL],[Validator::RULE_UNIQUE,'field'=>'email']],
            "password" => [Validator::RULE_REQUIRED, [Validator::RULE_MIN, 'min'=>8],[Validator::RULE_MAX, 'max'=>14]],
            "confirmPassword" => [Validator::RULE_REQUIRED, [Validator::RULE_MATCH, 'match'=> 'password']], 
        ];
    }

    public function rulesLogin()
    {
        return[
            "email" => [Validator::RULE_REQUIRED, [Validator::RULE_EMAIL]],
            "password" => [Validator::RULE_REQUIRED],        
        ];
    }

    public function saveUsers($data)
    {
        $data['password'] = password_hash($data['password'] , PASSWORD_DEFAULT);
        return $this->insert($data);
    }

    public function rulesAddUser()
    {
        return[
           "firstname" => [Validator::RULE_REQUIRED,[Validator::RULE_MIN, 'min'=>2]],
            "lastname" => [Validator::RULE_REQUIRED,[Validator::RULE_MIN, 'min'=>2]],
            "email" => [Validator::RULE_REQUIRED, [Validator::RULE_EMAIL],[Validator::RULE_UNIQUE,'field'=>'email']],
            "password" => [Validator::RULE_REQUIRED],
        ];
    }

    public function rulesUpdateUser()
    {
        return[
           "firstname" => [Validator::RULE_REQUIRED,[Validator::RULE_MIN, 'min'=>2]],
            "lastname" => [Validator::RULE_REQUIRED,[Validator::RULE_MIN, 'min'=>2]],
            "email" => [Validator::RULE_REQUIRED, [Validator::RULE_EMAIL],[Validator::RULE_UNIQUE,'field'=>'email']],
            "password" => [[Validator::RULE_MIN, 'min'=>8]],
            "confirmPassword" => [[Validator::RULE_MATCH, 'match'=> 'password']],  
        ];
    }
}