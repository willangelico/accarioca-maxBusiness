<?php 

class configModel extends mainModel
{

	public $form_msg;

	public function __construct( $db = false, $controller = null ) {
		$this->db = $db;
		$this->controller = $controller;
		$this->parametros = $this->controller->parametros;
		$this->userdata = $this->controller->userdata;
	}
	
	
	public function obtem_config ($id = false) {
		if( ! (isset($id) && is_numeric($id))){
			return;
		}
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] && ! empty( $_POST['add'] ) ) {
			unset($_POST['add']);			
			$query = $this->db->update('config', 'id_config', $id, $_POST);
			if ( $query ) {
				$this->form_msg = '<div class="alert alert-succes" role="alert">Configurações atualizadas com sucesso!</div>';
			}			
		}
		$query = $this->db->query(
			'SELECT * FROM config WHERE id_config = ? LIMIT 1',
			array( $id )
		);
		$fetch_data = $query->fetch();
		if ( empty( $fetch_data ) ) {
			return;
		}
		$this->form_data = $fetch_data;
	}
}