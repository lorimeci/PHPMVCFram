<?php
namespace App\Middleware;

class AuthMiddleware
{

    public function execute()
    {
        if(!isLoggedIn()){
            setFlash('error', 'You need to login first.');
            redirect('/login');
        }
        return true;
    }
}