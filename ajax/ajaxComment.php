<?php
	$actionsRequired=true;
	require_once "../controllers/commentController.php";

	$insComment = new commentController();

	$dateNow=date("Y-m-d");

	if(isset($_POST['comment']) && isset($_POST['codeUser'])){
		echo $insComment->add_comment_controller();
	}