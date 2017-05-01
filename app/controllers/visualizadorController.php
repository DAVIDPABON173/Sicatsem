<?php

/*
 * SICATSEM
 * Sistema de Informacion para el Control de Accidentes de Trabajo en el Sector Minero
 * Ingeniería de Sistemas de la UFPS.
 * Autor: William Schnaider Torres Bermon <williamschnaidertb@ufps.edu.co>
 * V1.0.0
 * 2016
 */
require_once 'controller.php';
require_once 'app/controllers/accidenteTrabajoController.php';
require_once 'app/controllers/empleadoController.php';
require 'app/bin/genPDF.php';

/**
* Controlador encargado de realizar las operaciones del home (Principal).
* @extends Controller - herramientas genéricas para los Controladores
*/
class Visualizador extends Controller
{

  /**
  * Construye y muestra la vista principal cuando el administrador no ha iniciado sesion.
  */
  public function showHome() {
      $view = $this->getView('loggin.html',1);
      if($view) {
          $this->showView($view);
      }
  }


  /**
  * Construye y muestra la vista principal cuando el administrador ha iniciado sesion.
  */
  public function showAdmin() {
      $view = $this->getView('home.html',1);
      $view = $this->insert($view, '{{nav}}', $this->getView('header.html',0));
      if($view) {
          $this->showView($view);
      }
  }

  /**
  * Construye y muestra la vista principal cuando el administrador ha iniciado sesion.
  */
  public function publishView($view) {
      $view = $this->getView($view, 1);
      $view = $this->insert($view, '{{nav}}', $this->getView('header.html',0));
      if($view) {
          $this->showView($view);
      }
  }



  /**
  * Construye y muestra la vista principal cuando el administrador ha iniciado sesion.
  */
  public function publishConsolidado($id_centro, $fecha1, $fecha2) {
      $view = $this->getView('visualizadorConsolidado.html', 2);
      $view = $this->insert($view, '{{nav}}', $this->getView('header.html',0));
      $view = $this->insert($view, '{{hidden_centro}}', $id_centro);
      $view = $this->insert($view, '{{hidden_fecha1}}', $fecha1);
      $view = $this->insert($view, '{{hidden_fecha2}}', $fecha2);


      if($view) {
          $this->showView($view);
      }
  }



  /**
  *
  */
  public function cargarDatosRegistroModificacionAT_C( $at, $empleado,$id_empresa)
  {

    //echo json_encode($empleado->cargarDatosEmpleados($id_empresa));

    $jsondata = array();
    $jsondata["empleado"] = $empleado->cargarDatosEmpleados($id_empresa);
    $jsondata["causa_factor_personal"] = $at->obtenerItemCMBCausaFactorPersonal_C();
    $jsondata["causa_factor_trabajo"] = $at->obtenerItemCMBCausaFactorTrabajo_C();
    $jsondata["causa_acto_subestandar"] = $at->obtenerItemCMBCausaActoSubEstandar_C();
    $jsondata["causa_cond_amb_sub"] = $at->obtenerItemCMBCausaCondAmbSub_C();
    $jsondata["datosAt"] = $at->obtenerItemCMBDatosAt_C();
    echo json_encode($jsondata);


  }

public function generarConsolidadoPDF($value)
{
  PDF::generarPdf($value);
}



}



?>
