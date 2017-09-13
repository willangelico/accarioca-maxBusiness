<?php 
/**
 * Modelo para gerenciar paginas
 *
 * @package MaxwillBusiness
 * @since 0.1
 */
class pagesModel extends mainModel
{

	/**
	 * $posts_per_page
	 *
	 * Receberá o número de posts por página para configurar a listagem de 
	 * notícias. Também utilizada na paginação. 
	 *
	 * @access public
	 */
	public $posts_por_pagina = 5;

	
	/**
	 * Construtor para essa classe
	 *
	 * Configura o DB, o controlador, os parâmetros e dados do usuário.
	 *
	 * @since 0.1
	 * @access public
	 * @param object $db Objeto da nossa conexão PDO
	 * @param object $controller Objeto do controlador
	 */
	public function __construct( $db = false, $controller = null ) {
		// Configura o DB (PDO)
		$this->db = $db;
		
		// Configura o controlador
		$this->controller = $controller;

		// Configura os parâmetros
		$this->parametros = $this->controller->parametros;

		// Configura a ação
		$this->acao = isset($this->controller->acao) ? $this->controller->acao : null;

		// Configura os dados do usuário
		$this->userdata = $this->controller->userdata;
	}
	
	/**
	 * Lista páginas
	 *
	 * @since 0.1
	 * @access public
	 * @return array Os dados da base de dados
	 */
	public function listar_paginas () {
	
		// Configura as variáveis que vamos utilizar
		$id = $where = $query_limit = null;
		
		// Verifica se um parâmetro foi enviado para carregar uma notícia
		if ( is_numeric( chk_array( $this->parametros, 0 ) ) ) {
			
			// Configura o ID para enviar para a consulta
			$id = array ( chk_array( $this->parametros, 0 ) );
			
			// Configura a cláusula where da consulta
			$where = " WHERE id_pages = ? ";
		}
		
		// Configura a página a ser exibida
		$pagina = ! empty( $this->parametros[1] ) ? $this->parametros[1] : 1;
		
		// A páginação inicia do 0
		$pagina--;
		
		// Configura o número de posts por página
		$posts_por_pagina = $this->posts_por_pagina;
		
		// O offset dos posts da consulta
		$offset = $pagina * $posts_por_pagina;
		
		/* 
		Esta propriedade foi configurada no noticias-adm-model.php para
		prevenir limite ou paginação na administração.
		*/
		if ( empty ( $this->sem_limite ) ) {
		
			// Configura o limite da consulta
			$query_limit = " LIMIT $offset,$posts_por_pagina ";
		
		}
		
		// Faz a consulta
		$query = $this->db->query(
			'SELECT * FROM pages ' . $where . ' ORDER BY ordenation  ASC, id_pages DESC' . $query_limit,
			$id
		);
		$pgs = $query->fetchAll();
		foreach ($pgs as $k => $v) {
			if($v['id_sob']>0){
				$query = $this->db->query(
					'SELECT * FROM pages WHERE id_pages = ? LIMIT 1',
					array( $v['id_sob'] )
				);
				$pg_mae = $query->fetch();
				$pgs[$k]['title_mae'] = $pg_mae['title'];
			}
		}
		
		return $pgs;
	} // listar_noticias
	
	/**
	 * Obtém a pagina e atualiza os dados se algo for postado
	 *
	 * Obtém apenas uma pagina da base de dados para preencher o formulário de
	 * edição.
	 * Configura a propriedade $this->form_data.
	 *
	 * @since 0.1
	 * @access public
	 */
	public function obtem_pagina () {

		// Verifica se a ação é "edit"
		if ( isset($this->acao) && $this->acao != 'edit' ) {
			$query = $this->db->query(
					'SELECT * FROM pages'
			);
			$this->form_data['pages'] = $query->fetchAll();
			return;
		}
		if( empty($this->id) ){			
			if ( ! is_numeric( chk_array( $this->parametros, 0 ) ) ) {
				return;
			}
			$id_pages = chk_array( $this->parametros, 0 );	
		}else{
			$id_pages = $this->id;
		}
		

		
		
		/* 
		Verifica se algo foi postado e se está vindo do form que tem o campo
		add.
		
		Se verdadeiro, atualiza os dados conforme a requisição.
		*/
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] && ! empty( $_POST['add'] ) ) {
		
			// Remove o campo insere_notica para não gerar problema com o PDO
			unset($_POST['add']);
			
						
			// Tenta enviar a imagem
			$imagem = $this->upload_imagem();
			
			// Verifica se a imagem foi enviada
			if ( $imagem ) {
				// Adiciona a imagem no $_POST
				$_POST['url_img'] = $imagem;
			}
			
			// Atualiza os dados
			$query = $this->db->update('pages', 'id_pages', $id_pages, $_POST);
			
			// Verifica a consulta
			if ( $query ) {
				// Retorna uma mensagem
				$this->form_msg = '<div class="alert alert-succes" role="alert">Página atualizada com sucesso!</div>';
			}
			
		}
		
		// Faz a consulta para obter o valor
		$query = $this->db->query(
			'SELECT * FROM pages WHERE id_pages = ? LIMIT 1',
			array( $id_pages )
		);
		
		// Obtém os dados
		$fetch_data = $query->fetch();

		$query = $this->db->query(
			'SELECT * FROM pages WHERE id_pages <> ?',
			array( $id_pages )
		);
		$fetch_data['pages'] = $query->fetchAll();

		
		// Se os dados estiverem nulos, não faz nada
		if ( empty( $fetch_data ) ) {
			return;
		}
		
		// Configura os dados do formulário
		$this->form_data = $fetch_data;
		
	} // obtem_noticia
	
	/**
	 * Insere paginas
	 *
	 * @since 0.1
	 * @access public
	 */
	public function add() {
	
		/* 
		Verifica se algo foi postado e se está vindo do form que tem o campo
		insere_noticia.
		*/
		if ( 'POST' != $_SERVER['REQUEST_METHOD'] || empty( $_POST['add'] ) ) {
			return;
		}
		
		/*
		Para evitar conflitos apenas inserimos valores se o parâmetro edit
		não estiver configurado.
		*/
		if ( chk_array( $this->parametros, 0 ) == 'edit' ) {
			return;
		}
		
		// Só pra garantir que não estamos atualizando nada
		if ( is_numeric( chk_array( $this->parametros, 0 ) ) ) {
			return;
		}
			
		// Tenta enviar a imagem
		$imagem = $this->upload_imagem();
		
		// Verifica se a imagem foi enviada
		if ( ! $imagem ) {
			//return;		
		}
		
		// Remove o campo insere_notica para não gerar problema com o PDO
		unset($_POST['add']);
		
		// Insere a imagem em $_POST
		$_POST['url_img'] = $imagem;
		
				
		// Insere os dados na base de dados
		$query = $this->db->insert( 'pages', $_POST );
		
		// Verifica a consulta
		if ( $query ) {
		
			// Retorna uma mensagem
			$this->form_msg = '<div class="alert alert-succes" role="alert">Página cadastrada com sucesso!</div>';		
			$this->id = $this->db->last_id;	
			return;
			
		} 
		
		// :(
		$this->form_msg = '<div class="alert alert-danger" role="alert">Erro ao enviar dados!</div>';

	} // insere_noticia
	
	/**
	 * Apaga a notícia
	 *
	 * @since 0.1
	 * @access public
	 */
	public function del () {
		
		// O parâmetro del deverá ser enviado
		if ( isset($this->acao) && $this->acao != 'del' ) {
			return;
		}
		
		// O segundo parâmetro deverá ser um ID numérico
		if ( ! is_numeric( chk_array( $this->parametros, 0 ) ) ) {
			return;
		}
		// Para excluir, o terceiro parâmetro deverá ser "confirma"
		if ( chk_array( $this->parametros, 1 ) != 'confirma' ) {
		
			// Configura uma mensagem de confirmação para o usuário
			$mensagem  = '<div class="alert alert-danger alert-dismissible" role="alert">';
				$mensagem .= '<h4>Tem certeza que deseja apagar a página?</h4>';
				$mensagem .= '<p><a href="' . $_SERVER['REQUEST_URI'] . '/confirma/" class="btn btn-danger">Sim</a>';
				$mensagem .= '<a href="' . HOME_URI . 'admin/pages/" class="btn btn-default">Não</a></p>';
			$mensagem .= '</div';
			// Retorna a mensagem e não excluir
			return $mensagem;
		}
		
		// Configura o ID da notícia
		$id_pages = (int)chk_array( $this->parametros, 0 );
		
		// Executa a consulta
		$query = $this->db->delete( 'pages', 'id_pages', $id_pages );
		
		// Redireciona para a página de administração de notícias
		echo '<meta http-equiv="Refresh" content="0; url=' . HOME_URI . 'admin/pages">';
		echo '<script type="text/javascript">window.location.href = "' . HOME_URI . 'admin/pages";</script>';
		
	} // apaga_noticia
	
	/**
	 * Envia a imagem
	 *
	 * @since 0.1
	 * @access public
	 */
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
		if ( ! in_array( $tipo_imagem, $permitir_tipos ) ) {
			// Retorna uma mensagem
			$this->form_msg = '<div class="alert alert-danger" role="alert">Você deve enviar uma imagem.</div>';
			return;
		}
		
		// Tenta mover o arquivo enviado
		if ( ! move_uploaded_file( $tmp_imagem, UP_ABSPATH . '/images/pages/' . $nome_imagem ) ) {
			// Retorna uma mensagem
			$this->form_msg = '<div class="alert alert-danger" role="alert">Erro ao enviar imagem.</div>';
			return;
		}
		
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
			'SELECT COUNT(*) as total FROM pages '
		);
		$total = $query->fetch();
		$total = $total['total'];
		
		// Configura o caminho para a paginação
		$caminho_noticias = HOME_URI . 'admin/pages/index/page/';
		
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

	} // paginacao

	public function changeStatus($id = false){
		if(!(isset($id) && is_numeric($id)) ){
			return json_encode(array('sucess' => false ));
		}else{
			$query = $this->db->query(
			'SELECT * FROM pages WHERE id_pages = ? LIMIT 1',
			array( $id )
			);
			$fetch_data = $query->fetch();
			$data['status'] = $fetch_data['status']==1 ? 2 : 1;
			$query = $this->db->update('pages', 'id_pages', $id, $data);
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
			$query = $this->db->query(
			'SELECT * FROM pages WHERE id_pages = ? LIMIT 1',
			array( $id )
			);
			$fetch_data = $query->fetch();
			$data['url_img'] = null;
			$query = $this->db->update('pages', 'id_pages', $id, $data);
			if ( $query ) {
				return json_encode(array('success' => true ));
			}else{
				return json_encode(array('success' => false ));
			}		
		}
	}
	
} // NoticiasAdmModel