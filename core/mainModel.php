<?php
	if($actionsRequired){
		require_once "../core/configAPP.php";
	}else{
		require_once "./core/configAPP.php"; 
	}

	class mainModel{


		/*----------  Funcion para conectar a la BD - Function to connect to DB  ----------*/
		public function connect(){
			$link= new PDO(SGBD,USER,PASS);
			return $link;
		}


		/*----------  Funcion para ejecutar una consulta simple - Function to execute a simple query  ----------*/
		public function execute_single_query($query){
			$response=self::connect()->prepare($query);
			$response->execute();
			return $response;
		}

		/*----------  Funcion para ejecutar una consulta simple directa  ----------*/
		public function execute_query($query){
			$response=self::connect()->query($query);
			return $response;
		}


		/*----------  Funcion para guardar cuenta - Save account function  ----------*/
		public function save_account($data){
			$query=self::connect()->prepare("INSERT INTO cuenta(Privilegio,Usuario,Clave,Tipo,Codigo,Genero) VALUES(:Privilegio,:Usuario,:Clave,:Tipo,:Codigo,:Genero)");
			$query->bindParam(":Privilegio",$data['Privilegio']);
			$query->bindParam(":Usuario",$data['Usuario']);
			$query->bindParam(":Clave",$data['Clave']);
			$query->bindParam(":Tipo",$data['Tipo']);
			$query->bindParam(":Genero",$data['Genero']);
			$query->bindParam(":Codigo",$data['Codigo']);
			$query->execute();
			return $query;
		}


		/*----------  Eliminar cuenta - Delete account  ----------*/
		public function delete_account($code){
			$query=self::connect()->prepare("DELETE FROM cuenta WHERE Codigo=:Codigo");
			$query->bindParam(":Codigo",$code);
			$query->execute();
			return $query;
		}


		/*----------  Datos de cuenta - Data of account  ----------*/
		public function data_account($code){
			$query=self::connect()->prepare("SELECT * FROM cuenta WHERE Codigo=:Codigo");
			$query->bindParam(":Codigo",$code);
			$query->execute();
			return $query;
		}


		/*----------  Actualizar cuenta - Update account  ----------*/
		public function update_account($data){
			if($data['Clave']!=""){
				$query=self::connect()->prepare("UPDATE cuenta SET Usuario=:Usuario,Clave=:Clave,Genero=:Genero WHERE Codigo=:Codigo");
				$query->bindParam(":Clave",$data['Clave']);
			}else{
				$query=self::connect()->prepare("UPDATE cuenta SET Usuario=:Usuario,Genero=:Genero WHERE Codigo=:Codigo");
			}
			$query->bindParam(":Usuario",$data['Usuario']);
			$query->bindParam(":Genero",$data['Genero']);
			$query->bindParam(":Codigo",$data['Codigo']);
			$query->execute();
			return $query;
		}


		/*----------  Funcion para encriptar claves - Function to encrypt keys  ----------*/
		public function encryption($string){
			$output=FALSE;
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_encrypt($string, METHOD, $key, 0, $iv);
			$output=base64_encode($output);
			return $output;
		}


		/*----------  Funcion para desencriptar claves - Function to decrypt keys  ----------*/
		public function decryption($string){
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
			return $output;
		}


		/*----------  Funcion para generar codigos aleatorios - Function to generate random codes  ----------*/
		public function generate_code($letter,$length,$correlative){
			for ($i=1; $i<=$length; $i++){ 
			    $number = rand(0,9); 
			    $letter .= $number; 
			}
			return $letter.$correlative;
		}


		/*----------  Funcion para limpiar cadenas de texto - Function to clean text strings  ----------*/
		public function clean_string($value) {
			$value = trim($value);
			$value = stripslashes($value);
			$value = str_ireplace("<script>", "", $value);
			$value = str_ireplace("</script>", "", $value);
			$value = str_ireplace("<script src", "", $value);
			$value = str_ireplace("<script type=", "", $value);
			$value = str_ireplace("SELECT * FROM", "", $value);
			$value = str_ireplace("DELETE FROM", "", $value);
			$value = str_ireplace("INSERT INTO", "", $value);
			$value = str_ireplace("--", "", $value);
			$value = str_ireplace("^", "", $value);
			$value = str_ireplace("[", "", $value);
			$value = str_ireplace("]", "", $value);
			$value = str_ireplace("\\", "", $value);
			$value = str_ireplace("=", "", $value);
			$value = str_ireplace("==", "", $value);
			return $value;
		}

	    
		/*----------  Función para mostrar alerta simple de SweetAlert - SweetAlert simple alert display function  ----------*/
	    public function sweet_alert_single($data){
			$alert="
				<script>
					swal(
					  '".$data['title']."',
					  '".$data['text']."',
					  '".$data['type']."'
					);
				</script>"
			;
			return $alert;
		}

		
		/*----------  Función para mostrar alerta de SweetAlert - SweetAlert alert display function  ----------*/
	    public function sweet_alert($data){
			$alert="
				<script>
					swal({
					  	title: '".$data['title']."',
					  	text: '".$data['text']."',
					  	type: '".$data['type']."',
					  	confirmButtonText: 'Aceptar'
					}).then(function () {
					  	location.reload();
					});
				</script>"
			;
			return $alert;
		}


		/*----------  Función para mostrar alerta de SweetAlert con url - SweetAlert alert with url display function  ----------*/
	    public function sweet_alert_url($data,$url){
			$alert="
				<script>
					swal({
						title: '".$data['title']."',
					  	text: '".$data['text']."',
					  	type: '".$data['type']."',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: '".$data['confirText']."',
						cancelButtonText: '".$data['cancelText']."'
					}).then(function () {
						window.open('$url','_blank');
					});
				</script>"
			;
			return $alert;
		}


		/*----------  Función para mostrar alerta de SweetAlert con url - SweetAlert alert with url display function  ----------*/
	    public function sweet_alert_url_reload($data,$url){
			$alert="
				<script>
					swal({
						title: '".$data['title']."',
					  	text: '".$data['text']."',
					  	type: '".$data['type']."',
						confirmButtonColor: '#3085d6',
						confirmButtonText: 'Aceptar'
					}).then(function () {
						window.location.href='$url';
					});
				</script>"
			;
			return $alert;
		}


		 public function sweet_alert_reset($data){
			$alert="
				<script>
					swal({
						title: '".$data['title']."',
					  	text: '".$data['text']."',
					  	type: '".$data['type']."',
						confirmButtonColor: '#3085d6',
						confirmButtonText: 'Aceptar'
					}).then(function () {
						$('.ajaxDataForm')[0].reset();
					});
				</script>"
			;
			return $alert;
		}
	}