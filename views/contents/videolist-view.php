<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-tv-list zmdi-hc-fw"></i> Clases <small>(Listado)</small></h1>
	</div>
	<p class="lead">
		En esta sección puede ver el listado de todas las clases impartidas en la plataforma de <strong><?php echo COMPANY; ?></strong>. Haga clic en el botón 
		<button  class="btn btn-info btn-raised btn-xs"> <i class="zmdi zmdi-tv"></i> </button> para acceder a la clase.
	</p>
</div>
<?php 
	require_once "./controllers/videoController.php";

	$insVideo = new videoController();

	$dateNow=date("Y-m-d");
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-success">
			  	<div class="panel-heading">
			    	<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> Lista de clases</h3>
			  	</div>
			  	<div class="panel-body">
					<div class="table-responsive">
						<?php
							$page=explode("/", $_GET['views']);
							echo $insVideo->pagination_video_list_controller($page[1],10);
						?>
					</div>
			  	</div>
			</div>
		</div>
	</div>
</div>