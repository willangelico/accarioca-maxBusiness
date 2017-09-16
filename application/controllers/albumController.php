<?php

class albumController extends mainController
{
	

	public $login_required = false;
	public $title;


    public function index() {
    	$this->parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();
    	$this->parametros = array_filter($this->parametros);
		$modelo = $this->load_model('front/frontModel');


        if(!$this->parametros){
			$this->title = "Álbuns - ".$modelo->config['titulo'];
			$this->description = $modelo->config['meta_description'];
			$this->keywords = $modelo->config['meta_tags'];	
			$banners = $modelo->bannersAtivos();			
			$this->meta_img = UP_ABSPATH.'/images/banners/mini/'.$banners[0]['url_img'];  

			
			$categorias = $modelo->categorias();
        	$this->require = ABSPATH .'/'. APPLICATION .'/views/index/albuns.php';
        }else{        	

        	$modelAlbum = $this->load_model('front/albumModel');
			if(count($this->parametros) < 2){
				$lista = $modelAlbum->galerias();


				$this->title = $lista['categoria']['titulo']." - ".$modelo->config['titulo'];
				$this->description = $lista['categoria']['meta_description'];
				$this->keywords = $lista['categoria']['meta_tags'];
				$this->meta_img = UP_ABSPATH.'/images/galerias/mini/'.$lista['categoria']['url_img'];  


        		$this->require = ABSPATH .'/'. APPLICATION .'/views/albuns/galerias.php';
			}else{
				$lista = $modelAlbum->fotos();

				$this->title = $lista['galeria']['titulo']." - ".$modelo->config['titulo'];
				$this->description = $lista['galeria']['meta_description'];
				$this->keywords = $lista['galeria']['meta_tags'];
				$this->meta_img = UP_ABSPATH.'/images/galerias/mini/'.$lista['fotos'][0]['url_img'];  

        		$this->require = ABSPATH .'/'. APPLICATION .'/views/albuns/fotos.php';
			}
		}

		require ABSPATH .'/'. APPLICATION .'/views/helpers/header.php';		
        require ABSPATH .'/'. APPLICATION .'/views/helpers/nav.php';
        echo '<div class="content">';
		require $this->require;
        echo '</div>';
		require ABSPATH .'/'. APPLICATION .'/views/helpers/footer.php';
    } 
} 