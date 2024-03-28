<?php
	if($actionsRequired){
		require_once "../core/mainModel.php";
	}else{ 
		require_once "./core/mainModel.php";
	}

	class commentModel extends mainModel{

		/*----------  Add Comment Model  ----------*/
		public function add_comment_model($data){
			$query=self::connect()->prepare("INSERT INTO comentarios(id,Comentario,Adjunto,Tipo,Codigo,Fecha) VALUES(:id,:Comentario,:Adjunto,:Tipo,:Codigo,:Fecha)");
			$query->bindParam(":id",$data['id']);
			$query->bindParam(":Comentario",$data['Comentario']);
			$query->bindParam(":Adjunto",$data['Adjunto']);
			$query->bindParam(":Tipo",$data['Tipo']);
			$query->bindParam(":Codigo",$data['Codigo']);
			$query->bindParam(":Fecha",$data['Fecha']);
			$query->execute();
			return $query;
		}


		/*----------  Delete Comment Model  ----------*/
		public function delete_comment_model($code){
			$query=self::connect()->prepare("DELETE FROM comentarios WHERE idc=:idc");
			$query->bindParam(":idc",$code);
			$query->execute();
			return $query;
		}

	}