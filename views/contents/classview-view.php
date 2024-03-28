<?php 
	require_once "./controllers/videoController.php";
	require_once "./controllers/commentController.php";

	$insVideo = new videoController();
	$insComment = new commentController();

	$dateNow=date("Y-m-d");
	$urls=SERVERURL.$_GET['views'];

	if(isset($_POST['commentCode'])){
		echo $insComment->delete_comment_controller($_POST['commentCode'],$_SESSION['userKey'],$urls);
	}

	$code=explode("/", $_GET['views']);

	$data=$insVideo->data_video_controller("Only",$code[1]);
	if($data->rowCount()>0):
		$rows=$data->fetch();
?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-videocam zmdi-hc-fw"></i> <small><?php echo $rows['Titulo']; ?></small></h1>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<p class="text-mutted"><i class="zmdi zmdi-star-circle"></i> TÍTULO O TEMA: <strong><?php echo $rows['Titulo']; ?></strong></p>
			<p class="text-mutted"><i class="zmdi zmdi-face"></i> TUTOR O DOCENTE: <strong><?php echo $rows['Tutor']; ?></strong></p>
			<p class="text-mutted"><i class="zmdi zmdi-time-restore"></i> FECHA DE PUBLICACIÓN: <strong><?php echo date("d/m/Y", strtotime($rows['Fecha'])); ?></strong></p>
			<div class="full-box text-center videoWrapper">
				<?php echo $rows['Video']; ?>
			</div>
			<div class="full-box thumbnail" style="padding: 10px;">
				<h3 class="text-titles text-center"><i class="zmdi zmdi-info"></i> Información de la clase</h3>
				<?php 
					echo $rows['Descripcion'];
					if($rows['Adjuntos']!=""):
				?>
				<br>
				<h4 class="text-titles text-center"><i class="zmdi zmdi-cloud-download"></i> Archivos para descargar</h4>
				<table class="table">
					<thead>
						<tr>
							<th>Archivo</th>
							<th>Descargar</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$attachment=explode(",", $rows['Adjuntos']);
							foreach ($attachment as $files):
								echo '
								<tr>
									<td>'.$files.'</td>
									<td>
										<a href="'.SERVERURL.'attachments/class/'.$files.'" download="'.$files.'" class="btn btn-primary"><i class="zmdi zmdi-download"></i></a>
									</td>
								</tr>
								';
							endforeach;
						?>
					</tbody>
				</table>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<br>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<form action="<?php echo SERVERURL; ?>ajax/ajaxComment.php" class="ajaxDataForm well" data-form="AddComent" method="POST" enctype="multipart/form-data" autocomplete="off" style="margin-bottom: 50px;">
				<h3 class="text-titles text-center"><i class="zmdi zmdi-comment-edit"></i> Agregar un comentario a la clase</h3>
				<input type="hidden" name="codeClass" value="<?php echo $rows['id']; ?>">
				<input type="hidden" name="codeUser" value="<?php echo $_SESSION['userKey']; ?>">
				<input type="hidden" name="typeUSer" value="<?php echo $_SESSION['userType']; ?>">
				<div class="form-group">
					<span>Comentario</span>
					<textarea class="form-control" name="comment" rows="3" id="textArea" required=""></textarea>
					<span class="help-block">Escriba su comentario acerca de la clase.</span>
				</div>
				<div class="form-group">
					<input type="file" name="attachment" accept=".jpg, .png, .jpeg, .pdf, .ppt, .pptx, .doc, .docx">
					<div class="input-group">
						<input type="text" readonly="" class="form-control" placeholder="Elija un archivo adjunto...">
						<span class="input-group-btn input-group-sm">
							<button type="button" class="btn btn-fab btn-fab-mini">
								<i class="zmdi zmdi-attachment-alt"></i>
							</button>
						</span>
					</div>
					<span><small>Tamaño máximo de los archivos adjuntos 5MB. Tipos de archivos permitidos imágenes PNG y JPG, documentos PDF, WORD y POWERPOINT</small></span>
				</div>
				<p class="text-center">
					<button class="btn btn-primary btn-raised" type="submit">Agregar comentario</button>
				</p>
				<div class="full-box form-process"></div>
			</form>
		</div>
		<div class="col-xs-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="zmdi zmdi-comments"></i> &nbsp; Comentarios de la clase</h3>
				</div>
				<div class="panel-body">
					<div class="list-group">
						<?php
							$page=explode("/", $_GET['views']);
							echo $insComment->pagination_comment_controller($code[1],$page[2],10,$rows['id']);
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php else: ?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-videocam zmdi-hc-fw"></i> Clase</h1>
	</div>
</div>
<p class="lead text-center">Lo sentimos ocurrió un error inesperado</p>
<?php endif; ?>