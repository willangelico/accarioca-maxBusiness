<?php

namespace MaxFW\Init;

abstract class Router
{
    private $routes;
    
    public function __construct()
    {
        $this->initRoutes();
        $this->run($this->getUrl());
    }
    
    abstract protected function initRoutes();
    
    protected function run($url)
    {         
        $array_url = explode("/",$url);
        $array_url[1] = empty($array_url[1]) ? "index" : $array_url[1];
        $array_url[2] = empty($array_url[2]) ? "index" : $array_url[2];

        var_dump($array_url);

        $class = "MaxBusiness\\Controllers\\".ucfirst($array_url[1])."Controller";
        $controller = new $class;

        $action = $array_url[2]
        $controller->$action();

        // array_walk($this->routes, function($route) use ($url) {
          
        //    if($url == $route['routes']){
        //        $class       = "MaxBusiness\\Controllers\\".ucfirst($route['controller']);
        //        $controller  = new $class;
        //        $action      = $route['action'];
        //        $controller->$action();
        //    }
        // });
    }
    
    protected function setRoutes(array $routes)
    {
        $this->routes = $routes;
    }
    
    protected function getUrl()
    {
        return parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    }
}