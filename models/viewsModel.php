<?php 
	class viewsModel{
		public function get_views_model($views){
			if(
				$views=="home" ||
				$views=="dashboard" ||
				$views=="admin" ||
				$views=="adminlist" ||
				$views=="admininfo" ||
				$views=="account" ||
				$views=="student" ||
				$views=="studentlist" ||
				$views=="studentinfo" ||
				$views=="class" ||
				$views=="classlist" ||
				$views=="classinfo" ||
				$views=="classview" ||
				$views=="videonow" ||
				$views=="videolist" ||
				$views=="search"
			){
				if(is_file("./views/contents/".$views."-view.php")){
					$contents="./views/contents/".$views."-view.php";
				}else{
					$contents="login";
				}
			}elseif($views=="index"){
				$contents="login";
			}elseif($views=="login"){
				$contents="login";
			}else{
				$contents="login";
			}
			return $contents;
		}
	}