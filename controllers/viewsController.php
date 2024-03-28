<?php
	require_once "./models/viewsModel.php"; 
	class viewsController extends viewsModel{
		/*----------  Get Template  ----------*/
		public function get_template(){
			require_once "./views/template.php";
		}

		/*----------  Get Views Controller  ----------*/
		public function get_views_controller(){
			if(isset($_GET['views'])){
				$route=explode("/", $_GET['views']);
				$view=$route[0];
				$response=self::get_views_model($view);
			}else{
				$response="login";
			}
			return $response;
		}
	}