<?php
	if($actionsRequired){
		require_once "../models/studentModel.php";
	}else{ 
		require_once "./models/studentModel.php";
	}

	class studentController extends studentModel{

		/*----------  Add Student Controller  ----------*/
		public function add_student_controller(){
			$name=self::clean_string($_POST['name']);
			$lastname=self::clean_string($_POST['lastname']);
			$gender=self::clean_string($_POST['gender']);
			$email=self::clean_string($_POST['email']);
			$username=self::clean_string($_POST['username']);
			$password1=self::clean_string($_POST['password1']);
			$password2=self::clean_string($_POST['password2']);

			if($password1!="" || $password2!=""){
				if($password1==$password2){
					$query1=self::execute_single_query("SELECT Usuario FROM cuenta WHERE Usuario='$username'");
					if($query1->rowCount()<=0){
						$query2=self::execute_single_query("SELECT id FROM cuenta");
						$correlative=($query2->rowCount())+1;

						$code=self::generate_code("EC",7,$correlative);
						$password1=self::encryption($password1);

						$dataAccount=[
							"Privilegio"=>4,
							"Usuario"=>$username,
							"Clave"=>$password1,
							"Tipo"=>"Estudiante",
							"Genero"=>$gender,
							"Codigo"=>$code
						];

						$dataStudent=[
							"Codigo"=>$code,
							"Nombres"=>$name,
							"Apellidos"=>$lastname,
							"Email"=>$email
						];

						if(self::save_account($dataAccount) && self::add_student_model($dataStudent)){
							$dataAlert=[
								"title"=>"¡Estudiante registrado!",
								"text"=>"El estudiante se registró con éxito en el sistema",
								"type"=>"success"
							];
							unset($_POST);
							return self::sweet_alert_single($dataAlert);
						}else{
							$dataAlert=[
								"title"=>"¡Ocurrió un error inesperado!",
								"text"=>"No hemos podido registrar el estudiante, por favor intente nuevamente",
								"type"=>"error"
							];
							return self::sweet_alert_single($dataAlert);
						}

					}else{
						$dataAlert=[
							"title"=>"¡Ocurrió un error inesperado!",
							"text"=>"El nombre de usuario que acaba de ingresar ya se encuentra registrado en el sistema, por favor elija otro",
							"type"=>"error"
						];
						return self::sweet_alert_single($dataAlert);
					}
				}else{
					$dataAlert=[
						"title"=>"¡Ocurrió un error inesperado!",
						"text"=>"Las contraseñas que acabas de ingresar no coinciden",
						"type"=>"error"
					];
					return self::sweet_alert_single($dataAlert);
				}
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"Debes de llenar los campos de las contraseñas para registrar el estudiante",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}



		/*----------  Data Student Controller  ----------*/
		public function data_student_controller($Type,$Code){
			$Type=self::clean_string($Type);
			$Code=self::clean_string($Code);

			$data=[
				"Tipo"=>$Type,
				"Codigo"=>$Code
			];

			if($studentdata=self::data_student_model($data)){
				return $studentdata;
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido seleccionar los datos del estudiante",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}

		}



		/*----------  Pagination Student Controller  ----------*/
		public function pagination_student_controller($Pagina,$Registros){
			$Pagina=self::clean_string($Pagina);
			$Registros=self::clean_string($Registros);

			$Pagina = (isset($Pagina) && $Pagina>0) ? floor($Pagina) : 1;

			$Inicio = ($Pagina>0) ? (($Pagina * $Registros)-$Registros) : 0;

			$Datos=self::execute_single_query("
				SELECT * FROM estudiante ORDER BY Nombres ASC LIMIT $Inicio,$Registros
			");
			$Datos=$Datos->fetchAll();

			$Total=self::execute_single_query("SELECT * FROM estudiante");
			$Total=$Total->rowCount();

			$Npaginas=ceil($Total/$Registros);

			$table='
			<table class="table text-center">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Nombres</th>
						<th class="text-center">Apellidos</th>
						<th class="text-center">Email</th>
						<th class="text-center">A. Datos</th>
						<th class="text-center">A. Cuenta</th>
						<th class="text-center">Eliminar</th>
					</tr>
				</thead>
				<tbody>
			';

			if($Total>=1){
				$nt=$Inicio+1;
				foreach($Datos as $rows){
					$table.='
					<tr>
						<td>'.$nt.'</td>
						<td>'.$rows['Nombres'].'</td>
						<td>'.$rows['Apellidos'].'</td>
						<td>'.$rows['Email'].'</td>
						<td>
							<a href="'.SERVERURL.'studentinfo/'.$rows['Codigo'].'/" class="btn btn-success btn-raised btn-xs">
								<i class="zmdi zmdi-refresh"></i>
							</a>
						</td>
						<td>
							<a href="'.SERVERURL.'account/'.$rows['Codigo'].'/" class="btn btn-success btn-raised btn-xs">
								<i class="zmdi zmdi-refresh"></i>
							</a>
						</td>
						<td>
							<a href="#!" class="btn btn-danger btn-raised btn-xs btnFormsAjax" data-action="delete" data-id="del-'.$rows['Codigo'].'">
								<i class="zmdi zmdi-delete"></i>
							</a>
							<form action="" id="del-'.$rows['Codigo'].'" method="POST" enctype="multipart/form-data">
								<input type="hidden" name="studentCode" value="'.$rows['Codigo'].'">
							</form>
						</td>
					</tr>
					';
					$nt++;
				}
			}else{
				$table.='
				<tr>
					<td colspan="5">No hay registros en el sistema</td>
				</tr>
				';
			}

			$table.='
				</tbody>
			</table>
			';

			if($Total>=1){
				$table.='
					<nav class="text-center full-width">
						<ul class="pagination pagination-sm">
				';

				if($Pagina==1){
					$table.='<li class="disabled"><a>«</a></li>';
				}else{
					$table.='<li><a href="'.SERVERURL.'studentlist/'.($Pagina-1).'/">«</a></li>';
				}

				for($i=1; $i <= $Npaginas; $i++){
					if($Pagina == $i){
						$table.='<li class="active"><a href="'.SERVERURL.'studentlist/'.$i.'/">'.$i.'</a></li>';
					}else{
						$table.='<li><a href="'.SERVERURL.'studentlist/'.$i.'/">'.$i.'</a></li>';
					}
				}

				if($Pagina==$Npaginas){
					$table.='<li class="disabled"><a>»</a></li>';
				}else{
					$table.='<li><a href="'.SERVERURL.'studentlist/'.($Pagina+1).'/">»</a></li>';
				}

				$table.='
						</ul>
					</nav>
				';
			}

			return $table;
		}


		/*----------  Delete Student Controller  ----------*/
		public function delete_student_controller($code){
			$code=self::clean_string($code);

			if(self::delete_account($code) && self::delete_student_model($code)){
				$dataAlert=[
					"title"=>"¡Estudiante eliminado!",
					"text"=>"El estudiante ha sido eliminado del sistema satisfactoriamente",
					"type"=>"success"
				];
				return self::sweet_alert_single($dataAlert);
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No pudimos eliminar el estudiante por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}


		/*----------  Update Student Controller  ----------*/
		public function update_student_controller(){
			$code=self::clean_string($_POST['code']);
			$name=self::clean_string($_POST['name']);
			$lastname=self::clean_string($_POST['lastname']);
			$email=self::clean_string($_POST['email']);

			$data=[
				"Codigo"=>$code,
				"Nombres"=>$name,
				"Apellidos"=>$lastname,
				"Email"=>$email
			];

			if(self::update_student_model($data)){
				$dataAlert=[
					"title"=>"¡Estudiante actualizado!",
					"text"=>"Los datos del estudiante fueron actualizados con éxito",
					"type"=>"success"
				];
				return self::sweet_alert_single($dataAlert);
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido actualizar los datos del estudiante, por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}

	}