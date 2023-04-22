<?php

namespace Core;

class Router
{
    public Request $request;
    public Response $response;
    public View $view;
    protected array $routes = [];
    protected array $middlewares = [];
    protected $currentPath = false;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
        $this->currentPath = $path;
        return $this;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
        $this->currentPath = $path;
        return $this;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            $this->response->setHttpResponseCode(404);
            return renderOnlyView('404');
        }

        if (is_string($callback)) { 
            return renderOnlyView($callback);
        }
        //if has middleware
        if (is_array($callback)) {
            if(isset($this->middlewares[$path])){
                foreach($this->middlewares[$path] as $middleware){
                    $middleware = app()->get($middleware);
                    $middleware->execute();
                }
            }
            $callback[0] = app()->get($callback[0]);       
        }
        return call_user_func($callback, $this->request, $this->response);
    }
    public function addMiddleware($middlewares)
    {
        if ($this->currentPath) {
            $this->middlewares[$this->currentPath] = $middlewares;
            $this->currentPath = false;
        }
    }
    public function run()
    {
        $body =  $this->resolve();
        $this->response->setBody($body);
    }
}
