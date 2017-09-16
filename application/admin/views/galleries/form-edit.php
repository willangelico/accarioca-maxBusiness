<?php 
	if ( ! defined('ABSPATH')) exit;
	$adm_uri = HOME_URI . 'admin/galleries/';
	$edit_uri = $adm_uri . 'edit/';
	$del_uri = $adm_uri . 'del/';
?>
<div class="col-md-offset-2 col-md-10 main-content">
	<section class="content-header">
		<h1>Materiais <small>Novo material</small></h1>
		<?php
			$breadcrumb = new breadcrumb;
			$breadcrumb->setWay(array("name"=>"Home", "icon"=>"fa fa-dashboard", "a"=>HOME_URI."admin"));
			$breadcrumb->setWay(array("name"=>"Materiais", "a"=>HOME_URI."admin/galleries","icon"=>"fa fa-file-image-o"));
			$breadcrumb->setWay(array("name"=>"Cadastro de materiais","li"=>"active"));
			$breadcrumb->getWay();
		?>	
	</section>
	<div class="container-fluid box">
		<div class="row">
			<div class="col-md-12">
				<nav class="navbar sub-header">
					<form class="navbar-form" method="post" action="<?=$adm_uri;?>search">
						<div class="pull-left">
							<h2>Cadastro de novo material</h2>
						</div>
						<div class="pull-right search">
							<a href="<?=$adm_uri;?>" class="btn btn-primary">Lista de materiais</a>
							<a href="<?=HOME_URI;?>admin/gallery/add/" class="btn btn-primary">Novo material</a>
						</div>					
					</form>	
				</nav>
				<?php
					if ( isset($modelo->form_msg) ) {
						echo $modelo->form_msg;
					}
				?>
				<form action="<?=$edit_uri;?><?=chk_array( $modelo->form_data, 'id_galerias')?>" method="post" enctype="multipart/form-data">
					<div class="col-xs-12 col-md-3 pull-right">
				    	<div class="form-group">
				        	<label for="status">Status</label>
				            <select name="status" class="form-control">
				            	<option value="1"<?=chk_array( $modelo->form_data, 'status')==1 ? ' selected' : '';?>>Ativa</option>                                  
				                <option value="2"<?=chk_array( $modelo->form_data, 'status')==2 ? ' selected' : '';?>>Removida</option>
							</select>
				        </div> 
				        <div class="form-group">
					   		<label for="id_galerias_categorias">Categoria</label>
					        <select name="id_galerias_categorias" class="form-control">
					           	<option value="0"<?=chk_array( $modelo->form_data, 'id_galerias_categorias')==0 ? ' selected' : '';?>>---</option>
					           	<?php foreach(chk_array( $modelo->form_data, 'galerias_categorias') as $l):?>
					          		<option value="<?=$l['id_galerias_categorias'];?>"<?=chk_array( $modelo->form_data, 'id_galerias_categorias')==$l['id_galerias_categorias'] ? ' selected' : '';?>><?=$l['titulo'];?></option>
					          	<?php endforeach;?>
					        </select>
					    </div>
				        <div class="form-group">
				            <label for="meta_tags">Palavras-chaves</label>
				            <input type="text" name="meta_tags" class="form-control" id="meta_tags" placeholder="Insira as palavras-chaves" value="<?php 
								echo htmlentities( chk_array( $modelo->form_data, 'meta_tags') , ENT_QUOTES, 'UTF-8');
							?>" />
				        </div>
				        <div class="form-group">
				            <label for="meta_description">Descrição</label>
				            <input type="text" name="meta_description" class="form-control" id="meta_description" placeholder="Insira a descrição da página" value="<?php 
								echo htmlentities( chk_array( $modelo->form_data, 'meta_description') , ENT_QUOTES, 'UTF-8');
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
								echo htmlentities( chk_array( $modelo->form_data, 'titulo') , ENT_QUOTES, 'UTF-8');
							?>" />
                         </div>   
				        <div class="form-group">
				            <label for="chamada">Chamada</label>
				            <input type="text" name="chamada" class="form-control" id="chamada" placeholder="Insira a Chamada" value="<?php 
								echo htmlentities( chk_array( $modelo->form_data, 'chamada'), ENT_QUOTES, 'UTF-8' );
							?>" />
				        </div>	
				        <div class="form-group">
				            <label for="conteudo">Conteúdo</label>
							<script type="text/javascript" src="<?=HOME_URI;?>library/plugins/ckeditor/ckeditor.js"></script>			
							<textarea name="conteudo" id="conteudo" class="form-control" rows="3"><?php 
								echo stripslashes( htmlentities(  chk_array( $modelo->form_data, 'conteudo'), ENT_QUOTES, 'UTF-8' ) );
							?></textarea>
							<script type="text/javascript">
				            //<![CDATA[
				                CKEDITOR.replace( 'conteudo',
				                    {
				                        filebrowserBrowseUrl: '<?=HOME_URI;?>library/plugins/FileManager/index.html',
				                        toolbar :
				                        [
				                            ['Source','RemoveFormat'],
				                            ['Image','Flash','YouTube','Table','HorizontalRule','Smiley','SpecialChar'],
				                            ['Maximize'],
				                            ['Link','Unlink'],										
				                            '/',
				                            ['FontSize'],
				                            ['Bold','Italic','Underline','Strike','Subscript','Superscript','TextColor','BGColor'],
				                            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
				                            ['NumberedList','BulletedList','Outdent','Indent','Blockquote']
				                        ]
				                    });
				            //]]>
				            </script>
				        </div>
				        <input type="hidden" name="add" value="1" />
				        <div class="btn-save"><button type="submit" class="btn btn-primary pull-right">Salvar</button></div>
				    </div>
				</form>
				<?Php if(is_array((chk_array( $modelo->form_data, 'fotos')))){?>
					<hr />
					<div class="gp col-xs-12 col-md-9">
						<h3>Fotos da galeria</h3>
						<ul class="galleries_photos sorted" data-url="<?=$adm_uri;?>sortFoto" style="padding:0px;">
							<?php foreach (chk_array( $modelo->form_data, 'fotos') as $fotos) :?>
								<li class="col-xs-6 col-md-3" id="img<?=$fotos['id_galerias_fotos'];?>" data-id="<?=$fotos['id_galerias_fotos'];?>">
									<div class="thumbnail">
										<a href="<?=HOME_URI;?>public/files/images/galerias/<?=$fotos['url_img'];?>" class="fancybox-thumb" rel="fancybox-thumb">
											<img src="<?=HOME_URI;?>public/files/images/galerias/mini/<?=$fotos['url_img'];?>?<?=rand(0,99);?>" class="photos">
										</a>
										<a class="btn btn-xs move" data-toggle="tooltip" data-placement="top" title="Mover">
											<i class="fa fa-arrows"></i>
										</a>
										<a href="<?=$adm_uri;?>cropImg/<?=$fotos['id_galerias_fotos'];?>" class="btn btn-xs" data-toggle="tooltip" data-placement="top" title="Editar">
											<i class="fa fa-pencil"></i>
										</a>
										<a href="<?=$adm_uri;?>removeImg" class="btn btn-xs removeImg" data-toggle="tooltip" data-placement="top" data-id="<?=$fotos['id_galerias_fotos'];?>" title="Excluir">
											<i class="fa fa-trash-o"></i>
										</a>
									</div>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?Php }?>
			</div>
		</div>
	</div>
</div>