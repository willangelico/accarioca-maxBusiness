<?php

class orcamentoController extends mainController
{
	
	public $login_required = false;

   public function index() {

		$modelo = $this->load_model('front/frontModel');		
		$this->title = $modelo->config['titulo'];
		$this->description = $modelo->config['meta_description'];
        $this->page = 'budget';

		$parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();

        require ABSPATH .'/'. APPLICATION .'/views/helpers/header.php';
        require ABSPATH .'/'. APPLICATION .'/views/helpers/nav.php';
        require ABSPATH .'/'. APPLICATION .'/views/index/orcamento.php';
        require ABSPATH .'/'. APPLICATION .'/views/helpers/footer.php';		
    }   
	
	public function send(){
    	$modelo = $this->load_model('front/frontModel');
		echo $modelo->envia_form($_POST);
    	return; 
    }
} 