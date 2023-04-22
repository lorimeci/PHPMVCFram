<?php

use Core\Request;
use Core\Response;

function app(){
    GLOBAL $app;
    return $app;
}

function getQueryString($exclude)
{
    $request = app()->get(Request::class);
    return $request->getQueryString($exclude);
}

function redirect(string $url)
{
    header('Location: '.$url);
    exit();
}

function setHttpResponseCode($httpResponseCode)
{
    $response = app()->get(Response::class);
    return $response->setHttpResponseCode($httpResponseCode);
}



