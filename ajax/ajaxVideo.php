<?php
	$actionsRequired=true;
	require_once "../controllers/videoController.php";

	$insVideo = new videoController();

	if(isset($_POST['code']) && isset($_POST['title'])){
		echo $insVideo->add_video_controller();
	}

	if(isset($_POST['videoCode'])){
		echo $insVideo->delete_video_controller($_POST['videoCode']);
	}

	if(isset($_POST['upid']) && isset($_POST['upcode'])){
		echo $insVideo->update_video_controller();
	}