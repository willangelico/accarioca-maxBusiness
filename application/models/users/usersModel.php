<?php 

class usersModel
{

	public $form_data;
	public $form_msg;	
	public $db;
	
	public function __construct( $db = false ) {
		$this->db = $db;
	}

	public function validate_register_form () {
		$this->form_data = array();
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] && ! empty ( $_POST ) ) {
			foreach ( $_POST as $key => $value ) {
				$this->form_data[$key] = $value;
				if ( empty( $value ) ) {
					$this->form_msg = '<div class="alert alert-danger" role="alert">Registro não pode ser enviado. Há campos vazios.</div>';
					return;
				}			
			}
		} else {
			return;
		}

		if( empty( $this->form_data ) ) {
			return;
		}

		$db_check_user = $this->db->query (
			'SELECT * FROM `users` WHERE `email` = ?', 
			array( 
				chk_array( $this->form_data, 'user')		
			) 
		);

		if ( ! $db_check_user ) {
			$this->form_msg = '<div class="alert alert-danger" role="alert">Internal error.</div>';
			return;
		}

		$fetch_user = $db_check_user->fetch();
		$user_id = $fetch_user['id_users'];
		$password_hash = new PasswordHash(8, FALSE);
		$password = $password_hash->HashPassword( $this->form_data['user_password'] );

		if ( preg_match( '/[^0-9A-Za-z\,\.\-\_\s ]/is', $this->form_data['user_permissions'] ) ) {
			$this->form_msg = '<div class="alert alert-danger" role="alert">Use just letters, numbers and a comma for permissions.</div>';
			return;
		}		
		
		$permissions = array_map('trim', explode(',', $this->form_data['user_permissions']));
		$permissions = array_unique( $permissions );
		$permissions = array_filter( $permissions );
		$permissions = serialize( $permissions );
		if ( ! empty( $user_id ) ) {
			$query = $this->db->update('users', 'id_users', $user_id, array(
				'password' => $password, 
				'name' => chk_array( $this->form_data, 'user_name'), 
				'user_session_id' => md5(time()), 
				'user_permissions' => $permissions, 
			));
			
			if ( ! $query ) {
				$this->form_msg = '<div class="alert alert-danger" role="alert">Internal error. Tente novamente.</div>';
				return;
			} else {
				$this->form_msg = '<div class="alert alert-succes" role="alert">Cadastro atualizado.</div>';
				return;
			}
		} else {
			$query = $this->db->insert('users', array(
				'email' => chk_array( $this->form_data, 'user'), 
				'password' => $password, 
				'name' => chk_array( $this->form_data, 'user_name'), 
				'user_session_id' => md5(time()), 
				'user_permissions' => $permissions, 
			));

			if ( ! $query ) {
				$this->form_msg = '<div class="alert alert-danger" role="alert">Internal error. Tente novamente.</div>';
				return;
			} else {
				$this->form_msg = '<div class="alert alert-danger" role="alert">Cadastro realizado com sucesso.</div>';
				return;
			}
		}
	}
	
	public function get_register_form ( $user_id = false ) {

		$s_user_id = false;

		if ( ! empty( $user_id ) ) {
			$s_user_id = (int)$user_id;
		}
		
		if ( empty( $s_user_id ) ) {
			return;
		}

		$query = $this->db->query('SELECT * FROM `users` WHERE `id_users` = ?', array( $s_user_id ));

		if ( ! $query ) {
			$this->form_msg = '<div class="alert alert-danger" role="alert">Usuário não existe.</div>';
			return;
		}

		$fetch_userdata = $query->fetch();

		if ( empty( $fetch_userdata ) ) {
			$this->form_msg = '<div class="alert alert-danger" role="alert">Usuário não existe.</div>';
			return;
		}

		foreach ( $fetch_userdata as $key => $value ) {
			$this->form_data[$key] = $value;
		}

		$this->form_data['user_password'] = null;
		$this->form_data['user_permissions'] = unserialize($this->form_data['user_permissions']);
		$this->form_data['user_permissions'] = implode(',', $this->form_data['user_permissions']);
	} 
	
	public function del_user ( $parametros = array() ) {

		$user_id = null;

		if ( chk_array( $parametros, 0 ) == 'del' ) {

			$mensagem  = '<div class="alert alert-danger alert-dismissible" role="alert">';
				$mensagem .= '<h4>Tem certeza que deseja apagar este usuário?</h4>';
				$mensagem .= '<p><a href="' . $_SERVER['REQUEST_URI'] . '/confirma" class="btn btn-danger">Sim</a>';
				$mensagem .= '<a href="' . HOME_URI . '/users" class="btn btn-default">Não</a> </p>';
			$mensagem .= '</div';
			
			echo $mensagem;


			
			if ( 
				is_numeric( chk_array( $parametros, 1 ) )
				&& chk_array( $parametros, 2 ) == 'confirma' 
			) {
				$user_id = chk_array( $parametros, 1 );
			}
		}

		if ( !empty( $user_id ) ) {

			$user_id = (int)$user_id;
			$query = $this->db->delete('users', 'id_users', $user_id);
			echo '<meta http-equiv="Refresh" content="0; url=' . HOME_URI . '/admin/users/">';
			echo '<script type="text/javascript">window.location.href = "' . HOME_URI . '/admin/users/";</script>';
			return;
		}
	}
	
	public function get_user_list() {
	
		$query = $this->db->query('SELECT * FROM `users` ORDER BY id_users DESC');

		if ( ! $query ) {
			return array();
		}

		return $query->fetchAll();
	}

	public function recover_password() {
	
		$this->form_data = array();

		if ( 'POST' == $_SERVER['REQUEST_METHOD'] && ! empty ( $_POST ) ) {

			foreach ( $_POST as $key => $value ) {
				$this->form_data[$key] = $value;
				if ( empty( $value ) ) {
					$this->form_msg = '<div class="alert alert-danger" role="alert">Campos vazios. Dados não enviados</div>';
					return;
				}			
			}
		} else {
			$this->form_msg = '<div class="alert alert-danger" role="alert">Nenhum dado enviado.</div>';
			return;
		}

		if( empty( $this->form_data ) ) {
			return;
		}

		if (!filter_var(chk_array( $this->form_data, 'email'), FILTER_VALIDATE_EMAIL)) {
  			$this->form_msg = '<div class="alert alert-danger" role="alert">Endereço de e-mail inválido.</div>';
  			return;
		}

		$db_check_user = $this->db->query (
			'SELECT * FROM `users` WHERE `email` = ?', 
			array( 
				chk_array( $this->form_data, 'email')		
			) 
		);

		if ( ! $db_check_user ) {
			$this->form_msg = '<div class="alert alert-danger" role="alert">Internal error.</div>';
			return;
		}
		
		$fetch_user = $db_check_user->fetch();
		$id_users = $fetch_user['id_users'];

		if( ! empty( $fetch_user) ) {

			$dt = date('Y-m-d H:i:s');
			$cod = geraSenha(32,false);
			$query = $this->db->update('users', 'id_users', $id_users, array(
				'dt_hash' => $dt, 
				'cod_verify' => $cod,
			));
			
			if ( ! $query ) {
				$this->form_msg = '<div class="alert alert-danger" role="alert">Internal error. Tente novamente.</div>';
				return;
			} else {
				$db_config = $this->db->query (
					'SELECT * FROM `config` WHERE `id_config` = ?', 
					array('1')	
				); 	
				if ( ! $db_config ) {
					$this->form_msg = '<div class="alert alert-danger" role="alert">Internal error.</div>';
					return;
				}

				$fetch_config = $db_config->fetch();
				require ABSPATH . '/library/plugins/PHPMailer-master/PHPMailerAutoload.php';

				$mail = new PHPMailer;

				$mail->CharSet = 'UTF-8';
				$mail->isSMTP();                                      // Set mailer to use SMTP
				$mail->Host = HOST_MAIL;  // Specify main and backup SMTP servers
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username = $fetch_config['email_envio'];       // SMTP username
				$mail->Password = $fetch_config['senha_envio'];       // SMTP password
				$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
				$mail->Port = PORTA_MAIL;                             // TCP port to connect to

				$mail->From = $fetch_config['email_envio'];
				$mail->FromName = $fetch_config['titulo'];
				$mail->addAddress($fetch_user['email'], $fetch_user['name']);     // Add a recipient
				$mail->addReplyTo($fetch_config['email_contato'], $fetch_config['titulo']);
				$mail->isHTML(true);                                  // Set email format to HTML
				$mail->Subject = 'Recuperação de senha - '.$fetch_config['titulo'];
				$mail->Body    = '<img src="'.URL.HOME_URI.'public/images/logo.png" /><br /><p>Solicitação de recuperação de senha.</p><a href="'.URL.HOME_URI.'admin/login/redefine/'.base64_encode($fetch_user['id_users']).'/'.md5($cod).'">Clique aqui para redefinir sua senha.</a>';
				$mail->AltBody = 'Solicitação de recuperação de senha. Acesse: '.URL.HOME_URI.'admin/login/redefine/'.base64_encode($fetch_user['id_users']).'/'.md5($cod).' e redefina a sua senha.';

				if(!$mail->send()) {
				    $this->form_msg = 'E-mail não pode ser enviado. Tente novamente.';
				    $this->form_msg .= '<i>Error: ' . $mail->ErrorInfo . '</i>';
				} else {
		    		$this->form_msg = 'E-mail de recuperação de senha enviado com sucesso';
				}
				return;
			}
		}else{
			$this->form_msg = '<div class="alert alert-danger" role="alert">E-mail não registrado. Tente novamente</div>';
			return;
		}
	}

	public function check_dt_hash( $user_id = false , $cod_verify = false){
		$this->get_register_form( $user_id );

		if($cod_verify === md5($this->form_data['cod_verify'])){
			$timestamp = strtotime($this->form_data['dt_hash'] . "+1 hour");
			if(strtotime( date('Y-m-d H:i:s')) > strtotime($this->form_data['dt_hash'] . "+1 hour")){
				$this->form_msg = '<div class="alert alert-danger" role="alert">Seu pedido de alteração de senha expirou. Tente novamente.</div>';
				return;
			}
		}else{
			$this->form_msg = '<div class="alert alert-danger" role="alert">Acesso inválido. Tente novamente ou consulte o administrador do sistema.</div>';
				return;
		}
	}
	
	public function redefine_password() {	
		$this->form_data = array();
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] && ! empty ( $_POST ) ) {
			if( $_POST['password'] === $_POST['re_password'] ) {
				foreach ( $_POST as $key => $value ) {
					$this->form_data[$key] = $value;
					if ( empty( $value ) ) {
						$this->form_msg = '<div class="alert alert-danger" role="alert">Erro. Campos estão vazios ou inválidos. Tente novamente</div>';
						return;
					}			
				}
			}else{
				$this->form_msg = '<div class="alert alert-danger" role="alert">Erro. Senha e Repetição de senha não são iguais.</div>';
				return;
			}
		} else {
			return;
		}

		if( empty( $this->form_data ) ) {
			return;
		}
		
		$db_check_user = $this->db->query (
			'SELECT * FROM `users` WHERE `email` = ?', 
			array( 
				chk_array( $this->form_data, 'email')		
			) 
		);
		
		if ( ! $db_check_user ) {
			$this->form_msg = '<div class="alert alert-danger" role="alert">Erro interno.</div>';
			return;
		}
		
		$fetch_user = $db_check_user->fetch();
		$id_user = $fetch_user['id_users'];
		$password_hash = new PasswordHash(8, FALSE);
		$password = $password_hash->HashPassword( $this->form_data['password'] );

		if ( ! empty( $id_user ) ) {

			$query = $this->db->update('users', 'id_users', $id_user, array(
				'password' => $password, 
				'user_session_id' => md5(time()), 
			));
			
			if ( ! $query ) {
				$this->form_msg = '<div class="alert alert-danger" role="alert">Erro interno. Tente novamente.</div>';
				return;
			} else {
				$this->form_msg = '<div class="alert alert-danger" role="alert">Senha atualizada.</div>';
				return;
			}
		} else {
				$this->form_msg = '<div class="alert alert-danger" role="alert">Erro interno. Consulte o administrador do sistema.</div>';
				return;
		}
	}

	public function changeStatus($id = false){
		if(!(isset($id) && is_numeric($id)) ){
			return json_encode(array('sucess' => false ));
		}else{
			$query = $this->db->query(
			'SELECT * FROM users WHERE id_users = ? LIMIT 1',
			array( $id )
			);
			$fetch_data = $query->fetch();
			$data['status'] = $fetch_data['status']==1 ? 2 : 1;
			$query = $this->db->update('users', 'id_users', $id, $data);
			if ( $query ) {
				return json_encode(array('success' => true, 'newStts' => "{$data['status']}" ));
			}else{
				return json_encode(array('success' => false ));
			}			
		}
	}		
}