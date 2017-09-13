<?php

class bannersController extends mainController
{
	public $login_required = true;
	public $body_class = 'banners';
	public $title = NAME;
	public $permission_required;

	public function __construct(){
		parent::__construct();
		if ( ! $this->logged_in ) {
			$this->logout();
			$this->goto_login();
			return;
		}
		$this->parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();
	}

    public function index() {
    	$this->title = 'Banners - Área Administrativa | '.$this->title;
		$this->permission_required = 'any';
		$this->permission();
        $modelo = $this->load_model('banners/bannersModel');
        $lista = $modelo->listar_banners();

		require ABSPATH . APPLICATION .'/admin/views/helpers/header.php';
		require ABSPATH . APPLICATION .'/admin/views/helpers/menu.php';
		echo '<div class="container-fluid">';
			echo '<div class="row">';
				require ABSPATH . APPLICATION .'/admin/views/helpers/nav.php';
				require ABSPATH . APPLICATION .'/admin/views/banners/index.php';
			echo '</div>';
		echo '</div>';
		require ABSPATH . APPLICATION .'/admin/views/helpers/footer.php';	
    }    
 
    public function add(){
		$this->title = 'Novo Banner - Área Administrativa | '.$this->title;
		$this->permission_required = 'any';
		$this->permission();
		$this->acao = 'add';	
		$modelo = $this->load_model('banners/bannersModel');
		$modelo->obtem_banner();
		$modelo->form_confirma = $modelo->del();
		require ABSPATH . APPLICATION .'/admin/views/helpers/header.php';
		require ABSPATH . APPLICATION .'/admin/views/helpers/menu.php';
		echo '<div class="container-fluid">';
			echo '<div class="row">';
				require ABSPATH . APPLICATION .'/admin/views/helpers/nav.php';
				require ABSPATH . APPLICATION .'/admin/views/banners/form-edit.php';
			echo '</div>';
		echo '</div>';
		require ABSPATH . APPLICATION .'/admin/views/helpers/footer.php';
    }

    public function edit(){
		$this->title = 'Editar Banner - Área Administrativa | '.$this->title;
		$this->permission_required = 'any';
		$this->permission();
		$this->acao = 'edit';		
		$modelo = $this->load_model('banners/bannersModel');		
		$modelo->add();
		$modelo->obtem_banner();
		$modelo->form_confirma = $modelo->del();
		require ABSPATH . APPLICATION .'/admin/views/helpers/header.php';
		require ABSPATH . APPLICATION .'/admin/views/helpers/menu.php';
		echo '<div class="container-fluid">';
			echo '<div class="row">';
				require ABSPATH . APPLICATION .'/admin/views/helpers/nav.php';
				require ABSPATH . APPLICATION .'/admin/views/banners/form-edit.php';
			echo '</div>';
		echo '</div>';
		require ABSPATH . APPLICATION .'/admin/views/helpers/footer.php';
    }

    public function del(){
    	$this->title = 'Banners - Área Administrativa | '.$this->title;
		$this->permission_required = 'any';
		$this->permission();
		$this->acao = 'del';		
        $modelo = $this->load_model('banners/bannersModel');
        $modelo->form_confirma = $modelo->del();
        $lista = $modelo->listar_banners();
		require ABSPATH . APPLICATION .'/admin/views/helpers/header.php';
		require ABSPATH . APPLICATION .'/admin/views/helpers/menu.php';
		echo '<div class="container-fluid">';
			echo '<div class="row">';
				require ABSPATH . APPLICATION .'/admin/views/helpers/nav.php';
				require ABSPATH . APPLICATION .'/admin/views/banners/index.php';
			echo '</div>';
		echo '</div>';
		require ABSPATH . APPLICATION .'/admin/views/helpers/footer.php';
    }

    public function status(){
		$this->permission_required = 'any';
		$this->permission();
		$modelo = $this->load_model('banners/bannersModel');
		echo $modelo->changeStatus($_POST['id']);
    	return;
    }

    public function cropImg(){
    	$this->title = 'Banners - Editar Imagem - Área Administrativa | '.$this->title;
		$this->permission_required = 'any';
		$this->permission();
        $modelo = $this->load_model('banners/bannersModel');
        $lista = $modelo->crop_banners();
		require ABSPATH . APPLICATION .'/admin/views/helpers/header.php';
		require ABSPATH . APPLICATION .'/admin/views/helpers/menu.php';
		echo '<div class="container-fluid">';
			echo '<div class="row">';
				require ABSPATH . APPLICATION .'/admin/views/helpers/nav.php';
				require ABSPATH . APPLICATION .'/admin/views/banners/crop-img.php';
			echo '</div>';
		echo '</div>';
		require ABSPATH . APPLICATION .'/admin/views/helpers/footer.php';
    }

    public function permission(){
   		if (!$this->check_permissions($this->permission_required, $this->userdata['user_permissions'])) {
			echo 'Você não tem permissões para acessar essa página.';
			return;
		}
    }	
}