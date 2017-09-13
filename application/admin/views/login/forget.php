	
<?php if ( ! defined('ABSPATH')) exit; ?>



<?php
	// Carrega todos os métodos do modelo
	$modelo->recover_password();
?>


	
	<div class="login-box">
		<div class="logo">
			<a href=<?=HOME_URI;?> target="_blank" class="login"><img src="<?=HOME_URI;?>public/images/logo.png" /></a>
		</div>
		<div class="signin-box">
			<p>Área administrativa</p>
			<?php
			if ( $modelo->form_msg ) {
				echo '<h1>' . $modelo->form_msg . '</h1>';
			}
			?>
			
			<a href="<?=HOME_URI;?>admin">Voltar para página de acesso</a><br>
		</div>
	</div>