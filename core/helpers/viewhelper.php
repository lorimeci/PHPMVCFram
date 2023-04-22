<?php

use Core\View;

function view(){
    return app()->get(View::class);
}

function renderContent($viewContent)
{
   return view()->renderContent($viewContent);
}

function renderOnlyView($view, $params = [])
{
    return view()->renderOnlyView($view, $params);
}

function renderView($view)
{
    return view()->renderView($view);
}

function setLayout($layout)
{
    return view()->setLayout($layout);
}
