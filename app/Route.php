<?php

namespace MaxBusiness;

use MaxFW\Init\Router;

class Route extends Router
{
    
    protected function initRoutes(){

		// $routes['home'] = array(
		//     'routes' => '/', 
		//     'controller' =>'indexController', 
		//     'action' => 'index'
		// );
		
		// $routes['contact'] = array(
		//     'routes' => '/contact', 
		//     'controller' =>'indexController', 
		//     'action' => 'contact'
		// );
		//$this->setRoutes($routes);

    	$this->setRoutes();
	}
}