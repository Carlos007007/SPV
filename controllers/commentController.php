<?php
	if($actionsRequired){
		require_once "../models/commentModel.php";
	}else{ 
		require_once "./models/commentModel.php";
	}

	class commentController extends commentModel{

		/*----------  Add Comment Controller  ----------*/
		public function add_comment_controller(){
			$codeClass=self::clean_string($_POST['codeClass']);
			$codeUser=self::clean_string($_POST['codeUser']);
			$typeUSer=self::clean_string($_POST['typeUSer']);
			$comment=self::clean_string($_POST['comment']);

			$AttMaxSize=5120;
			$AttDir="../attachments/comments/";
			$AttName=self::clean_string($_FILES['attachment']['name']);
			$AttType=self::clean_string($_FILES['attachment']['type']);
			$AttSize=self::clean_string($_FILES['attachment']['size']);

			if($AttName!=""){
				if($AttType=="image/jpeg" || $AttType=="image/png" || $AttType=="application/msword" || $AttType=="application/vnd.ms-powerpoint" || $AttType=="application/pdf" || $AttType=="application/vnd.openxmlformats-officedocument.wordprocessingml.document" || $AttType=="application/vnd.openxmlformats-officedocument.presentationml.presentation"){
					if(($AttSize/1024)<=$AttMaxSize){
						$AttFinalName=$AttName;
						if(is_file($AttDir.$AttName)){
							$dataAlert=[
								"title"=>"¡Ocurrió un error inesperado!",
								"text"=>"Ya existe un archivo con el nombre <b>".$AttName."</b> registrado en el sistema por favor cambie el nombre del archivo adjunto antes de subirlo",
								"type"=>"error"
							];
							return self::sweet_alert_single($dataAlert);
							exit();
						}else{
							chmod($AttDir, 0777);

							if(!move_uploaded_file($_FILES['attachment']['tmp_name'], $AttDir.$AttFinalName)){
								$dataAlert=[
									"title"=>"¡Ocurrió un error inesperado!",
									"text"=>"No se pudo cargar el archivo adjunto",
									"type"=>"error"
								];
								return self::sweet_alert_single($dataAlert);
								exit();
							}
						}

					}else{
						$dataAlert=[
							"title"=>"¡Ocurrió un error inesperado!",
							"text"=>"El tamaño del archivo supera el límite de peso máximo que son 5MB",
							"type"=>"error"
						];
						return self::sweet_alert_single($dataAlert);
						exit();
					}
				}else{
					$dataAlert=[
						"title"=>"¡Ocurrió un error inesperado!",
						"text"=>"El tipo de formato del archivo que acaba de seleccionar no esta permitido",
						"type"=>"error"
					];
					return self::sweet_alert_single($dataAlert);
					exit();
				}
			}else{
				$AttFinalName="";
			}

			$dateNowC = date("Y-m-d H:i:s");

			$data=[
				"id"=>$codeClass,
				"Comentario"=>$comment,
				"Adjunto"=>$AttFinalName,
				"Tipo"=>$typeUSer,
				"Codigo"=>$codeUser,
				"Fecha"=>$dateNowC
			];

			if(self::add_comment_model($data)){
				$dataAlert=[
					"title"=>"¡Comentario agregado!",
					"text"=>"El comentario se agregó con éxito a la clase",
					"type"=>"success"
				];
				unset($_POST);
				return self::sweet_alert($dataAlert);
			}else{
				if($AttFinalName!=""){
					chmod($AttDir.$AttFinalName, 0777);
					unlink($AttDir.$AttFinalName);	
				}
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No se pudo agregar el comentario, por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}


		/*----------  Pagination Comment Controller  ----------*/
		public function pagination_comment_controller($codeC,$Pagina,$Registros,$id){
			$Pagina=self::clean_string($Pagina);
			$Registros=self::clean_string($Registros);
			$id=self::clean_string($id);

			$Pagina = (isset($Pagina) && $Pagina>0) ? floor($Pagina) : 1;

			$Inicio = ($Pagina>0) ? (($Pagina * $Registros)-$Registros) : 0;

			$Datos=self::execute_single_query("
				SELECT * FROM comentarios WHERE id='$id' ORDER BY idc ASC LIMIT $Inicio,$Registros
			");
			$Datos=$Datos->fetchAll();

			$Total=self::execute_single_query("SELECT * FROM comentarios WHERE id='$id'");
			$Total=$Total->rowCount();

			$Npaginas=ceil($Total/$Registros);

			$table='<div class="list-group">';

			if($Total>=1){
				$nt=$Inicio+1;
				foreach($Datos as $rows){
					$query1=self::execute_single_query("SELECT Usuario,Genero,Tipo FROM cuenta WHERE Codigo='".$rows['Codigo']."'");
					$data1=$query1->fetch();
					if($rows['Tipo']=="Administrador"){
						$avatar="avatar-chef.png";
					}else{
						if($data1['Genero']=="Masculino"){
							$avatar="avatar-user-male.png";
						}else{
							$avatar="avatar-user-female.png";
						}
					}
					if($rows['Codigo']==$_SESSION['userKey'] && $rows['Tipo']==$_SESSION['userType']){
						$table.='
							<div class="list-group-item">
								<div class="row-action-primary">
									<img class="circle" src="'.SERVERURL.'views/assets/avatars/'.$avatar.'" alt="icon">
								</div>
								<div class="row-content">
									<div class="action-secondary btnFormsAjax" data-action="delcomment" data-id="delete-comment-'.$rows['idc'].'">
										<i class="zmdi zmdi-close"></i>
									</div>
									<form action="" id="delete-comment-'.$rows['idc'].'" method="POST" enctype="multipart/form-data">
										<input type="hidden" name="commentCode" value="'.$rows['idc'].'">
									</form>
									<h4 class="list-group-item-heading"><strong>'.$nt.' - '.$data1['Usuario'].' (Yo)</strong></h4>
									<p class="list-group-item-text text-info">
									'.$rows['Comentario'].'<br>
						';
										if($rows['Adjunto']!=""){
											$att=explode(".", $rows['Adjunto']);
											if($att[1]=="jpg" || $att[1]=="png" || $att[1]=="jpeg"){
												$table.='<a href="'.SERVERURL.'attachments/comments/'.$rows['Adjunto'].'" download="'.$rows['Adjunto'].'" class="btn btn-info"><i class="zmdi zmdi-image zmdi-hc-2x"></i></a>';
											}else{
												$table.='<a href="'.SERVERURL.'attachments/comments/'.$rows['Adjunto'].'" download="'.$rows['Adjunto'].'" class="btn btn-info"><i class="zmdi zmdi-file-text zmdi-hc-2x"></i></a>';
											}
										}
						$table.='
									</p>
								</div>
							</div>
							<div class="list-group-separator"></div>
						';
					}else{
						$table.='
							<div class="list-group-item">
								<div class="row-picture">
									<img class="circle" src="'.SERVERURL.'views/assets/avatars/'.$avatar.'" alt="icon">
								</div>
								<div class="row-content">
									<h4 class="list-group-item-heading">'.$nt.' - '.$data1['Usuario'].'</h4>
									<p class="list-group-item-text">
									'.$rows['Comentario'].'<br>
						';
										if($rows['Adjunto']!=""){
											$att=explode(".", $rows['Adjunto']);
											if($att[1]=="jpg" || $att[1]=="png" || $att[1]=="jpeg"){
												$table.='<a href="'.SERVERURL.'attachments/comments/'.$rows['Adjunto'].'" download="'.$rows['Adjunto'].'" class="btn btn-info"><i class="zmdi zmdi-image zmdi-hc-2x"></i></a>';
											}else{
												$table.='<a href="'.SERVERURL.'attachments/comments/'.$rows['Adjunto'].'" download="'.$rows['Adjunto'].'" class="btn btn-info"><i class="zmdi zmdi-file-text zmdi-hc-2x"></i></a>';
											}
										}
						$table.='
									</p>
								</div>
							</div>
							<div class="list-group-separator"></div>
						';
					}
					$nt++;
				}
			}else{
				$table.='<p class="lead text-center">No hay comentarios acerca de la clase</p>';
			}

			$table.='</div>';

			if($Total>=1){
				$table.='
					<nav class="text-center full-width">
						<ul class="pagination pagination-sm">
				';

				if($Pagina==1){
					$table.='<li class="disabled"><a>«</a></li>';
				}else{
					$table.='<li><a href="'.SERVERURL.'classview/'.$codeC.'/'.($Pagina-1).'/">«</a></li>';
				}

				for($i=1; $i <= $Npaginas; $i++){
					if($Pagina == $i){
						$table.='<li class="active"><a href="'.SERVERURL.'classview/'.$codeC.'/'.$i.'/">'.$i.'</a></li>';
					}else{
						$table.='<li><a href="'.SERVERURL.'classview/'.$codeC.'/'.$i.'/">'.$i.'</a></li>';
					}
				}

				if($Pagina==$Npaginas){
					$table.='<li class="disabled"><a>»</a></li>';
				}else{
					$table.='<li><a href="'.SERVERURL.'classview/'.$codeC.'/'.($Pagina+1).'/">»</a></li>';
				}

				$table.='
						</ul>
					</nav>
				';
			}

			return $table;
		}


		/*----------  Delete Comment Controller  ----------*/
		public function delete_comment_controller($code,$codeU,$urls){
			$code=self::clean_string($code);
			$codeU=self::clean_string($codeU);
			$AttDir="./attachments/comments/";

			$query1=self::execute_single_query("SELECT * FROM comentarios WHERE idc='$code'");
			$data1=$query1->fetch();
			if($data1['Codigo']==$codeU){
				if(self::delete_comment_model($code)){
					if($data1['Adjunto']!=""){
						$file=$AttDir.$data1['Adjunto'];
						chmod($file, 0777);
						unlink($file);
					}
					$dataAlert=[
						"title"=>"¡Comentario eliminado!",
						"text"=>"El comentario ha sido eliminado del sistema satisfactoriamente",
						"type"=>"success"
					];
					return self::sweet_alert_url_reload($dataAlert,$urls);
				}else{
					$dataAlert=[
						"title"=>"¡Ocurrió un error inesperado!",
						"text"=>"No pudimos eliminar el comentario por favor intente nuevamente",
						"type"=>"error"
					];
					return self::sweet_alert_single($dataAlert);
				}
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No tienes permisos para eliminar el comentario",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}

	}