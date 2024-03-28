<?php
	if($actionsRequired){
		require_once "../core/mainModel.php";
	}else{ 
		require_once "./core/mainModel.php";
	}

	class videoModel extends mainModel{

		/*----------  Add Video Model  ----------*/
		public function add_video_model($data){
			$query=self::connect()->prepare("INSERT INTO clase(Video,Fecha,Titulo,Tutor,Descripcion,Adjuntos) VALUES(:Video,:Fecha,:Titulo,:Tutor,:Descripcion,:Adjuntos)");
			$query->bindParam(":Video",$data['Video']);
			$query->bindParam(":Fecha",$data['Fecha']);
			$query->bindParam(":Titulo",$data['Titulo']);
			$query->bindParam(":Tutor",$data['Tutor']);
			$query->bindParam(":Descripcion",$data['Descripcion']);
			$query->bindParam(":Adjuntos",$data['Adjuntos']);
			$query->execute();
			return $query;
		}


		/*----------  Data Video Model  ----------*/
		public function data_video_model($data){
			if($data['Tipo']=="Count"){
				$query=self::connect()->prepare("SELECT id FROM clase");
			}elseif($data['Tipo']=="Only"){
				$query=self::connect()->prepare("SELECT * FROM clase WHERE id=:id");
				$query->bindParam(":id",$data['id']);
			}
			$query->execute();
			return $query;
		}


		/*----------  Delete Video Model  ----------*/
		public function delete_video_model($code){
			$query=self::connect()->prepare("DELETE FROM clase WHERE id=:id");
			$query->bindParam(":id",$code);
			$query->execute();
			return $query;
		}


		/*----------  Update Video Model  ----------*/
		public function update_video_model($data){
			$query=self::connect()->prepare("UPDATE clase SET Video=:Video,Fecha=:Fecha,Titulo=:Titulo,Tutor=:Tutor,Descripcion=:Descripcion,Adjuntos=:Adjuntos WHERE id=:id");
			$query->bindParam(":Video",$data['Video']);
			$query->bindParam(":Fecha",$data['Fecha']);
			$query->bindParam(":Titulo",$data['Titulo']);
			$query->bindParam(":Tutor",$data['Tutor']);
			$query->bindParam(":Descripcion",$data['Descripcion']);
			$query->bindParam(":Adjuntos",$data['Adjuntos']);
			$query->bindParam(":id",$data['id']);
			$query->execute();
			return $query;
		}
	}