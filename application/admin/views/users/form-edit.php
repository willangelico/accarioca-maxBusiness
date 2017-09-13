<?php 
	if ( ! defined('ABSPATH')) exit;
	$adm_uri = HOME_URI . 'admin/users/';
	$edit_uri = $adm_uri . 'index/edit/';
	$delete_uri = $adm_uri . 'index/del/';
?>
<div class="col-md-offset-2 col-md-10 main-content">
	<section class="content-header">
		<h1>Usuários <small>Novo usuário</small></h1>
		<?php
			$breadcrumb = new breadcrumb;
			$breadcrumb->setWay(array("name"=>"Home", "icon"=>"fa fa-dashboard", "a"=>HOME_URI."admin"));
			$breadcrumb->setWay(array("name"=>"Usuários", "a"=>$adm_uri));
			$breadcrumb->setWay(array("name"=>"Novo usuário","li"=>"active"));
			$breadcrumb->getWay();
		?>		
	</section>
	<div class="container-fluid box">
		<div class="row">
			<div class="col-md-12">
				<nav class="navbar sub-header">
					<form class="navbar-form" method="post" action="<?=$adm_uri;?>search">
						<div class="pull-left">
							<h2>Cadastro de novo usuário</h2>
						</div>
						<div class="pull-right search">
							<a href="<?=$adm_uri;?>" class="btn btn-primary">Lista de usuários</a>
							<a href="<?=$edit_uri;?>" class="btn btn-primary">Novo usuário</a>
						</div>					
					</form>	
				</nav>
				<?php
					if ( isset($this->form_msg) ) {
						echo $this->form_msg;
					}
				?>			
				<form action="<?=$edit_uri;?><?=chk_array( $modelo->form_data, 'id_users')?>" method="post" enctype="multipart/form-data">
					<div class="col-xs-12 col-md-3 pull-right">
				    	<div class="form-group">
				        	<label for="status">Status</label>
				            <select name="status" class="form-control">
				            	<option value="1"<?=chk_array( $modelo->form_data, 'status')==1 ? ' selected' : '';?>>Ativa</option>                                  
				                <option value="2"<?=chk_array( $modelo->form_data, 'status')==2 ? ' selected' : '';?>>Removida</option>
							</select>
				        </div> 
				    	<input type="hidden" name="user_permissions" value="any">


				    </div>
				    <div class="col-xs-12 col-md-9">
				        <div class="form-group">
				            <label for="user_name">Nome</label>
				            <input type="text" name="user_name" class="form-control" id="user_name" placeholder="Insira o Nome" value="<?php 
								echo htmlentities( chk_array( $modelo->form_data, 'name'), ENT_QUOTES, 'UTF-8' );
							?>" required />
				        </div>
				        <div class="form-group">
				            <label for="user">E-mail</label>
				            <input type="email" name="user" class="form-control" id="user" placeholder="Insira o E-mail" value="<?php 
								echo htmlentities( chk_array( $modelo->form_data, 'email'), ENT_QUOTES, 'UTF-8' );
							?>" required />
				        </div>				         
				        <div class="form-group">
				            <label for="user_password">Senha</label>
				            <input type="password" name="user_password" class="form-control" id="user_password" placeholder="Insira a Senha" required />
				        </div>
				        <input type="hidden" name="add" value="1" />
				        <div class="btn-save"><button type="submit" class="btn btn-primary pull-right">Salvar</button></div>
				    </div>
				</form>
			</div>
		</div>
	</div>
</div>