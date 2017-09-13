<?php 

class frontModel extends mainModel
{

	public $form_msg;

	public function __construct( $db = false, $controller = null ) {
		$this->db = $db;
		$this->controller = $controller;
		$this->parametros = $this->controller->parametros;
		$this->userdata = $this->controller->userdata;


		$db_config = $this->db->query (
			'SELECT * FROM `config` WHERE `id_config` = ?', 
			array('1')	
		); 	
		if ( ! $db_config ) {
			$this->form_msg = 'Internal error.';
			return;
		}

		$this->config = $db_config->fetch();

	}
		
	public function bannersAtivos () {
		$id = $where = $query_limit = null;
		$query = $this->db->query(
			'SELECT * FROM banners WHERE status = ? ORDER BY ordem  ASC, id_banners DESC' . $query_limit,
			array( 1 )
		);
		return $query->fetchAll();
	}

	public function ultimosTrabalhos($q){
		$id = $where = $query_limit = null;
		$query_limit = " LIMIT ".$q;
		$query = $this->db->query(
			'SELECT * FROM galerias WHERE status = ? ORDER BY id_galerias DESC' . $query_limit,
			array( 1 )
		);
		$pgs = $query->fetchAll();		
		
		foreach ($pgs as $k => $v) {
			$query = $this->db->query(
				'SELECT * FROM galerias_categorias WHERE id_galerias_categorias = ? LIMIT 1',
				array( $v['id_galerias_categorias'] )
			);	
			$category = $query->fetch();			
			$query = $this->db->query(
				'SELECT * FROM galerias_fotos WHERE id_galerias = ? ORDER BY ordem  ASC, id_galerias_fotos DESC LIMIT 1',
				array( $v['id_galerias'])
			);	
			$fotos = $query->fetch();		
			$pgs[$k]['category'] = $category['titulo'];
			$pgs[$k]['cover'] = $fotos['url_img'];
		}		
		return $pgs;
	}

	public function categorias(){
		$id = $where = $query_limit = null;
		$query = $this->db->query(
			'SELECT * FROM galerias_categorias WHERE status = ? ORDER BY titulo ASC, id_galerias_categorias DESC' . $query_limit,
			array( 1 )
		);
		return $query->fetchAll();
	}

	public function paginas(){
		$id = $where = $query_limit = null;
		$query = $this->db->query(
			'SELECT * FROM pages WHERE status = ? and id_pages = 1 ORDER BY ordenation  ASC, id_pages DESC' . $query_limit,
			array( 1 )
		);
		return $query->fetchAll();
	}	

	public function envia_form($dados){
		if(empty($dados['name']) || strlen($dados['name']) < 2){
			return json_encode(array('success' => false, 'msg' => '<div class="alert alert-danger" role="alert">Não enviado! Nome inválido.</div>'));			
		}
		if(empty($dados['email']) || !filter_var($dados['email'], FILTER_VALIDATE_EMAIL)){
			return json_encode(array('success' => false, 'msg' => '<div class="alert alert-danger" role="alert">Não enviado! E-mail inválido.</div>'));			
		}
		if(empty($dados['phone']) || strlen($dados['phone']) < 8){
			return json_encode(array('success' => false, 'msg' => '<div class="alert alert-danger" role="alert">Não enviado! Telefone inválido.</div>'));			
		}
		if(empty($dados['message']) || strlen($dados['message']) < 15){
			return json_encode(array('success' => false, 'msg' => '<div class="alert alert-danger" role="alert">Não enviado! Mensagem muito curta.</div>'));			
		}

		$fetch_config = $this->config;


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
		$mail->addAddress($fetch_config['email_contato'], $fetch_config['titulo']);     // Add a recipient
		$mail->addReplyTo($dados['email'], $dados['name']);
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = utf8_decode("Contato de: {$dados['name']}");
		$mail->Body = "
			<html>
				<head></head>
				<body>
					<table border='0' aling='center' width='500'>
						<tr>
							<td width='90'></td>
							<td><h2>Novo contato</h2></td>
						</tr>
						<tr>
							<td colspan='2'><hr><br><br></td>
						</tr>
						<tr>
							<td colspan='2'><font size='2' face='verdana'>Nome: {$dados['name']}</font></td>
						</tr>
						<tr>
							<td colspan='2'><font size='2' face='verdana'>Telefone: {$dados['phone']}</font></td>
						</tr>
						<tr>
							<td colspan='2'><font size='2' face='verdana'>E-mail: {$dados['email']}</font></td>
						</tr>
						<tr>
							<td colspan='2'><font size='2' face='verdana'>Mensagem: {$dados['message']}</font></td>
						</tr>
						<tr>
							<td colspan='2'><br><br></td>
						</tr>
						<tr>
						<td colspan='2'>
							<hr>
							<font size='1' face='verdana'>
								E-mail enviado por ".NAME." <br>
							</font>
					  </td>
					</tr>
				</table>
			</body>
		</html>";
		if(!$mail->send()) {
			return json_encode(array('success' => false, 'msg' => '<div class="alert alert-danger" role="alert">E-mail não pode ser enviado. Tente novamente.<i>Error: ' . $mail->ErrorInfo . '</i></div>'));			
		} else {
			return json_encode(array('success' => true, 'msg' => '<div class="alert alert-success" role="alert">E-mail enviado! Em breve entraremos em contato.</div>'));			
		}
	}
}