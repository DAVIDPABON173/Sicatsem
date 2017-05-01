<?php

/**
 * SICATSEM
 * Sistema de Informacion para el Control de Accidentes Laborales en Sector Minero
 * Ingeniería de Sistemas de la UFPS.
 * Autor: Jesus David Pabon Ortega <jesusdavidpo@ufps.edu.co>
 * V1.0.0
 * 2016
 */

	/**
	* Interfaz de conexion para el acceso a los datos correspondientes a
	* los centros de trabajo
	*/
	class CentroTrabajoDAO{

	/**
	* Permite realizar un nuevo registro sobre un centro de trabajo en la base de Datos
	*/
	public function registrarCentroTrabajo($obj)
	{
		$mysqli =  new model();
		$jsondata = array();
		$sql=$mysqli->query("SELECT  * from centro_trabajo where nombre_centro = '".$obj->get_nombre_centro()."'");
		 if ($mysqli->rowsQuery($sql)>0) {
		 	$jsondata['success'] = 0;
	 		echo json_encode($jsondata);
		 } else {
		 	$insert= $mysqli->query("INSERT INTO centro_trabajo (identificador_empresa, nombre_centro, municipio_centro, direccion_centro, telefono_centro)VALUES ('".$obj->get_identificador_empresa()."','".$obj->get_nombre_centro()."','".$obj->get_municipio_centro()."','".$obj->get_direccion_centro()."','".$obj->get_telefono_centro()."');");

		 	if ($mysqli->rowsOpe()>0) {
		 		$jsondata['success'] = 1;
	 			echo json_encode($jsondata);
		 	} else {
		 		$jsondata['success'] = -1;
	 			echo json_encode($jsondata);
		 	}


	 }
	    $mysqli->close();
	}

	/**
	* Permite consultar y obtener la informacion correspondiente a un centro de trabajo de la base de Datos
	*/
	public function consultarCentroTrabajo($obj)
	{
		$mysqli =  new model();
		$jsondata = array();
		$sql=$mysqli->query("SELECT centro_trabajo"."."."nombre_centro , departamento"."."."departamento ,
		municipio"."."."municipio,centro_trabajo"."."."direccion_centro, centro_trabajo"."."."telefono_centro
		 from centro_trabajo join empresa ON (empresa"."."."identificador_empresa = centro_trabajo.identificador_empresa)
		  join municipio on (centro_trabajo"."."."municipio_centro = municipio"."."."id)
			join departamento on( municipio"."."."departamento_mun = departamento"."."."id)
			 where nombre_centro = '".$obj->get_nombre_centro()."';") ;

		if ($mysqli->rowsQuery($sql)>0){
		 	$jsondata['success'] = 1;
			$fila= $sql->fetch_assoc();
				$centro_trabajo = array();
				$centro_trabajo['nombre_centro'] = $fila['nombre_centro'];
				$centro_trabajo['departamento'] = $fila['departamento'];
				$centro_trabajo['municipio'] = $fila['municipio'];
				$centro_trabajo['direccion_centro'] = $fila['direccion_centro'];
				$centro_trabajo['telefono_centro'] = $fila['telefono_centro'];
				$jsondata['centro_trabajo'] = $centro_trabajo;

			echo json_encode($jsondata);
	 	}else{
	 		$jsondata['success'] = 0;
			echo json_encode($jsondata);
	 	}
	 		$mysqli->liberar($sql);
	 		$mysqli->close();
	}
	//Metodo que obtiene todos los datos correspondientes a lod departamentos y municipio
	public function cargarDatosRegistroModificacion($id_departamento)
	{
		$jsondata = array();
		$jsondata['municipio'] = $this->cargarMunicipios($id_departamento);
		echo json_encode($jsondata);
	}
	/**
	* Obtiene todos los departamentos con sus id contenidos en la base de datos
	*/
	private function cargarDepartamentos()
	{
		$mysqli =  new model();
		$departamentos = array();
		$sql=$mysqli->query("SELECT departamento"."."."id, departamento"."."."departamento from departamento;");
		if ($mysqli->rowsQuery($sql)>0){
			$indice = 0;
			while ($fila = $sql->fetch_array(MYSQLI_NUM)) {
				$departamento = array();
				$departamento['id'] = $fila[0];
				$departamento['departamento'] = $fila[1];
				// se guarda dentro del vector departamentos
				$departamentos[$indice] = $departamento;
				$indice++;
			}
		}
			$mysqli->liberar($sql);
	 		$mysqli->close();
	 		return $departamentos;
	}

	/**
	* Obtiene todos los departamentos con sus id contenidos en la base de datos
	*/
	private function cargarMunicipios($id_departamento)
	{
		$mysqli =  new model();

		$jsondata = array();
		$sql=$mysqli->query("SELECT id, municipio  FROM municipio WHERE `departamento_mun` = $id_departamento ; ");
		if ($mysqli->rowsQuery($sql)>0){
			$indice = 0;
			while ($fila = $sql->fetch_array(MYSQLI_NUM)) {
				$municipio = array();
				$municipio['id'] = $fila[0];
				$municipio['municipio'] = $fila[1];
				// se guarda dentro del vector departamentos
				$jsondata[$indice] = $municipio;
				$indice++;
			}
		}
			$mysqli->liberar($sql);
	 		$mysqli->close();
	 		return $jsondata;
	}
	/**
	* Permite realizar modificaciones de un registro sobre un centro de trabajo en la base de Datos
	*/
	public function editarCentroTrabajo($obj , $id_centro)
	{
		$mysqli =  new model();
		$sql=$mysqli->query("UPDATE `centro_trabajo` SET `nombre_centro`= '".$obj->get_nombre_centro()."' ,`municipio_centro`= '".$obj->get_municipio_centro()."',`direccion_centro`= '".$obj->get_direccion_centro()."',`telefono_centro`= '".$obj->get_telefono_centro()."' WHERE identificador_centro = '$id_centro' ;");

		if ($mysqli->rowsOpe()>0) {
	 		$jsondata['success'] = 1;
 			echo json_encode($jsondata);
	 	} else {
	 		$jsondata['success'] = -1;
			echo json_encode($jsondata);
	 	}

		 	$mysqli->close();

	}

	public function cargarDatosConsulta($id_empresa)
	{
		$mysqli =  new model();
		$jsondata = array();
		$centro_trabajos = array();
		$sql=$mysqli->query("SELECT identificador_centro, nombre_centro FROM centro_trabajo where identificador_empresa = $id_empresa ;");
		if ($mysqli->rowsQuery($sql)>0){
			$jsondata['success'] = 1 ;
			$indice = 0;
			while ($fila = $sql->fetch_array(MYSQLI_NUM)) {
				$centro_trabajo = array();
				$centro_trabajo['identificador_centro'] = $fila[0];
				$centro_trabajo['nombre_centro'] = $fila[1];
				// se guarda dentro del vector departamentos
				$centro_trabajos[$indice] = $centro_trabajo;
				$indice++;
			}
			$jsondata['centro_trabajo'] =$centro_trabajos;
			echo json_encode($jsondata);
		}else{
			$jsondata['success'] = 0;
			echo json_encode($jsondata);
		}
			$mysqli->liberar($sql);
	 		$mysqli->close();
	}

	public function obtenerDatosGeneralesConsolidado($obj){
			$mysqli =  new model();
			$jsondata = array();
			$sql=$mysqli->query("SELECT empresa"."."."nombre_empresa, empresa"."."."telefono_empresa, centro_trabajo"."."."nombre_centro, centro_trabajo"."."."direccion_centro, cuenta_empresa"."."."email_cuenta FROM centro_trabajo JOIN empresa ON (centro_trabajo"."."."identificador_empresa = empresa"."."."identificador_empresa) JOIN cuenta_empresa ON (empresa"."."."identificador_empresa = cuenta_empresa"."."."id_empresa) WHERE empresa"."."."identificador_empresa = ".$obj->get_identificador_empresa()." AND centro_trabajo"."."."nombre_centro = '".$obj->get_nombre_centro()."';");

			if ($mysqli->rowsQuery($sql)>0){
			$fila = $sql->fetch_array(MYSQLI_NUM);
			$jsondata['success'] = 1; 
			$jsondata['nombre_empresa'] = $fila[0]; 
			$jsondata['telefono_empresa'] = $fila[1]; 
			$jsondata['nombre_centro'] = $fila[2]; 
			$jsondata['direccion_centro'] = $fila[3];
			$jsondata['responsable'] = $fila[4]; 

			}else{
			$jsondata['success'] = 0; 
			}
			$mysqli->liberar($sql);
			$mysqli->close();
			return $jsondata;
	}


	}
 ?>
