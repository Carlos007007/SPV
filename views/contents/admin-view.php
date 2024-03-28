<?php if($_SESSION['userType']=="Administrador"): ?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-account zmdi-hc-fw"></i> Usuarios <small>(Administradores)</small></h1>
	</div>
	<p class="lead">
		Bienvenido a la sección de usuarios administradores, aquí podrás registrar nuevos administradores (Los campos marcados con * son obligatorios para registrar un administrador).
	</p>
</div>
<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
	  	<li class="active">
	  	<a href="<?php echo SERVERURL; ?>admin/" class="btn btn-info">
	  		<i class="zmdi zmdi-plus"></i> Nuevo
	  	</a>
	  	</li>
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>adminlist/" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> Lista
	  		</a>
	  	</li>
	</ul>
</div>
<?php 
	require_once "./controllers/adminController.php";

	$insAdmin = new adminController();

	if(isset($_POST['name']) && isset($_POST['username'])){
		echo $insAdmin->add_admin_controller();
	}
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-info">
				<div class="panel-heading">
				    <h3 class="panel-title"><i class="zmdi zmdi-plus"></i> Nuevo Administrador</h3>
				</div>
			  	<div class="panel-body">
				    <form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
				    	<fieldset>
				    		<legend><i class="zmdi zmdi-account-box"></i> Datos personales</legend><br>
				    		<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<label class="control-label">Nombres *</label>
										  	<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="name" value="<?php if(isset($_POST['name'])){ echo $_POST['name']; } ?>" required="" maxlength="30">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Apellidos *</label>
										  	<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="lastname" value="<?php if(isset($_POST['lastname'])){ echo $_POST['lastname']; } ?>" required="" maxlength="30">
										</div>
				    				</div>
				    			</div>
				    		</div>
				    	</fieldset>
				    	<br><br>
				    	<fieldset>
				    		<legend><i class="zmdi zmdi-key"></i> Datos de la cuenta</legend><br>
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-12 col-sm-6">
							    		<div class="form-group label-floating">
										  	<label class="control-label">Nombre de usuario *</label>
										  	<input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ]{1,15}" class="form-control" type="text" name="username" value="<?php if(isset($_POST['username'])){ echo $_POST['username']; } ?>" required="" maxlength="15">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Genero</label>
										  	<select name="gender" class="form-control">
										  		<?php 
										  			if(isset($_POST['gender'])){ 
										  				echo '<option value="'.$_POST['gender'].'">'.$_POST['gender'].' Actual</option>'; 
										  			} 
										  		?>
									          	<option value="Masculino">Masculino</option>
									          	<option value="Femenino">Femenino</option>
									        </select>
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Contraseña *</label>
										  	<input class="form-control" type="password" name="password1" value="<?php if(isset($_POST['password1'])){ echo $_POST['password1']; } ?>" required="" maxlength="70">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Repita la contraseña *</label>
										  	<input class="form-control" type="password" name="password2" value="<?php if(isset($_POST['password2'])){ echo $_POST['password2']; } ?>" required="" maxlength="70">
										</div>
				    				</div>
								</div>
							</div>
				    	</fieldset>
					    <p class="text-center">
					    	<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Guardar</button>
					    </p>
				    </form>
			  	</div>
			</div>
		</div>
	</div>
</div>
<?php 
	else:
		$logout2 = new loginController();
        echo $logout2->login_session_force_destroy_controller(); 
	endif;
?>
