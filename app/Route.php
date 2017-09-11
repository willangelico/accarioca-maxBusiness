<?php

namespace MaxBusiness;

use MaxFW\Init\Router;

class Route extends Router
{
    
    protected function initRoutes(){

		$routes['admin'] = array(
		    'routes' 	=> '/admin', 
		    'auth'		=>'true', 
		    'folder' 	=> 'Admin'
		);
		
		// $routes['contact'] = array(
		//     'routes' => '/contact', 
		//     'controller' =>'indexController', 
		//     'action' => 'contact'
		// );
		$this->setRoutes($routes);


	}
}