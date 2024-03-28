<?php if($_SESSION['userType']=="Administrador"): ?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-settings zmdi-hc-fw"></i> Cuenta</h1>
	</div>
	<p class="lead">
		Bienvenido a la sección de actualización de los datos de las cuentas. Si desea actualizar la clave ingrese la clave nueva y repetirla, si no desea actualizarla deje en blanco los campos de las nuevas claves
	</p>
</div>
<?php 
	require_once "./controllers/mainController.php";

	$insMain = new mainController();

	if(isset($_POST['username']) && isset($_POST['code'])){
		echo $insMain->update_account_controller();
	}

	$code=explode("/", $_GET['views']);

	$data=$insMain->data_account_controller($code[1]);
	if($data->rowCount()>0):
		$rows=$data->fetch();
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-success">
				<div class="panel-heading">
				    <h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> Actualizar cuenta</h3>
				</div>
			  	<div class="panel-body">
				    <form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
				    	<fieldset>
				    		<legend><i class="zmdi zmdi-key"></i> Datos de la cuenta</legend><br>
				    		<input type="hidden" name="code" value="<?php echo $rows['Codigo']; ?>">
				    		<input type="hidden" name="oldusername" value="<?php echo $rows['Usuario']; ?>">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-12 col-sm-6">
							    		<div class="form-group label-floating">
										  	<label class="control-label">Nombre de usuario *</label>
										  	<input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ]{1,15}" class="form-control" type="text" name="username" value="<?php echo $rows['Usuario']; ?>" required="" maxlength="15">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Genero</label>
										  	<select name="gender" class="form-control">
										  		<option value="<?php echo $rows['Genero']; ?>"><?php echo $rows['Genero']; ?> (Actual)</option>
									          	<option value="Masculino">Masculino</option> 
									          	<option value="Femenino">Femenino</option>
									        </select>
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Nueva Contraseña *</label>
										  	<input class="form-control" type="password" name="password1" value="<?php if(isset($_POST['password1'])){ echo $_POST['password1']; } ?>"  maxlength="70">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Repita la nueva contraseña *</label>
										  	<input class="form-control" type="password" name="password2" value="<?php if(isset($_POST['password2'])){ echo $_POST['password2']; } ?>"  maxlength="70">
										</div>
				    				</div>
								</div>
							</div>
				    	</fieldset>
					    <p class="text-center">
					    	<button type="submit" class="btn btn-success btn-raised btn-sm"><i class="zmdi zmdi-refresh"></i> Guardar cambios</button>
					    </p>
				    </form>
			  	</div>
			</div>
		</div>
	</div>
</div>
<?php else: ?>
	<p class="lead text-center">Lo sentimos ocurrió un error inesperado</p>
<?php
		endif;
	else:
		$logout2 = new loginController();
        echo $logout2->login_session_force_destroy_controller(); 
	endif;
?>