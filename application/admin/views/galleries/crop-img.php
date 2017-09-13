<?php 
	if ( ! defined('ABSPATH')) exit;
	$adm_uri = HOME_URI . 'admin/galleries/';
	$edit_uri = $adm_uri . 'edit/';
?>
<div class="col-md-offset-2 col-md-10 main-content">
	<section class="content-header">
		<h1>Editar Imagem <small>Recorte de imagem para o galeria</small></h1>
		<?php
			$breadcrumb = new breadcrumb;

			$breadcrumb->setWay(array("name"=>"Home", "icon"=>"fa fa-dashboard", "a"=>HOME_URI."admin"));
			$breadcrumb->setWay(array("name"=>"Galerias", "a"=>HOME_URI."admin/galleries","icon"=>"fa fa-file-image-o"));
			$breadcrumb->setWay(array("name"=>"Cadastro de galeria","a"=>$edit_uri.chk_array( $modelo->form_data, 'id_galerias')));
			$breadcrumb->setWay(array("name"=>"Edição de imagem", "li"=>"active"));
			$breadcrumb->getWay();
		?>					
	</section>
	<div class="container-fluid box">
		<div class="row">
			<div class="col-md-12">
				<nav class="navbar sub-header">
					<form class="navbar-form" method="post" action="<?=$adm_uri;?>search">
						<div class="pull-left">
							<h2>Editar imagem</h2>
						</div>
						<div class="pull-right search">
							<a href="<?=$edit_uri;?><?=chk_array( $modelo->form_data, 'id_galerias')?>" class="btn btn-primary">Voltar</a>
						</div>					
					</form>	
				</nav>
				<?php
					if ( isset($this->form_msg) ) {
						echo $this->form_msg;
					}
				?>
				<form action="<?=$adm_uri;?>cropImg/<?=chk_array( $modelo->form_data, 'id_galerias_fotos')?>" method="post" enctype="multipart/form-data">
					<div class="col-xs-12 col-md-4 pull-right">
				    	<div class="form-group">
				        	<h6>Recortada</h6>					        	
					    	<img src="<?=HOME_URI;?>public/files/images/galerias/mini/<?=chk_array($modelo->form_data,'url_img')?>?<?=rand(0,99);?>" style="width: 384px;" />		
					    </div>
					</div>					
					<div class="col-xs-12 col-md-8 pull-left">
				    	<div class="form-group">
				        	<h6>Imagem</h6>
							<img src="<?=HOME_URI;?>public/files/images/galerias/<?=chk_array($modelo->form_data,'url_img')?>" style="width: 754px;" id="cropbox" />	<br />
					    	<input type="hidden" id="x" name="x" />
                            <input type="hidden" id="y" name="y" />
                            <input type="hidden" id="w" name="w" />
                            <input type="hidden" id="h" name="h" />
                            <input type="hidden" id="targ_w" name="targ_w" value="384" />
                            <input type="hidden" id="targ_h" name="targ_h" value="216" />			            
				        </div> 
				        <input type="hidden" name="add" value="1" />
				        <div class="btn-save"><button type="submit" class="btn btn-primary pull-right">Salvar</button></div>
				    </div>
				</form>
			</div>
		</div>
	</div>
</div>