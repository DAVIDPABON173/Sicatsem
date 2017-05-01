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
   * Controlador encargado de realizar las operaciones propias de la valoracion medica.
   * @extends Controller - herramientas genericas para los Controladores
   */

 class ValoracionMedicaController extends controller
 {

   /**
   * DAO encargado de las operaciones propias de la valoracion medica.
   */
   private $valoracionMedicaDAO;


   /**
   * Constructor de ValoracionMedicaController. Inicializa el DAO valoracionMedicaDAO.
   */
   function __construct()
   {
     $this->valoracionMedicaDAO = new valoracionMedicaDAO();
   }


   /**
   * Metodo que valida las entradas del formulario de registro de Valoracion Medica,
   * instancia un objeto ValoracionMedicaDTO e invoca un metodo de valoracionMedicaDAO.
   * @param $identificador_at -	Numero que referencia la Valoracion Medica con un accidente
   * @param $codigo_valoracion - Numero que identifica la valoracion medica del accidente
   * @param $dias_incapacidad - Dias de incapacidad que se asignan en la valoracion medica del accidentea un empleado accidentado
   * @param $observacion - anotaciones u observaciones de la valoracion medica
   */

   public function registrarValoracionMedica_C($identificador_at, $codigo_valoracion, $dias_incapacidad, $observacion)
   {
     if($identificador_at != '' && $codigo_valoracion != '' && $dias_incapacidad != '')
     {
       if(is_numeric($identificador_at) && is_string($codigo_valoracion) && is_numeric($dias_incapacidad))
       {
         $valoracionMedica = new valoracionMedicaDTO($identificador_at, $codigo_valoracion, $dias_incapacidad, 0 ,$observacion);
        echo $this->valoracionMedicaDAO->registrarValoracionMedica($valoracionMedica);
       }else {
         #Datos errones
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
   * Metodo que valida las entradas del formulario de consulta y modificacion de Valoracion Medica,
   * instancia un objeto ValoracionMedicaDTO e invoca un metodo de valoracionMedicaDAO..
   * @param $identificador_at -	Numero que referencia la Valoracion Medica con un accidente
   * @param $codigo_valoracion - Numero que identifica la valoracion medica del accidente
   * @param $dias_incapacidad - Dias de incapacidad que se asignan en la valoracion medica del accidentea un empleado accidentado
   * @param $dias_prorroga - Dias extendidos a los dias de incapacidad
   * @param $observacion - anotaciones u observaciones de la valoracion medica
   */
   public function editarValoracionMedica_C($identificador_at, $codigo_valoracion, $dias_incapacidad, $dias_prorroga, $observacion, $identificador_at_ant)
   {
     $jsondata = array();
     if($identificador_at != '' && $codigo_valoracion != '' && $dias_incapacidad != '' && $dias_prorroga != '')
     {
       if(is_numeric($identificador_at) && is_string($codigo_valoracion) && is_numeric($dias_incapacidad) &&  is_numeric($dias_prorroga) && is_numeric($identificador_at_ant))
       {
         $valoracionMedica = new valoracionMedicaDTO($identificador_at, $codigo_valoracion, $dias_incapacidad, $dias_prorroga ,$observacion);
        echo $this->valoracionMedicaDAO->editarValoracionMedica($valoracionMedica, $identificador_at_ant);
       }else {
         #Datos errones
         $jsondata['success']=-2;
         echo json_encode($jsondata);
       }
     }else{
       #Datos vacios
       $jsondata['success']=-3;
       echo json_encode($jsondata);
     }

   }

   /**
   * Metodo que valida las entradas del formulario de consulta y modificacion de Valoracion Medica,
   * instancia un objeto ValoracionMedicaDTO e invoca un metodo de valoracionMedicaDAO..
   * @param $identificador_at -	Numero que referencia la Valoracion Medica con un accidente
   */
   public function obtenerValoracionMedica_C($identificador_at)
   {
     $jsondata = array();
     if($identificador_at != '')
     {
       if(is_numeric($identificador_at))
       {
          $valoracionMedica = new ValoracionMedicaDTO($identificador_at);
          echo $this->valoracionMedicaDAO->consultarValoracionMedica($valoracionMedica);
       }else{
         #Dato erroneo
         $jsondata['success']=-2;
         echo json_encode($jsondata);
       }

     }else{
      #Faltan datos
      $jsondata['success']=-3;
      echo json_encode($jsondata);
     }
   }

   /**
   * Metodo que en lista los dotos necesarios para registrar o modificar un accidentes de trabajo
   */
   public function cargarDatosRegistroModificacion_C()
   {
     echo $this->accidenteTrabajoDAO->cargarDatosRegistroModificacion_C();
   }

   /**
   * Metodo que consulta el codigo de valoracion
   */
   public function consultarCodigoValoracion_C($cod_valo)
   {
     $jsondata = array();
     if($cod_valo != ''){
        echo $this->valoracionMedicaDAO->consultarCodigoValoracion($cod_valo);
     }else {
       $jsondata['success']=-3;
       echo $jsondata;
     }
   }
 }


 ?>
