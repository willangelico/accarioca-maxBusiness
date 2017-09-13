<?php

class indexController extends mainController
{
	

	public $login_required = false;


    public function index() {

		$modelo = $this->load_model('front/frontModel');
		// $banners = $modelo->bannersAtivos();
		// $recentes = $modelo->ultimosTrabalhos(3);
		// $categorias = $modelo->categorias();
		// $paginas = $modelo->paginas();

		$this->title = $modelo->config['titulo'];
		$this->description = $modelo->config['meta_description'];
		// $this->keywords = $modelo->config['meta_tags'];	
		// $this->meta_img = UP_ABSPATH.'/images/banners/mini/'.$banners[0]['url_img'];
        $this->page = 'home';

		$parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();

        require ABSPATH .'/'. APPLICATION .'/views/helpers/header.php';
		

        require ABSPATH .'/'. APPLICATION .'/views/helpers/nav.php';
        require ABSPATH .'/'. APPLICATION .'/views/index/index.php';


        // require ABSPATH .'/'. APPLICATION .'/views/index/banners.php';
        // require ABSPATH .'/'. APPLICATION .'/views/index/recentes.php';
        // require ABSPATH .'/'. APPLICATION .'/views/index/albuns.php';
        // require ABSPATH .'/'. APPLICATION .'/views/index/sobre.php';
        // require ABSPATH .'/'. APPLICATION .'/views/index/contato.php';

		
		
        require ABSPATH .'/'. APPLICATION .'/views/helpers/footer.php';
		
    } 

    public function existe_album($categoria,$galeria){
    	$modelo = $this->load_model('front/albumModel');
    	if(!$galeria){
    		return $modelo->existeCat($categoria);
    	}
    	return $modelo->existeGal($galeria);
    }
} 