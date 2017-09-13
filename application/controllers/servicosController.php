<?php

class servicosController extends mainController
{
	

	public $login_required = false;


    public function index() {

		$modelo = $this->load_model('front/frontModel');		
		$this->title = $modelo->config['titulo'];
		$this->description = $modelo->config['meta_description'];
        $this->page = 'works';

		$parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();

        require ABSPATH .'/'. APPLICATION .'/views/helpers/header.php';
        require ABSPATH .'/'. APPLICATION .'/views/helpers/nav.php';
        require ABSPATH .'/'. APPLICATION .'/views/index/servicos.php';
        require ABSPATH .'/'. APPLICATION .'/views/helpers/footer.php';		
    }    
} 