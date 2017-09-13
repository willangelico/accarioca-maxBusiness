<?php
/**
 * home - Controller de exemplo
 *
 * @package TutsupMVC
 * @since 0.1
 */
class pagesController extends mainController
{
	public $login_required = true;

	public $body_class = 'pages';

	public $title = NAME;

	/**
	 * $permission_required
	 *
	 * Permissão necessária
	 *
	 * @access public
	 */
	public $permission_required;

	public function __construct(){
		parent::__construct();
		if ( ! $this->logged_in ) {
		
			// Se não; garante o logout
			$this->logout();

			// Redireciona para a página de login
			$this->goto_login();
			
			// Garante que o script não vai passar daqui
			return;
		
		}
		$this->parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();
	}

	/**
	 * Carrega a página "/views/home/index.php"
	 */
    public function index() {
    	$this->title = 'Páginas - Área Administrativa | '.$this->title;
		$this->permission_required = 'any';
		// Verifica se o usuário está logado
		
		
		// Verifica se o usuário tem a permissão para acessar essa página
		$this->permission();
		// Carrega o modelo para este view
        $modelo = $this->load_model('pages/pagesModel');
        $lista = $modelo->listar_paginas();

		require ABSPATH . APPLICATION .'/admin/views/helpers/header.php';
		require ABSPATH . APPLICATION .'/admin/views/helpers/menu.php';
		echo '<div class="container-fluid">';
			echo '<div class="row">';
				require ABSPATH . APPLICATION .'/admin/views/helpers/nav.php';
				require ABSPATH . APPLICATION .'/admin/views/pages/index.php';
			echo '</div>';
		echo '</div>';
		require ABSPATH . APPLICATION .'/admin/views/helpers/footer.php';
		
    }    
    // index

    public function add(){
		$this->title = 'Nova Página - Área Administrativa | '.$this->title;
		$this->permission_required = 'any';
		$this->permission();
		$this->acao = 'add';	
		$modelo = $this->load_model('pages/pagesModel');
		$modelo->obtem_pagina();
		$modelo->form_confirma = $modelo->del();
		require ABSPATH . APPLICATION .'/admin/views/helpers/header.php';
		require ABSPATH . APPLICATION .'/admin/views/helpers/menu.php';
		echo '<div class="container-fluid">';
			echo '<div class="row">';
				require ABSPATH . APPLICATION .'/admin/views/helpers/nav.php';
				require ABSPATH . APPLICATION .'/admin/views/pages/form-edit.php';
			echo '</div>';
		echo '</div>';
		require ABSPATH . APPLICATION .'/admin/views/helpers/footer.php';
		

    }

    public function edit(){
		$this->title = 'Editar Página - Área Administrativa | '.$this->title;
		$this->permission_required = 'any';
		$this->permission();
		$this->acao = 'edit';		
		$modelo = $this->load_model('pages/pagesModel');		
		$modelo->add();
		$modelo->obtem_pagina();
		$modelo->form_confirma = $modelo->del();
		require ABSPATH . APPLICATION .'/admin/views/helpers/header.php';
		require ABSPATH . APPLICATION .'/admin/views/helpers/menu.php';
		echo '<div class="container-fluid">';
			echo '<div class="row">';
				require ABSPATH . APPLICATION .'/admin/views/helpers/nav.php';
				require ABSPATH . APPLICATION .'/admin/views/pages/form-edit.php';
			echo '</div>';
		echo '</div>';
		require ABSPATH . APPLICATION .'/admin/views/helpers/footer.php';

    }

    public function del(){
    	$this->title = 'Páginas - Área Administrativa | '.$this->title;
		$this->permission_required = 'any';
		$this->permission();
		$this->acao = 'del';		
        $modelo = $this->load_model('pages/pagesModel');
        $modelo->form_confirma = $modelo->del();
        $lista = $modelo->listar_paginas();

		require ABSPATH . APPLICATION .'/admin/views/helpers/header.php';
		require ABSPATH . APPLICATION .'/admin/views/helpers/menu.php';
		echo '<div class="container-fluid">';
			echo '<div class="row">';
				require ABSPATH . APPLICATION .'/admin/views/helpers/nav.php';
				require ABSPATH . APPLICATION .'/admin/views/pages/index.php';
			echo '</div>';
		echo '</div>';
		require ABSPATH . APPLICATION .'/admin/views/helpers/footer.php';
    }

    public function status(){
		$this->permission_required = 'any';
		$this->permission();
		$modelo = $this->load_model('pages/pagesModel');
		echo $modelo->changeStatus($_POST['id']);
    	return;
    }    

    public function removeImg(){
		$this->permission_required = 'any';
		$this->permission();
		$modelo = $this->load_model('pages/pagesModel');
		echo $modelo->removeImg($_POST['id']);
    	return;    
    }

    public function permission(){
   		if (!$this->check_permissions($this->permission_required, $this->userdata['user_permissions'])) {
		
			// Exibe uma mensagem
			echo 'Você não tem permissões para acessar essa página.';
			
			// Finaliza aqui
			return;
		}
    }


	
} // class HomeController