	
<?php if ( ! defined('ABSPATH')) exit; ?>



<?php
	// Carrega todos os métodos do modelo
	$modelo->check_dt_hash( base64_decode( chk_array( $parametros, 0 ) ) ,   chk_array( $parametros, 1 ) );
	$modelo->redefine_password();
	$modelo->get_register_form( base64_decode( chk_array( $parametros, 0 ) ) );
?>



	<div class="login-box">
		<div class="logo">
			<a href=<?=HOME_URI;?> target="_blank" class="login"><img src="<?=HOME_URI;?>public/images/logo.png" /></a>
		</div>
		<div class="signin-box">
			<p>Redefinir senha</p>
			<?php
			if ( $modelo->form_msg ) {
				echo $modelo->form_msg;
			}else{
				?>
				<form action="" method="post">
	       			<div class="form-group has-feedback">
	           			<input type="email" class="form-control" placeholder="E-mail" name="_email" disabled value="<?php 
							echo htmlentities( chk_array( $modelo->form_data, 'email'), ENT_QUOTES, 'UTF-8' );
							?>" />
						<input type="hidden" name="email" value="<?php 
							echo htmlentities( chk_array( $modelo->form_data, 'email') , ENT_QUOTES, 'UTF-8');
							?>" />
	           			<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
	       			</div>
	       			<div class="form-group has-feedback">
	           			<input type="password" class="form-control" placeholder="Nova senha"  name="password" />
	           			<span class="glyphicon glyphicon-lock form-control-feedback"></span>
	       			</div>
	       			<div class="form-group has-feedback">
	           			<input type="password" class="form-control" placeholder="Repetição de nova senha"  name="re_password"/>
	           			<span class="glyphicon glyphicon-lock form-control-feedback"></span>
	       			</div>
	       			<div class="row">           			
	           			<div class="col-xs-5">
	           				<button type="submit" class="btn btn-primary btn-block btn-flat">Redefinir senha</button>
	           			</div><!-- /.col -->
	       			</div>
	       		</form>
	       	<?php }?>
	       	<a href="<?=HOME_URI;?>admin">Voltar para página de acesso</a><br>
		</div>
	</div>