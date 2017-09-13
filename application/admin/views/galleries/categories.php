<?php 
	if ( ! defined('ABSPATH')) exit;
	$adm_uri = HOME_URI . 'admin/galleries/categories/';
	$edit_uri = HOME_URI . 'admin/galleries/categoriesedit/';
	$del_uri = HOME_URI . 'admin/galleries/categoriesdel/';
?>
<div class="col-md-offset-2 col-md-10 main-content">
	<section class="content-header">
		<h1>Categorias <small>Lista de categorias de galerias</small></h1>
		<?php
			$breadcrumb = new breadcrumb;
			$breadcrumb->setWay(array("name"=>"Home", "icon"=>"fa fa-dashboard", "a"=>HOME_URI."admin"));
			$breadcrumb->setWay(array("name"=>"Galerias", "a"=>HOME_URI."admin/galleries","icon"=>"fa fa-file-image-o"));
			$breadcrumb->setWay(array("name"=>"Categorias", "li"=>"active"));
			$breadcrumb->getWay();
		?>
	</section>
	<div class="container-fluid box">
		<div class="row">
			<div class="col-md-12">
				<nav class="navbar sub-header">
					<form class="navbar-form" method="post" action="<?=$adm_uri;?>search">
						<div class="pull-left">
							<h2>Lista de categorias</h2>
						</div>
						<div class="pull-right search">
							<?php require ABSPATH . APPLICATION .'/admin/views/helpers/search.php';?>
							<a href="<?=HOME_URI;?>admin/galleries/" class="btn btn-primary">Galerias</a>
							<a href="<?=HOME_URI;?>admin/galleries/categoriesadd/" class="btn btn-primary">Nova categoria</a>
						</div>					
					</form>	
				</nav>
				<?php 
					echo $modelo->form_confirma;
					if ( isset($modelo->form_msg) ) {
						echo $modelo->form_msg;
					}
				?>
				<div class="table-responsive">
                    <form action="" method="post" id="form-list">
                        <table id="table-list" class="table table-striped table-hover">
                            <thead>
                    	        <tr>
                                    <th class="col-sm-1 text-center"></th>
                                    <th>Título</th>
                                    <th class="col-sm-2">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php foreach( $lista as $pg ):?>
	                                <tr id="list<?=$pg['id_galerias_categorias'];?>" class="list">
	                                    <td class="col-sm-1 text-center">
											<a href="<?=HOME_URI;?>admin/galleries/categoriesstts/" class="btn btn-xs changestatus" data-id="<?=$pg['id_galerias_categorias'];?>">	                                    	
	                                    		<i class="fa fa-power-off <?=($pg['status']==1) ? 'on' : 'off';?>"></i>
	                                    	</a>
	                                    </td>
	                                    <td class="text-muted"><?=$pg['titulo'];?></td>
	                                    <td>
		                    	            <a href="<?php echo $edit_uri . $pg['id_galerias_categorias']?>" class="btn btn-primary btn-xs">Editar</a>
	                                        <a href="<?php echo $del_uri . $pg['id_galerias_categorias']?>" class="btn btn-primary btn-xs rem">Remover</a>
	                                    </td>
	                                </tr>
	                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="col-sm-1 text-center"></th>
                             	    <th>Título</th>
                                    <th>Opções</th>
                                </tr>
                            </tfoot>                            
                        </table>
					</form>                                
                </div>
                <nav>
					<ul class="pagination pagination-sm">
						<?=$modelo->paginacao();;?>					
					</ul>
				</nav>
			</div>
		</div>
	</div>
</div>