<?php

/*
 * SICATSEM
 * Sistema de Informacion para el Control de Accidentes de Trabajo en el Sector Minero
 * Ingeniería de Sistemas de la UFPS.
 * Autor: William Schnaider Torres Bermon <williamschnaidertb@ufps.edu.co>
 * V1.0.0
 * 2016
 */

  require_once 'app/controllers/controller.php';

  /**
  * Controlador encargado de realizar las operaciones propias de los accidentes de trabajo.
  * @extends Controller - herramientas genericas para los Controladores
  */

class AccidenteTrabajoController extends controller
{

  /**
  * DAO encargado de las operaciones propias del accidente de trabajo.
  */
  private $accidenteTrabajoDAO;


  /**
  * Constructor de AccidenteTrabajoController. Inicializa el DAO accidenteTrabajoDAO.
  */
  function __construct()
  {
    $this->accidenteTrabajoDAO = new AccidenteTrabajoDAO();
  }


  /**
  * Metodo que depura las entradas provenientes del formulario de registro del accidente de trabajo,
  * instancia un objeto de AccidenteTrabajoDTO y llama una funcion de accidenteTrabajoDAO.
  * @param $fiatep_at - Codigo del accidente de trabajo
  * @param $identificador_empleado - Id que referencia al empleado
  * @param $fecha_at - Fecha de ocurrencia del accidente
  * @param $jornada_at - Tipo de jornada en que sucede el accidente
  * @param $muerte_em - Si/No
  * @param $labor_habitual_em - Si/No
  * @param $tipo_at - Tipo de accidente
  * @param $zona_at - Zona del accidente
  * @param $lugar_at - Lugar de ocurrencia del accidente
  * @param $sitio_at - Sitipo del accidente
  * @param $tipo_lesion_at - Tipo de lesion que sufre el empleado
  * @param $parte_cuerpo_em - Parte del cuerpodel empleado
  * @param $agente_at - Agente del accidente
  * @param $mecanismo_at - Mecanismo o forma de accidente
  * @param $con_amb_peligrosa - Condicion ambiental peligrosa
  * @param $acto_inseguro - Acto inseguo realizado
  */

  public function registrarAccidenteTrabajo_C($fiatep_at, $identificador_empleado, $fecha_at, $jornada_at, $muerte_em,
  	 $labor_habitual_em, $tipo_at, $zona_at, $lugar_at, $sitio_at, $tipo_lesion_at, $parte_cuerpo_em, $agente_at,
   $mecanismo_at, $con_amb_peligrosa, $acto_inseguro,   $fisiologica_inadecuada, $mental_inadecuada, $tension_fisica,
   $tension_mental, $falta_conocimiento, $falta_habilidad, $motivacion_deficiente, $sup_deficiente, $ing_inadecuada,
   $deficiencia_adquisiciones, $mant_deficiente, $equipos_inadecuados, $estand_deficientes_trab, $desgaste, $maltrato,
   $limpieza_equipo , $omitir_proteccion, $no_asegurar, $bromas, $uso_impropio_manos, $uso_impropio_equipos,$falta_atencion, $inop_disp_seguridad,
   $opera_vel_inseguras, $adoptar_pos_insegura, 	$errores_conduccion, $colocar_inseguramente, $usar_equipo_inseguro,
   $defecto_agente, $riesgos_ropa, $riesgos_ambientales, $metodos_peligrosos,$riesgos_colocacion, $inadecuada_proteccion,
   $riesgos_publicos)
   {


     $jsondata = array();
     if($fiatep_at != '' && $identificador_empleado != '' && $fecha_at != '' && $jornada_at != '' && $muerte_em != '' &&
      $labor_habitual_em != '' && $tipo_at != '' && $zona_at != '' && $lugar_at != '' && $sitio_at != '' && $tipo_lesion_at != ''
      && $parte_cuerpo_em != '' && $agente_at != '' && $mecanismo_at != '' && $con_amb_peligrosa != '' && $acto_inseguro != ''
      && $fisiologica_inadecuada != '' && $mental_inadecuada != '' && $tension_fisica != ''&&
      $tension_mental != '' && $falta_conocimiento != '' && $falta_habilidad != '' && $motivacion_deficiente != '' && $sup_deficiente != ''
      && $ing_inadecuada != '' && $deficiencia_adquisiciones != '' && $mant_deficiente != '' && $equipos_inadecuados != ''
      && $estand_deficientes_trab != '' && $desgaste != '' && $maltrato != ''  && $limpieza_equipo  != ''
      && $omitir_proteccion != '' && $no_asegurar != '' && $bromas != '' && $uso_impropio_manos != '' && $uso_impropio_equipos != '' && $falta_atencion != '' &&
      $inop_disp_seguridad != '' && $opera_vel_inseguras != '' && $adoptar_pos_insegura != '' && 	$errores_conduccion != '' &&
      $colocar_inseguramente != '' && $usar_equipo_inseguro != '' && $defecto_agente != '' && $riesgos_ropa != '' && $riesgos_ambientales != ''
      && $metodos_peligrosos != '' && $riesgos_colocacion != '' && $inadecuada_proteccion != '' && $riesgos_publicos != '')
      {
              /*
              * Arrays con la información respectiva de las causas basicas e inmediatas
              */
              $CausasFactorPersonal = $this->almacenarCausasFactorPersonal($fisiologica_inadecuada, $mental_inadecuada, $tension_fisica, $tension_mental, $falta_conocimiento, $falta_habilidad, $motivacion_deficiente);
              $CausasFactorTrabajo = $this->almacenarCausasFactorTrabajo($sup_deficiente, $ing_inadecuada, $deficiencia_adquisiciones, $mant_deficiente, $equipos_inadecuados,
              $estand_deficientes_trab, $desgaste, $maltrato);
              $CausasActoSubestandar = $this->almacenarCausasActoSubestandar($limpieza_equipo , $omitir_proteccion, $no_asegurar, $bromas, $uso_impropio_equipos,
                                                              $uso_impropio_manos, $falta_atencion, $inop_disp_seguridad, $opera_vel_inseguras,
                                                              $adoptar_pos_insegura, $errores_conduccion, $colocar_inseguramente, $usar_equipo_inseguro);
              $CausasCondAmbSub = $this->almacenarCausasCondAmbSub($defecto_agente, $riesgos_ropa, $riesgos_ambientales, $metodos_peligrosos, $riesgos_colocacion,
                                                         $inadecuada_proteccion, $riesgos_publicos);

              $accidenteTrabajo = new AccidenteTrabajoDTO($fiatep_at, $identificador_empleado, $fecha_at, $jornada_at, $muerte_em,
              $labor_habitual_em, $tipo_at, $zona_at,$lugar_at, $sitio_at, $tipo_lesion_at, $parte_cuerpo_em, $agente_at,
              $mecanismo_at, $con_amb_peligrosa, $acto_inseguro, $CausasFactorPersonal, $CausasFactorTrabajo, $CausasActoSubestandar, $CausasCondAmbSub);
//var_dump($accidenteTrabajo);
                echo $this->accidenteTrabajoDAO->registrarAccidenteTrabajo($accidenteTrabajo);

      }else{
          #datos incompletos
          $jsondata['success']=-3;
          echo json_encode($jsondata);
      }
  }

  /**
  * Metodo que recibe las entradas provenientes del formulario de la vista consulta y modificacion del accidente de trabajo,
  * instancia un objeto la clase accidenteTrabajoClass y llama una funcion del modelo de accidenteTrabajoModel.
  * @param $fiatep_at - Codigo del accidente de trabajo
  * @param $identificador_empleado - Id que referencia al empleado
  * @param $fecha_at - Fecha de ocurrencia del accidente
  * @param $jornada_at - Tipo de jornada en que sucede el accidente
  * @param $muerte_em - Si/No
  * @param $labor_habitual_em - Si/No
  * @param $tipo_at - Tipo de accidente
  * @param $zona_at - Zona del accidente
  * @param $lugar_at - Lugar de ocurrencia del accidente
  * @param $sitio_at - Sitipo del accidente
  * @param $tipo_lesion_at - Tipo de lesion que sufre el empleado
  * @param $parte_cuerpo_em - Parte del cuerpodel empleado
  * @param $agente_at - Agente del accidente
  * @param $mecanismo_at - Mecanismo o forma de accidente
  * @param $con_amb_peligrosa - Condicion ambiental peligrosa
  * @param $acto_inseguro - Acto inseguo realizado


  * @param $fiatep_at_ant - Fiatep original del acciente de trabajo
  */

  public function editarAccidenteTrabajo_C($fiatep_at, $identificador_empleado, $fecha_at, $jornada_at, $muerte_em,
  	 $labor_habitual_em, $tipo_at, $zona_at, $lugar_at, $sitio_at, $tipo_lesion_at, $parte_cuerpo_em, $agente_at,
   $mecanismo_at, $con_amb_peligrosa, $acto_inseguro,   $fisiologica_inadecuada, $mental_inadecuada, $tension_fisica,
   $tension_mental, $falta_conocimiento, $falta_habilidad, $motivacion_deficiente, $sup_deficiente, $ing_inadecuada,
   $deficiencia_adquisiciones, $mant_deficiente, $equipos_inadecuados, $estand_deficientes_trab, $desgaste, $maltrato,
   $limpieza_equipo , $omitir_proteccion, $no_asegurar, $bromas, $uso_impropio_manos, $uso_impropio_equipos,$falta_atencion, $inop_disp_seguridad,
   $opera_vel_inseguras, $adoptar_pos_insegura, $errores_conduccion, $colocar_inseguramente, $usar_equipo_inseguro,
   $defecto_agente, $riesgos_ropa, $riesgos_ambientales, $metodos_peligrosos,$riesgos_colocacion, $inadecuada_proteccion,
   $riesgos_publicos, $fiatep_at_ant)
  {
    if($fiatep_at != '' && $identificador_empleado != '' && $fecha_at != '' && $jornada_at != '' && $muerte_em != '' &&
     $labor_habitual_em != '' && $tipo_at != '' && $zona_at != '' && $lugar_at != '' && $sitio_at != '' && $tipo_lesion_at != ''
     && $parte_cuerpo_em != '' && $agente_at != '' && $mecanismo_at != '' && $con_amb_peligrosa != '' && $acto_inseguro != ''
     && $fisiologica_inadecuada != '' && $mental_inadecuada != '' && $tension_fisica != ''&&
     $tension_mental != '' && $falta_conocimiento != '' && $falta_habilidad != '' && $motivacion_deficiente != '' && $sup_deficiente != ''
     && $ing_inadecuada != '' && $deficiencia_adquisiciones != '' && $mant_deficiente != '' && $equipos_inadecuados != ''
     && $estand_deficientes_trab != '' && $desgaste != '' && $maltrato != ''  && $limpieza_equipo  != ''
     && $omitir_proteccion != '' && $no_asegurar != '' && $bromas != '' && $uso_impropio_manos != '' && $uso_impropio_equipos != '' && $falta_atencion != '' &&
     $inop_disp_seguridad != '' && $opera_vel_inseguras != '' && $adoptar_pos_insegura != '' && 	$errores_conduccion != '' &&
     $colocar_inseguramente != '' && $usar_equipo_inseguro != '' && $defecto_agente != '' && $riesgos_ropa != '' && $riesgos_ambientales != ''
     && $metodos_peligrosos != '' && $riesgos_colocacion != '' && $inadecuada_proteccion != '' && $riesgos_publicos != '')
     {

       if(is_numeric($fiatep_at) && is_numeric($identificador_empleado) && is_string($fecha_at) && ctype_alpha($jornada_at) && is_numeric($tipo_at)
         && ctype_alpha($muerte_em)  && ctype_alpha($labor_habitual_em) && ctype_alpha($lugar_at) && is_numeric($sitio_at) && ctype_alpha($zona_at)
         && is_numeric($tipo_lesion_at) && is_numeric($parte_cuerpo_em) && is_numeric($agente_at) && is_numeric($mecanismo_at) &&
         is_numeric($con_amb_peligrosa) && is_numeric($acto_inseguro) && is_numeric($fisiologica_inadecuada) && is_numeric($mental_inadecuada)
         && is_numeric($tension_fisica) && is_numeric($tension_mental) && is_numeric($falta_conocimiento) && is_numeric($falta_habilidad)
         && is_numeric($motivacion_deficiente) && is_numeric($sup_deficiente) && is_numeric($ing_inadecuada) && is_numeric($deficiencia_adquisiciones)
         && is_numeric($mant_deficiente) && is_numeric($equipos_inadecuados) && is_numeric($estand_deficientes_trab) && is_numeric($desgaste)
         && is_numeric($maltrato) &&  is_numeric($limpieza_equipo)  && is_numeric($omitir_proteccion) && is_numeric($no_asegurar)
         && is_numeric($bromas) && is_numeric($uso_impropio_manos) && is_numeric($uso_impropio_equipos) && is_numeric($falta_atencion)
         && is_numeric($inop_disp_seguridad) && is_numeric($opera_vel_inseguras) && is_numeric($adoptar_pos_insegura) && is_numeric($errores_conduccion)
         && is_numeric($colocar_inseguramente) && is_numeric($usar_equipo_inseguro) && is_numeric($defecto_agente) && is_numeric($riesgos_ropa)
         && is_numeric($riesgos_ambientales) && is_numeric($metodos_peligrosos) && is_numeric($riesgos_colocacion) && is_numeric($inadecuada_proteccion)
         && is_numeric($riesgos_publicos)){

            /*
            * Arrays con la información respectiva de las causas basicas e inmediatas
            */
            $CausasFactorPersonal = $this->almacenarCausasFactorPersonal($fisiologica_inadecuada, $mental_inadecuada, $tension_fisica, $tension_mental, $falta_conocimiento, $falta_habilidad, $motivacion_deficiente);
            $CausasFactorTrabajo = $this->almacenarCausasFactorTrabajo($sup_deficiente, $ing_inadecuada, $deficiencia_adquisiciones, $mant_deficiente, $equipos_inadecuados,
            $estand_deficientes_trab, $desgaste, $maltrato);
            $CausasActoSubestandar = $this->almacenarCausasActoSubestandar($limpieza_equipo , $omitir_proteccion, $no_asegurar, $bromas, $uso_impropio_equipos,
                                                            $uso_impropio_manos, $falta_atencion, $inop_disp_seguridad, $opera_vel_inseguras,
                                                            $adoptar_pos_insegura, $errores_conduccion, $colocar_inseguramente, $usar_equipo_inseguro);
            $CausasCondAmbSub = $this->almacenarCausasCondAmbSub($defecto_agente, $riesgos_ropa, $riesgos_ambientales, $metodos_peligrosos, $riesgos_colocacion,
                                                       $inadecuada_proteccion, $riesgos_publicos);

            $accidenteTrabajo = new AccidenteTrabajoDTO($fiatep_at, $identificador_empleado, $fecha_at, $jornada_at, $muerte_em,
            $labor_habitual_em, $tipo_at, $zona_at, $lugar_at, $sitio_at, $tipo_lesion_at, $parte_cuerpo_em, $agente_at,
            $mecanismo_at, $con_amb_peligrosa, $acto_inseguro, $CausasFactorPersonal, $CausasFactorTrabajo, $CausasActoSubestandar, $CausasCondAmbSub);

            echo $this->accidenteTrabajoDAO->editarAccidenteTrabajo($accidenteTrabajo, $fiatep_at_ant);
       }else {
         $jsondata['success']=-2;
         echo json_encode($jsondata);
       }

  }else{
    #datos vacios
    $jsondata['success']=-3;
    echo json_encode($jsondata);
  }

  }

  /**
  * Metodo que obtiene toda la informacion respectiva de un accidente de trabajo
  * @param $fiatep_at - Identificador del accidente de trabajo
  */

  public function obtenerAccidenteTrabajo_C($fiatep_at)
  {
    if($fiatep_at != '')
    {
      if(is_numeric($fiatep_at))
      {
        $fiatep_at = htmlspecialchars($fiatep_at);
        $accidenteTrabajo = new AccidenteTrabajoDTO($fiatep_at);
        echo $this->accidenteTrabajoDAO->consultarAccidenteTrabajo($accidenteTrabajo);
      }else{
        $jsondata['success']=-2;
        echo json_encode($jsondata);
      }

    }else {
      $jsondata['success']=-3;
      echo json_encode($jsondata);
    }
  }

  /**
  * Metodo que en lista los fiateps de todos los accidentes de trabajo resgistrados en la base de datos
  */
  public function cargarDatosConsulta_C($id_empresa)
  {
    echo json_encode($this->accidenteTrabajoDAO->listarFiatepAccidenteTrabajo($id_empresa));
    
  }

  public function cargarDatosConsulta_C_2($id_empresa)
  {
    $jsondata = array();
    $jsondata["fiatep"] = $this->accidenteTrabajoDAO->listarFiatepAccidenteTrabajo($id_empresa);
    $jsondata["causa_factor_personal"] = $this->obtenerItemCMBCausaFactorPersonal_C();
    $jsondata["causa_factor_trabajo"] = $this->obtenerItemCMBCausaFactorTrabajo_C();
    $jsondata["causa_acto_subestandar"] = $this->obtenerItemCMBCausaActoSubEstandar_C();
    $jsondata["causa_cond_amb_sub"] = $this->obtenerItemCMBCausaCondAmbSub_C();
    $jsondata["datosAt"] = $this->obtenerItemCMBDatosAt_C();
    echo json_encode($jsondata);
  }

  /*
  *
  */
  private function almacenarCausasFactorPersonal($fisiologica_inadecuada, $mental_inadecuada, $tension_fisica, $tension_mental, $falta_conocimiento, $falta_habilidad, $motivacion_deficiente)
  {
    $CausasFactorPersonal = array(0 => $fisiologica_inadecuada, 1 => $mental_inadecuada, 2 => $tension_fisica, 3 => $tension_mental,
                                  4 => $falta_conocimiento, 5 => $falta_habilidad , 6 => $motivacion_deficiente);
    return $CausasFactorPersonal;
  }

  /*
  *
  */
  private function almacenarCausasFactorTrabajo($sup_deficiente, $ing_inadecuada, $deficiencia_adquisiciones, $mant_deficiente, $equipos_inadecuados,
  $estand_deficientes_trab, $desgaste, $maltrato)
  {
    $CausasFactorTrabajo = array(0 => $sup_deficiente, 1 => $ing_inadecuada, 2 => $deficiencia_adquisiciones, 3 => $mant_deficiente,
    4 => $equipos_inadecuados, 5 => $estand_deficientes_trab , 6 => $desgaste, 7 => $maltrato);

    return $CausasFactorTrabajo;
  }

  /*
  *
  */
  private function almacenarCausasActoSubestandar($limpieza_equipo , $omitir_proteccion, $no_asegurar, $bromas, $uso_impropio_equipos,
                                                  $uso_impropio_manos, $falta_atencion, $inop_disp_seguridad, $opera_vel_inseguras,
                                                  $adoptar_pos_insegura, $errores_conduccion, $colocar_inseguramente, $usar_equipo_inseguro)
  {
    $CausasActoSubestandar = array(0 => $limpieza_equipo, 1 => $omitir_proteccion, 2 => $no_asegurar, 3 => $bromas, 4 => $uso_impropio_manos,
                                 5 => $uso_impropio_equipos, 6 => $falta_atencion , 7 => $inop_disp_seguridad, 8 => $opera_vel_inseguras,
                                 9 => $adoptar_pos_insegura, 10 => $errores_conduccion, 11 => $colocar_inseguramente, 12 => $usar_equipo_inseguro);
    return $CausasActoSubestandar;
  }

  /*
  *
  */
  private function almacenarCausasCondAmbSub($defecto_agente, $riesgos_ropa, $riesgos_ambientales, $metodos_peligrosos, $riesgos_colocacion,
                                             $inadecuada_proteccion, $riesgos_publicos)
  {
    $CausasCondAmbSub = array(0 => $defecto_agente, 1 => $riesgos_ropa, 2 => $riesgos_ambientales, 3 => $metodos_peligrosos,
                                  4 => $riesgos_colocacion, 5 => $inadecuada_proteccion , 6 => $riesgos_publicos);
    return $CausasCondAmbSub;
  }

 /*
 *
 */
  public function obtenerSubTipoLesionAT_C($tipo)
  {
    echo json_encode($this->accidenteTrabajoDAO->obtenerSubTipoLesionAT($tipo));
  }

 /*
 *
 */
  public function obtenerSubTipoParteCuerpo_C($tipo)
  {
   echo json_encode($this->accidenteTrabajoDAO->obtenerSubTipoParteCuerpo($tipo));
  }

   /*
   *
   */
  public function obtenerSubTipoAgenteAT_C($tipo)
  {
    echo json_encode($this->accidenteTrabajoDAO->obtenerSubTipoAgenteAT($tipo));
  }

  /**
  *
  */
  public function cargarSitioAccidente_C()
  {
    $this->accidenteTrabajoDAO->cargarSitioAccidente();
  }

  /**
  *
  */
  public function cargarTipoAccidente_C()
  {
    $this->accidenteTrabajoDAO->cargarTipoAccidente();
  }

  /**
  *
  */
  public function cargarMecanismo_C()
  {
    $this->accidenteTrabajoDAO->cargarMecanismo();
  }

  /**
  *
  */
  public function cargarCondicionAmbiental_C()
  {
    $this->accidenteTrabajoDAO->cargarCondicionAmbiental();
  }

  /**
  *
  */
  public function cargarActoInseguro_C()
  {
    $this->accidenteTrabajoDAO->cargarActoInseguro();
  }

  /*
  *ESTADISTICA 1 
  */

  public function estadisticaVariablexFechas_C( $id_empresa ,$nom_tabla, $id_nombre, $nom_var ,$var_at , $fecha1, $fecha2)
  {
      echo $this->accidenteTrabajoDAO->estadisticaVariablexFechas( $id_empresa ,$nom_tabla,$id_nombre,$nom_var,$var_at , $fecha1,$fecha2);
  }


  /*
  *ESTADISTICAS 2
  */
  public function estadisticaVariablexCentros_C( $id_empresa ,$nom_tabla, $id_nombre,  $nom_var , $var_at ,$id_centro)
  {
      echo $this->accidenteTrabajoDAO->estadisticaVariablexCentros($id_empresa , $nom_tabla, $id_nombre,  $nom_var , $var_at ,$id_centro);
  }

  /*
  *ESTADISTICAS 3
  */

  public function estadisticaVariablexFechasCentros_C($id_empresa , $nom_tabla, $id_nombre, $nom_var , $var_at , $id_centro, $fecha1, $fecha2)
  {

      echo $this->accidenteTrabajoDAO->estadisticaVariablexFechasCentros($id_empresa , $nom_tabla, $id_nombre, $nom_var , $var_at , $id_centro, $fecha1, $fecha2);
  }

  /**
  * Estadistica 4 - Cantidad de ATs en un rango de fechas
  */
  public function estadisticaCantidadATxFechas_C($id_empresa , $fecha1, $fecha2)
  {
      echo $this->accidenteTrabajoDAO->estadisticaCantidadATxFechas($id_empresa ,$fecha1, $fecha2);
  }

  /**
  * Estadistica 5 - Cantidad de ATs en uno o varios centros de trabajo
  */
  public function estadisticaCantidadATxCentros_C($id_empresa ,$id_centro)
  {
      echo $this->accidenteTrabajoDAO->estadisticaCantidadATxCentros($id_empresa ,$id_centro);
  }

  /**
  * Estadistica 6 - Cantidad de ATs en un rango de fechas y en uno o varios centros de trabajo
  */
  public function estadisticaCantidadATxFechasCentros_C($id_empresa ,$id_centro,$fecha1,$fecha2)
  {
      echo $this->accidenteTrabajoDAO->estadisticaCantidadATxFechasCentros($id_empresa ,$id_centro, $fecha1, $fecha2);
  }

  public function generarConsolidado($id_empresa ,$id_centro, $fecha1, $fecha2)
  {
    echo json_encode($this->accidenteTrabajoDAO->generarConsolidado($id_empresa ,$id_centro, $fecha1, $fecha2));
  }

  // Combos
  public function obtenerItemCMBCausaFactorPersonal_C(){
    return $this->accidenteTrabajoDAO->obtenerItemCMBCausaFactorPersonal();
  }

  public function obtenerItemCMBCausaFactorTrabajo_C(){
    return $this->accidenteTrabajoDAO->obtenerItemCMBCausaFactorTrabajo();
  }

  public function obtenerItemCMBCausaActoSubEstandar_C(){
    return $this->accidenteTrabajoDAO->obtenerItemCMBCausaActoSubEstandar();
  }

  public function obtenerItemCMBCausaCondAmbSub_C(){
   return $this->accidenteTrabajoDAO->obtenerItemCMBCausaCondAmbSub();
  }

  public function obtenerItemCMBDatosAt_C(){
    return $this->accidenteTrabajoDAO->obtenerItemCMBDatosAt();
  }


}


  ?>
