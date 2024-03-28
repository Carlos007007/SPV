<?php
	if($actionsRequired){
		require_once "../core/mainModel.php";
	}else{ 
		require_once "./core/mainModel.php";
	}

	class loginModel extends mainModel{

		/* Modelo para iniciar sesion - Model to log in*/
		public function login_session_start_model($data){
			$query=self::connect()->prepare("SELECT * FROM cuenta WHERE Usuario=:Usuario AND Clave=:Clave");
			$query->bindParam(":Usuario",$data['Usuario']);
			$query->bindParam(":Clave",$data['Clave']);
			$query->execute();
			return $query;
		}

		/* Modelo para destruir sesion - Model to destroy session*/
		public function login_session_destroy_model($data){
			if($data['userName']!="" && $data['userToken']==$data['token']){
				session_destroy();
				return true;
			}else{
				return false;
			}
		}
	}