<?php
namespace App\Middleware;

class AdminMiddleware
{
 
    public function execute()
    {
        if(!isAdmin()){
            setFlash('error', 'You are 
            unauthorised to access this page.');
            setHttpResponseCode(403);
            redirect('/');
        }
        return true;
    }
}