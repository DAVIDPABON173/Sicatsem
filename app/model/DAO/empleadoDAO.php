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
	* los empleados
	*/
	class EmpleadoDAO {

	/**
	* Permite realizar un nuevo registro sobre un empleado en la base de datos
	*/
	public function registrarEmpleado($obj)
	{
		$mysqli =  new model();
		$jsondata = array();
    #validacion de tipo documento y numero
    $sql=$mysqli->query("SELECT * from empleado where tipo_doc = '".$obj->get_tipo_doc()."'
		and numero_doc = '".$obj->get_numero_doc()."';");

    if ($mysqli->rowsQuery($sql)>0) {
	 		$jsondata['success'] = 0;
	 		echo json_encode($jsondata);
	 	}else{

         $insert= $mysqli->query("INSERT INTO empleado (nombres_em, apellido_em , apellido_2_em, tipo_doc,
					 numero_doc, salario_base, fecha_nacimiento, genero_em, eps_ips, entidad_salud, tipo_cargo_em,
					cargo_em, centro_trabajo) VALUES ('".$obj->get_nombres_em()."', '".$obj->get_apellido_em()."',
					'".$obj->get_apellido_2_em()."', '".$obj->get_tipo_doc()."', '".$obj->get_numero_doc()."',
					'".$obj->get_salario_base()."','".$obj->get_fecha_nacimiento()."', '".$obj->get_genero_em()."',
					'".$obj->get_eps_ips()."', '".$obj->get_entidad_salud()."', '".$obj->get_tipo_cargo_em()."',
					'".$obj->get_cargo_em()."', '".$obj->get_centro_trabajo()."');");


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
	* Permite consultar y obtener la informacion correspondiente a un empleado de la base de Datos
	*/
	public function consultarEmpleado($obj)
	{
		$mysqli =  new model();
		$jsondata = array();

       	$sql = $mysqli->query("SELECT empleado"."."."identificador_empleado ,empleado"."."."nombres_em,empleado"."."."apellido_em, empleado"."."."apellido_2_em, empleado"."."."tipo_doc, empleado"."."."numero_doc,empleado"."."."salario_base, empleado"."."."fecha_nacimiento, empleado"."."."genero_em,empleado"."."."eps_ips, empleado"."."."entidad_salud, empleado"."."."tipo_cargo_em,empleado"."."."cargo_em,  centro_trabajo"."."."identificador_centro, centro_trabajo"."."."nombre_centro, empleado"."."."estado_em From empleado JOIN centro_trabajo ON (empleado"."."."centro_trabajo = centro_trabajo"."."."identificador_centro) WHERE nombres_em = '".$obj->get_nombres_em()."' AND apellido_em = '".$obj->get_apellido_em()."' AND apellido_2_em = '".$obj->get_apellido_2_em()."';");

       	if ($mysqli->rowsQuery($sql)) {
	 		  $jsondata['success'] = 1;
	 		  //Solo devuelve un empleado....
				$fila=$sql->fetch_assoc();
				$empleado = array();
				$empleado['identificador_empleado'] = $fila['identificador_empleado'];
				$empleado['nombres_em'] = $fila['nombres_em'];
				$empleado['apellido_em'] = $fila['apellido_em'];
				$empleado['apellido_2_em'] = $fila['apellido_2_em'];
				$empleado['tipo_doc'] = $fila['tipo_doc'];
				$empleado['numero_doc'] = $fila['numero_doc'];
				$empleado['salario_base'] = $fila['salario_base'];
				$empleado['fecha_nacimiento'] = $fila['fecha_nacimiento'];
				$empleado['genero_em'] = $fila['genero_em'];
				$empleado['eps_ips'] = $fila['eps_ips'];
				$empleado['entidad_salud'] = $fila['entidad_salud'];
				$empleado['tipo_cargo_em'] = $fila['tipo_cargo_em'];
				$empleado['cargo_em'] = $fila['cargo_em'];
				$empleado['identificador_centro'] = $fila['identificador_centro'];
				$empleado['nombre_centro'] = $fila['nombre_centro'];
				$empleado['estado_em'] = $fila['estado_em'];
				$jsondata['empleado'] = $empleado;
			echo json_encode($jsondata);

	 	}else{
	 		$jsondata['success'] = 0;
	 		echo json_encode($jsondata);

	 	$mysqli->close();

	}
}

	/**
	*Metodo para obtener el nombre y apellidos de todos los empleados de la empresa
	*/
	public function cargarDatosEmpleados($id_empresa)
	{
		$mysqli =  new model();
		$jsondata = array();
       	$sql = $mysqli->query("SELECT identificador_empleado, nombres_em, apellido_em, apellido_2_em from empleado join centro_trabajo on (empleado"."."."centro_trabajo = centro_trabajo"."."."identificador_centro) join empresa on (centro_trabajo"."."."identificador_empresa = empresa"."."."identificador_empresa) WHERE empresa"."."."identificador_empresa = ".$id_empresa);
       		
       if ($mysqli->rowsQuery($sql)) {
			 		$indice = 0;
					$jsondata['success'] = 1;
					while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
						$empleado = array();
						$empleado['identificador_empleado'] = $fila[0];
						$empleado['nombres_em'] = $fila[1];
						$empleado['apellido_em'] = $fila[2];
						$empleado['apellido_2_em'] = $fila[3];
						$empleados[$indice] = $empleado;
						$indice++;
					}
					$jsondata['empleado']=$empleados;
	 	}else{
	 	$jsondata['success'] = -1;
	 	}
	 	$mysqli->liberar($sql);
	 	$mysqli->close();
	 	return $jsondata;

	}

	//metodo obtener centro cc

	public function cargarDatosRegistroModificacion($id_empresa)
	{
		$mysqli =  new model();
		$jsondata = array();
		$jsondata['success'] = 1;
		$jsondata['cargo_empleado'] = $this->cargarCargos();
		$jsondata['centro_trabajo'] = $this->cargarCentros($id_empresa);
       	echo json_encode($jsondata);

	}

	private function cargarCargos()
		{
			$mysqli =  new model();
			$cargo_empleado = array();
	       	#validacion de tipo documento y numero
	       	$sql = $mysqli->query("SELECT identificador_cargo_em, nombre_cargo, tipo_cargo FROM cargo_empleado;");
	       	if ($mysqli->rowsQuery($sql)>0){
				$indice = 0;
				$indice2 = 0;
				$administrativo = array();
				$operativo = array();
				while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
					if($fila[2] == "administrativo"){

					$cargo_administrativo = array();
					$cargo_administrativo['identificador_cargo_em'] = $fila[0];
					$cargo_administrativo['nombre_cargo'] = $fila[1];
					$administrativo[$indice] = $cargo_administrativo;
					$indice++;
					}else{
					$cargo_operativo = array();
					$cargo_operativo['identificador_cargo_em'] = $fila[0];
					$cargo_operativo['nombre_cargo'] = $fila[1];
					$operativo[$indice2] = $cargo_operativo;
					$indice2++;
					}
					// se guarda dentro del vector cargo_empleado
					$cargo_empleado['administrativo'] = $administrativo;
					$cargo_empleado['operativo'] =$operativo;

				}
			}
				$mysqli->liberar($sql);
		 		$mysqli->close();
		 		return $cargo_empleado;
		}
	private function cargarCentros($id_empresa)
	{
		$mysqli =  new model();
		$centro_trabajo = array();
       	$sql = $mysqli->query("SELECT identificador_centro, nombre_centro FROM centro_trabajo where identificador_empresa = $id_empresa ;");

 
       	if ($mysqli->rowsQuery($sql)>0){
			$indice = 0;
			while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
				$centro = array();
				$centro['identificador_centro'] = $fila[0];
				$centro['nombre_centro'] = $fila[1];
				//cada fila es un vector
				$centro_trabajo[$indice] = $centro;
				$indice++;
			}
		}
			$mysqli->liberar($sql);
	 		$mysqli->close();
	 		return $centro_trabajo;

	}




	/**
	* Permite realizar modificaciones de un registro sobre un empleado en la base de Datos
	*/
	public function editarEmpleado($obj, $id_empleado)
	{
		$mysqli =  new model();
		 $sql=$mysqli->query("UPDATE `empleado` SET `nombres_em`='".$obj->get_nombres_em()."',
		`apellido_em`='".$obj->get_apellido_em()."',`apellido_2_em`='".$obj->get_apellido_2_em()."',
		`tipo_doc`='".$obj->get_tipo_doc()."',`numero_doc`='".$obj->get_numero_doc()."',
		`salario_base`='".$obj->get_salario_base()."',`fecha_nacimiento`='".$obj->get_fecha_nacimiento()."',
		`genero_em`='".$obj->get_genero_em()."',`eps_ips`='".$obj->get_eps_ips()."',
		`entidad_salud`='".$obj->get_entidad_salud()."',`tipo_cargo_em`='".$obj->get_tipo_cargo_em()."'
		,`cargo_em`='".$obj->get_cargo_em()."',`centro_trabajo`='".$obj->get_centro_trabajo()."',
		`estado_em`='".$obj->get_estado_em()."' WHERE identificador_empleado = $id_empleado ;");

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
