<?php 
	if ( ! defined('ABSPATH')) exit;
	$adm_uri = HOME_URI . 'admin/galleries/categories/';
	$edit_uri = HOME_URI . 'admin/galleries/categoriesedit/';
	$del_uri = HOME_URI . 'admin/galleries/categoriesdel/';
?>
<div class="col-md-offset-2 col-md-10 main-content">
	<section class="content-header">
		<h1>Categorias <small>Nova categoria das galerias</small></h1>
		<?php
			$breadcrumb = new breadcrumb;
			$breadcrumb->setWay(array("name"=>"Home", "icon"=>"fa fa-dashboard", "a"=>HOME_URI."admin"));
			$breadcrumb->setWay(array("name"=>"Galerias", "a"=>HOME_URI."admin/galleries","icon"=>"fa fa-file-image-o"));
			$breadcrumb->setWay(array("name"=>"Categorias","a"=>$adm_uri));
			$breadcrumb->setWay(array("name"=>"Cadastro de categorias","li"=>"active"));
			$breadcrumb->getWay();
		?>				
	</section>
	<div class="container-fluid box">
		<div class="row">
			<div class="col-md-12">
				<nav class="navbar sub-header">
					<form class="navbar-form" method="post" action="<?=$adm_uri;?>search">
						<div class="pull-left">
							<h2>Cadastro de nova categoria</h2>
						</div>
						<div class="pull-right search">
							<a href="<?=$adm_uri;?>" class="btn btn-primary">Lista de categorias</a>
							<a href="<?=HOME_URI;?>admin/galleries/categoriesadd/" class="btn btn-primary">Nova categoria</a>
						</div>					
					</form>	
				</nav>
				<?php
					if ( isset($modelo->form_msg) ) {
						echo $modelo->form_msg;
					}
				?>
				<form action="<?=$edit_uri;?><?=chk_array( $modelo->form_data, 'id_galerias_categorias')?>" method="post" enctype="multipart/form-data">
					<div class="col-xs-12 col-md-3 pull-right">
				    	<div class="form-group">
				        	<label for="status">Status</label>
				            <select name="status" class="form-control">
				            	<option value="1"<?=chk_array( $modelo->form_data, 'status')==1 ? ' selected' : '';?>>Ativa</option>                                  
				                <option value="2"<?=chk_array( $modelo->form_data, 'status')==2 ? ' selected' : '';?>>Removida</option>
							</select>
				        </div> 
				        <div class="form-group">
				            <label for="meta_tags">Palavras-chaves</label>
				            <input type="text" name="meta_tags" class="form-control" id="meta_tags" placeholder="Insira as palavras-chaves" value="<?php 
								echo htmlentities( chk_array( $modelo->form_data, 'meta_tags'), ENT_QUOTES, 'UTF-8' );
							?>" />
				        </div>
				        <div class="form-group">
				            <label for="meta_description">Descrição</label>
				            <input type="text" name="meta_description" class="form-control" id="meta_description" placeholder="Insira a descrição da página" value="<?php 
								echo htmlentities( chk_array( $modelo->form_data, 'meta_description'), ENT_QUOTES, 'UTF-8' );
							?>" />
				        </div>
				        <div class="form-group">
					    	<label for="url_img">Imagem de destaque</label>
					    	<input type="file" class="filestyle" placeholder="Insira uma imagem" name="url_img" id="url_img" data-buttonText="Localizar arquivo">
					    	<?php if(chk_array($modelo->form_data,'url_img')){?>
					    		<img src="<?=HOME_URI;?>public/files/images/galerias/mini/<?=chk_array($modelo->form_data,'url_img')?>" style="width: 100%;" />					
					    	<?php }?>    	
					    </div>	
				    </div>
				    <div class="col-xs-12 col-md-9">
				        <div class="form-group">
				            <label for="title">Título</label>
				            <input type="text" name="titulo" class="form-control" id="title" placeholder="Insira o Titulo" value="<?php 
								echo htmlentities( chk_array( $modelo->form_data, 'titulo'), ENT_QUOTES, 'UTF-8' );
							?>" />
				        </div>				        
				        <input type="hidden" name="add" value="1" />
				        <div class="btn-save"><button type="submit" class="btn btn-primary pull-right">Salvar</button></div>
				    </div>
				</form>
			</div>
		</div>
	</div>
</div>