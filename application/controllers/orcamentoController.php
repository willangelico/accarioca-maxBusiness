<?php

class orcamentoController extends mainController
{
	
	public $login_required = false;

    public function index() {
		$modelo = $this->load_model('front/frontModel');
		echo $modelo->envia_form($_POST);
    	return; 
    } 
	
} 