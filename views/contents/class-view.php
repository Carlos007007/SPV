<?php if($_SESSION['userType']=="Administrador"): ?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-tv-alt-play zmdi-hc-fw"></i> Clases <small>(Registro)</small></h1>
	</div>
	<p class="lead">
		Bienvenido a la sección de clases, aquí podrás registrar nuevas clases (Los campos marcados con * son obligatorios para registrar una nueva clase o transmisión en vivo).
	</p>
</div>
<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
	  	<li class="active">
		  	<a href="<?php echo SERVERURL; ?>class/" class="btn btn-info">
		  		<i class="zmdi zmdi-plus"></i> Nueva
		  	</a>
	  	</li>
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>classlist/" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> Lista
	  		</a>
	  	</li>
	</ul>
</div>
<?php 

	$dateNow=date("Y-m-d");
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-info">
				<div class="panel-heading">
				    <h3 class="panel-title"><i class="zmdi zmdi-plus"></i> Nueva clase</h3>
				</div>
			  	<div class="panel-body">
				    <form action="<?php echo SERVERURL; ?>ajax/ajaxVideo.php" method="POST" enctype="multipart/form-data" autocomplete="off" data-form="AddVideo" class="ajaxDataForm">
				    	<fieldset class="full-box">
				    		<legend><i class="zmdi zmdi-videocam"></i> Datos de la clase</legend>
				    		<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<span class="control-label">Título *</span>
										  	<input class="form-control" type="text" name="title" required="">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<span class="control-label">Tutor o Docente *</span>
										  	<input class="form-control" type="text" name="teacher" required="">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<span class="control-label">Fecha *</span>
										  	<input class="form-control" type="date" value="<?php echo $dateNow; ?>" name="date" required="" maxlength="30">
										</div>
				    				</div>
				    				<div class="col-xs-12">
										<div class="form-group label-floating">
										  	<label class="control-label">Código del vídeo *</label>
										  	<textarea name="code" class="form-control" rows="3" required=""></textarea>
										</div>
				    				</div>    				
				    			</div>
				    		</div>
				    	</fieldset>
				    	<fieldset class="full-box">
							<legend><i class="zmdi zmdi-comment-video"></i> Descripción e información adicional</legend>
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-12">
										  <textarea name="description" class="full-box" id="spv-editor"></textarea>
				    				</div>
								</div>
							</div>
				    	</fieldset>
				    	<fieldset class="full-box">
							<legend><i class="zmdi zmdi-attachment"></i> Archivos adjuntos</legend>
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-12">
				    					<div class="form-group">
											<input type="file" name="attachments[]" multiple="" accept=".jpg, .png, .jpeg, .pdf, .ppt, .pptx, .doc, .docx">
											<div class="input-group">
												<input type="text" readonly="" class="form-control" placeholder="Elija los archivos adjuntos...">
												<span class="input-group-btn input-group-sm">
													<button type="button" class="btn btn-fab btn-fab-mini">
														<i class="zmdi zmdi-attachment-alt"></i>
													</button>
												</span>
											</div>
											<span><small>Tamaño máximo de los archivos adjuntos 5MB. Tipos de archivos permitidos imágenes PNG y JPG, documentos PDF, WORD y POWERPOINT</small></span>
										</div>
				    				</div>
								</div>
							</div>
				    	</fieldset>
					    <p class="text-center">
					    	<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Guardar</button>
					    </p>
					    <div class="full-box form-process"></div>
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
