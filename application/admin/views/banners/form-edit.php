<?php 
	if ( ! defined('ABSPATH')) exit;
	$adm_uri = HOME_URI . 'admin/banners/';
	$edit_uri = $adm_uri . 'edit/';
	$delete_uri = $adm_uri . 'del/';
?>
<div class="col-md-offset-2 col-md-10 main-content">
	<section class="content-header">
		<h1>Banners <small>Novo banner</small></h1>
		<?php
			$breadcrumb = new breadcrumb;
			$breadcrumb->setWay(array("name"=>"Home", "icon"=>"fa fa-dashboard", "a"=>HOME_URI."admin"));
			$breadcrumb->setWay(array("name"=>"Banners", "a"=>$adm_uri,"icon"=>"fa fa-picture-o"));
			$breadcrumb->setWay(array("name"=>"Novo banner", "li"=>"active"));
			$breadcrumb->getWay();
		?>					
	</section>
	<div class="container-fluid box">
		<div class="row">
			<div class="col-md-12">
				<nav class="navbar sub-header">
					<form class="navbar-form" method="post" action="<?=$adm_uri;?>search">
						<div class="pull-left">
							<h2>Cadastro de novo banner</h2>
						</div>
						<div class="pull-right search">
							<a href="<?=$adm_uri;?>" class="btn btn-primary">Lista de banners</a>
							<a href="<?=$adm_uri;?>add" class="btn btn-primary">Novo banner</a>
						</div>					
					</form>	
				</nav>
				<?php
					if ( isset($this->form_msg) ) {
						echo $this->form_msg;
					}
				?>
				<form action="<?=$edit_uri;?><?=chk_array( $modelo->form_data, 'id_banners')?>" method="post" enctype="multipart/form-data">
					<div class="col-xs-12 col-md-3 pull-right">
				    	<div class="form-group">
				        	<label for="status">Status</label>
				            <select name="status" class="form-control">
				            	<option value="1"<?=chk_array( $modelo->form_data, 'status')==1 ? ' selected' : '';?>>Ativa</option>                                  
				                <option value="2"<?=chk_array( $modelo->form_data, 'status')==2 ? ' selected' : '';?>>Removida</option>
							</select>
				        </div> 			        					    
				    </div>
				    <div class="col-xs-12 col-md-9">
				        <div class="form-group">
				            <label for="title">Título</label>
				            <input type="text" name="titulo" class="form-control" id="title" placeholder="Insira o Titulo" value="<?php 
								echo htmlentities( chk_array( $modelo->form_data, 'titulo'), ENT_QUOTES, 'UTF-8' );
							?>" />
				        </div>
				        <div class="form-group">
				            <label for="legend">Chamada</label>
				            <input type="text" name="legenda" class="form-control" id="legend" placeholder="Insira a Legenda" value="<?php 
								echo htmlentities( chk_array( $modelo->form_data, 'legenda') , ENT_QUOTES, 'UTF-8');
							?>" />
				        </div><div class="form-group">
				            <label for="url">Url de destino</label>
				            <input type="text" name="url" class="form-control" id="url" placeholder="Insira a Url de destino" value="<?php 
								echo htmlentities( chk_array( $modelo->form_data, 'url') , ENT_QUOTES, 'UTF-8');
							?>" />
				        </div> 
						<div class="form-group">
					    	<label for="url_img">Imagem do banner</label>
					    	<input type="file" class="filestyle" placeholder="Insira uma imagem" name="url_img" id="url_img" data-buttonText="Localizar arquivo">
					    	<?php if(chk_array($modelo->form_data,'url_img')){?>
					    		<img src="<?=HOME_URI;?>public/files/images/banners/mini/<?=chk_array($modelo->form_data,'url_img')?>?<?=rand(0,99);?>" style="width: 100%;" />	
					    		<a href="<?=$adm_uri;?>cropImg/<?=chk_array( $modelo->form_data, 'id_banners')?>" class="pull-right">Ver imagem original e editar</a>				
					    	<?php }?>    	
					    </div>				        
				        <input type="hidden" name="add" value="1" />
				        <div class="btn-save"><button type="submit" class="btn btn-primary pull-right">Salvar</button></div>
				    </div>
				</form>
			</div>
		</div>
	</div>
</div>