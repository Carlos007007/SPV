<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-search zmdi-hc-fw"></i> Búsqueda</h1>
	</div>
	<p class="lead">
		Bienvenido en esta sección aquí puede buscar una clase por Docente/Tutor o Título.
	</p>
</div>
<?php 
	require_once "./controllers/videoController.php";

	if(isset($_POST['search_init'])){
		$_SESSION['search']=$_POST['search_init'];
	}

	if(isset($_POST['search_destroy'])){
		unset($_SESSION['search']);
	}

	$insVideo = new videoController();
	if(!isset($_SESSION['search']) && empty($_SESSION['search'])):
?>
<div class="container-fluid">
	<form action="" method="POST" enctype="multipart/form-data" autocomplete="off" class="well">
		<div class="row">
			<div class="col-xs-12 col-md-8 col-md-offset-2">
				<div class="form-group label-floating">
				  	<span class="control-label">¿Qué estás buscando?</span>
				  	<input class="form-control" type="text" name="search_init" required="">
				</div>
			</div>
			<div class="col-xs-12">
				<p class="text-center">
			    	<button type="submit" class="btn btn-primary btn-raised btn-sm"><i class="zmdi zmdi-search"></i> &nbsp; Buscar</button>
			    </p>
			</div>
		</div>
	</form>
</div>
<?php 
	endif; 
	if(isset($_SESSION['search']) && !empty($_SESSION['search'])):
?>
<div class="container-fluid">
	<form action="" method="POST" enctype="multipart/form-data" autocomplete="off" class="well">
		<p class="lead text-center">Su última búsqueda  fue <strong>“<?php echo $_SESSION['search']; ?>”</strong></p>
		<div class="row">
			<input class="form-control" type="hidden" name="search_destroy" required="">
			<div class="col-xs-12">
				<p class="text-center">
			    	<button type="submit" class="btn btn-danger btn-raised btn-sm"><i class="zmdi zmdi-delete"></i> &nbsp; Eliminar búsqueda</button>
			    </p>
			</div>
		</div>
	</form>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-success">
			  	<div class="panel-heading">
			    	<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; Lista de clases de la búsqueda "<?php echo $_SESSION['search']; ?>"</h3>
			  	</div>
			  	<div class="panel-body">
					<div class="table-responsive">
						<?php
							$page=explode("/", $_GET['views']);
							echo $insVideo->pagination_video_search_controller($page[1],10,$_SESSION['search']);
						?>
					</div>
			  	</div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>