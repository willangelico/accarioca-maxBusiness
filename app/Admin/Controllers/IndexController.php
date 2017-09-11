<?php

namespace MaxBusiness\Admin\Controllers;

use MaxFW\Controller\Action;
use MaxFW\DI\Container;

/**
 * 
 */
class IndexController extends Action
{
    
    /**
     * 
     */
    public function __construct()
    {
        // code...
    }
    
    public function index()
    {
        $this->render("index",true, "/Admin");
    }
           
}