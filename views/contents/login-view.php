<div class="full-box cover containerLogin">
	<form action="" method="POST" autocomplete="off" class="full-box logInForm">
		<figure class="full-box">
			<img src="<?php echo SERVERURL; ?>views/assets/img/logo.png" alt="<?php echo COMPANY; ?>" class="img-responsive" style="max-width: 100px; display: block; margin: 0 auto;">
		</figure>
		<p class="text-center text-muted text-uppercase"><?php echo COMPANY; ?></p>
		<div class="form-group label-floating">
		  <label class="control-label" for="loginUserName">Nombre de usuario</label>
		  <input class="form-control" id="loginUserName" type="text" name="loginUserName">
		  <p class="help-block">Escribe tú Usuario</p>
		</div>
		<div class="form-group label-floating">
		  <label class="control-label" for="loginUserPass">Contraseña</label>
		  <input class="form-control" id="loginUserPass" type="password" name="loginUserPass">
		  <p class="help-block">Escribe tú contraseña</p>
		</div>
		<div class="form-group text-center">
			<input type="submit" value="Iniciar sesión" class="btn btn-raised btn-info">
		</div>
	</form>
</div>
<?php 
	if(isset($_POST['loginUserName'])){
		require_once "./controllers/loginController.php";
		$log = new loginController();
		echo $log->login_session_start_controller();
	}
?>