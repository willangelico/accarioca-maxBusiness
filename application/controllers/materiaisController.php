<?php

class materiaisController extends mainController
{
	

	public $login_required = false;
	public $title;


    public function index() {
    	$this->parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();
    	$this->parametros = array_filter($this->parametros);
		$modelo = $this->load_model('front/frontModel');


        if(!$this->parametros){
			$this->title = "Materiais - ".$modelo->config['titulo'];
			$this->description = $modelo->config['meta_description'];
			$categorias = $modelo->categorias();
        	$this->require = ABSPATH .'/'. APPLICATION .'/views/index/albuns.php';
        }else{        	

        	$modelAlbum = $this->load_model('front/albumModel');
			if(count($this->parametros) < 2){
				$lista = $modelAlbum->galerias();


				$this->title = $lista['categoria']['titulo']." - ".$modelo->config['titulo'];
				$this->description = $lista['categoria']['meta_description'];				

        		$this->require = ABSPATH .'/'. APPLICATION .'/views/albuns/galerias.php';
			}else{
				$lista = $modelAlbum->fotos();

				$this->title = $lista['galeria']['titulo']." - ".$modelo->config['titulo'];
				$this->description = $lista['galeria']['meta_description'];
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