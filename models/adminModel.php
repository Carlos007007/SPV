<?php
	if($actionsRequired){
		require_once "../core/mainModel.php";
	}else{ 
		require_once "./core/mainModel.php";
	}

	class adminModel extends mainModel{

		/*----------  Add Admin Model  ----------*/
		public function add_admin_model($data){
			$query=self::connect()->prepare("INSERT INTO admin(Codigo,Nombres,Apellidos) VALUES(:Codigo,:Nombres,:Apellidos)");
			$query->bindParam(":Codigo",$data['Codigo']);
			$query->bindParam(":Nombres",$data['Nombres']);
			$query->bindParam(":Apellidos",$data['Apellidos']);
			$query->execute();
			return $query;
		}


		/*----------  Data Admin Model  ----------*/
		public function data_admin_model($data){
			if($data['Tipo']=="Count"){
				$query=self::connect()->prepare("SELECT Codigo FROM admin");
			}elseif($data['Tipo']=="Only"){
				$query=self::connect()->prepare("SELECT * FROM admin WHERE Codigo=:Codigo");
				$query->bindParam(":Codigo",$data['Codigo']);
			}
			$query->execute();
			return $query;
		}


		/*----------  Delete Admin Model  ----------*/
		public function delete_admin_model($code){
			$query=self::connect()->prepare("DELETE FROM admin WHERE Codigo=:Codigo");
			$query->bindParam(":Codigo",$code);
			$query->execute();
			return $query;
		}


		/*----------  Update Admin Model  ----------*/
		public function update_admin_model($data){
			$query=self::connect()->prepare("UPDATE admin SET Nombres=:Nombres,Apellidos=:Apellidos WHERE Codigo=:Codigo");
			$query->bindParam(":Nombres",$data['Nombres']);
			$query->bindParam(":Apellidos",$data['Apellidos']);
			$query->bindParam(":Codigo",$data['Codigo']);
			$query->execute();
			return $query;
		}
	}