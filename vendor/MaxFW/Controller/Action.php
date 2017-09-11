<?php 

namespace MaxFW\Controller;

abstract class Action
{
    
    protected $view;
    private $action;
    
    public function __construct()
    {
        $this->view = new \stdClass;
    }
    
    protected function render($action, $layout = true)
    {
        $this->action = $action;
        if($layout && file_exists("../app/Views/layout.phtml")){
            include_once "../app/Views/layout.phtml";
        }else{
            $this->content();
        }
    }
    
    protected function content(){
        $current = get_class($this);
        $singleClassName = strtolower((str_replace("Controller","",str_replace("MaxBusiness\\Controllers\\","",$current))));
        include_once "../app/Views/".$singleClassName."/".$this->action.".phtml";
    }
}