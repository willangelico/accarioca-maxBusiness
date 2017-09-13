<?php 
	if ( ! defined('ABSPATH')) exit;
	$adm_uri = HOME_URI . 'admin/banners/';
	$edit_uri = $adm_uri . 'edit/';
	$delete_uri = $adm_uri . 'del/';
?>
<div class="col-md-offset-2 col-md-10 main-content">
	<section class="content-header">
		<h1>Banners <small>Lista de banners</small></h1>
		<?php
			$breadcrumb = new breadcrumb;
			$breadcrumb->setWay(array("name"=>"Home", "icon"=>"fa fa-dashboard", "a"=>HOME_URI."admin"));
			$breadcrumb->setWay(array("name"=>"Banners", "li"=>"active"));
			$breadcrumb->getWay();
		?>			
	</section>
	<div class="container-fluid box">
		<div class="row">
			<div class="col-md-12">
				<nav class="navbar sub-header">
					<form class="navbar-form" method="post" action="<?=$adm_uri;?>search">
						<div class="pull-left">
							<h2>Lista de banners</h2>
						</div>
						<div class="pull-right search">							
							<?php require ABSPATH . APPLICATION .'/admin/views/helpers/search.php';?>
							<a href="<?=$adm_uri;?>add" class="btn btn-primary">Novo banner</a>
						</div>					
					</form>	
				</nav>
				<?php 
					echo $modelo->form_confirma;
					if ( isset($this->form_msg) ) {
						echo $this->form_msg;
					}
				?>
				<div class="table-responsive">
                    <form action="" method="post" id="form-list">
                        <table id="table-list" class="table table-striped table-hover">
                            <thead>
                    	        <tr>
                                    <th class="col-sm-1 text-center"></th>
                                    <th>Título</th>
                                    <th>Imagem</th>
                                    <th>Destino</th>
                                    <th class="col-sm-2">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php foreach( $lista as $pg ):?>
	                                <tr id="list<?=$pg['id_banners'];?>" class="list">
	                                    <td class="col-sm-1 text-center">
	                                    	<a href="<?php echo $adm_uri . 'status/'?>" class="btn btn-xs changestatus" data-id="<?=$pg['id_banners'];?>">
	                                    		<i class="fa fa-power-off <?=($pg['status']==1) ? 'on' : 'off';?>"></i>
	                                    	</a>
	                                    </td>
	                                    <td class="text-muted"><?=$pg['titulo'];?><br /><small><?=$pg['legenda'];?></small></td>
	                                    <td style="display:block; width: 300px; height: 115px; overflow: hidden;">
	                                    	<img src="<?=HOME_URI;?>public/files/images/banners/mini/<?=$pg['url_img']?>?<?=rand(0,99);?>" style="max-width: 300px;" />
	                                    </td>
	                                    <td><?=$pg['url'];?></td>
	                                    <td>
		                    	            <a href="<?php echo $edit_uri . $pg['id_banners']?>" class="btn btn-primary btn-xs">Editar</a>
	                                        <a href="<?php echo $delete_uri . $pg['id_banners']?>" class="btn btn-primary btn-xs rem">Remover</a>
	                                    </td>
	                                </tr>
	                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="col-sm-1 text-center"></th>
                                    <th>Título</th>
                                    <th>Imagem</th>
                                    <th>Destino</th>
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