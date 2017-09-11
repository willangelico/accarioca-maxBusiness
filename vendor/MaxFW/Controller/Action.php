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
    
    protected function render($action, $layout = true, $folder = "")
    {
        $this->action = $action;
        if($layout && file_exists("app".$folder."/Views/layout.phtml")){
            include_once "app".$folder."/Views/layout.phtml";
        }else{
            $this->content();
        }
    }
    
    protected function content($folder = ""){
        $current = get_class($this);
        var_dump($current);
        $singleClassName = strtolower((str_replace("Controller","",str_replace("MaxBusiness\\Controllers\\","",$current))));
        include_once "app".$folder."/Views/".$singleClassName."/".$this->action.".phtml";
    }
}