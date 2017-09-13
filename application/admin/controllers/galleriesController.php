<?php

class galleriesController extends mainController
{
	public $login_required = true;
	public $body_class = 'galleries';
	public $title = NAME;
	public $permission_required;

	public function __construct(){
		parent::__construct();
		if ( ! $this->logged_in ) {
			$this->logout();
			$this->goto_login();
			return;
		}
		$this->parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();
	}

    public function index() {
    	$this->title = 'Galerias - Área Administrativa | '.$this->title;
		$this->permission_required = 'any';
		$this->permission();
        $modelo = $this->load_model('galleries/galleriesModel');
        $lista = $modelo->listar_galleries();

		require ABSPATH . APPLICATION .'/admin/views/helpers/header.php';
		require ABSPATH . APPLICATION .'/admin/views/helpers/menu.php';
		echo '<div class="container-fluid">';
			echo '<div class="row">';
				require ABSPATH . APPLICATION .'/admin/views/helpers/nav.php';
				require ABSPATH . APPLICATION .'/admin/views/galleries/index.php';
			echo '</div>';
		echo '</div>';
		require ABSPATH . APPLICATION .'/admin/views/helpers/footer.php';	
    }    
 
    public function add(){
		$this->title = 'Nova Galeria - Área Administrativa | '.$this->title;
		$this->permission_required = 'any';
		$this->permission();
		$this->acao = 'add';	
		$modelo = $this->load_model('galleries/galleriesModel');
		$modelo->obtem_gallery();
		$modelo->form_confirma = $modelo->del();
		require ABSPATH . APPLICATION .'/admin/views/helpers/header.php';
		require ABSPATH . APPLICATION .'/admin/views/helpers/menu.php';
		echo '<div class="container-fluid">';
			echo '<div class="row">';
				require ABSPATH . APPLICATION .'/admin/views/helpers/nav.php';
				require ABSPATH . APPLICATION .'/admin/views/galleries/form-edit.php';
			echo '</div>';
		echo '</div>';
		require ABSPATH . APPLICATION .'/admin/views/helpers/footer.php';
		require ABSPATH . APPLICATION .'/admin/views/galleries/script-upload.php';
    }

    public function edit(){
		$this->title = 'Editar Galeria - Área Administrativa | '.$this->title;
		$this->permission_required = 'any';
		$this->permission();
		$this->acao = 'edit';		
		$modelo = $this->load_model('galleries/galleriesModel');		
		$modelo->add();
		$modelo->obtem_gallery();
		$modelo->form_confirma = $modelo->del();
		require ABSPATH . APPLICATION .'/admin/views/helpers/header.php';
		require ABSPATH . APPLICATION .'/admin/views/helpers/menu.php';
		echo '<div class="container-fluid">';
			echo '<div class="row">';
				require ABSPATH . APPLICATION .'/admin/views/helpers/nav.php';
				require ABSPATH . APPLICATION .'/admin/views/galleries/form-edit.php';
			echo '</div>';
		echo '</div>';
		require ABSPATH . APPLICATION .'/admin/views/helpers/footer.php';
		require ABSPATH . APPLICATION .'/admin/views/galleries/script-upload.php';
    }

    public function del(){
    	$this->title = 'Galerias - Área Administrativa | '.$this->title;
		$this->permission_required = 'any';
		$this->permission();
		$this->acao = 'del';		
        $modelo = $this->load_model('galleries/galleriesModel');
        $modelo->form_confirma = $modelo->del();      
        $lista = $modelo->listar_galleries();
		require ABSPATH . APPLICATION .'/admin/views/helpers/header.php';
		require ABSPATH . APPLICATION .'/admin/views/helpers/menu.php';
		echo '<div class="container-fluid">';
			echo '<div class="row">';
				require ABSPATH . APPLICATION .'/admin/views/helpers/nav.php';
				require ABSPATH . APPLICATION .'/admin/views/galleries/index.php';
			echo '</div>';
		echo '</div>';
		require ABSPATH . APPLICATION .'/admin/views/helpers/footer.php';
    }

    public function status(){
		$this->permission_required = 'any';
		$this->permission();
		$modelo = $this->load_model('galleries/galleriesModel');
		echo $modelo->changeStatus($_POST['id']);
    	return;
    }    

    public function categories(){
    	$this->title = "Categorias das Galerias - Área Administrativa | {$this->title}";
    	$this->permission_required = 'any';
    	$this->permission();
    	$this->acao = 'categorias';

    	$modelo = $this->load_model('galleries/categoriesModel');
    	$lista = $modelo->listar_categories();

		require ABSPATH . APPLICATION .'/admin/views/helpers/header.php';
		require ABSPATH . APPLICATION .'/admin/views/helpers/menu.php';
		echo '<div class="container-fluid">';
			echo '<div class="row">';
				require ABSPATH . APPLICATION .'/admin/views/helpers/nav.php';
				require ABSPATH . APPLICATION .'/admin/views/galleries/categories.php';
			echo '</div>';
		echo '</div>';
		require ABSPATH . APPLICATION .'/admin/views/helpers/footer.php';	
    }

 	public function categoriesadd(){
		$this->title = 'Nova Categoria da Galeria - Área Administrativa | '.$this->title;
		$this->permission_required = 'any';
		$this->permission();
		$this->acao = 'add';	
		$modelo = $this->load_model('galleries/categoriesModel');
		$modelo->obtem_category();
		$modelo->form_confirma = $modelo->del();
		require ABSPATH . APPLICATION .'/admin/views/helpers/header.php';
		require ABSPATH . APPLICATION .'/admin/views/helpers/menu.php';
		echo '<div class="container-fluid">';
			echo '<div class="row">';
				require ABSPATH . APPLICATION .'/admin/views/helpers/nav.php';
				require ABSPATH . APPLICATION .'/admin/views/galleries/form-categories.php';
			echo '</div>';
		echo '</div>';
		require ABSPATH . APPLICATION .'/admin/views/helpers/footer.php';
    }

    public function categoriesedit(){
		$this->title = 'Editar Categoria da Galeria - Área Administrativa | '.$this->title;
		$this->permission_required = 'any';
		$this->permission();
		$this->acao = 'edit';		
		$modelo = $this->load_model('galleries/categoriesModel');		
		$modelo->add();
		$modelo->obtem_category();
		$modelo->form_confirma = $modelo->del();
		require ABSPATH . APPLICATION .'/admin/views/helpers/header.php';
		require ABSPATH . APPLICATION .'/admin/views/helpers/menu.php';
		echo '<div class="container-fluid">';
			echo '<div class="row">';
				require ABSPATH . APPLICATION .'/admin/views/helpers/nav.php';
				require ABSPATH . APPLICATION .'/admin/views/galleries/form-categories.php';
			echo '</div>';
		echo '</div>';
		require ABSPATH . APPLICATION .'/admin/views/helpers/footer.php';
    }

    public function categoriesdel(){
    	$this->title = 'Categorias - Área Administrativa | '.$this->title;
		$this->permission_required = 'any';
		$this->permission();
		$this->acao = 'del';		
        $modelo = $this->load_model('galleries/categoriesModel');
        $modelo->form_confirma = $modelo->del();
        $lista = $modelo->listar_categories();
		require ABSPATH . APPLICATION .'/admin/views/helpers/header.php';
		require ABSPATH . APPLICATION .'/admin/views/helpers/menu.php';
		echo '<div class="container-fluid">';
			echo '<div class="row">';
				require ABSPATH . APPLICATION .'/admin/views/helpers/nav.php';
				require ABSPATH . APPLICATION .'/admin/views/galleries/categories.php';
			echo '</div>';
		echo '</div>';
		require ABSPATH . APPLICATION .'/admin/views/helpers/footer.php';
    }

    public function categoriesstts(){
		$this->permission_required = 'any';
		$this->permission();
		$modelo = $this->load_model('galleries/categoriesModel');
		echo $modelo->changeStatus($_POST['id']);
    	return;
    }    


    public function uploadfotos(){
    	
    	require(ABSPATH.'/public/plugins/Simple-Ajax-Uploader-master/extras/Uploader.php');
		$uploader = new FileUpload('uploadfile');
		$upload_dir = ABSPATH.'/public/files/images/galerias/';
    	$allowedExtensions = array('png', 'jpg', 'gif');
		$result = $uploader->handleUpload($upload_dir,$allowedExtensions);

		require(ABSPATH.'/public/plugins/Simple-Ajax-Uploader-master/extras/canvas.php');
		$mini = new canvas();
		$targ_w = 384;	$targ_h = 216;	$jpeg_quality = 100;
		$mini->carrega( $upload_dir.$uploader->getFileName() )->hexa( '#FFFFFF' )->grava($upload_dir.$uploader->getFileName());
		$mini->carrega( $upload_dir.$uploader->getFileName() )->hexa( '#FFFFFF' )->redimensiona( $targ_w,'' , 'preenchimento' )->grava( $upload_dir.'mini/'.$uploader->getFileName() );
		$mini->carrega( $upload_dir.'mini/'.$uploader->getFileName() )->hexa( '#FFFFFF' )->posicaoCrop(0,0)->redimensiona( $targ_w,$targ_h , 'crop' )->grava( $upload_dir.'mini/'.$uploader->getFileName() );
		
		if (!$result) {
			exit(json_encode(array('success' => false, 'msg' => $uploader->getErrorMsg())));  
		}

		echo json_encode(array('success' => true, 'file' => $uploader->getFileName()));
		exit;
    }

    public function removeImg(){
		$this->permission_required = 'any';
		$this->permission();
		$modelo = $this->load_model('galleries/galleriesModel');
		echo $modelo->removeImg($_POST['id']);
    	return;    
    }  
 
    public function sortFoto()  {
		$this->permission_required = 'any';
		$this->permission();
		$modelo = $this->load_model('galleries/galleriesModel');
		echo $modelo->sortImg($_POST['data']);	
    }

    public function cropImg(){
    	$this->title = 'Galerias - Editar Imagem - Área Administrativa | '.$this->title;
		$this->permission_required = 'any';
		$this->permission();
        $modelo = $this->load_model('galleries/galleriesModel');
        $lista = $modelo->crop_foto();
		require ABSPATH . APPLICATION .'/admin/views/helpers/header.php';
		require ABSPATH . APPLICATION .'/admin/views/helpers/menu.php';
		echo '<div class="container-fluid">';
			echo '<div class="row">';
				require ABSPATH . APPLICATION .'/admin/views/helpers/nav.php';
				require ABSPATH . APPLICATION .'/admin/views/galleries/crop-img.php';
			echo '</div>';
		echo '</div>';
		require ABSPATH . APPLICATION .'/admin/views/helpers/footer.php';
    }    

    public function permission(){
   		if (!$this->check_permissions($this->permission_required, $this->userdata['user_permissions'])) {
			echo 'Você não tem permissões para acessar essa página.';
			return;
		}
    }	
}