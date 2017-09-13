<?php
/**
 * LoginController - Controller de exemplo
 *
 * @package TutsupMVC
 * @since 0.1
 */
class loginController extends mainController
{

	/**
	 * Carrega a página "/views/login/index.php"
	 */
    public function index() {
		$this->title = 'Área administrativa - '.NAME;
		$this->description = '';
		$this->keywords = '';
		$this->body_class = 'login-body';
		require ABSPATH .'/'. APPLICATION .'/admin/views/helpers/header.php';
		require ABSPATH .'/'. APPLICATION .'/admin/views/login/index.php';
		require ABSPATH .'/'. APPLICATION .'/admin/views/helpers/footer.php';
    } // index

    public function forget(){
    	$this->title = 'Recuperação de senha - Área administrativa - '.NAME;
		$this->body_class = 'login-body';
		$modelo = $this->load_model('users/usersModel');
		require ABSPATH .'/'. APPLICATION .'/admin/views/helpers/header.php';
		require ABSPATH .'/'. APPLICATION .'/admin/views/login/forget.php';
		require ABSPATH .'/'. APPLICATION .'/admin/views/helpers/footer.php';
    }

    public function redefine(){
    	$this->title = 'Redefinição de senha - Área administrativa = '.NAME;
    	$this->body_class = 'login-body';
    	$parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();
    	$modelo = $this->load_model('users/usersModel');
 		require ABSPATH .'/'. APPLICATION .'/admin/views/helpers/header.php';
		require ABSPATH .'/'. APPLICATION .'/admin/views/login/redefine.php';
		require ABSPATH .'/'. APPLICATION .'/admin/views/helpers/footer.php';   	

    }
	
} // class LoginController