<?php 
	require_once "./core/configGeneral.php";
	require_once "./controllers/viewsController.php";

	$ViewTemplate=new viewsController();
	$ViewTemplate->get_template();