<?php

namespace Core;

class Validator
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';
    public const RULE_IMAGE = 'image';
    public const RULE_EXTENTION = 'extention';
    public const RULE_SIZE = 'size';

    public array $errors = [];
    public Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
  
    public function validate($data, $rules , $model = false)
    {
        foreach ($data as $attribute => $value) {
            $rulesAttr = $rules[$attribute] ?? [];
            foreach ($rulesAttr as $rule) {
                $ruleName = $rule;
                if (is_array($ruleName)) {
                    $ruleName = $rule[0];
                }
                if ($ruleName === self::RULE_REQUIRED && empty($value)) {
                    $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorForRule($attribute, self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addErrorForRule($attribute, self::RULE_MIN, $rule);
                }
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addErrorForRule($attribute, self::RULE_MAX, $rule);
                }
                if ($ruleName === self::RULE_MATCH && $value !== $data[$rule['match']]) {                     
                    $this->addErrorForRule($attribute, self::RULE_MATCH, $rule);
                }
                if ($ruleName === self::RULE_UNIQUE  && $value !== $rule['field'] && $model) {        
                    $model = app()->get($model);
                    $result = $model->findOne([$attribute=>$value]);
                    if($result && $result['id'] != $data['id']){
                        $this->addErrorForRule($attribute, self::RULE_UNIQUE, $rule);
                    }
                }
                if($ruleName === self::RULE_IMAGE){
                   $this->checkImage($attribute, $value, $rule);
                }
            }
        }    
        return empty($this->errors);
    }

    public function checkImage($attribute, $data, $rulesInfo)
    {
        if ($rulesInfo['require'] && empty($data['tmp_name'])) {
            $this->addErrorForRule($attribute, self::RULE_REQUIRED);
        }
        if(!in_array($data['type'],  $rulesInfo['extention'])){
            $rulesInfo['extention'] = implode(',', $rulesInfo['extention']);
            $this->addErrorForRule($attribute, self::RULE_EXTENTION, $rulesInfo);
        }
        if($data['size'] > $rulesInfo['size']){
            $this->addError($attribute, 'Choose a smaller image size.');
        }
    }

    private function addErrorForRule(string $attribute, string $rule, $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? '';
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }
    
    public function addError(string $attribute, string $message)
    {     
        $this->errors[$attribute][] = $message;
    }

    public function errorMessages()
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be valid email address',
            self::RULE_MIN => 'Min length of this field must be {min}',
            self::RULE_MAX => 'Max length of this field must be {max}',
            self::RULE_MATCH => 'This field must be the same as {match}',
            self::RULE_UNIQUE => 'Record with this {field} already exists',
            self::RULE_IMAGE => 'This field must have the correct format',
            self::RULE_EXTENTION => 'Only {extention} files are allowed.',
            self::RULE_SIZE => 'Max size must be {size}.'
        ];
    }

    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }
}
