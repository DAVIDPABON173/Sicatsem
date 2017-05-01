<?php

/**
 * SICATSEM
 * Sistema de Informacion para el Control de Accidentes Laborales en Sector Minero
 * Ingeniería de Sistemas de la UFPS.
 * Autor: William Schnaider Torres Bermon <williamschnaidertb@ufps.edu.co>
 * V1.0.0
 * 2016
 */
	require_once 'app/bin/mail.php';
	/**
	* Interfaz de conexion para el acceso a los datos correspondientes a
	* las cuentas
	*/
	class CuentaDAO{

	/**
	* Permite realizar un nuevo registro sobre una cuenta en la base de Datos
	* @param $cuenta - DTO de tipo cuenta
	*/
	public function registrarCuenta($cuenta, $res_empresa)
	{
		$jsondata = array();

		if($res_empresa['success']==1){
				$mysqli = new model();
					$cuenta->set_pass_cuenta(password_hash($cuenta->get_pass_cuenta(), PASSWORD_DEFAULT));
					$insert = $mysqli->query("INSERT INTO cuenta_empresa (email_cuenta, pass_cuenta, id_empresa)
					VALUES ('".$cuenta->get_email_cuenta()."','".$cuenta->get_pass_cuenta()."',
					 '".$res_empresa['identificador_empresa']."');");

					if ($mysqli->rowsOpe()>0) {
							$jsondata['success']=1;
							$jsondata['entidad']='cuenta';
					}else{
						$jsondata['success']=-1;
						$jsondata['entidad']='cuenta';
					}
				$mysqli->close();
		}else if ($res_empresa['success']==0) {
			 $jsondata['success']=0;
			 $jsondata['entidad']='empresa';
		}else {
			$jsondata['success']=-1;
			$jsondata['entidad']='empresa';
		}
		echo json_encode($jsondata);
	}

	/**
	* Permite realizar una consulta sobre un email en la tabla cuenta
	* @param $mysqli - Conexion a la base de datos
	* @param $email_cuenta - Correo electronico asociado a la cuenta
	* @return Retorna true si existe la cuenta registrada o false si no existe
	*/
	private function consultarCuenta($mysqli, $email_cuenta)
	{
		$sql = $mysqli->query("SELECT email_cuenta FROM cuenta_empresa WHERE email_cuenta='".$email_cuenta."' LIMIT 1;");
		if($mysqli->rowsQuery($sql)==0){
			$mysqli->liberar($sql);
			return false;
		}else {
			$mysqli->liberar($sql);
			return true;
		}


	}

	/**
	* Actualiza el correo asociado a la cuenta
	* @param $cuenta - DTO de tipo cuenta
	*/
	public function changeEmail($cuenta, $email_anterior)
	{
		$mysqli = new model();
	  $jsondata = array();
	//	echo "UPDATE cuenta_empresa SET email_cuenta ='".$cuenta->get_email_cuenta()."' WHERE email_cuenta = '".$email_anterior."';";
		$update = $mysqli->query("UPDATE cuenta_empresa SET email_cuenta ='".$cuenta->get_email_cuenta()."' WHERE email_cuenta = '".$email_anterior."';");
		//echo "UPDATE email_cuenta VALUES('".$cuenta->get_email_cuenta()."') FROM cuenta_empresa WHERE email = '".$email_anterior."';"
		if($mysqli->rowsOpe()>0){
			$jsondata['success']=1;
			echo json_encode($jsondata);
		}else{
			$jsondata['success']=-1;
			echo json_encode($jsondata);
		}
		$mysqli->close();
	}

	/**
	* Actualiza la contraseña de acceso asociado a la cuenta siempre y cuando cumpla con los requisitos
	* @param $cuenta - DTO de tipo cuenta
	* @param $pass_ant - Es la contraseña actual
 	*/
	public function changePassword($cuenta, $pass_ant)
	{
		$mysqli = new model();
		$jsondata = array();
		$sql = $mysqli->query("SELECT pass_cuenta FROM cuenta_empresa WHERE email_cuenta = '".$cuenta->get_email_cuenta()."' LIMIT 1;");
		if ($mysqli->rowsQuery($sql)) {
			$fila = $sql->fetch_assoc();

			if(@password_verify($pass_ant, $fila['pass_cuenta'])){
				echo
				$cuenta->set_pass_cuenta(password_hash($cuenta->get_pass_cuenta(), PASSWORD_DEFAULT));
				$update = $mysqli->query("UPDATE cuenta_empresa SET pass_cuenta='".$cuenta->get_pass_cuenta()."' WHERE email_cuenta = '".$cuenta->get_email_cuenta()."';");
				if($mysqli->rowsOpe()>0){
					$jsondata['success']=1;
					echo json_encode($jsondata);
				}else{
					$jsondata['success']=-1;
					echo json_encode($jsondata);
				}
		 }else{
			 $jsondata['success']=-5;
			 echo json_encode($jsondata);
		 }
	 }else{
		 $jsondata['success']=-4;
		 echo json_encode($jsondata);
	 }
		$mysqli->close();

	}


	/**
	* Permite al administrador iniciar sesion en el sistema
	* @param $cuenta - DTO de tipo cuenta
	* @param $sesion - Opcion de inicio de sesion que determina el tiempo que la sesion del administrador estara vigente // valores: true-false
	*/
	public function iniciarSesion($cuenta, $sesion){
		$mysqli =  new model();
		$jsondata = array();
    $sql = $mysqli->query("SELECT email_cuenta, pass_cuenta, id_empresa FROM cuenta_empresa WHERE
       email_cuenta='".$cuenta->get_email_cuenta()."' LIMIT 1;");

    if($mysqli->rowsQuery($sql) > 0){

      $datos= $sql->fetch_assoc();

      if (@password_verify($cuenta->get_pass_cuenta(), $datos['pass_cuenta'])) {
        if($sesion) {
					ini_set('session.cookie_lifetime', time() + (60*60*24));
				}
            $_SESSION['id_empresa'] = $datos['id_empresa'];
						$jsondata['success']= 1;
		  }else{
				$jsondata['success']=-4;
			}
	  }else{
			$jsondata['success']=-5;
		}
		echo json_encode($jsondata);
  }

	public function cerrarSesion()
	{
		session_start();

		$_SESSION = array();

		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
			);
		}

		session_destroy();

	}


	/**
	* Se genera una contraseña para que el administrador pueda ingresar a la cuenta.
	* @param $cuenta - DTO de tipo cuenta
	*/
	public function recuperarCuenta($cuenta)
	{
		$mysqli = new model();
		$jsondata = array();
		$sql = $mysqli->query("SELECT * FROM cuenta_empresa WHERE email_cuenta='".$cuenta->get_email_cuenta()."' LIMIT 1;");

		if ($mysqli->rowsQuery($sql)>0) {
			$new_pass = strtoupper(substr(sha1(time()),0,8));
			$pass_encritype = password_hash($new_pass, PASSWORD_DEFAULT);
			$update = $mysqli->query("UPDATE cuenta_empresa SET pass_cuenta='".$pass_encritype."' WHERE email_cuenta = '".$cuenta->get_email_cuenta()."';");

			if($mysqli->rowsOpe()>0)
			{
				$success = Mail::sendMail('Soporte Tecnico de SICATSEM', $this->generarMensaje($new_pass),
				'Recuperación de la Cuenta',$cuenta->get_email_cuenta());

				if($success){
					$jsondata['success']=1;
				}else {
					$jsondata['success']=-1;
				}

			}else {
				$jsondata['success']=-1;
			}

		} else {
			$jsondata['success']=-2;
		}
		echo json_encode($jsondata);

  }
  /**
	* @param $to - Destinatario del mensaje
	* @param $title - Titulo del mensaje
	* @param $header - Encabezado del mensaje
	* @param $message - Cuerpo del mensaje
	*/
	private function generarMensaje($new_pass){

		return $message   = '<html> </head> <title>Recuperación de Contraseña</title> </head>'.
            '<body> <p>El día <strong>'. date('d/m/Y', time()).'</strong> ha solicitado
						recuperar la cuenta, por lo tanto, el sistema ha generado una contraseña
						para que pueda ingresar.'.' Podrá cambiarla cuando guste en la sección de
						configuraciones de la cuenta.'. '<br><br><strong>Contraseña: </strong>'.$new_pass.'</p> <br>
            <br> </body> </html>';
  }
}
 ?>
