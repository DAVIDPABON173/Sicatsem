<?php

/**
 * SICATSEM
 * Sistema de Informacion para el Control de Accidentes Laborales en Sector Minero
 * Ingeniería de Sistemas de la UFPS.
 * Autor: Jesus David Pabon Ortega <jesusdavidpo@ufps.edu.co>
 * V1.0.0
 * 2016
 */
 require_once 'app/model/DAO/cuentaDAO.php';
  require_once 'app/model/DTO/cuentaDTO.php';
	/**
	* Interfaz de conexion para el acceso a los datos correspondientes a
	* las empresas
	*/
	class EmpresaDAO{

	/**
	* Permite realizar un nuevo registro sobre una empresa en la base de Datos
	*/
	public function registrarEmpresa($obj)
	{
		$mysqli =  new model();
		$empresa = array();
    $sql=$mysqli->query("SELECT  nombre_empresa from empresa where nombre_empresa = '".$obj->get_nombre_empresa().";");
	 	$mysqli->liberar($sql);
	 if ($sql) {
	 	$empresa['success'] = 0;
	 	} else {
	 	$sql= $mysqli->query("INSERT INTO empresa (nombre_empresa, razon_social,nit_empresa, direccion_empresa , telefono_empresa) VALUES ('".$obj->get_nombre_empresa()."','".$obj->get_razon_social()."','".$obj->get_nit_empresa()."','".$obj->get_direccion_empresa()."','".$obj->get_telefono_empresa()."');");

	 		if ($mysqli->rowsOpe()>0) {
	 			$select=$mysqli->query("SELECT identificador_empresa from empresa where nombre_empresa = '".$obj->get_nombre_empresa()."';") or trigger_error($mysqli->error);
	 			$fila = $select->fetch_assoc();
	 			$empresa['identificador_empresa'] = $fila['identificador_empresa'];
		 		$empresa['success'] = 1;
		 	} else {
		 		$empresa['success'] = -1;
		 	}
	 }
    $mysqli->close();
		return $empresa;
	}


	/**
	* Permite consultar y obtener la informacion correspondiente a una empresa de la base de Datos
	*/
	public function consultarEmpresa($identificador_empresa)
	{
		$mysqli =  new model();
		$jsondata = array();
		$sql = $mysqli->query("SELECT nombre_empresa, razon_social, nit_empresa, direccion_empresa,
      telefono_empresa, email_cuenta FROM empresa JOIN cuenta_empresa ON
      (identificador_empresa = id_empresa) WHERE identificador_empresa = '".$identificador_empresa."';");

		if ($mysqli->rowsQuery($sql)>0) {
	 		$jsondata['success'] = 1;
				$fila=$sql->fetch_assoc();
				$empresa = array();
				$empresa['nombre_empresa'] = $fila['nombre_empresa'];
				$empresa['razon_social'] = $fila['razon_social'];
				$empresa['nit_empresa'] = $fila['nit_empresa'];
				$empresa['direccion_empresa'] = $fila['direccion_empresa'];
				$empresa['telefono_empresa'] = $fila['telefono_empresa'];
        $empresa['email_cuenta'] = $fila['email_cuenta'];

			$jsondata['empresa'] = $empresa;
			echo json_encode($jsondata);

	 	}else{
	 		$jsondata['success'] = 1;
	 		echo json_encode($jsondata);
	 	}

	 	$mysqli->close();

	}

	/**
	* Permite realizar modificaciones de un registro sobre una empresa en la base de Datos
	*/
	public function editarEmpresa($obj , $id_empresa)
	{
		$mysqli =  new model();
    $jsondata = array();
		$sql=$mysqli->query("UPDATE `empresa` SET `nombre_empresa`= '".$obj->get_nombre_empresa()."' ,`razon_social`='".$obj->get_razon_social()."',`nit_empresa`='".$obj->get_nit_empresa()."',`direccion_empresa`='".$obj->get_direccion_empresa()."',`telefono_empresa`='".$obj->get_telefono_empresa()."' WHERE `identificador_empresa` = $id_empresa ;");
		if ($mysqli->rowsOpe()>0) {
	 		$jsondata['success'] = 1;
 			echo json_encode($jsondata);
	 	} else {
	 		$jsondata['success'] = -1;
			echo json_encode($jsondata);
	 	}

		 	$mysqli->close();
	}


	}
 ?>
