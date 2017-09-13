<?php 

class categoriesModel extends mainModel
{
	
	public $posts_por_pagina = 5;

	

	public function __construct( $db = false, $controller = null ) {
		$this->db = $db;
		$this->controller = $controller;
		$this->parametros = $this->controller->parametros;
		$this->acao = isset($this->controller->acao) ? $this->controller->acao : null;
		$this->userdata = $this->controller->userdata;
	}
	
	
	public function listar_categories () {
		$id = $where = $query_limit = null;		
		$pagina = ! empty( $this->parametros[1] ) ? $this->parametros[1] : 1;
		$pagina--;
		$posts_por_pagina = $this->posts_por_pagina;
		$offset = $pagina * $posts_por_pagina;
		if ( empty ( $this->sem_limite ) ) {
			$query_limit = " LIMIT $offset,$posts_por_pagina ";
		}
		$query = $this->db->query(
			'SELECT * FROM galerias_categorias ' . $where . ' ORDER BY ordem  ASC, id_galerias_categorias DESC' . $query_limit,
			$id
		);
		return $query->fetchAll();
	}
	
	public function obtem_category () {
		if ( isset($this->acao) && $this->acao != 'edit' ) {			
			return;
		}
		if( empty($this->id) ){			
			if ( ! is_numeric( chk_array( $this->parametros, 0 ) ) ) {
				return;
			}
			$id_galerias_categorias = chk_array( $this->parametros, 0 );	
		}else{
			$id_galerias_categorias = $this->id;
		}
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] && ! empty( $_POST['add'] ) ) {
			unset($_POST['add']);

			 $imagem = $this->upload_imagem();
			 if ( $imagem ) {
				$_POST['url_img'] = $imagem;
			 }
			
			$query = $this->db->update('galerias_categorias', 'id_galerias_categorias', $id_galerias_categorias, $_POST);
			if ( $query ) {
				$this->form_msg = '<div class="alert alert-success" role="alert">Categoria atualizada com sucesso!</div>';
			}
		}
		
		$query = $this->db->query(
			'SELECT * FROM galerias_categorias WHERE id_galerias_categorias = ? LIMIT 1',
			array( $id_galerias_categorias )
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
		if ( chk_array( $this->parametros, 0 ) == 'edit' ) {
			return;
		}
		if ( is_numeric( chk_array( $this->parametros, 0 ) ) ) {
			return;
		}
			
		$imagem = $this->upload_imagem();
		if ( ! $imagem ) {
			return;		
		}
		
		unset($_POST['add']);
		$_POST['url_img'] = $imagem;
		
				
		$query = $this->db->insert( 'galerias_categorias', $_POST );
		if ( $query ) {
			$this->form_msg = '<div class="alert alert-success" role="alert">Categoria cadastrada com sucesso!</div>';		
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
				$mensagem .= '<h4>Tem certeza que deseja apagar a categoria e os álbuns dela ?</h4>';
				$mensagem .= '<p><a href="' . $_SERVER['REQUEST_URI'] . '/confirma/" class="btn btn-danger">Sim</a>';
				$mensagem .= '<a href="' . HOME_URI . 'admin/galleries/categories" class="btn btn-default">Não</a></p>';
			$mensagem .= '</div';
			return $mensagem;
		}
		
		$id_galerias = (int)chk_array( $this->parametros, 0 );
		$query = $this->db->delete( 'galerias_categorias', 'id_galerias_categorias', $id_galerias );
		$query = $this->db->delete( 'galerias', 'id_galerias_categorias', $id_galerias );
		echo '<meta http-equiv="Refresh" content="0; url=' . HOME_URI . 'admin/galleries/categories">';
		echo '<script type="text/javascript">window.location.href = "' . HOME_URI . 'admin/galleries/categories";</script>';
		
	}
	
	public function upload_imagem() {
	
		// Verifica se o arquivo da imagem existe
		if ( empty( $_FILES['url_img'] ) ) {
			return;
		}
		
		// Configura os dados da imagem
		$imagem         = $_FILES['url_img'];
		
		// Nome e extensão
		$nome_imagem    = strtolower( $imagem['name'] );
		$ext_imagem     = explode( '.', $nome_imagem );
		$ext_imagem     = end( $ext_imagem );
		$nome_imagem    = preg_replace( '/[^a-zA-Z0-9]/', '', $nome_imagem);
		$nome_imagem   .= '_' . mt_rand() . '.' . $ext_imagem;
		
		// Tipo, nome temporário, erro e tamanho
		$tipo_imagem    = $imagem['type'];
		$tmp_imagem     = $imagem['tmp_name'];
		$erro_imagem    = $imagem['error'];
		$tamanho_imagem = $imagem['size'];
		
		// Os mime types permitidos
		$permitir_tipos  = array(
			'image/bmp',
			'image/x-windows-bmp',
			'image/gif',
			'image/jpeg',
			'image/pjpeg',
			'image/png',
		);
		
		// Verifica se o mimetype enviado é permitido
		// if ( ! in_array( $tipo_imagem, $permitir_tipos ) ) {
		// 	// Retorna uma mensagem
		// 	$this->form_msg = '<div class="alert alert-danger" role="alert">Você deve enviar uma imagem.</div>';
		// 	return;
		// }
		
		// Tenta mover o arquivo enviado
		if ( ! move_uploaded_file( $tmp_imagem, UP_ABSPATH . '/images/galerias/' . $nome_imagem ) ) {
			// Retorna uma mensagem
			$this->form_msg = '<div class="alert alert-danger" role="alert">Erro ao enviar imagem.</div>';
			return;
		}
		$upload_dir = ABSPATH.'/public/files/images/galerias/';
		require(ABSPATH.'/public/plugins/Simple-Ajax-Uploader-master/extras/canvas.php');		
		$mini = new canvas();
		$targ_w = 384;	$targ_h = 216;	$jpeg_quality = 100;
		$mini->carrega( $upload_dir.$nome_imagem )->hexa( '#FFFFFF' )->grava($upload_dir.$nome_imagem );
		$mini->carrega( $upload_dir.$nome_imagem )->hexa( '#FFFFFF' )->redimensiona( $targ_w,'' , 'preenchimento' )->grava( $upload_dir.'mini/'.$nome_imagem );
		$mini->carrega( $upload_dir.'mini/'.$nome_imagem )->hexa( '#FFFFFF' )->posicaoCrop(0,0)->redimensiona( $targ_w,$targ_h , 'crop' )->grava( $upload_dir.'mini/'.$nome_imagem );

		
		// Retorna o nome da imagem
		return $nome_imagem;
		
	} // upload_imagem
	
	/**
	 * Paginação
	 *
	 * @since 0.1
	 * @access public
	 */
	public function paginacao () {
	
		/* 
		Verifica se o primeiro parâmetro não é um número. Se for é um single
		e não precisa de paginação.
		*/
		if ( is_numeric( chk_array( $this->parametros, 0) ) ) {	
			return;
		}
		
		// Obtém o número total de notícias da base de dados
		$query = $this->db->query(
			'SELECT COUNT(*) as total FROM galerias_categorias '
		);
		$total = $query->fetch();
		$total = $total['total'];
		
		// Configura o caminho para a paginação
		$caminho_noticias = HOME_URI . 'admin/galleries/categories/page/';
		
		// Itens por página
		$posts_per_page = $this->posts_por_pagina;
		
		// Obtém a última página possível
		$last = ceil($total/$posts_per_page);
		
		// Configura a primeira página
		$first = 1;
		
		// Configura os offsets
		$offset1 = 3;
		$offset2 = 6;
		
		// Página atual
		$current = isset($this->parametros[1]) ? $this->parametros[1] : 1;
		
		// Exibe a primeira página e reticências no início
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
		
		// O primeiro loop toma conta da parte esquerda dos números
		for ( $i = ( $current - $offset1 ); $i < $current; $i++ ) {

			if ( $i > 0 ) {
				
				echo "<li><a href='$caminho_noticias$i'>$i</a></li>";
				
				// Diminiu o offset do segundo loop
				$offset2--;
			}
		}
		
		// O segundo loop toma conta da parte direita dos números 
		// Obs.: A primeira expressão realmente não é necessária
		for ( ; $i < $current + $offset2; $i++ ) {
			if ( $i <= $last ) {
				if($i==$current)
					$class = ' class="active"';
				else
					$class ='';
				echo "<li$class><a href='$caminho_noticias$i'>$i</a></li>";
			}
		}
		
		// Exibe reticências e a última página no final
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
			'SELECT * FROM galerias_categorias WHERE id_galerias_categorias = ? LIMIT 1',
			array( $id )
			);
			$fetch_data = $query->fetch();
			$data['status'] = $fetch_data['status']==1 ? 2 : 1;
			$query = $this->db->update('galerias_categorias', 'id_galerias_categorias', $id, $data);
			if ( $query ) {
				return json_encode(array('success' => true, 'newStts' => "{$data['status']}" ));
			}else{
				return json_encode(array('success' => false ));
			}			
		}

	}
}