<?php
// A router contains a collection of routes and their intended resources to direct the user/customer to
class Router{
    protected $routes = [];
    protected $dynamicRoutes = [];

    // Add a dynamic route to the router
    public function addDynamic($regex,$route){
        $this->dynamicRoutes[] = [
            'regex' => $regex,
            'path' => $route
        ];
    }

    // Add a static route to the router
    public function add($uri,$route){
        $this->routes[] = [
            'uri' => $uri,
            'path' => $route
        ];
        return $this;
    }

    // router a given uri to a given resource given the routes available
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

