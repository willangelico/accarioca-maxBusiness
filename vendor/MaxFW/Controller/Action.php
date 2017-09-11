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
            $this->content($folder);
        }
    }
    
    protected function content($folder = ""){
        $current = get_class($this);
        var_dump($current);
        echo "<br>";
        var_dump($folder);

        if(!empty($folder)){
            $singleClassName = strtolower((str_replace("Controller","",str_replace("MaxBusiness\\".ltrim($folder, "/")."\\Controllers\\","",$current))));    
        }else{
            $singleClassName = strtolower((str_replace("Controller","",str_replace("MaxBusiness\\Controllers\\","",$current))));    
        }
        echo "<br>";
        var_dump($singleClassName);

        include_once "app".$folder."/Views/".$singleClassName."/".$this->action.".phtml";
    }
}