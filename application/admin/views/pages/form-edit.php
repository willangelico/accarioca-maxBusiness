<?php 
	if ( ! defined('ABSPATH')) exit;
	$adm_uri = HOME_URI . 'admin/pages/';
	$edit_uri = $adm_uri . 'edit/';
	$delete_uri = $adm_uri . 'del/';
?>
<div class="col-md-offset-2 col-md-10 main-content">
	<section class="content-header">
		<h1>Sobre mim <small>estefan Bombonato</small></h1>
		<?php
			$breadcrumb = new breadcrumb;
			$breadcrumb->setWay(array("name"=>"Home", "icon"=>"fa fa-dashboard", "a"=>HOME_URI."admin"));
			$breadcrumb->setWay(array("name"=>"Páginas", "a"=>$adm_uri));
			$breadcrumb->setWay(array("name"=>"Nova página","li"=>"active"));
			$breadcrumb->getWay();
		?>		
	</section>
	<div class="container-fluid box">
		<div class="row">
			<div class="col-md-12">
				<nav class="navbar sub-header">
					<form class="navbar-form" method="post" action="<?=$adm_uri;?>search">
						<div class="pull-left">
							<h2>Editando página</h2>
						</div>					
					</form>	
				</nav>
				<?php
					if ( isset($this->form_msg) ) {
						echo $this->form_msg;
					}
				?>			
				<form action="<?=$edit_uri;?><?=chk_array( $modelo->form_data, 'id_pages')?>" method="post" enctype="multipart/form-data">
					<div class="col-xs-12 col-md-3 pull-right">
				    	<div class="form-group">
				        	<label for="status">Status</label>
				            <select name="status" class="form-control">
				            	<option value="1"<?=chk_array( $modelo->form_data, 'status')==1 ? ' selected' : '';?>>Ativa</option>                                  
				                <option value="2"<?=chk_array( $modelo->form_data, 'status')==2 ? ' selected' : '';?>>Removida</option>
							</select>
				        </div> 
					    <div class="form-group">
					    	<label for="url_img">Imagem de destaque</label>
					    	<input type="file" class="filestyle" placeholder="Insira uma imagem" name="url_img" id="url_img" data-buttonText="Localizar arquivo">
					    	<?php if(chk_array($modelo->form_data,'url_img')){?>
					    		<div id="img<?=chk_array( $modelo->form_data, 'id_pages')?>">
						    		<img src="<?=HOME_URI;?>public/files/images/pages/<?=chk_array($modelo->form_data,'url_img')?>" style="width: 100%;" />		
							    	<a href="<?=$adm_uri ;?>removeImg" data-id="<?=chk_array( $modelo->form_data, 'id_pages')?>" class="removeImg pull-right">Remover imagem</a>			
							   	</div>
					    	<?php }?>    	
					    </div>
				    </div>
				    <div class="col-xs-12 col-md-9">
				        <div class="form-group">
				            <label for="title">Título</label>
				            <input type="text" name="title" class="form-control" id="title" placeholder="Insira o Titulo" value="<?php 
								echo htmlentities( chk_array( $modelo->form_data, 'title') , ENT_QUOTES, 'UTF-8');
							?>" />
				        </div> 
				        <div class="form-group">
				            <label for="caption">Título</label>
				            <input type="text" name="caption" class="form-control" id="caption" placeholder="Insira um subtítulo" value="<?php 
								echo htmlentities( chk_array( $modelo->form_data, 'caption'), ENT_QUOTES, 'UTF-8' );
							?>" />
				        </div> 
				        <div class="form-group">
				            <label for="content">Conteúdo</label>
							<script type="text/javascript" src="<?=HOME_URI;?>library/plugins/ckeditor/ckeditor.js"></script>			
							<textarea name="content" id="content" class="form-control" rows="3"><?php 
								echo htmlentities( chk_array( $modelo->form_data, 'content'), ENT_QUOTES, 'UTF-8' );
							?></textarea>
							<script type="text/javascript">
				            //<![CDATA[
				                CKEDITOR.replace( 'content',
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
			</div>
		</div>
	</div>
</div>