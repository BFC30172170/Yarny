<?php

class Router{
    protected $routes = [];
    protected $dynamicRoutes = [];
    public function addDynamic($regex,$route){
        $this->dynamicRoutes[] = [
            'regex' => $regex,
            'path' => $route
        ];
    }
    public function add($uri,$route){
        $this->routes[] = [
            'uri' => $uri,
            'path' => $route
        ];
        return $this;
    }
    public function route($uri){
        foreach ($this->routes as $route) {
            // STATIC ROUTES
            if($uri === $route['uri']){
                return include page($route['path']);
            }
        }
        foreach ($this->dynamicRoutes as $route) {
            if (preg_match($route['regex'],$uri)){
                $match = preg_match($route['regex'],$uri,$matches);
                $_GET['id'] = $matches[1];
                return include page($route['path']);
            }
        }

    }
    
}

