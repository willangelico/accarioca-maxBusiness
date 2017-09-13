<?php

class configController extends mainController
{
	public $login_required = true;
	public $body_class = 'conig';
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
    	$this->title = 'Configurações - Área Administrativa | '.$this->title;
		$this->permission_required = 'any';
		$this->permission();
        $modelo = $this->load_model('config/configModel');
		$modelo->obtem_config(1);
		require ABSPATH . APPLICATION .'/admin/views/helpers/header.php';
		require ABSPATH . APPLICATION .'/admin/views/helpers/menu.php';
		echo '<div class="container-fluid">';
			echo '<div class="row">';
				require ABSPATH . APPLICATION .'/admin/views/helpers/nav.php';
				require ABSPATH . APPLICATION .'/admin/views/config/form-edit.php';
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