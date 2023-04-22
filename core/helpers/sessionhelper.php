<?php

use Core\Session;

function session()
{
    return app()->get(Session::class);
}

function set($key, $value)
{
    return session()->set($key, $value);
}

function get($key)
{
    return session()->get($key);
}

function setFLash($key, $message)
{
    return session()->setFlash($key, $message);
}

function getFlash($key)
{
    return session()->getFlash($key);
}

function remove($key)
{
    return session()->remove($key);
}

function  isLoggedIn(){
    return get('user');
}

function getUser()
{
    if ($id = isLoggedIn()) {
        $userModel = app()->get(\App\Models\User::class);
        $user = $userModel->getById($id);
        return $user;
    } 
    return '';
}

function isAdmin(){
    if(isLoggedIn() && getUser()['role'] == 1){
        return true;
    }
    return false;
}

function isCreator(){
    if(isLoggedIn() && getUser()['role'] == 2){
        return true;
    }
    return false;
}
