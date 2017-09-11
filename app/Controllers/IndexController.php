<?php

namespace MaxBusiness\Controllers;

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
        $this->render("index");
    }
    
    public function contact()
    {
        $this->render("contact");
    }
    
}