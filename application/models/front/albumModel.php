<?php 

class albumModel extends mainModel
{

	public $form_msg;

	public function __construct( $db = false, $controller = null ) {
		$this->db = $db;
		$this->controller = $controller;
		$this->parametros = $this->controller->parametros;
		$this->userdata = $this->controller->userdata;
	}

	public function galerias(){
		$id = end($this->parametros);
		$id = explode('-',$id);
		$id = end($id);
		$id = str_replace('Controller','',$id);
		if(!is_numeric($id)){
			return;
		}

		$query = $this->db->query(
			'SELECT * FROM galerias WHERE status = 1 and id_galerias_categorias = ? ORDER BY ordem ASC, id_galerias DESC',
			array( $id )
		);
		$fetch_data['galerias'] = $query->fetchAll();	


		foreach ($fetch_data['galerias'] as $k => $v) {
						
			$query = $this->db->query(
				'SELECT * FROM galerias_fotos WHERE id_galerias = ? ORDER BY ordem  ASC, id_galerias_fotos asc LIMIT 1',
				array( $v['id_galerias'])
			);	
			$fotos = $query->fetch();		
			$fetch_data['galerias'][$k]['cover'] = $fotos['url_img'];
		}		

		$query = $this->db->query(
			'SELECT * FROM galerias_categorias WHERE status = 1 and id_galerias_categorias = ? LIMIT 1',
			array( $id )
		);
		$fetch_data['categoria'] = $query->fetch();
		
		return $fetch_data;
	}

	public function fotos(){
		$id = end($this->parametros);
		$id = explode('-',$id);
		$id = end($id);
		if(!is_numeric($id)){
			return;
		}
		$query = $this->db->query(
			'SELECT * FROM galerias WHERE status = 1 and id_galerias = ? LIMIT 1',
			array( $id )
		);
		$fetch_data['galeria'] = $query->fetch();

		$query = $this->db->query(
			'SELECT * FROM galerias_categorias WHERE status = 1 and id_galerias_categorias = ? LIMIT 1',
			array( $fetch_data['galeria']['id_galerias_categorias'] )
		);
		$fetch_data['categoria'] = $query->fetch();		

		$query = $this->db->query(
			'SELECT * FROM galerias_fotos WHERE status = 1 and id_galerias = ? ORDER BY ordem ASC, id_galerias_fotos asc',
			array( $id )
		);
		
		$fetch_data['fotos'] = $query->fetchAll();
		return $fetch_data;

	}

	public function existeCat($cat){
		$id = explode('-',$cat);
		$id = end($id);
		$id = str_replace('Controller','',$id);	
		$query = $this->db->query(
			'SELECT * FROM galerias_categorias WHERE status = 1 and id_galerias_categorias = ? LIMIT 1',
			array( $id )
		);
		if($query->fetch()){
			return true;
		}else{
			return false;
		}	

	}

	public function existeGal($gal){
		$id = explode('-',$gal);
		$id = end($id);
		$query = $this->db->query(
			'SELECT * FROM galerias WHERE status = 1 and id_galerias = ? LIMIT 1',
			array( $id )
		);
		if($query->fetch()){
			return true;
		}else{
			return false;
		}	}

}