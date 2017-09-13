<?php 
	if ( ! defined('ABSPATH')) exit;
	$adm_uri = HOME_URI . 'admin/pages/';
	$edit_uri = $adm_uri . 'edit/';
	$delete_uri = $adm_uri . 'del/';
?>
<div class="col-md-offset-2 col-md-10 main-content">
	<section class="content-header">
		<h1>Páginas <small>Lista de páginas</small></h1>
		<?php
			$breadcrumb = new breadcrumb;
			$breadcrumb->setWay(array("name"=>"Home", "icon"=>"fa fa-dashboard", "a"=>HOME_URI."admin"));
			$breadcrumb->setWay(array("name"=>"Páginas", "li"=>"active"));
			$breadcrumb->getWay();
		?>			
	</section>
	<div class="container-fluid box">
		<div class="row">
			<div class="col-md-12">
				<nav class="navbar sub-header">
					<form class="navbar-form" method="post" action="<?=$adm_uri;?>search">
						<div class="pull-left">
							<h2>Lista de páginas</h2>
						</div>
						<div class="pull-right search">
							<?php require ABSPATH . APPLICATION .'/admin/views/helpers/search.php';?>
							<a href="<?=$adm_uri;?>add" class="btn btn-primary">Nova página</a>
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
	                                <tr id="list<?=$pg['id_pages'];?>" class="list">
	                                    <td class="col-sm-1 text-center">
											<a href="<?php echo $adm_uri . 'status/'?>" class="btn btn-xs changestatus" data-id="<?=$pg['id_pages'];?>">	                                    	
	                                    		<i class="fa fa-power-off <?=($pg['status']==1) ? 'on' : 'off';?>"></i>
	                                    	</a>
	                                    </td>
	                                    <td><?=$pg['title'];?> <small class="text-muted">(<?=(!empty($pg['title_mae'])) ? $pg['title_mae'].' / ' : '';?><?=$pg['title'];?>)</small></td>
	                                    <td>
		                    	            <a href="<?php echo $edit_uri . $pg['id_pages']?>" class="btn btn-primary btn-xs">Editar</a>
	                                        <a href="<?php echo $delete_uri . $pg['id_pages']?>" class="btn btn-primary btn-xs rem">Remover</a>
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