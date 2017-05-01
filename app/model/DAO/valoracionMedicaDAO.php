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
	* las valoraciones medicas
	*/
	class ValoracionMedicaDAO{

	/**
	* Permite realizar un nuevo registro sobre una valoracion medica en la base de Datos
	*/
	public function registrarValoracionMedica($obj)
	{

	 $mysqli =  new model();
	 $jsondata = array();

	 $sql=$mysqli->query("SELECT * from valoracion_medica_at where identificador_at = ".$obj->get_identificador_at());

	 if ($mysqli->rowsQuery($sql)>0) {
	 	$jsondata['success'] = 0;
	 	echo json_encode($jsondata);
	 	} else {
	 	$insert= $mysqli->query("INSERT INTO valoracion_medica_at (identificador_at , codigo_valoracion, dias_incapacidad,dias_prorroga, observacion)
	 		VALUES ('".$obj->get_identificador_at()."','".$obj->get_codigo_valoracion()."','".$obj->get_dias_incapacidad()."','".$obj->get_dias_prorroga()."','"
	 		.$obj->get_observacion()."');");

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
	* Permite consultar y obtener la informacion correspondiente a una valoracion medica de la base de Datos
	*/
	public function consultarValoracionMedica($obj)
	{
		$mysqli =  new model();
		$jsondata = array();
   	$sql=$mysqli->query("SELECT valoracion_medica_at"."."."identificador_at , valoracion_medica_at"."."."codigo_valoracion,
		valoracion_medica_at"."."."dias_incapacidad, valoracion_medica_at"."."."dias_prorroga, valoracion_medica_at"."."."observacion,
		valoracion_medica"."."."descripcion FROM valoracion_medica_at  JOIN valoracion_medica ON (valoracion_medica"."."."identificador_codigo =
		valoracion_medica_at"."."."codigo_valoracion) where valoracion_medica_at"."."."identificador_at = ".$obj->get_identificador_at().";");

    if ($mysqli->rowsQuery($sql)>0) {
	 		$jsondata['success'] = 1;
	 		$fila=$sql->fetch_assoc();
			$valoracion_medica_at = array();
			$valoracion_medica_at['id_fiatep'] = $fila['identificador_at'];
			$valoracion_medica_at['codigo_valoracion'] = $fila['codigo_valoracion'];
			$valoracion_medica_at['dias_incapacidad'] = $fila['dias_incapacidad'];
			$valoracion_medica_at['dias_prorroga'] = $fila['dias_prorroga'];
			$valoracion_medica_at['observacion'] = $fila['observacion'];
			$valoracion_medica_at['descripcion'] = $fila['descripcion'];

			$jsondata['valoracion_medica_at'] = $valoracion_medica_at;
			echo json_encode($jsondata);
	 	}else{
	 		$jsondata['success'] = 0;
	 		echo json_encode($jsondata);
	 	}
	 	$mysqli->close();
	}

	public function consultarCodigoValoracion($codigo)
	{
		$mysqli =  new model();
		$jsondata = array();

		$sql = $mysqli->query("SELECT identificador_codigo, descripcion  FROM `valoracion_medica` WHERE identificador_codigo = '$codigo'");

		if ($mysqli->rowsQuery($sql)) {
			$diagnostico = array();
	 		  $jsondata['success'] = 1;
	 		  $fila=$sql->fetch_assoc();
	 		  $diagnostico['identificador_codigo'] = $fila['identificador_codigo'];
			  $diagnostico['descripcion'] = $fila['descripcion'];
			  $jsondata['diagnostico'] = $diagnostico;

	 	}else{
	 		$jsondata['success'] = 0;
	 	}
	 	echo json_encode($jsondata);
	 	$mysqli->close();
	}


	public function cargarDatosregistroModificacion()
	{
		$mysqli =  new model();
		$jsondata = array();
       	$sql=$mysqli->query("SELECT 'accidente_trabajo.fiatep_at' FROM accidente_trabajo ;");

       	if ($mysqli->rowsQuery($sql)>0) {
	 		$jsondata['success'] = 1;
	 		$indice = 0;
	 		$fiatep_at = array();
	 		while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
				$fiatep_at[$indice] = $fila[0];
				$indice++;
			}
			$jsondata['fiatep_at'] = $fiatep_at;
			echo json_encode($jsondata);


	 	}else{
	 		$jsondata['success'] = 0;
	 		echo json_encode($jsondata);
	 	}

	 	$mysqli->close();


	}



	/**
	* Permite realizar modificaciones de un registro sobre una valoracion medica en la base de Datos
	*/
	public function editarValoracionMedica($obj, $id_at)
	{
		$mysqli =  new model();
		echo"UPDATE `valoracion_medica_at` SET `codigo_valoracion`='".$obj->get_codigo_valoracion()."',`dias_incapacidad`='".$obj->get_dias_incapacidad()."',`dias_prorroga`='".$obj->get_dias_prorroga()."',`observacion`='".$obj->get_observacion()."' WHERE identificador_at = $id_at ;";
		$sql=$mysqli->query("UPDATE `valoracion_medica_at` SET `codigo_valoracion`='".$obj->get_codigo_valoracion()."',`dias_incapacidad`='".$obj->get_dias_incapacidad()."',`dias_prorroga`='".$obj->get_dias_prorroga()."',`observacion`='".$obj->get_observacion()."' WHERE identificador_at = $id_at ;");

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
