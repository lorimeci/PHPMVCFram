<?php

namespace Core;

class View
{
    public string $layout = 'main';
    
    public function renderOnlyView($view, $params = [])
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderView($view, $params);
        return str_replace('{{content}}', $viewContent,$layoutContent);
    }

    public function renderView($view, $params)
    {
        foreach($params as $key => $value){
            $$key = $value; 
        }
        ob_start();
        include_once "../view/$view.php";
        return ob_get_clean(); 
    }

    public function layoutContent()
    {
        $layout = $this->layout;
        ob_start();
        include_once "../view/layouts/$layout.php";
        return ob_get_clean();
    }

    public function renderContent($viewContent)
    {
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);       
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    } 

    public function getLayout()
    {
        return $this->layout;
    }
}
