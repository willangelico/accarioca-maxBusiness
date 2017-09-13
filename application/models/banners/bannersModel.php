<?php 

class bannersModel extends mainModel
{

	public $posts_por_pagina = 5;
	public $form_msg;

	public function __construct( $db = false, $controller = null ) {
		$this->db = $db;
		$this->controller = $controller;
		$this->parametros = $this->controller->parametros;
		$this->acao = isset($this->controller->acao) ? $this->controller->acao : null;
		$this->userdata = $this->controller->userdata;
	}
	
	public function listar_banners () {
		$id = $where = $query_limit = null;
		if ( is_numeric( chk_array( $this->parametros, 0 ) ) ) {
			$id = array ( chk_array( $this->parametros, 0 ) );
			$where = " WHERE id_banners = ? ";
		}
		$pagina = ! empty( $this->parametros[1] ) ? $this->parametros[1] : 1;
		$pagina--;
		$posts_por_pagina = $this->posts_por_pagina;
		$offset = $pagina * $posts_por_pagina;
		if ( empty ( $this->sem_limite ) ) {
			$query_limit = " LIMIT $offset,$posts_por_pagina ";
		}
		$query = $this->db->query(
			'SELECT * FROM banners ' . $where . ' ORDER BY ordem  ASC, id_banners DESC' . $query_limit,
			$id
		);
		return $query->fetchAll();
	}
	
	public function obtem_banner () {
		if ( isset($this->acao) && $this->acao != 'edit' ) {	
			return;
		}
		if( empty($this->id) ){			
			if ( ! is_numeric( chk_array( $this->parametros, 0 ) ) ) {
				return;
			}
			$id_banners = chk_array( $this->parametros, 0 );	
		}else{
			$id_banners = $this->id;
		}
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] && ! empty( $_POST['add'] ) ) {
			unset($_POST['add']);
			$imagem = $this->upload_imagem();
			if ( $imagem ) {
				$_POST['url_img'] = $imagem;
			}
			if( ! empty($_POST['daterange'])){
				$data = explode(' até ', $_POST['daterange']);
				$_POST['dt_inicio'] = $this->inverte_data(chk_array($data, 0 ));
				$_POST['dt_final'] = $this->inverte_data(chk_array($data, 1 ));
			}
			unset($_POST['daterange']);
			$query = $this->db->update('banners', 'id_banners', $id_banners, $_POST);
			if ( $query ) {
				$this->form_msg = '<div class="alert alert-success" role="alert">Banner atualizado com sucesso!</div>';
			}			
		}
		$query = $this->db->query(
			'SELECT * FROM banners WHERE id_banners = ? LIMIT 1',
			array( $id_banners )
		);
		$fetch_data = $query->fetch();
		if ( empty( $fetch_data ) ) {
			return;
		}
		$this->form_data = $fetch_data;
	}
	
	public function add() {
		if ( 'POST' != $_SERVER['REQUEST_METHOD'] || empty( $_POST['add'] ) ) {
			return;
		}
		if ( is_numeric( chk_array( $this->parametros, 0 ) ) ) {
			return;
		}
		$imagem = $this->upload_imagem();
		if ( ! $imagem ) {
			$this->form_msg = '<div class="alert alert-danger" role="alert">Banner não enviado.</div>';
			return;		
		}
		unset($_POST['add']);
		$_POST['url_img'] = $imagem;
		if( ! empty($_POST['daterange'])){
			$data = explode(' até ', $_POST['daterange']);
			$_POST['dt_inicio'] = $this->inverte_data(chk_array($data, 0 ));
			$_POST['dt_final'] = $this->inverte_data(chk_array($data, 1 ));
		}
		unset($_POST['daterange']);
		$query = $this->db->insert( 'banners', $_POST );
		if ( $query ) {
			$this->form_msg = '<div class="alert alert-succes" role="alert">Banner cadastrado com sucesso!</div>';		
			$this->id = $this->db->last_id;	
			return;
		} 
		$this->form_msg = '<div class="alert alert-danger" role="alert">Erro ao enviar dados!</div>';
	}
	
	public function del () {
		if ( isset($this->acao) && $this->acao != 'del' ) {
			return;
		}
		if ( ! is_numeric( chk_array( $this->parametros, 0 ) ) ) {
			return;
		}
		if ( chk_array( $this->parametros, 1 ) != 'confirma' ) {
			$mensagem  = '<div class="alert alert-danger alert-dismissible" role="alert">';
				$mensagem .= '<h4>Tem certeza que deseja apagar o banner?</h4>';
				$mensagem .= '<p><a href="' . $_SERVER['REQUEST_URI'] . '/confirma/" class="btn btn-danger">Sim</a>';
				$mensagem .= '<a href="' . HOME_URI . 'admin/banners/" class="btn btn-default">Não</a></p>';
			$mensagem .= '</div';
			return $mensagem;
		}
		$id_banners = (int)chk_array( $this->parametros, 0 );
		$query = $this->db->delete( 'banners', 'id_banners', $id_banners );
		echo '<meta http-equiv="Refresh" content="0; url=' . HOME_URI . 'admin/banners">';
		echo '<script type="text/javascript">window.location.href = "' . HOME_URI . 'admin/banners";</script>';
	}
	
	public function upload_imagem() {
		if ( empty( $_FILES['url_img'] ) ) {
			return;
		}
		$imagem         = $_FILES['url_img'];
		$nome_imagem    = strtolower( $imagem['name'] );
		$ext_imagem     = explode( '.', $nome_imagem );
		$ext_imagem     = end( $ext_imagem );
		$nome_imagem    = preg_replace( '/[^a-zA-Z0-9]/', '', $nome_imagem);
		$nome_imagem   .= '_' . mt_rand() . '.' . $ext_imagem;

		$tipo_imagem    = $imagem['type'];
		$tmp_imagem     = $imagem['tmp_name'];
		$erro_imagem    = $imagem['error'];
		$tamanho_imagem = $imagem['size'];
		
		$permitir_tipos  = array(
			'image/bmp',
			'image/x-windows-bmp',
			'image/gif',
			'image/jpeg',
			'image/pjpeg',
			'image/png',
		);		
		if ( ! in_array( $tipo_imagem, $permitir_tipos ) ) {
			$this->form_msg = '<div class="alert alert-danger" role="alert">Você deve enviar uma imagem.</div>';
			return;
		}		
		if ( ! move_uploaded_file( $tmp_imagem, UP_ABSPATH . '/images/banners/' . $nome_imagem ) ) {
			$this->form_msg = '<div class="alert alert-danger" role="alert">Erro ao enviar imagem.</div>';
			return;
		}
		require(ABSPATH.'/public/plugins/Simple-Ajax-Uploader-master/extras/canvas.php');
		$mini = new canvas();
		$targ_w = 940;	$targ_h = 530;	$jpeg_quality = 100;
		$mini->carrega( UP_ABSPATH . '/images/banners/' . $nome_imagem )->hexa( '#FFFFFF' )->grava(UP_ABSPATH . '/images/banners/' . $nome_imagem);
		$mini->carrega( UP_ABSPATH . '/images/banners/' . $nome_imagem )->hexa( '#FFFFFF' )->redimensiona( $targ_w,'' , 'preenchimento' )->grava(UP_ABSPATH . '/images/banners/mini/' . $nome_imagem);
		$mini->carrega( UP_ABSPATH . '/images/banners/mini/' . $nome_imagem )->hexa( '#FFFFFF' )->posicaoCrop(0,0)->redimensiona( $targ_w,$targ_h , 'crop' )->grava( UP_ABSPATH . '/images/banners/mini/' . $nome_imagem);
		
		return $nome_imagem;
	}

	public function crop_banners(){	
		if ( ! is_numeric( chk_array( $this->parametros, 0 ) ) ) {
			echo '2';
			return;
		}
		$id_banners = chk_array( $this->parametros, 0 );			
		$query = $this->db->query(
			'SELECT * FROM banners WHERE id_banners = ? LIMIT 1',
			array( $id_banners )
		);
		$fetch_data = $query->fetch();
		if ( empty( $fetch_data ) ) {
			return;
		}
		$this->form_data = $fetch_data;		
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] && ! empty( $_POST['add'] ) ) {
			$targ_w = 940;
			//$x = $_POST['x']*2;
			//$y = $_POST['y']*2;
			//$w = $_POST['w']*2;
			//$h = $_POST['h']*2;

			unset($_POST['add']);
			require(ABSPATH.'/public/plugins/Simple-Ajax-Uploader-master/extras/canvas.php');
			$crop = new canvas();
			$crop->carrega( UP_ABSPATH . '/images/banners/' . $fetch_data['url_img'] )->hexa( '#FFFFFF' )->redimensiona( $targ_w,'' , 'preenchimento' )->grava(UP_ABSPATH . '/images/banners/mini/' . $fetch_data['url_img']);
			$crop->carrega( UP_ABSPATH . '/images/banners/mini/' . $fetch_data['url_img'] )->hexa( '#FFFFFF' )->posicaoCrop($x,$y)->redimensiona( $w, $h , 'crop' )->grava( UP_ABSPATH . '/images/banners/mini/' . $fetch_data['url_img']);
		}

	}
	
	public function paginacao () {
		if ( is_numeric( chk_array( $this->parametros, 0) ) ) {	
			return;
		}
		
		$query = $this->db->query(
			'SELECT COUNT(*) as total FROM banners '
		);
		$total = $query->fetch();
		$total = $total['total'];
		
		$caminho_noticias = HOME_URI . 'admin/banners/index/banner/';	
		$posts_per_page = $this->posts_por_pagina;
		$last = ceil($total/$posts_per_page);
		$first = 1;
		$offset1 = 3;
		$offset2 = 6;
		$current = isset($this->parametros[1]) ? $this->parametros[1] : 1;
		if ( $current > 1 ) {
			$class = '';			
		}else{
			$class = " class='disabled'";
		}
		echo "<li$class>
				<a aria-label='Previous' href='$caminho_noticias$first''>
					<span aria-hidden='true'>«</span>
				</a>
			</li>";
		for ( $i = ( $current - $offset1 ); $i < $current; $i++ ) {
			if ( $i > 0 ) {
				echo "<li><a href='$caminho_noticias$i'>$i</a></li>";
				$offset2--;
			}
		}
		for ( ; $i < $current + $offset2; $i++ ) {
			if ( $i <= $last ) {
				if($i==$current)
					$class = ' class="active"';
				else
					$class ='';
				echo "<li$class><a href='$caminho_noticias$i'>$i</a></li>";
			}
		}
		if ( $current ==  $last ) {
			$class = " class='disabled'";
		}else{
			$class = '';
		}
		echo "<li$class>
				<a aria-label='Next' href='$caminho_noticias$last''>
					<span aria-hidden='true'>»</span>
				</a>
			</li>";
	}

	public function changeStatus($id = false){
		if(!(isset($id) && is_numeric($id)) ){
			return json_encode(array('sucess' => false ));
		}else{
			$query = $this->db->query(
			'SELECT * FROM banners WHERE id_banners = ? LIMIT 1',
			array( $id )
			);
			$fetch_data = $query->fetch();
			$data['status'] = $fetch_data['status']==1 ? 2 : 1;
			$query = $this->db->update('banners', 'id_banners', $id, $data);
			if ( $query ) {
				return json_encode(array('success' => true, 'newStts' => "{$data['status']}" ));
			}else{
				return json_encode(array('success' => false ));
			}			
		}

	}
}