<?php
/**
 * home - Controller de exemplo
 *
 * @package TutsupMVC
 * @since 0.1
 */
class indexController extends mainController
{
	public $login_required = true;

	public $body_class = 'dashboard';

	public $title = NAME;

	/**
	 * Carrega a página "/views/home/index.php"
	 */
    public function index() {
    	$this->title = 'Dashboard - Área Administrativa | '.$this->title;

		$this->permission_required = 'any';
		// Verifica se o usuário está logado
		if ( ! $this->logged_in ) {
		
			// Se não; garante o logout
			$this->logout();

			// Redireciona para a página de login
			$this->goto_login();
			
			// Garante que o script não vai passar daqui
			return;
		
		}
		
		// Verifica se o usuário tem a permissão para acessar essa página
		if (!$this->check_permissions($this->permission_required, $this->userdata['user_permissions'])) {
		
			// Exibe uma mensagem
			echo 'Você não tem permissões para acessar essa página.';
			
			// Finaliza aqui
			return;
		}
		require ABSPATH . APPLICATION .'/admin/views/helpers/header.php';
		require ABSPATH . APPLICATION .'/admin/views/helpers/menu.php';
		echo '<div class="container-fluid">';
			echo '<div class="row">';
				require ABSPATH . APPLICATION .'/admin/views/helpers/nav.php';
				require ABSPATH . APPLICATION .'/admin/views/index/index.php';
			echo '</div>';
		echo '</div>';
		require ABSPATH . APPLICATION .'/admin/views/helpers/footer.php';
		
    } 

    public function sair(){
    	$this->logout();  
    	echo '<meta http-equiv="Refresh" content="0; url=' . HOME_URI . 'admin">';
		echo '<script type="text/javascript">window.location.href = "' . HOME_URI . 'admin";</script>';
    	return;  
    }
    // index
	
} // class HomeController