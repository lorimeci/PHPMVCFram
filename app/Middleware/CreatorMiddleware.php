<?php
namespace App\Middleware;

class CreatorMiddleware
{

    public function execute()
    {
        if(isCreator() || isAdmin()){
            return true;
        }
        setFlash('error', 'You are 
        unauthorised to access this page.');
        redirect('/');
        
    }
}