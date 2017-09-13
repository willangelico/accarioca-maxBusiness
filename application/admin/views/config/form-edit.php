<?php 
	if ( ! defined('ABSPATH')) exit;
	$adm_uri = HOME_URI . 'admin/config/';
?>
<div class="col-md-offset-2 col-md-10 main-content">
	<section class="content-header">
		<h1>Configurações <small>Editar configurações gerais do site</small></h1>
		<?php
			$breadcrumb = new breadcrumb;
			$breadcrumb->setWay(array("name"=>"Home", "icon"=>"fa fa-dashboard", "a"=>HOME_URI."admin"));
			$breadcrumb->setWay(array("name"=>"Configurações", "li"=>"active"));
			$breadcrumb->getWay();
		?>					
	</section>
	<div class="container-fluid box">
		<div class="row">
			<div class="col-md-12">
				<nav class="navbar sub-header">
					<form class="navbar-form" method="post" action="<?=$adm_uri;?>search">
						<div class="pull-left">
							<h2>Edição das configurações</h2>
						</div>					
					</form>	
				</nav>
				<?php
					if ( isset($modelo->form_msg) ) {
						echo $modelo->form_msg;
					}
				?>
				<form action="<?=$adm_uri;?><?=chk_array( $modelo->form_data, 'id_config')?>" method="post" enctype="multipart/form-data">
					<div class="col-xs-12 col-md-3 pull-right"> 				        
				        <div class="form-group">
				            <label for="meta_description">Descrição</label>
				            <input type="text" name="meta_description" class="form-control" id="meta_description" placeholder="Insira a descrição da página" value="<?php 
								echo htmlentities( chk_array( $modelo->form_data, 'meta_description') , ENT_QUOTES, 'UTF-8');
							?>" />
				        </div>

				        <div class="form-group">
				            <label for="email_envio">E-mail para envio do sistema</label>
				            <input type="text" name="email_envio" class="form-control" id="email_envio" placeholder="Insira o e-mail do sistema" value="<?php 
								echo htmlentities( chk_array( $modelo->form_data, 'email_envio'), ENT_QUOTES, 'UTF-8' );
							?>" />
				        </div>
				        <div class="form-group">
				            <label for="senha_envio">Senha do email do sistema</label>
				            <input type="text" name="senha_envio" class="form-control" id="senha_envio" placeholder="Insira a senha do e-mail do sistema" value="<?php 
								echo htmlentities( chk_array( $modelo->form_data, 'senha_envio') , ENT_QUOTES, 'UTF-8');
							?>" />
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
				            <label for="email_contato">E-mail de destino do formulário de contato</label>
				            <input type="text" name="email_contato" class="form-control" id="email_contato" placeholder="Insira o e-mail de contato" value="<?php 
								echo htmlentities( chk_array( $modelo->form_data, 'email_contato') , ENT_QUOTES, 'UTF-8' );
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