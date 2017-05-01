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
	* los accidentes de trabajo
	*/
	class AccidenteTrabajoDAO{

	/**
	* Permite realizar un nuevo registro sobre un accidente de trabajo en la base de Datos
	*/
	public function registrarAccidenteTrabajo($obj)
	{
		$mysqli =  new model();
		$jsondata = array();
       	#validacion de tipo documento y numero
    $sql=$mysqli->query("SELECT * from accidente_trabajo  where fiatep_at = '".$obj->get_fiatep_at()."';");

		if ($mysqli->rowsQuery($sql)>0) {
	 	$jsondata['success'] = 0;
	 	echo json_encode($jsondata);
	 	}
	 	else {
	 	$sql= $mysqli->query("INSERT INTO accidente_trabajo (fiatep_at, identificador_empleado , fecha_at ,
			 jornada_at , muerte_em ,labor_habitual_em , tipo_at, zona_at, lugar_at, sitio_at, tipo_lesion_at,
			 parte_cuerpo_em, agente_at , mecanismo_at ,con_amb_peligrosa ,acto_inseguro) VALUES
			  ('".$obj->get_fiatep_at()."','".$obj->get_identificador_empleado()."','".$obj->get_fecha_at()."','"
				.$obj->get_jornada_at()."','".$obj->get_muerte_em()."','".$obj->get_labor_habitual_em()."','"
				.$obj->get_tipo_at()."','".$obj->get_zona_at()."','".$obj->get_lugar_at()."','".$obj->get_sitio_at().
				"','".$obj->get_tipo_lesion_at()."','".$obj->get_parte_cuerpo_em()."','".$obj->get_agente_at().
				"','".$obj->get_mecanismo_at()."','".$obj->get_con_amb_peligrosa()."','"
				.$obj->get_acto_inseguro()."');");
				$jsondata['success'] = 1;

		 	if ($mysqli->rowsOpe()>0) {
		 		$mysqli->close();
				$this->registrarAtCausaFactorPersonal($obj->get_causa_factor_personal(), $obj->get_fiatep_at());
				$this->registrarAtCausaFactorTrabajo($obj->get_causa_factor_trabajo(), $obj->get_fiatep_at());
				$this->registrarAtCausaActoSubestandar($obj->get_causa_acto_sub_subestandar(),$obj->get_fiatep_at());
				$this->registrarAtCausaCondAmbSub($obj->get_causa_cond_amb_sub(), $obj->get_fiatep_at());
		 		$jsondata['success'] = 1;
	 			echo json_encode($jsondata);
		 	} else {
		 		$mysqli->close();
		 		$jsondata['success'] = -1;
	 			echo json_encode($jsondata);
		 	}
	 	}
	}

	private function registrarAtCausaFactorPersonal($causa_factor_personal, $fiatep)
	{
		$mysqli =  new model();
		$size = sizeof($causa_factor_personal);
		for ($i=0; $i < $size ; $i++) {
			if($causa_factor_personal[$i] >= 0){
			$sql= $mysqli->query("INSERT INTO at_factor_personal (identificador_at, identificador_fp) VALUES ($fiatep , ".$causa_factor_personal[$i].");");
			$mysqli->liberar($sql);
			}
		}
		$mysqli->close();
	}

	private function registrarAtCausaFactorTrabajo($Causa_factor_trabajo, $fiatep)
	{
		$mysqli =  new model();
		$size = sizeof($Causa_factor_trabajo);
		for ($i=0; $i < $size ; $i++) {
			if($Causa_factor_trabajo[$i] >= 0){
			$sql= $mysqli->query("INSERT INTO at_factor_trabajo (identificador_at, identificador_ft) VALUES ( $fiatep, ".$Causa_factor_trabajo[$i].");");
			$mysqli->liberar($sql);
			}
		}
		$mysqli->close();
	}

	private function registrarAtCausaActoSubestandar($causa_acto_sub_subestandar, $fiatep)
	{
		$mysqli =  new model();
		$size = sizeof($causa_acto_sub_subestandar);
		for ($i=0; $i < $size ; $i++) {
			if($causa_acto_sub_subestandar[$i] >= 0){
			$sql= $mysqli->query("INSERT INTO at_acto_subestandar (identificador_at, identificador_as) VALUES ( $fiatep, ".$causa_acto_sub_subestandar[$i].");");
			$mysqli->liberar($sql);
			}
		}
		$mysqli->close();
	}

	private function registrarAtCausaCondAmbSub($causa_cond_amb_sub, $fiatep)
	{
		$mysqli =  new model();
		$size = sizeof($causa_cond_amb_sub);
		for ($i=0; $i < $size ; $i++) {
			if($causa_cond_amb_sub[$i] >= 0){
			$sql= $mysqli->query("INSERT INTO at_cond_amb_sub (identificador_at, identificador_cas) VALUES ($fiatep, ".$causa_cond_amb_sub[$i].");");
			$mysqli->liberar($sql);
			}
		}

		$mysqli->close();
	}

	/**
	* Permite consultar y obtener la informacion correspondiente a un accidente de trabajo de la base de Datos
	*/
	public function consultarAccidenteTrabajo($obj)
	{
		$mysqli =  new model();
		$jsondata = array();
       	#validacion de tipo documento y numero
        $sql=$mysqli->query("SELECT fiatep_at, centro_trabajo"."."."nombre_centro, empleado"."."."nombres_em,
				empleado"."."."apellido_em, empleado"."."."apellido_2_em, empleado"."."."numero_doc, accidente_trabajo"."."."fecha_at,
				accidente_trabajo"."."."jornada_at, accidente_trabajo"."."."muerte_em, accidente_trabajo"."."."labor_habitual_em,
				accidente_trabajo"."."."tipo_at,accidente_trabajo"."."."zona_at, accidente_trabajo"."."."lugar_at,
				accidente_trabajo"."."."sitio_at,lesion_at"."."."super_tipo_lesion, accidente_trabajo"."."."tipo_lesion_at,
				parte_cuerpo"."."."super_tipo_parte, accidente_trabajo"."."."parte_cuerpo_em, agente_at"."."."super_agente,
				accidente_trabajo"."."."agente_at, accidente_trabajo"."."."mecanismo_at,accidente_trabajo"."."."con_amb_peligrosa,
				accidente_trabajo"."."."acto_inseguro FROM accidente_trabajo JOIN empleado ON
				(accidente_trabajo"."."."identificador_empleado = empleado"."."."identificador_empleado)
				JOIN centro_trabajo ON (empleado.centro_trabajo = centro_trabajo"."."."identificador_centro )
				JOIN lesion_at ON (accidente_trabajo"."."."tipo_lesion_at = lesion_at"."."."identificador_lesion)
				JOIN parte_cuerpo ON (accidente_trabajo"."."."parte_cuerpo_em = parte_cuerpo"."."."identificador_parte_cuerpo)
				JOIN agente_at ON (accidente_trabajo"."."."agente_at = agente_at"."."."identificador_agente)
				WHERE fiatep_at =".$obj->get_fiatep_at().";");

       	if ($mysqli->rowsQuery($sql)) {
       		$datos= $sql->fetch_assoc();
       		$accidente_trabajo = array();
       		$accidente_trabajo['fiatep_at']=$datos['fiatep_at'];
       		$accidente_trabajo['nombre_centro']=$datos['nombre_centro'];
       		$accidente_trabajo['nombres_em']=$datos['nombres_em'];
       		$accidente_trabajo['apellido_em']=$datos['apellido_em'];
       		$accidente_trabajo['apellido_2_em']=$datos['apellido_2_em'];
       		$accidente_trabajo['numero_doc']=$datos['numero_doc'];
       		$time = date_create($datos['fecha_at']);
       		$accidente_trabajo['fecha_at']= date_format($time,"Y-m-d");
       		$accidente_trabajo['jornada_at']=$datos['jornada_at'];
       		$accidente_trabajo['muerte_em']=$datos['muerte_em'];
       		$accidente_trabajo['labor_habitual_em']=$datos['labor_habitual_em'];
       		$accidente_trabajo['tipo_at']=$datos['tipo_at'];
       		$accidente_trabajo['zona_at']=$datos['zona_at'];
       		$accidente_trabajo['lugar_at']=$datos['lugar_at'];
       		$accidente_trabajo['sitio_at']=$datos['sitio_at'];
       		$accidente_trabajo['super_tipo_lesion']=$datos['super_tipo_lesion'];
       		$accidente_trabajo['tipo_lesion_at']=$datos['tipo_lesion_at'];
       		$accidente_trabajo['super_tipo_parte']=$datos['super_tipo_parte'];
       		$accidente_trabajo['parte_cuerpo_em']=$datos['parte_cuerpo_em'];
       		$accidente_trabajo['super_agente']=$datos['super_agente'];
       		$accidente_trabajo['agente_at']=$datos['agente_at'];
       		$accidente_trabajo['mecanismo_at']=$datos['mecanismo_at'];
       		$accidente_trabajo['con_amb_peligrosa']=$datos['con_amb_peligrosa'];
       		$accidente_trabajo['acto_inseguro']=$datos['acto_inseguro'];



       		$jsondata['success'] = 1;
       		$jsondata['accidente_trabajo'] = $accidente_trabajo;
	 		$mysqli->close();
	 		// De las foraneas enviar numerito y nombre------
			$jsondata['paso3_1']=$this->consultarCusasFactorPersonalAT($obj->get_fiatep_at());
			$jsondata['paso3_2'] = $this->consultarCusasFactorTrabajoAT($obj->get_fiatep_at());
			$jsondata['paso4_1'] = $this->consultarCusasActoSubEstandarAT($obj->get_fiatep_at());
			$jsondata['paso4_2']	= $this->consultarCusasCondicionAmbientalSubEstandarAT($obj->get_fiatep_at());
			echo json_encode($jsondata);
	 	}else{
	 		$jsondata['success'] = 0;
			echo json_encode($jsondata);
			$mysqli->liberar($sql);
	 		$mysqli->close();
	 	}


	}

	private function consultarCusasFactorPersonalAT($fiatep)
	{
		$mysqli =  new model();

		$causa_factor_personal =array();
		$sql=$mysqli->query("SELECT causa_factor_personal"."."."identificador_fp,causa_factor_personal"."."."tipo_factor FROM at_factor_personal JOIN causa_factor_personal ON (at_factor_personal"."."."identificador_fp = causa_factor_personal"."."."identificador_fp) WHERE at_factor_personal"."."."identificador_at =  $fiatep ;");

		if ($mysqli->rowsQuery($sql)) {
	 		$causa_factor_personal['success'] = 1;
	 		$causa_factor_personal['Fisiologica_inadecuada'] = -1;
	 		$causa_factor_personal['Mental_psicologica_inadecuada'] = -1;
	 		$causa_factor_personal['Tension_fisica_fisiologica'] = -1;
	 		$causa_factor_personal['Tension_mental_psicologica'] = -1;
	 		$causa_factor_personal['Falta_conocimiento'] = -1;
	 		$causa_factor_personal['Falta_habilidad'] = -1;
	 		$causa_factor_personal['Motivacion_deficiente'] = -1;
	 		// Si una da las causas existe en la base de datos, se aññade en el vector de lo contrario, se envia -1 en la posicion indice con el nombre del  atributo
       		while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
       			if ($fila[1] == "Fisiologica inadecuada") {
       				$causa_factor_personal['Fisiologica_inadecuada'] = $fila[0];
       			} else if($fila[1] == "Mental/psicologica inadecuada"){
       				$causa_factor_personal['Mental_psicologica_inadecuada'] = $fila[0];
       			}else if($fila[1] == "Tension fisica o fisiologica"){
       				$causa_factor_personal['Tension_fisica_fisiologica'] = $fila[0];
       			}else if($fila[1] == "Tension mental o psicologica"){
       				$causa_factor_personal['Tension_mental_psicologica'] = $fila[0];
       			}else if($fila[1] == "Falta de conocimiento"){
       				$causa_factor_personal['Falta_conocimiento'] = $fila[0];
       			}else if($fila[1] == "Falta de habilidad"){
       				$causa_factor_personal['Falta_habilidad'] = $fila[0];
       			}else if($fila[1] == "Motivacion deficiente"){
       				$causa_factor_personal['Motivacion_deficiente'] = $fila[0];
						}
			}

	 	}else{
	 		$causa_factor_personal['success'] = 0;
	 	}

		$mysqli->liberar($sql);
	 	$mysqli->close();
	 	return $causa_factor_personal;
	}

	private function consultarCusasFactorTrabajoAT($fiatep)
	{
		$mysqli =  new model();
		$causa_factor_trabajo = array();
		$sql=$mysqli->query("SELECT causa_factor_trabajo"."."."identificador_ft, causa_factor_trabajo"."."."tipo_factor FROM at_factor_trabajo JOIN causa_factor_trabajo ON (at_factor_trabajo"."."."identificador_ft = causa_factor_trabajo"."."."identificador_ft) WHERE at_factor_trabajo"."."."identificador_at =  $fiatep ;");
		if ($mysqli->rowsQuery($sql)>0) {
	 		$causa_factor_trabajo['success'] = 1;
	 		$causa_factor_trabajo['Abuso_Maltrato'] =-1;
	 		$causa_factor_trabajo['Deficiencia_adquisiciones'] =-1;
	 		$causa_factor_trabajo['Estandares_deficientes_trabajo'] =-1;
	 		$causa_factor_trabajo['Herramientas_equipos_inadecuados'] =-1;
	 		$causa_factor_trabajo['Ingenieria_inadecuada'] =-1;
	 		$causa_factor_trabajo['Mantenimietno_deficiente'] =-1;
	 		$causa_factor_trabajo['Supervision_liderazgo_deficientes'] =-1;
	 		$causa_factor_trabajo['Uso_desgaste'] =-1;
       		while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
       			if ($fila[1] == "Abuso o Maltrato") {
       				$causa_factor_trabajo['Abuso_Maltrato'] = $fila[0];
       			} else if($fila[1] == "Deficiencia de las adquisiciones"){
       				$causa_factor_trabajo['Deficiencia_adquisiciones'] = $fila[0];
       			}else if($fila[1] == "Estandares deficientes de trabajo"){
       				$causa_factor_trabajo['Estandares_deficientes_trabajo'] = $fila[0];
       			}else if($fila[1] == "Herramientas y equipos inadecuados"){
       				$causa_factor_trabajo['Herramientas_equipos_inadecuados'] = $fila[0];
       			}else if($fila[1] == "Ingenieria inadecuada"){
       				$causa_factor_trabajo['Ingenieria_inadecuada'] = $fila[0];
       			}else if($fila[1] == "Mantenimietno deficiente"){
       				$causa_factor_trabajo['Mantenimietno_deficiente'] = $fila[0];
       			}else if($fila[1] == "Supervision y liderazgo deficientes"){
       				$causa_factor_trabajo['Supervision_liderazgo_deficientes'] = $fila[0];
       			}else if($fila[1] == "Uso o desgaste"){
       				$causa_factor_trabajo['Uso_desgaste'] = $fila[0];
       			}
			}

	 	}else{
	 		$causa_factor_trabajo['success'] = 0;
	 	}

		$mysqli->liberar($sql);
	 	$mysqli->close();
	 	return $causa_factor_trabajo;
	}

	private function consultarCusasActoSubEstandarAT($fiatep)
	{
		$mysqli =  new model();
		$causa_acto_subestandar =array();
		$sql=$mysqli->query("SELECT causa_acto_subestandar"."."."identificador_as , causa_acto_subestandar"."."."tipo_acto  FROM causa_acto_subestandar JOIN at_acto_subestandar ON (causa_acto_subestandar"."."."identificador_as = at_acto_subestandar"."."."identificador_as) WHERE at_acto_subestandar"."."."identificador_at = $fiatep ;");
		if ($mysqli->rowsQuery($sql)>0) {
	 		$causa_acto_subestandar['success'] = 1;
	 		$causa_acto_subestandar['adoptar_posicion_insegura'] = -1;
	 		$causa_acto_subestandar['Bromas'] = -1;
	 		$causa_acto_subestandar['Colocar_inseguramente'] = -1;
	 		$causa_acto_subestandar['Errores_conduccion'] = -1;
	 		$causa_acto_subestandar['Falta_de_atencion'] = -1;
	 		$causa_acto_subestandar['Hacer_inoperante_dispositivo_seguridad'] = -1;
	 		$causa_acto_subestandar['Limpieza_equipo_en_movimiento'] = -1;
	 		$causa_acto_subestandar['No_asegurar'] = -1;
	 		$causa_acto_subestandar['Omitir_uso_equipo_de_proteccion'] = -1;
	 		$causa_acto_subestandar['Opera_velocidades_inseguras'] = -1;
	 		$causa_acto_subestandar['Usar_equipo_Inseguro'] = -1;
	 		$causa_acto_subestandar['Uso_impropio_equipos'] = -1;
	 		$causa_acto_subestandar['Uso_impropio_manos'] = -1;

       		while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
       			if ($fila[1] === "adoptar posicion insegura") {
       				$causa_acto_subestandar['adoptar_posicion_insegura'] = $fila[0];
       			} else if($fila[1] === "Bromas"){
       				$causa_acto_subestandar['Bromas'] = $fila[0];
       			}else if($fila[1] === "Colocar inseguramente"){
       				$causa_acto_subestandar['Colocar_inseguramente'] = $fila[0];
       			}else if($fila[1] === "Errores conduccion"){
       				$causa_acto_subestandar['Errores_conduccion'] = $fila[0];
       			}else if($fila[1] === "Falta de atencion"){
       				$causa_acto_subestandar['Falta_de_atencion'] = $fila[0];
       			}else if($fila[1] === "Hacer inoperante dispositivo seguridad"){
       				$causa_acto_subestandar['Hacer_inoperante_dispositivo_seguridad'] = $fila[0];
       			}else if($fila[1] === "Limpieza equipo en movimiento"){
       				$causa_acto_subestandar['Limpieza_equipo_en_movimiento'] = $fila[0];
       			}else if($fila[1] === "No asegurar"){
       				$causa_acto_subestandar['No_asegurar'] = $fila[0];
       			}else if($fila[1] === "Omitir uso equipo de proteccion"){
       				$causa_acto_subestandar['Omitir_uso_equipo_de_proteccion'] = $fila[0];
       			}else if($fila[1] === "Opera velocidades inseguras"){
       				$causa_acto_subestandar['Opera_velocidades_inseguras'] = $fila[0];
       			}else if($fila[1] === "Usar equipo Inseguro"){
       				$causa_acto_subestandar['Usar_equipo_Inseguro'] = $fila[0];
       			}else if($fila[1] === "Uso impropio de equipos"){
       				$causa_acto_subestandar['Uso_impropio_equipos'] = $fila[0];
       			}else if($fila[1] === "Uso impropio manos"){
       				$causa_acto_subestandar['Uso_impropio_manos'] = $fila[0];
       			}
			}

	 	}else{
	 		$causa_acto_subestandar['success'] = 0;
	 	}
		$mysqli->liberar($sql);
	 	$mysqli->close();

	 	return $causa_acto_subestandar;
	}

	private function consultarCusasCondicionAmbientalSubEstandarAT($fiatep)
	{
		$mysqli =  new model();
		$causa_cond_amb_sub = array();
		$sql=$mysqli->query("SELECT causa_cond_amb_sub"."."."identificador_cas , causa_cond_amb_sub"."."."tipo_cond FROM causa_cond_amb_sub JOIN at_cond_amb_sub ON (causa_cond_amb_sub"."."."identificador_cas = at_cond_amb_sub"."."."identificador_cas) WHERE at_cond_amb_sub"."."."identificador_at = $fiatep ;");
		if ($mysqli->rowsQuery($sql)>0) {
	 		$causa_cond_amb_sub['success'] = 1;
	 		$causa_cond_amb_sub['Defecto_agente'] = -1;
	 		$causa_cond_amb_sub['Inadecuada_Proteccion'] = -1;
	 		$causa_cond_amb_sub['Metodos_peligrosos'] = -1;
	 		$causa_cond_amb_sub['Riesgos_ambientales'] = -1;
	 		$causa_cond_amb_sub['Riesgos_colocacion'] = -1;
	 		$causa_cond_amb_sub['Riesgos_ropa'] = -1;
	 		$causa_cond_amb_sub['Riesgos_publicos']=-1;
       		while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
       			if ($fila[1] === "Defecto agente") {
       				$causa_cond_amb_sub['Defecto_agente'] = $fila[0];
       			} else if($fila[1] === "Inadecuada Proteccion"){
       				$causa_cond_amb_sub['Inadecuada_Proteccion'] = $fila[0];
       			}else if($fila[1] === "Metodos peligrosos"){
       				$causa_cond_amb_sub['Metodos_peligrosos'] = $fila[0];
       			}else if($fila[1] === "Riesgos ambientales"){
       				$causa_cond_amb_sub['Riesgos_ambientales'] = $fila[0];
       			}else if($fila[1] === "Riesgos colocacion"){
       				$causa_cond_amb_sub['Riesgos_colocacion'] = $fila[0];
       			}else if($fila[1] === "Riesgos por la ropa"){
       				$causa_cond_amb_sub['Riesgos_ropa'] = $fila[0];
       			}else if($fila[1] === "Riesgos publicos"){
       				$causa_cond_amb_sub['Riesgos_publicos'] = $fila[0];
       			}

			}

	 	}else{
	 		$causa_cond_amb_sub['success'] = 0;
	 	}

		$mysqli->liberar($sql);
	 	$mysqli->close();
	 	return $causa_cond_amb_sub;
	}


	public function obtenerSubTipoLesionAt($tipo){

		$mysqli =  new model();
		$jsondata = array();
       	$sql=$mysqli->query("SELECT identificador_lesion, nombre_lesion FROM lesion_at WHERE super_tipo_lesion = $tipo ;");

       	if ($mysqli->rowsQuery($sql)>0) {
       		$jsondata['success'] = 1;
       		$tipo_lesion_at = array();
       		$indice = 0;
       		while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
       			$sub_tipo_lesion_at = array();
				$sub_tipo_lesion_at['identificador_lesion']=$fila[0];
				$sub_tipo_lesion_at['nombre_lesion']=$fila[1];
				$tipo_lesion_at[$indice] = $sub_tipo_lesion_at;
				$indice++;
			}
			$jsondata['tipo_lesion_at'] = $tipo_lesion_at;
			

	 	}else{
	 		$jsondata['success'] = 0;
	 		
	 	}
	 	$mysqli->liberar($sql);
	 	$mysqli->close();
		return $jsondata;
	}

	public function obtenerSubTipoParteCuerpo($tipo){

		$mysqli =  new model();
		$jsondata = array();
       	$sql=$mysqli->query("SELECT identificador_parte_cuerpo, nombre_parte_cuerpo FROM parte_cuerpo WHERE super_tipo_parte = $tipo ;");

       	if ($mysqli->rowsQuery($sql)>0) {
	 		$jsondata['success'] = 1;
       		$parte_cuerpo = array();
       		$indice = 0;
       		while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
       			$sub_tipo_parte_cuerpo = array();
				$sub_tipo_parte_cuerpo['identificador_parte_cuerpo']=$fila[0];
				$sub_tipo_parte_cuerpo['nombre_parte_cuerpo']=$fila[1];
				$parte_cuerpo[$indice] = $sub_tipo_parte_cuerpo;
				$indice++;
			}
			$jsondata['parte_cuerpo'] = $parte_cuerpo;
			

	 	}else{
	 		$jsondata['success'] = 0;
	 		
	 	}
	 	$mysqli->liberar($sql);
	 	$mysqli->close();
		return $jsondata;
	}

	public function obtenerSubTipoAgenteAt($tipo){

		$mysqli =  new model();
		$jsondata = array();

    $sql=$mysqli->query("SELECT identificador_agente, nombre_agente FROM agente_at WHERE super_agente = $tipo ;");

    	if ($mysqli->rowsQuery($sql)>0) {
	 	    $jsondata['success'] = 1;
     		$agente_at = array();
     		$indice = 0;
       	while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
       	$sub_tipo_agente_at = array();
				$sub_tipo_agente_at['identificador_agente']=$fila[0];
				$sub_tipo_agente_at['nombre_agente']=$fila[1];
				$agente_at[$indice] = $sub_tipo_agente_at;
				$indice++;
			}
			$jsondata['agente_at'] = $agente_at;
			

	 	}else{
	 		$jsondata['success'] = 0;
	 		
	 	}
	 	$mysqli->liberar($sql);
	 	$mysqli->close();
		return $jsondata;

	}

	/**
	* Carga todos los sitios contenidos en la base de datos
	*  @return vector
	**/

	public function cargarSitioAccidente()
	{
		$mysqli =  new model();
		$sitio_accidente = array();
		$sql=$mysqli->query("SELECT identificador_sitio, nombre_sitio FROM sitio_accidente ;");
		$indice=0;
		while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
       			$tipo = array();
				$tipo['identificador_sitio']=$fila[0];
				$tipo['nombre_sitio']=$fila[1];
				$sitio_accidente[$indice] = $tipo;
				$indice++;
			}
		$mysqli->liberar($sql);
	 	$mysqli->close();
	 	return $sitio_accidente;
	}

	/*
	* Carga todos los Tipos de Accidentes contenidos en la base de datos
	 @return vecto
	**/
	public function cargarTipoAccidente()
	{
		$mysqli =  new model();
		$tipo_accidente = array();
		$sql=$mysqli->query("SELECT identificador_tipo, tipo_at FROM tipo_accidente ;");
		$indice=0;
		while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
       			$tipo = array();
				$tipo['identificador_tipo']=$fila[0];
				$tipo['tipo_at']=$fila[1];
				$tipo_accidente[$indice] = $tipo;
				$indice++;
			}
		$mysqli->liberar($sql);
	 	$mysqli->close();
	 	return $tipo_accidente;
	}

	/**
	* Carga todos los mecanismos contenidos en la base de datos
	* @return vector
	*/
	public function cargarMecanismo()
	{
		$mysqli =  new model();
		$mecanismo = array();
		$sql=$mysqli->query("SELECT identificador_mecanismo , nombre_mecanismo FROM mecanismo_at;");
		$indice=0;
		while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
       			$tipo = array();
				$tipo['identificador_mecanismo']=$fila[0];
				$tipo['nombre_mecanismo']=$fila[1];
				$mecanismo[$indice] = $tipo;
				$indice++;
			}
		$mysqli->liberar($sql);
	 	$mysqli->close();
	 	return $mecanismo;
	}

	/**
	* Carga todos los Tipos condiciones ambientales contenidos en la base de datos
	* @return vector
	**/
	public function cargarCondicionAmbiental()
	{
		$mysqli =  new model();
		$condicion_ambiental = array();
		$sql=$mysqli->query("SELECT identificador_cond_amb, nombre_cond_amb FROM condicion_ambiental ;");
		$indice=0;
		while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
       			$tipo = array();
				$tipo['identificador_cond_amb']=$fila[0];
				$tipo['nombre_cond_amb']=$fila[1];
				$condicion_ambiental[$indice] = $tipo;
				$indice++;
			}
		$mysqli->liberar($sql);
	 	$mysqli->close();
	 	return $condicion_ambiental;
	}

	/*
	* Carga todos los Tipos de Actos Inseguros en la base de datos
	 @return vecto
	**/
	public function cargarActoInseguro()
	{
		$mysqli =  new model();
		$acto_inseguro = array();
		$indice=0;
		$sql=$mysqli->query("SELECT identificador_ai, nombre_ai FROM acto_inseguro ;");
		while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
       			$tipo = array();
				$tipo['identificador_ai']=$fila[0];
				$tipo['nombre_ai']=$fila[1];
				$acto_inseguro[$indice] = $tipo;
				$indice++;
			}
		$mysqli->liberar($sql);
	 	$mysqli->close();
	 	return $acto_inseguro;
	}

	/**
	* Permite realizar modificaciones de un registro sobre un accidente de trabajo en la base de Datos
	*/
	public function editarAccidenteTrabajo($obj, $id_fiatep)
	{
		$mysqli =  new model();

		$sql=$mysqli->query("UPDATE `accidente_trabajo` SET `fiatep_at`='".$obj->get_fiatep_at()."',`identificador_empleado`='".$obj->get_identificador_empleado()."',`fecha_at`='".$obj->get_fecha_at()."',`jornada_at`='".$obj->get_jornada_at()."',`muerte_em`='".$obj->get_muerte_em()."',`labor_habitual_em`='".$obj->get_labor_habitual_em()."',`tipo_at`='".$obj->get_tipo_at()."',`zona_at`='".$obj->get_zona_at()."',`lugar_at`='".$obj->get_lugar_at()."',`sitio_at`='".$obj->get_sitio_at()."',`tipo_lesion_at`='".$obj->get_tipo_lesion_at()."',`parte_cuerpo_em`='".$obj->get_parte_cuerpo_em()."',`agente_at`='".$obj->get_agente_at()."',`mecanismo_at`='".$obj->get_mecanismo_at()."',`con_amb_peligrosa`='".$obj->get_con_amb_peligrosa()."',`acto_inseguro`='".$obj->get_acto_inseguro()."' WHERE  fiatep_at = '$id_fiatep';");

		if ($mysqli->rowsOpe()>0) {
			$mysqli->close();
			$this->eliminarATCausas($obj->get_fiatep_at());
			$this->registrarAtCausaFactorPersonal($obj->get_causa_factor_personal(), $id_fiatep);
	 		$this->registrarAtCausaFactorTrabajo($obj->get_causa_factor_trabajo(), $id_fiatep);
	 		$this->registrarAtCausaActoSubestandar($obj->get_causa_acto_sub_subestandar(),$id_fiatep);
	 		$this->registrarAtCausaCondAmbSub($obj->get_causa_cond_amb_sub(), $id_fiatep);
	 		$jsondata['success'] = 1;
 			echo json_encode($jsondata);
	 	} else {
	 		$jsondata['success'] = -1;
			echo json_encode($jsondata);
	 	}


	}

	private function eliminarATCausas($fiatep)
	{
		$mysqli =  new model();
		$sql1=$mysqli->query("DELETE FROM `at_factor_personal` WHERE identificador_at = $fiatep;");
		$sql2=$mysqli->query("DELETE FROM `at_factor_trabajo` WHERE identificador_at = $fiatep;");
		$sql3=$mysqli->query("DELETE FROM `at_acto_subestandar` WHERE identificador_at = $fiatep;");
		$sql4=$mysqli->query("DELETE FROM `at_cond_amb_sub` WHERE identificador_at = $fiatep;");
		$mysqli->close();
	}

	public function listarFiatepAccidenteTrabajo($id_empresa)
	{		
		$mysqli =  new model();
		$jsondata = array();
  	$sql=$mysqli->query("SELECT fiatep_at FROM accidente_trabajo JOIN empleado ON (accidente_trabajo"."."."identificador_empleado = empleado"."."."identificador_empleado) JOIN centro_trabajo ON (empleado"."."."centro_trabajo = centro_trabajo"."."."identificador_centro) JOIN empresa ON (centro_trabajo"."."."identificador_empresa = empresa"."."."identificador_empresa) WHERE empresa"."."."identificador_empresa =".$id_empresa);

      if ($mysqli->rowsQuery($sql)) {
	 		$jsondata['success'] = 1;
	 		$indice = 0;
	 		$fiatep_at = array();
	 		while ($fila = $sql->fetch_array(MYSQLI_NUM)) {
				$fiatep_at[$indice] = $fila[0];
				$indice++;
			}
			$jsondata['fiatep_at'] = $fiatep_at;
			
	 	}else{
	 		$jsondata['success'] = 0;	 			 	
	 	}	 
	 	$mysqli->close();
	 	return $jsondata;
	}

	/**
 	* Estadistica 1 - Variable del AT en un rango de fechas
 	$nom_tabla, $nom_id_tabla, $nom_var_tabla, $nom_var_at, $fecha1, $fecha2
  	*/
	public function estadisticaVariablexFechas( $id_empresa ,$nom_tabla, $id_nombre, $nom_var ,$var_at , $fecha1, $fecha2)
	{
		$mysqli =  new model();
		$jsondata = array();
		 if($var_at =="jornada_at" || $var_at =="muerte_em" ||$var_at =="labor_habitual_em" || $var_at =="zona_at" || $var_at =="lugar_at" ){

		 	$sql=$mysqli->query("SELECT accidente_trabajo"."."."$var_at , COUNT(fiatep_at)  FROM accidente_trabajo join empleado ON (accidente_trabajo"."."."identificador_empleado = empleado"."."."identificador_empleado) JOIN centro_trabajo ON (empleado"."."."centro_trabajo = centro_trabajo.identificador_centro) JOIN empresa ON (centro_trabajo"."."."identificador_empresa = empresa"."."."identificador_empresa) WHERE fecha_at BETWEEN '$fecha1' AND '$fecha2' AND empresa"."."."identificador_empresa = $id_empresa GROUP BY accidente_trabajo"."."."$var_at ;");
			
		}else{
			$sql=$mysqli->query("SELECT $nom_tabla"."."."$nom_var , COUNT(fiatep_at)  FROM accidente_trabajo JOIN $nom_tabla ON (accidente_trabajo"."."."$var_at"." = "."$nom_tabla"."."."$id_nombre) JOIN empleado ON (accidente_trabajo"."."."identificador_empleado = empleado"."."."identificador_empleado) JOIN centro_trabajo on (empleado"."."."centro_trabajo = centro_trabajo"."."."identificador_centro) JOIN empresa ON (centro_trabajo"."."."identificador_empresa = empresa"."."."identificador_empresa) WHERE fecha_at BETWEEN '$fecha1' AND '$fecha2' AND empresa"."."."identificador_empresa = $id_empresa GROUP BY accidente_trabajo"."."."$var_at;");
		}

		if ($mysqli->rowsQuery($sql)) {
				$jsondata['success'] = 1;
				//
				$variablesG = array();
				$variablesT = array();
				$xy = array();
				$xy[0] = "Tipo de Varible en un Rango de Fechas";
				$xy[1] = 'Numero de Accidentes';
				$variablesG[0] = $xy;
				$indice = 1;
				$indice2 = 0;
			while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
				$variableG = array();
				//$variableT = array();
				$variablesT[$indice2] = $x = array(0 => $fila[0], 1 => $x2 = array('v' => $fila[1]-0, 'f' => $fila[1].'' ) );
				$variableG[0] = $fila[0];
				$variableG[1] = $fila[1]-0;
				$variablesG[$indice] = $variableG;
				$indice++;
				$indice2++;
			}

			$jsondata['grafica'] =$variablesG;
			$jsondata['tabla'] = $variablesT;
			echo json_encode($jsondata);

		}else{
			$jsondata['success'] = 0;
			echo json_encode($jsondata);
		}

			$mysqli->close();

	}

	/**
  	* Estadistica 2 - Variable del AT en uno o varios centros de trabajo
  	$nom_tabla, $nom_id_tabla, $nom_var_tabla, $nom_var_at, $id_centro
  	*/
	public function estadisticaVariablexCentros( $id_empresa, $nom_tabla, $id_nombre,  $nom_var , $var_at ,$id_centro)
	{
		$mysqli =  new model();
		$jsondata = array();
		if($id_centro>0){
			if($var_at =="jornada_at" || $var_at =="muerte_em" ||$var_at =="labor_habitual_em" || $var_at =="zona_at" || $var_at =="lugar_at" ){

				$sql=$mysqli->query("SELECT accidente_trabajo"."."."$var_at , COUNT(fiatep_at) FROM accidente_trabajo JOIN empleado ON (accidente_trabajo"."."."identificador_empleado = empleado"."."."identificador_empleado) JOIN centro_trabajo on (empleado"."."."centro_trabajo = centro_trabajo"."."."identificador_centro) JOIN empresa ON (centro_trabajo"."."."identificador_empresa = empresa"."."."identificador_empresa) WHERE  empresa"."."."identificador_empresa = $id_empresa AND centro_trabajo"."."."identificador_centro = $id_centro GROUP BY accidente_trabajo"."."."$var_at;");

				
			}else{
				$sql=$mysqli->query("SELECT $nom_tabla"."."."$nom_var, COUNT(fiatep_at) FROM accidente_trabajo JOIN $nom_tabla ON (accidente_trabajo"."."."$var_at"." = "."$nom_tabla"."."."$id_nombre) JOIN empleado ON (accidente_trabajo"."."."identificador_empleado = empleado"."."."identificador_empleado) JOIN centro_trabajo ON (empleado"."."."centro_trabajo = centro_trabajo"."."."identificador_centro) JOIN empresa ON (centro_trabajo"."."."identificador_empresa = empresa"."."."identificador_empresa) WHERE empresa"."."."identificador_empresa = $id_empresa AND centro_trabajo"."."."identificador_centro = $id_centro GROUP BY accidente_trabajo"."."."$var_at;");
			}

		}else{

			if($var_at =="jornada_at" || $var_at =="muerte_em" ||$var_at =="labor_habitual_em" || $var_at =="zona_at" || $var_at =="lugar_at" ){

				$sql=$mysqli->query("SELECT accidente_trabajo"."."."$var_at , COUNT(fiatep_at) FROM accidente_trabajo JOIN empleado ON (accidente_trabajo"."."."identificador_empleado = empleado"."."."identificador_empleado) JOIN centro_trabajo on (empleado"."."."centro_trabajo = centro_trabajo"."."."identificador_centro) JOIN empresa ON (centro_trabajo"."."."identificador_empresa = empresa"."."."identificador_empresa) WHERE  empresa"."."."identificador_empresa = $id_empresa GROUP BY accidente_trabajo"."."."$var_at;");

			}else{
				$sql=$mysqli->query("SELECT $nom_tabla"."."."$nom_var , COUNT(fiatep_at)  FROM accidente_trabajo JOIN $nom_tabla ON (accidente_trabajo"."."."$var_at"." = "."$nom_tabla"."."."$id_nombre) JOIN empleado ON (accidente_trabajo"."."."identificador_empleado = empleado"."."."identificador_empleado) JOIN centro_trabajo on (empleado"."."."centro_trabajo = centro_trabajo"."."."identificador_centro) JOIN empresa ON (centro_trabajo"."."."identificador_empresa = empresa"."."."identificador_empresa) WHERE  empresa"."."."identificador_empresa = $id_empresa GROUP BY accidente_trabajo"."."."$var_at;");
			}
		}

		if ($mysqli->rowsQuery($sql)) {
				$jsondata['success'] = 1;
				//
				$variablesG = array();
				$variablesT = array();
				$xy = array();
				$xy[0] = "Tipo de Varible por centro(s)";
				$xy[1] = 'Numero de Accidentes';
				$variablesG[0] = $xy;
				$indice = 1;
				$indice2 = 0;
			while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
				$variableG = array();
				//$variableT = array();
				$variablesT[$indice2] = $x = array(0 => $fila[0], 1 => $x2 = array('v' => $fila[1]-0, 'f' => $fila[1].'' ) );
				$variableG[0] = $fila[0];
				$variableG[1] = $fila[1]-0;
				$variablesG[$indice] = $variableG;
				$indice++;
				$indice2++;
			}

			$jsondata['grafica'] =$variablesG;
			$jsondata['tabla'] = $variablesT;
			echo json_encode($jsondata);

		}else{
			$jsondata['success'] = 0;
			echo json_encode($jsondata);
		}

			$mysqli->close();

	}

	/**
    * Estadistica 3 - Variable del AT en uno o varios centros de trabajo y en un rango de fechas
    $nom_tabla, $nom_id_tabla, $nom_var_tabla, $nom_var_at, $id_centro, $fecha1, $fecha2
    */
	public function estadisticaVariablexFechasCentros( $id_empresa, $nom_tabla, $id_nombre, $nom_var , $var_at , $id_centro, $fecha1, $fecha2)
	{

		$mysqli =  new model();
		$jsondata = array();
		if($id_centro>0){
			if($var_at =="jornada_at" || $var_at =="muerte_em" ||$var_at =="labor_habitual_em" || $var_at =="zona_at" || $var_at =="lugar_at" ){

				$sql=$mysqli->query("SELECT accidente_trabajo"."."."$var_at , COUNT(fiatep_at) FROM accidente_trabajo  JOIN empleado ON (accidente_trabajo"."."."identificador_empleado = empleado"."."."identificador_empleado) JOIN centro_trabajo on (empleado"."."."centro_trabajo = centro_trabajo"."."."identificador_centro) JOIN empresa ON (centro_trabajo"."."."identificador_empresa = empresa"."."."identificador_empresa) WHERE  empresa"."."."identificador_empresa = $id_empresa AND centro_trabajo"."."."identificador_centro = $id_centro AND fecha_at BETWEEN '$fecha1' AND '$fecha2' GROUP BY accidente_trabajo"."."."$var_at;");

			}else{

			$sql=$mysqli->query("SELECT $nom_tabla"."."."$nom_var, COUNT(fiatep_at) FROM accidente_trabajo JOIN $nom_tabla ON (accidente_trabajo"."."."$var_at"." = "."$nom_tabla"."."."$id_nombre) JOIN empleado ON (accidente_trabajo"."."."identificador_empleado = empleado"."."."identificador_empleado) JOIN centro_trabajo on (empleado"."."."centro_trabajo = centro_trabajo"."."."identificador_centro) JOIN empresa ON (centro_trabajo"."."."identificador_empresa = empresa"."."."identificador_empresa) WHERE  empresa"."."."identificador_empresa = $id_empresa AND centro_trabajo"."."."identificador_centro = $id_centro AND fecha_at BETWEEN '$fecha1' AND '$fecha2' GROUP BY accidente_trabajo"."."."$var_at;");
			}

		}else{

			if($var_at =="jornada_at" || $var_at =="muerte_em" ||$var_at =="labor_habitual_em" || $var_at =="zona_at" || $var_at =="lugar_at" ){

				$sql=$mysqli->query("SELECT accidente_trabajo"."."."$var_at , COUNT(fiatep_at) FROM accidente_trabajo JOIN empleado ON (accidente_trabajo"."."."identificador_empleado = empleado"."."."identificador_empleado) JOIN centro_trabajo on (empleado"."."."centro_trabajo = centro_trabajo"."."."identificador_centro) JOIN empresa ON (centro_trabajo"."."."identificador_empresa = empresa"."."."identificador_empresa) WHERE  empresa"."."."identificador_empresa = $id_empresa AND fecha_at BETWEEN '$fecha1' AND '$fecha2' GROUP BY accidente_trabajo"."."."$var_at;");

			}else{
			$sql=$mysqli->query("SELECT $nom_tabla"."."."$nom_var , COUNT(fiatep_at)  FROM accidente_trabajo JOIN $nom_tabla ON (accidente_trabajo"."."."$var_at"." = "."$nom_tabla"."."."$id_nombre) JOIN empleado ON (accidente_trabajo"."."."identificador_empleado = empleado"."."."identificador_empleado) JOIN centro_trabajo on (empleado"."."."centro_trabajo = centro_trabajo"."."."identificador_centro) JOIN empresa ON (centro_trabajo"."."."identificador_empresa = empresa"."."."identificador_empresa) WHERE  empresa"."."."identificador_empresa = $id_empresa AND fecha_at BETWEEN '$fecha1' AND '$fecha2' GROUP BY accidente_trabajo"."."."$var_at;");
			}

		}

		if ($mysqli->rowsQuery($sql)) {
				$jsondata['success'] = 1;
				//
				$variablesG = array();
				$variablesT = array();
				$xy = array();
				$xy[0] = "Tipo de Varible por centro(s) en un rango de fechas";
				$xy[1] = 'Numero de Accidentes';
				$variablesG[0] = $xy;
				$indice = 1;
				$indice2 = 0;
			while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
				$variableG = array();
				//$variableT = array();
				$variablesT[$indice2] = $x = array(0 => $fila[0], 1 => $x2 = array('v' => $fila[1]-0, 'f' => $fila[1].'' ) );
				$variableG[0] = $fila[0];
				$variableG[1] = $fila[1]-0;
				$variablesG[$indice] = $variableG;
				$indice++;
				$indice2++;
			}

			$jsondata['grafica'] =$variablesG;
			$jsondata['tabla'] = $variablesT;
			echo json_encode($jsondata);

		}else{
			$jsondata['success'] = 0;
			echo json_encode($jsondata);
		}

			$mysqli->close();

	}

	/**
	* Estadistica 4
	*/

	public function estadisticaCantidadATxFechas($id_empresa, $fecha1, $fecha2)
	{
		$mysqli =  new model();
		$jsondata = array();

		$sql=$mysqli->query("SELECT COUNT(fiatep_at) as cantidad_at FROM accidente_trabajo  JOIN empleado ON (accidente_trabajo"."."."identificador_empleado = empleado"."."."identificador_empleado) JOIN centro_trabajo on (empleado"."."."centro_trabajo = centro_trabajo"."."."identificador_centro) JOIN empresa ON (centro_trabajo"."."."identificador_empresa = empresa"."."."identificador_empresa) WHERE  empresa"."."."identificador_empresa = $id_empresa AND fecha_at BETWEEN '".$fecha1."' AND '".$fecha2."';");


		if ($mysqli->rowsQuery($sql)) {

			$cant = $mysqli->query("SELECT COUNT(fiatep_at) as total_at FROM accidente_trabajo JOIN empleado ON (accidente_trabajo"."."."identificador_empleado = empleado"."."."identificador_empleado) JOIN centro_trabajo ON (empleado"."."."centro_trabajo = centro_trabajo"."."."identificador_centro) JOIN empresa ON (centro_trabajo"."."."identificador_empresa = empresa"."."."identificador_empresa) WHERE  empresa"."."."identificador_empresa = $id_empresa;");
			$fila= $sql->fetch_assoc();
			$datos= $cant->fetch_assoc();

			//Datos para la grafica
			$acciG = array(0 => $xy = array(0 => 'Fechas', 1 => 'Numero de Accidentes'),
			1 => $at = array(0 => 'Accidentes en Rango de Fechas', 1 => $fila['cantidad_at']-0),
		 	2 => $at2 = array(0 => 'Accidentes Fuera de Rango de Fechas', 1 => $datos['total_at']-$fila['cantidad_at']));
			$jsondata['success'] = 1;
			$jsondata['grafica'] = $acciG;

			//Datos para la tabla
			$acciT = array(0 => $at = array(0 => 'Accidentes en Rango de Fechas',
			1 => $x = array('v' => $fila['cantidad_at']-0 , 'f' =>$fila['cantidad_at'])),
			1 => $at2 = array(0 => 'Accidentes Fuera de Rango de Fechas',
			1 => $y = array('v' => $datos['total_at']-$fila['cantidad_at'], 'f' =>$datos['total_at']-$fila['cantidad_at'].'')));
			$jsondata['tabla'] = $acciT;
			echo json_encode($jsondata);
		}else{
			$jsondata['success'] = 0;
	 		echo json_encode($jsondata);
		}
		$mysqli->close();
	}



	/**
	* Estadistica 5
	*/

	public function estadisticaCantidadATxCentros($id_empresa, $id_centro)
	{
		$mysqli =  new model();
		$jsondata = array();

		if($id_centro == 0){

			
			$sql=$mysqli->query("SELECT  centro_trabajo"."."."nombre_centro , COUNT(fiatep_at)
			FROM accidente_trabajo JOIN empleado ON (empleado"."."."identificador_empleado=accidente_trabajo"."."."identificador_empleado)
			JOIN centro_trabajo ON (empleado"."."."centro_trabajo=centro_trabajo"."."."identificador_centro) JOIN empresa ON (centro_trabajo"."."."identificador_empresa = empresa"."."."identificador_empresa) WHERE  empresa"."."."identificador_empresa = $id_empresa GROUP BY centro_trabajo"."."."nombre_centro");

			if ($mysqli->rowsQuery($sql)) {
				$jsondata['success'] = 1;

				//Datos para la grafica y Tabla
				$centrosG = array();
				$centrosT = array();
				$xy = array();
				$xy[0] = 'Centros de Trabajo';
				$xy[1] = 'Numero de Accidentes';
				$centrosG[0] =  $xy;
				$indice = 1;
				$indice2 = 0;

				while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
					$centroG = array();
					$centroT = array();
					$centrosT[$indice2] = $x = array(0 => $fila[0], 1 => $x2 = array('v' => $fila[1]-0, 'f' => $fila[1].'' ) );
					$centroG[0] = $fila[0];
					$centroG[1] = $fila[1]-0;
					$centrosG[$indice] = $centroG;
					$indice++;
					$indice2++;
				}
				$jsondata['grafica'] =$centrosG;
				$jsondata['tabla'] = $centrosT;
				echo json_encode($jsondata);
			} else {
				$jsondata['success'] = 0;
	 			echo json_encode($jsondata);
			}

		}else{
			
			$sql=$mysqli->query("SELECT centro_trabajo"."."."nombre_centro as nombre_centro, COUNT(fiatep_at) as cantidad_at
			FROM accidente_trabajo JOIN empleado ON (accidente_trabajo"."."."identificador_empleado = empleado.identificador_empleado)
			JOIN centro_trabajo ON (empleado"."."."centro_trabajo = centro_trabajo"."."."identificador_centro)
			WHERE centro_trabajo"."."."identificador_centro = $id_centro ;");

			if ($mysqli->rowsQuery($sql)) {
				//Obtener el total de accidentes de la empresa minera
				$cant = $mysqli->query("SELECT COUNT(fiatep_at) as total_at FROM accidente_trabajo JOIN empleado ON (accidente_trabajo"."."."identificador_empleado = empleado"."."."identificador_empleado) JOIN centro_trabajo on (empleado"."."."centro_trabajo = centro_trabajo"."."."identificador_centro) JOIN empresa ON (centro_trabajo"."."."identificador_empresa = empresa"."."."identificador_empresa) WHERE  empresa"."."."identificador_empresa = $id_empresa;");
				$jsondata['success'] = 1;
				$fila=$sql->fetch_assoc();
				$dato=$cant->fetch_assoc();
				//Datos para grafica
				$centrosG = array(0 =>  $xy = array(0 =>  'Centros de Trabajo', 1 => 'Numero de Accidentes'),
					1	=> $centro = array(0 =>  $fila['nombre_centro'], 1 => $fila['cantidad_at']-0),
					2   => $centroCant = array(0 => 'Otros Centros', 1 => $dato['total_at']-$fila['cantidad_at']));

				$jsondata['grafica'] =$centrosG;

				//Datos para tabla
				$centrosT = array(0 =>  $x = array(0 => $fila['nombre_centro'] ,
				 	1 => $w = array('v' => $fila['cantidad_at']-0, 'f' => $fila['cantidad_at'] .'' )),
					1 => $s = array(0 => 'Otros Centro', 1 => $d = array('v' => $dato['total_at']-$fila['cantidad_at'], 'f' => $dato['total_at']-$fila['cantidad_at'] .'' )));

				$jsondata['tabla'] =$centrosT;
				echo json_encode($jsondata);
			} else {
				$jsondata['success'] = 0;
	 			echo json_encode($jsondata);
			}
		}
		$mysqli->close();
	}

	/**
	* Estadistica 6
	*/

	public function estadisticaCantidadATxFechasCentros($id_empresa, $id_centro, $fecha1, $fecha2)
	{
		$mysqli =  new model();
		$jsondata = array();
		if($id_centro == 0){
			
			$sql=$mysqli->query("SELECT  centro_trabajo"."."."nombre_centro as nombre_centro, COUNT(fiatep_at) as cantidad_at
			FROM accidente_trabajo JOIN empleado ON (empleado"."."."identificador_empleado=accidente_trabajo"."."."identificador_empleado)
			JOIN centro_trabajo ON (empleado"."."."centro_trabajo=centro_trabajo"."."."identificador_centro) JOIN empresa ON (centro_trabajo"."."."identificador_empresa = empresa"."."."identificador_empresa) WHERE  empresa"."."."identificador_empresa = $id_empresa AND accidente_trabajo"."."."fecha_at
			BETWEEN '".$fecha1."' AND '".$fecha2."' GROUP BY centro_trabajo"."."."nombre_centro");

			if ($mysqli->rowsQuery($sql)) {
				$jsondata['success'] = 1;

				//Datos para la grafica y Tabla
				$centrosG = array();
				$centrosT = array();
				$xy = array();
				$xy[0] = 'Centros de Trabajo';
				$xy[1] = 'Numero de Accidentes';
				$centrosG[0] =  $xy;
				$indice = 1;
				$indice2 = 0;

				while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
					$centroG = array();
					$centroT = array();
					$centrosT[$indice2] = $x = array(0 => $fila[0], 1 => $x2 = array('v' => $fila[1]-0, 'f' => $fila[1].'' ) );
					$centroG[0] = $fila[0];
					$centroG[1] = $fila[1]-0;
					$centrosG[$indice] = $centroG;
					$indice++;
					$indice2++;
				}
				$jsondata['grafica'] =$centrosG;
				$jsondata['tabla'] = $centrosT;
				echo json_encode($jsondata);
			} else {
				$jsondata['success'] = 0;
	 			echo json_encode($jsondata);
			}

		}else{
			
			$sql=$mysqli->query("SELECT centro_trabajo"."."."nombre_centro as nombre_centro, COUNT(fiatep_at) as cantidad_at FROM accidente_trabajo JOIN empleado ON (accidente_trabajo"."."."identificador_empleado = empleado.identificador_empleado) JOIN centro_trabajo ON (empleado"."."."centro_trabajo = centro_trabajo"."."."identificador_centro) JOIN empresa ON (centro_trabajo"."."."identificador_empresa = empresa"."."."identificador_empresa) WHERE  empresa"."."."identificador_empresa = $id_empresa AND centro_trabajo"."."."identificador_centro = $id_centro AND accidente_trabajo"."."."fecha_at
			BETWEEN '".$fecha1."' AND '".$fecha2."';");

			if ($mysqli->rowsQuery($sql)) {
				$cant = $mysqli->query("SELECT COUNT(fiatep_at) as total_at FROM accidente_trabajo JOIN empleado ON (accidente_trabajo"."."."identificador_empleado = empleado.identificador_empleado) JOIN centro_trabajo ON (empleado"."."."centro_trabajo = centro_trabajo"."."."identificador_centro) JOIN empresa ON (centro_trabajo"."."."identificador_empresa = empresa"."."."identificador_empresa) WHERE  empresa"."."."identificador_empresa = $id_empresa ;");
				$jsondata['success'] = 1;
				$fila=$sql->fetch_assoc();
				$dato=$cant->fetch_assoc();
				//Datos para grafica
				$centrosG = array(0 =>  $xy = array(0 =>  'Centros de Trabajo', 1 => 'Numero de Accidentes'),
				1	=> $centro = array(0 =>  $fila['nombre_centro'], 1 => $fila['cantidad_at']-0),
				2 => $centroCant = array(0 => 'Otros Centros', 1 => $dato['total_at']-$fila['cantidad_at']));

				$jsondata['grafica'] =$centrosG;

				//Datos para tabla
				$centrosT = array(0 =>  $x = array(0 => $fila['nombre_centro'] ,
				1 => $w = array('v' => $fila['cantidad_at']-0, 'f' => $fila['cantidad_at'] .'' )),
				1 => $s = array(0 => 'Otros Centros', 1 => $d = array('v' => $dato['total_at']-$fila['cantidad_at'], 'f' => $dato['total_at']-$fila['cantidad_at'] .'' )));

				$jsondata['tabla'] =$centrosT;
				echo json_encode($jsondata);
			} else {
				$jsondata['success'] = 0;
	 			echo json_encode($jsondata);
			}
		}
		$mysqli->close();
	}


	public function generarConsolidado($id_empresa ,$id_centro, $fecha1, $fecha2){


		$mysqli =  new model();
		$jsondata = array();

		$variablesAT = array(0 => 'jornada_at', 1 => 'muerte_em', 2 => 'labor_habitual_em', 3 => 'zona_at', 4 => 'lugar_at');

		//Nombres de las tablas
		$nombresTablas = array(0 => 'tipo_accidente',1 =>'sitio_accidente',2 =>'lesion_at',3 =>'parte_cuerpo',4 => 'agente_at', 5 =>'mecanismo_at',6 =>'condicion_ambiental',7 =>'acto_inseguro');

		//Identificador de cada Tabla ['nom_id_tabla']
		$IdTablas = array(0 => 'identificador_tipo',1 => 'identificador_sitio',2 => 'identificador_lesion',3 => 'identificador_parte_cuerpo', 4 => 'identificador_agente', 5 => 'identificador_mecanismo', 6 =>  'identificador_cond_amb', 7 => 'identificador_ai');

		//Nombres de la variable de cada tabla ['nom_var_tabla']
    	$variableTabla = array(0 => 'tipo_at', 1 => 'nombre_sitio',2 => 'nombre_lesion',3 => 'nombre_parte_cuerpo',4 => 'nombre_agente',5 => 'nombre_mecanismo', 6 => 'nombre_cond_amb',7 => 'nombre_ai');

    	//Nombres de las variables en el at ['nom_var_at']
		$nombreVariableEnAt = array(0 => 'tipo_at', 1 =>'sitio_at', 2 =>'tipo_lesion_at', 3 =>'parte_cuerpo_em', 4 =>'agente_at',5 =>'mecanismo_at',6 =>'con_amb_peligrosa',7 =>'acto_inseguro');

    	
    	foreach ($variablesAT as $key => $value) {
    		$sql= "SELECT accidente_trabajo".".". $value .", COUNT(fiatep_at) FROM accidente_trabajo  JOIN empleado ON (accidente_trabajo"."."."identificador_empleado = empleado"."."."identificador_empleado) JOIN centro_trabajo on (empleado"."."."centro_trabajo = centro_trabajo"."."."identificador_centro) JOIN empresa ON (centro_trabajo"."."."identificador_empresa = empresa"."."."identificador_empresa) WHERE  empresa"."."."identificador_empresa = $id_empresa AND centro_trabajo"."."."identificador_centro = $id_centro AND fecha_at BETWEEN '$fecha1' AND '$fecha2' GROUP BY accidente_trabajo".".".$value.";";

    		    $result = $mysqli->query($sql);

    		    $jsondata[$value] = $this->formatearVector($mysqli, $result);
      	}

		
		foreach ($nombresTablas as $key => $value) {
			$sql = "SELECT $value"."."."$variableTabla[$key], COUNT(fiatep_at) FROM accidente_trabajo JOIN $value ON (accidente_trabajo"."."."$nombreVariableEnAt[$key]"." = "."$value"."."."$IdTablas[$key]) JOIN empleado ON (accidente_trabajo"."."."identificador_empleado = empleado"."."."identificador_empleado) JOIN centro_trabajo on (empleado"."."."centro_trabajo = centro_trabajo"."."."identificador_centro) JOIN empresa ON (centro_trabajo"."."."identificador_empresa = empresa"."."."identificador_empresa) WHERE  empresa"."."."identificador_empresa = $id_empresa AND centro_trabajo"."."."identificador_centro = $id_centro AND fecha_at BETWEEN '$fecha1' AND '$fecha2' GROUP BY accidente_trabajo"."."."$nombreVariableEnAt[$key];";
			$result=$mysqli->query($sql);
			$jsondata[$value] = $this->formatearVector($mysqli, $result);
		}
	
		
			$mysqli->close();
			return $jsondata;

	}


	private function formatearVector($mysqli, $result)
	{
		if ($mysqli->rowsQuery($result)) {
								
			$variablesT = array();				
			$indice = 0;						
			while ($fila = $result->fetch_array(MYSQLI_NUM)) {							
				$variablesT[$indice] = $x = array(0 => $fila[0], 1 => $x2 = array('v' => $fila[1]-0, 'f' => $fila[1].'' ) );						
				$indice++;
			}

			return $variablesT;
		}
	}

	public  function obtenerItemCMBCausaFactorPersonal(){
		
		$mysqli =  new model();
		$sql=$mysqli->query("SELECT * FROM causa_factor_personal");
		
		$a = array();
		$factor1 = array(); $factor2 = array(); $factor3 = array();
		$factor4 = array(); $factor5 = array(); $factor6 = array();
		$factor7 = array();
		
		while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
			$item = array($fila[0] , $fila[1]);
			if ($fila[2] == "Fisiologica inadecuada") {
       			array_push($factor1, $item);
       			} else if($fila[2] == "Mental/psicologica inadecuada"){
       			array_push($factor2, $item);
       			}else if($fila[2] == "Tension fisica o fisiologica"){
       			array_push($factor3, $item);
       			}else if($fila[2] == "Tension mental o psicologica"){
       			array_push($factor4, $item);
       			}else if($fila[2] == "Falta de conocimiento"){
       			array_push($factor5, $item);
       			}else if($fila[2] == "Falta de habilidad"){
       			array_push($factor6, $item);
       			}else if($fila[2] == "Motivacion deficiente"){
       		 	array_push($factor7, $item);
				}
			}
		$mysqli->close();
		$a[0] = $factor1; $a[1] = $factor2; $a[2] = $factor3;
		$a[3] = $factor4; $a[4] = $factor5; $a[5] = $factor6;
		$a[6] = $factor7;
		//echo var_dump($a);
		return $a;
	}

	public  function obtenerItemCMBCausaFactorTrabajo(){
		$mysqli =  new model();
		$sql=$mysqli->query("SELECT * FROM causa_factor_trabajo");
		
		$b = array();
		$factor1 = array(); $factor2 = array(); $factor3 = array();
		$factor4 = array(); $factor5 = array(); $factor6 = array();
		$factor7 = array(); $factor8 = array(); 

		while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
			$item = array($fila[0] , $fila[1]);
		if ($fila[2] == "Supervision y liderazgo deficientes") {
   				array_push($factor1, $item);
   			} else if($fila[2] == "Ingenieria inadecuada"){
   				array_push($factor2, $item);
   			}else if($fila[2] == "Deficiencia de las adquisiciones"){
   				array_push($factor3, $item);
   			}else if($fila[2] == "Mantenimietno deficiente"){
   				array_push($factor4, $item);
   			}else if($fila[2] == "Herramientas y equipos inadecuados"){
   				array_push($factor5, $item);
   			}else if($fila[2] == "Estandares deficientes de trabajo"){
   				array_push($factor6, $item);
   			}else if($fila[2] == "Uso o desgaste"){
   				array_push($factor7, $item);
   			}else if($fila[2] == "Abuso o Maltrato"){
   				array_push($factor8, $item);
   			}
   		}
   		$mysqli->close();
		$b[0] = $factor1; $b[1] = $factor2; $b[2] = $factor3;
		$b[3] = $factor4; $b[4] = $factor5; $b[5] = $factor6;
		$b[6] = $factor7; $b[7] = $factor8; 
		//echo var_dump($b);
		return $b;
	}



	public  function obtenerItemCMBCausaActoSubEstandar(){
		$mysqli =  new model();
		$sql=$mysqli->query("SELECT * FROM causa_acto_subestandar");
		
		$c = array();
		$factor1 = array(); $factor2 = array(); $factor3 = array();
		$factor4 = array(); $factor5 = array(); $factor6 = array();
		$factor7 = array(); $factor8 = array(); $factor9 = array();
		$factor10= array(); $factor11=array();  $factor12=array();
		$factor13= array();

		while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
			$item = array($fila[0] , $fila[1]);
		if ($fila[2] === "Limpieza equipo en movimiento") {
       			array_push($factor1, $item);
   			} else if($fila[2] === "Omitir uso equipo de proteccion"){
   				array_push($factor2, $item);
   			}else if($fila[2] === "No asegurar"){
   				array_push($factor3, $item);
   			}else if($fila[2] === "Bromas"){
   				array_push($factor4, $item);
   			}else if($fila[2] === "Uso impropio de equipos"){
   				array_push($factor5, $item);
   			}else if($fila[2] === "Uso impropio manos"){
   				array_push($factor6, $item);
   			}else if($fila[2] === "Falta de atencion"){
   				array_push($factor7, $item);
   			}else if($fila[2] === "Hacer inoperante dispositivo seguridad"){
   				array_push($factor8, $item);
   			}else if($fila[2] === "Opera velocidades inseguras"){
   				array_push($factor9, $item);
   			}else if($fila[2] === "adoptar posicion insegura"){
   				array_push($factor10, $item);
   			}else if($fila[2] === "Errores conduccion"){
   				array_push($factor11, $item);
   			}else if($fila[2] === "Colocar inseguramente"){
   				array_push($factor12, $item);
   			}else if($fila[2] === "Usar equipo Inseguro"){
   				array_push($factor13, $item);
   			}
		}
		$mysqli->close();
	  	$c[0] = $factor1; $c[1] = $factor2; $c[2] = $factor3;
		$c[3] = $factor4; $c[4] = $factor5; $c[5] = $factor6;
		$c[6] = $factor7; $c[7] = $factor8; $c[8] = $factor9;
		$c[9] = $factor10; $c[10]=$factor11; $c[11]=$factor12; 
		$c[12]=  $factor13;
		//echo var_dump($c);
		return $c;
	}

	public  function obtenerItemCMBCausaCondAmbSub(){
		$mysqli =  new model();
		$sql=$mysqli->query("SELECT * FROM causa_cond_amb_sub");
		
		$d = array();
		$factor1 = array(); $factor2 = array(); $factor3 = array();
		$factor4 = array(); $factor5 = array(); $factor6 = array();
		$factor7 = array(); 
		
		while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
			$item = array($fila[0] , $fila[1]);
			if ($fila[2] === "Defecto agente") {
       			array_push($factor1, $item);
   			} else if($fila[2] === "Riesgos por la ropa"){
   				array_push($factor2, $item);
   			}else if($fila[2] === "Riesgos ambientales"){
   				array_push($factor3, $item);
   			}else if($fila[2] === "Metodos peligrosos"){
   				array_push($factor4, $item);
   			}else if($fila[2] === "Riesgos colocacion"){
   				array_push($factor5, $item);
   			}else if($fila[2] === "Inadecuada Proteccion"){
   				array_push($factor6, $item);
   			}else if($fila[2] === "Riesgos publicos"){
   				array_push($factor7, $item);
   			}
		}
		$mysqli->close();
		$d[0] = $factor1; $d[1] = $factor2; $d[2] = $factor3;
		$d[3] = $factor4; $d[4] = $factor5; $d[5] = $factor6;
		$d[6] = $factor7;
		//echo var_dump($d);
		return $d;

	}

	public function obtenerItemCMBDatosAt(){
		$datosAt = array();
		$datosAt[0] = $this->obtenerCMBSitioAt();
		$datosAt[1] = $this->obtenerCMBTipoAt();
		$datosAt[2] = $this->obtenerCMBMecanismoAt();
		$datosAt[3] = $this->obtenerCMBCondAmbAt();
		$datosAt[4] = $this->obtenerCMBActoInseguroAt();
		$datosAt[5] = $this->obtenerCMBAgenteAt();
		$datosAt[6] = $this->obtenerCMBTipoLesionAt();
		$datosAt[7] = $this->obtenerCMBParteCuerpoAt();
		//echo var_dump($datosAt);
		return $datosAt;
	}

	public function obtenerCMBTipoAt(){
		$mysqli = new model();
		$array = array();
		$sql=$mysqli->query("SELECT * FROM `tipo_accidente` ");
		while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
			$item = array($fila[0] , $fila[1]);
			array_push($array, $item);
		}
		$mysqli->close();
		//echo var_dump($array);
		return $array;
	}

	public function obtenerCMBMecanismoAt(){
		$mysqli = new model();
		$array = array();
		$sql=$mysqli->query("SELECT * FROM `mecanismo_at` ");
		while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
			$item = array($fila[0] , $fila[1]);
			array_push($array, $item);
		}
		$mysqli->close();
		//echo var_dump($array);
		return $array;
	}

	public function obtenerCMBCondAmbAt(){
		$mysqli = new model();
		$array = array();
		$sql=$mysqli->query("SELECT * FROM `condicion_ambiental` ");
		while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
			$item = array($fila[0] , $fila[1]);
			array_push($array, $item);
		}
		$mysqli->close();
		//echo var_dump($array);
		return $array;
	}

	public function obtenerCMBActoInseguroAt(){
		$mysqli = new model();
		$array = array();
		$sql=$mysqli->query("SELECT * FROM `acto_inseguro` ");
		while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
			$item = array($fila[0] , $fila[1]);
			array_push($array, $item);
		}
		$mysqli->close();
		//echo var_dump($array);
		return $array;
	}

	public function obtenerCMBSitioAt(){
		$mysqli = new model();
		$array = array();
		$sql=$mysqli->query("SELECT * FROM `sitio_accidente` ");
		while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
			$item = array($fila[0] , $fila[1]);
			array_push($array, $item);
		}
		$mysqli->close();
		//echo var_dump($array);
		return $array;
	}

	public function obtenerCMBAgenteAt(){
		$mysqli = new model();
		$array = array();
		$sql=$mysqli->query("SELECT * FROM `agente_at` ");
		while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
			if(empty($fila[2])){
			$item = array($fila[0] , $fila[1]);
			array_push($array, $item);
			}
		}
		$mysqli->close();
		//echo var_dump($array);
		return $array;
	}

	public function obtenerCMBTipoLesionAt(){
		$mysqli = new model();
		$array = array();
		$sql=$mysqli->query("SELECT * FROM `lesion_at` ");
		while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
			if(empty($fila[2])){
			$item = array($fila[0] , $fila[1]);
			array_push($array, $item);
			}
		}
		$mysqli->close();
		//echo var_dump($array);
		return $array;
	}
	public function obtenerCMBParteCuerpoAt(){
		$mysqli = new model();
		$array = array();
		$sql=$mysqli->query("SELECT * FROM `parte_cuerpo` ");
		while ($fila = $sql->fetch_array( MYSQLI_NUM)) {
			if(empty($fila[2])){
			$item = array($fila[0] , $fila[1]);
			array_push($array, $item);
			}
		}
		$mysqli->close();
		//echo var_dump($array);
		return $array;
	}


}
 ?>
