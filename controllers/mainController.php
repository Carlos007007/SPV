<?php
	if($actionsRequired){
		require_once "../core/mainModel.php";
	}else{ 
		require_once "./core/mainModel.php";
	}

	class mainController extends mainModel{

		public function data_account_controller($code){
			$code=self::clean_string($code);
			if($data=self::data_account($code)){
				return $data;
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido seleccionar los datos de la cuenta",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}


		public function update_account_controller(){
			$code=self::clean_string($_POST['code']);
			$oldusername=self::clean_string($_POST['oldusername']);
			$username=self::clean_string($_POST['username']);
			$password1=self::clean_string($_POST['password1']);
			$password2=self::clean_string($_POST['password2']);
			$gender=self::clean_string($_POST['gender']);

			if($oldusername!=$username){
				$query1=self::execute_query("SELECT Usuario FROM cuenta WHERE Usuario='$username'");
				if($query1->rowCount()>0){
					$dataAlert=[
						"title"=>"¡Ocurrió un error inesperado!",
						"text"=>"El nombre de usuario que acaba de ingresar ya se encuentra registrado en el sistema por favor elija otro",
						"type"=>"error"
					];
					return self::sweet_alert_single($dataAlert);
					exit();
				}
			}

			if($password1!="" && $password2!=""){
				if($password1!=$password2){
					$dataAlert=[
						"title"=>"¡Ocurrió un error inesperado!",
						"text"=>"Las claves que acaba de ingresar no coinciden, por favor verifique e intente nuevamente",
						"type"=>"error"
					];
					return self::sweet_alert_single($dataAlert);
					exit();
				}else{
					$password1=self::encryption($password1);
				}
			}

			$data=[
				"Codigo"=>$code,
				"Usuario"=>$username,
				"Clave"=>$password1,
				"Genero"=>$gender
			];

			if(self::update_account($data)){
				$dataAlert=[
					"title"=>"¡Cuenta actualizada!",
					"text"=>"Los datos de la cuenta se actualizaron exitosamente",
					"type"=>"success"
				];
				unset($_POST);
				return self::sweet_alert_single($dataAlert);
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido actualizar los datos de la cuenta, por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}
	}