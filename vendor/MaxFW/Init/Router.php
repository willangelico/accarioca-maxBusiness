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

        array_walk($this->routes, function($route) use ($array_url) {
          
           if($array_url[1] == $route['routes']){
              $array_url[3] = empty($array_url[3]) ? "index" : $array_url[3];
               $class       = "MaxBusiness\\".$route['folder']."\\Controllers\\".ucfirst($array_url[2]);
               $controller  = new $class;
               $action      = $array_url[3];
               $controller->$action();
               die();
           }
        });
        

        $class = "MaxBusiness\\Controllers\\".ucfirst($array_url[1])."Controller";
        $controller = new $class;

        $action = $array_url[2];
        $controller->$action();

       
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