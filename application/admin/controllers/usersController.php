<?php
/**
 * UserRegisterController - Controller de exemplo
 *
 * @package TutsupMVC
 * @since 0.1
 */
class usersController extends mainController{



	public $login_required = true;
	public $body_class = 'users';
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
    	$this->title = 'Usuários - Área Administrativa | '.$this->title;
		$this->permission_required = 'any';
		$this->permission();		

        $modelo = $this->load_model('users/usersModel');
		$modelo->validate_register_form();
		$modelo->get_register_form( chk_array( $this->parametros, 1 ) );
		$lista = $modelo->get_user_list(); 

		require ABSPATH . APPLICATION .'/admin/views/helpers/header.php';
		require ABSPATH . APPLICATION .'/admin/views/helpers/menu.php';
		echo '<div class="container-fluid">';
			echo '<div class="row">';
				require ABSPATH . APPLICATION .'/admin/views/helpers/nav.php';
				require ABSPATH . APPLICATION .'/admin/views/users/index.php';
			echo '</div>';
		echo '</div>';
		require ABSPATH . APPLICATION .'/admin/views/helpers/footer.php';
    } // index

    public function edit(){
    	$this->title = 'Usuários - Área Administrativa | '.$this->title;
		$this->permission_required = 'any';
		$this->permission();		

    	$modelo = $this->load_model('users/usersModel');
		$modelo->get_register_form( chk_array( $this->parametros, 0 ) );
		
		require ABSPATH . APPLICATION .'/admin/views/helpers/header.php';
		require ABSPATH . APPLICATION .'/admin/views/helpers/menu.php';
		echo '<div class="container-fluid">';
			echo '<div class="row">';
				require ABSPATH . APPLICATION .'/admin/views/helpers/nav.php';
				require ABSPATH . APPLICATION .'/admin/views/users/form-edit.php';
			echo '</div>';
		echo '</div>';
		require ABSPATH . APPLICATION .'/admin/views/helpers/footer.php';
    }

    public function status(){
		$this->permission_required = 'any';
		$this->permission();
		$modelo = $this->load_model('users/usersModel');
		echo $modelo->changeStatus($_POST['id']);
    	return;
    }    

    public function permission(){
   		if (!$this->check_permissions($this->permission_required, $this->userdata['user_permissions'])) {
			echo 'Você não tem permissões para acessar essa página.';
			return;
		}
    }	    


	
} // class home