<?php 

class galleriesModel extends mainModel
{
	
	public $posts_por_pagina = 10;

	

	public function __construct( $db = false, $controller = null ) {
		$this->db = $db;
		$this->controller = $controller;
		$this->parametros = $this->controller->parametros;
		$this->acao = isset($this->controller->acao) ? $this->controller->acao : null;
		$this->userdata = $this->controller->userdata;
	}
	
	
	public function listar_galleries () {
		$id = $where = $query_limit = null;
		if ( is_numeric( chk_array( $this->parametros, 0 ) ) ) {
			$id = array ( chk_array( $this->parametros, 0 ) );
			$where = " WHERE id_galerias = ? ";
		}
		$pagina = ! empty( $this->parametros[1] ) ? $this->parametros[1] : 1;
		$pagina--;
		$posts_por_pagina = $this->posts_por_pagina;
		$offset = $pagina * $posts_por_pagina;
		if ( empty ( $this->sem_limite ) ) {
			$query_limit = " LIMIT $offset,$posts_por_pagina ";
		}
		$query = $this->db->query(
			'SELECT * FROM galerias ' . $where . ' ORDER BY ordem  ASC, id_galerias DESC' . $query_limit,
			$id
		);
		return $query->fetchAll();
	}
	
	public function obtem_gallery () {
		if ( isset($this->acao) && $this->acao != 'edit' ) {
			$query = $this->db->query(
					'SELECT * FROM galerias_categorias'
			);
			$this->form_data['galerias_categorias'] = $query->fetchAll();
			return;
		}
		if( empty($this->id) ){			
			if ( ! is_numeric( chk_array( $this->parametros, 0 ) ) ) {
				return;
			}
			$id_galerias = chk_array( $this->parametros, 0 );	
		}else{
			$id_galerias = $this->id;
		}
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] && ! empty( $_POST['add'] ) ) {
			unset($_POST['add']);

			if(isset($_POST['img_src'])){
				$img_src = $_POST['img_src'];
				unset($_POST['img_src']);
			}
			
			$query = $this->db->update('galerias', 'id_galerias', $id_galerias, $_POST);			
			if ( $query ) {
				if(isset($img_src)){
					foreach ($img_src as $img) {
						$dt['url_img'] = $img;
						$dt['ordem'] = 0;
						$dt['status'] = 1;
						$dt['id_galerias'] = $id_galerias;
						$queryFotos = $this->db->insert('galerias_fotos', $dt);
						// retorno da query fotos
					}
				}
				$this->form_msg = '<div class="alert alert-success" role="alert">Galerias atualizada com sucesso!</div>';
			}
		}
		
		$query = $this->db->query(
			'SELECT * FROM galerias WHERE id_galerias = ? LIMIT 1',
			array( $id_galerias )
		);
		$fetch_data = $query->fetch();
		$query = $this->db->query(
			'SELECT * FROM galerias_fotos WHERE id_galerias = ? order by ordem asc, id_galerias_fotos asc',
			array( $id_galerias )
		);
		$fetch_data['fotos'] = $query->fetchAll();
		$query = $this->db->query(
			'SELECT * FROM galerias_categorias'
		);
		$fetch_data['galerias_categorias'] = $query->fetchAll();
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
			
		//$imagem = $this->upload_imagem();
		//if ( ! $imagem ) {
			//return;		
		//}
		
		unset($_POST['add']);
		if(isset($_POST['img_src'])){
				$img_src = $_POST['img_src'];
				unset($_POST['img_src']);
			}
		//$_POST['url_img'] = $imagem;
		
				
		$query = $this->db->insert( 'galerias', $_POST );
		if ( $query ) {
			$this->form_msg = '<div class="alert alert-success" role="alert">Galeria cadastrada com sucesso!</div>';		
			$this->id = $this->db->last_id;	
			if(isset($img_src)){
				foreach ($img_src as $img) {
					$dt['url_img'] = $img;
					$dt['ordem'] = 0;
					$dt['status'] = 1;
					$dt['id_galerias'] = $this->id;
					$queryFotos = $this->db->insert('galerias_fotos', $dt);
					// retorno da query fotos
				}
			}			
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
				$mensagem .= '<h4>Tem certeza que deseja apagar a galeria?</h4>';
				$mensagem .= '<p><a href="' . $_SERVER['REQUEST_URI'] . '/confirma/" class="btn btn-danger">Sim</a>';
				$mensagem .= '<a href="' . HOME_URI . 'admin/galleries/" class="btn btn-default">Não</a></p>';
			$mensagem .= '</div';
			return $mensagem;
		}
		
		$id_galerias = (int)chk_array( $this->parametros, 0 );
		$query = $this->db->delete( 'galerias', 'id_galerias', $id_galerias );
		$query = $this->db->delete( 'galerias_fotos', 'id_galerias', $id_galerias );		
		echo '<meta http-equiv="Refresh" content="0; url=' . HOME_URI . 'admin/galleries">';
		echo '<script type="text/javascript">window.location.href = "' . HOME_URI . 'admin/galleries";</script>';
		
	}
	
	public function upload_imagem() {
	
		// Verifica se o arquivo da imagem existe
		if ( empty( $_FILES['url_img'] ) ) {
			return;
		}

		foreach ($_FILES['url_img'] as $imagem) {
		
		// Configura os dados da imagem
		//$imagem         = $_FILES['url_img'];
		
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
			if ( ! in_array( $tipo_imagem, $permitir_tipos ) ) {
				// Retorna uma mensagem
				$this->form_msg = '<div class="alert alert-danger" role="alert">Você deve enviar uma imagem.</div>';
				return;
			}
			
			// Tenta mover o arquivo enviado
			if ( ! move_uploaded_file( $tmp_imagem, UP_ABSPATH . '/images/galerias/' . $nome_imagem ) ) {
				// Retorna uma mensagem
				$this->form_msg = '<div class="alert alert-danger" role="alert">Erro ao enviar imagem.</div>';
				return;
			}
			$n[] = $nome_imagem;
		}
		// Retorna o nome da imagem
		return $n;
		
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
			'SELECT COUNT(*) as total FROM galerias '
		);
		$total = $query->fetch();
		$total = $total['total'];
		
		// Configura o caminho para a paginação
		$caminho_noticias = HOME_URI . 'admin/galleries/index/page/';
		
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
			'SELECT * FROM galerias WHERE id_galerias = ? LIMIT 1',
			array( $id )
			);
			$fetch_data = $query->fetch();
			$data['status'] = $fetch_data['status']==1 ? 2 : 1;
			$query = $this->db->update('galerias', 'id_galerias', $id, $data);
			if ( $query ) {
				return json_encode(array('success' => true, 'newStts' => "{$data['status']}" ));
			}else{
				return json_encode(array('success' => false ));
			}			
		}
	}

	public function removeImg($id = false){
		if(!(isset($id) && is_numeric($id)) ){
			return json_encode(array('sucess' => false ));
		}else{
			$query = $this->db->delete('galerias_fotos', 'id_galerias_fotos', $id);
			if ( $query ) {
				return json_encode(array('success' => true ));
			}else{
				return json_encode(array('success' => false ));
			}		
		}
	}	

	public function sortImg($list = false){
		if(!(isset($list)) && is_array($list) ) {
			return json_encode(array('sucess' => false ));
		}else{	
			$lis = explode(';',str_replace(']','',str_replace('[','',$list)));
			$lista = str_replace('}','',str_replace('{','[',$lis[0]));
			$lista = trim($lista);
			$lista = str_replace('"','',$lista);
			$lista = stripslashes($lista);
			$lista = explode(',',$lista);
			foreach($lista as $k => $v){
				$ids[] = trim(end(explode(':',$v)));
			}
			
			//$lista2 = explode(',',$lista);
			
			//var_dump($ids);
		
		
		//var_dump(json_decode($_POST[0]));	
			//foreach($list[0] as $l){
				//$ids[] = $l->id;
			//}
			$x=0;
			$when = null;
			//echo 'teste'
			foreach($ids as $i){
				$when .= "WHEN id_galerias_fotos = {$i} THEN {$x} ";
				$x++;
			}
			//echo 'UPDATE galerias_fotos SET ordem = CASE {$when}	ELSE ordem END;';
			$query = $this->db->query("UPDATE galerias_fotos SET ordem = CASE {$when} ELSE ordem END;");
			if ( $query ) {
				return json_encode(array('success' => true ));
			}else{
				return json_encode(array('success' => false ));
			}	
			//echo $this->model->order('banners','id_banners','ordenation',$ids);  
		} 
	}

	public function crop_foto(){	
		if ( ! is_numeric( chk_array( $this->parametros, 0 ) ) ) {
			return;
		}
		$id_galerias_fotos = chk_array( $this->parametros, 0 );			
		$query = $this->db->query(
			'SELECT * FROM galerias_fotos WHERE id_galerias_fotos = ? LIMIT 1',
			array( $id_galerias_fotos )
		);
		$fetch_data = $query->fetch();
		if ( empty( $fetch_data ) ) {
			return;
		}
		$this->form_data = $fetch_data;		
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] && ! empty( $_POST['add'] ) ) {
			if(!empty($_POST['x']) || !empty($_POST['y']) || !empty($_POST['w']) || !empty($_POST['h'])){			
				$targ_w = 754;
				$x = $_POST['x'];
				$y = $_POST['y'];
				$w = $_POST['w'];
				$h = $_POST['h'];
				unset($_POST['add']);
				require(ABSPATH.'/public/plugins/Simple-Ajax-Uploader-master/extras/canvas.php');
				$crop = new canvas();
				$crop->carrega( UP_ABSPATH . '/images/galerias/' . $fetch_data['url_img'] )->hexa( '#FFFFFF' )->redimensiona( $targ_w,'' , 'preenchimento' )->grava(UP_ABSPATH . '/images/galerias/mini/' . $fetch_data['url_img']);
				$crop->carrega( UP_ABSPATH . '/images/galerias/mini/' . $fetch_data['url_img'] )->hexa( '#FFFFFF' )->posicaoCrop($x,$y)->redimensiona( $w, $h , 'crop' )->grava( UP_ABSPATH . '/images/galerias/mini/' . $fetch_data['url_img']);
			}
		}

	}	
}