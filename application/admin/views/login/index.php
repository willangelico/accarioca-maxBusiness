	<div class="login-box">
		<div class="logo">
			<a href=<?=HOME_URI;?> target="_blank" class="login"><img src="<?=HOME_URI;?>public/images/logo.jpg" /></a>
		</div>
		<div class="signin-box">
			<p>Área administrativa</p>
			<?php
			if ( $this->login_error ) {
				echo '<h1>' . $this->login_error . '</h1>';
			}
			?>
			<form action="<?=HOME_URI;?>admin" method="post">
       			<div class="form-group has-feedback">
           			<input type="email" class="form-control" placeholder="E-mail" name="userdata[email]"/>
           			<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
       			</div>
       			<div class="form-group has-feedback">
           			<input type="password" class="form-control" placeholder="Senha"  name="userdata[password]"/>
           			<span class="glyphicon glyphicon-lock form-control-feedback"></span>
       			</div>
       			<div class="row">
           			<div class="col-xs-8">    
           				<div class="checkbox icheck">
               				<label>
               					<input type="checkbox" name="userdata[remember_me]"> Mantenha conectado
               				</label>
           				</div>                        
           			</div><!-- /.col -->
           			<div class="col-xs-4">
           				<button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
           			</div><!-- /.col -->
       			</div>
       		</form>
			<a href="#" data-toggle="modal" data-target="#forgetPass">Esqueci minha senha</a><br>
		</div>
	</div>
<!-- Modal -->	
	<div class="modal fade" id="forgetPass" tabindex="-1" role="dialog" aria-labelledby="Esqueci minha senha" aria-hidden="true">
		<form action="<?=HOME_URI;?>admin/login/forget" method="post">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Cancelar">
	                    	<span aria-hidden="true">&times;</span>
	                    </button>
	                    <h4 class="modal-title" id="myModalLabel">Esqueci minha senha</h4>
	                </div>
	                <div class="modal-body">
	                	<div class="form-group">
	                    	<label for="iptEmail">E-mail</label>
	                        <input type="email" name="email" class="form-control" id="iptEmail" placeholder="Insira seu e-mail" required>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	                    <button type="submit" class="btn btn-primary">Enviar minha senha</button>
	                </div>
	            </div>
	        </div>
		</form>
	</div>