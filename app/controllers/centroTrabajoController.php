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
   * Controlador encargado de realizar las operaciones propias de los centros de trabajo.
   * @extends Controller - herramientas genericas para los Controladores
   */

  class CentroTrabajoController extends controller
  {

    /**
    * DAO encargado de las operaciones propias del centro de trabajo.
    */
    private $centroTrabajoDAO;


    /**
    * Constructor de CentroTrabajoController. Inicializa el DAO centroTrabajoDAO.
    */
    function __construct()
    {
      $this->centroTrabajoDAO = new CentroTrabajoDAO();
    }

    /**
    * Metodo que depura las entradas provenientes del formulario de registro de centro de trabajo,
    * instancia un objeto de CentroTrabajoDTO y llama una funcion del modelo de centroTrabajoDAO.
		* @param $identificador_empresa - Referencia a la empresa que pertenece el centro
		* @param $nombre_centro - Nombre del centro de trabajo
		* @param $departamento_centro - Departamento donde se encuentra el centro de trabajo
		* @param $municipio_centro - Municipio donde se encuentra el centro de trabajo
		* @param $direccion_centro - Direccion donde se encuentra el centro de trabajo
		* @param $telefono_centro - Telefono del centro de trabajo
		*/
    public function registrarCentroTrabajo_C($identificador_empresa, $nombre_centro, $departamento_centro, $municipio_centro, $direccion_centro, $telefono_centro)
    {
        $jsondata = array();
        if($identificador_empresa != '' && $nombre_centro != '' && $departamento_centro != '' && $municipio_centro != '' &&
         $direccion_centro != '' && $telefono_centro != '')
        {

          if(is_numeric($identificador_empresa) && is_string($nombre_centro) && is_numeric($departamento_centro)
           && is_numeric($municipio_centro) && is_string($direccion_centro) && is_numeric($telefono_centro))
          {
              $centro = new CentroTrabajoDTO($identificador_empresa, $nombre_centro, $departamento_centro, $municipio_centro, $direccion_centro, $telefono_centro);
              echo $this->centroTrabajoDAO->registrarCentroTrabajo($centro);
          }else{
            #Datos erroneos
            $jsondata['success']=-2;
            echo json_encode($jsondata);
          }

        }else{
          #Respuesta de que faltan datos
          $jsondata['success']=-3;
          echo json_encode($jsondata);
        }
    }


    /**
    * Metodo que depura las entradas provenientes del formulario de consulta y modificacion de centro de trabajo,
    * instancia un objeto de CentroTrabajoDTO y llama una funcion de centroTrabajoDAO.
    * @param $identificador_empresa - Referencia a la empresa que pertenece el centro
    * @param $nombre_centro - Nombre del centro de trabajo
    * @param $departamento_centro - Departamento donde se encuentra el centro de trabajo
    * @param $municipio_centro - Municipio donde se encuentra el centro de trabajo
    * @param $direccion_centro - Direccion donde se encuentra el centro de trabajo
    * @param $telefono_centro - Telefono del centro de trabajo
    */
    public function editarCentroTrabajo_C($identificador_empresa, $nombre_centro, $departamento_centro, $municipio_centro, $direccion_centro, $telefono_centro, $identificador_centro)
    {
      $jsondata = array();
      if($identificador_empresa != '' && $nombre_centro != '' && $departamento_centro != '' && $municipio_centro != '' && $direccion_centro != ''
       && $telefono_centro != '')
      {
        #telofono?
        if(is_numeric($identificador_empresa) && is_string($nombre_centro) && is_numeric($departamento_centro)
         && is_numeric($municipio_centro) && is_string($direccion_centro) && is_numeric($telefono_centro) && is_numeric($identificador_centro))
        {
           $centro = new CentroTrabajoDTO($identificador_empresa, $nombre_centro, $departamento_centro, $municipio_centro, $direccion_centro, $telefono_centro);
           echo $this->centroTrabajoDAO->editarCentroTrabajo($centro , $identificador_centro);
        }else{
          #Datos erroneos
          $jsondata['success']=-2;
          echo json_encode($jsondata);
        }

      }else{
          #Respuesta de que faltan datos
          $jsondata['success']=-3;
          echo json_encode($jsondata);
      }
    }

    /**
    * Metodo que depura las entrada proveniente del formulario de consulta y modificacion de centro de trabajo,
    * instancia un objeto de CentroTrabajoDTO y llama una funcion de centroTrabajoDAO.
    * @param $nombre_centro - Nombre del centro de trabajo
    */
    public function obtenerCentroTrabajo_C($nombre_centro)
    {
      $jsondata = array();
      if($nombre_centro != '')
      {
          $nombre_centro = htmlspecialchars($nombre_centro);
          $centro = new CentroTrabajoDTO(null, $nombre_centro);
          echo $this->centroTrabajoDAO->consultarCentroTrabajo($centro);
      }else{
        $jsondata['success']=-3;
        echo json_encode($jsondata);
      }
    }

    /**
    * Metodo que en lista los dotos necesarios para consultar un centro de trabajo
    */
    public function cargarDatosConsulta_C($id_empresa)
    {
      echo $this->centroTrabajoDAO->cargarDatosConsulta($id_empresa);
    }

    /**
    * Metodo que en lista los dotos necesarios para registrar o modificar un centro de trabajo
    */
    public function cargarDatosRegistroModificacion_C($departamento_centro)
    {
        echo $this->centroTrabajoDAO->cargarDatosRegistroModificacion($departamento_centro);
    }

    public function obtenerDatosGeneralesConsolidado($id_empresa, $nombre_centro)
    {
         $obj = new CentroTrabajoDTO($id_empresa, $nombre_centro);
         echo json_encode($this->centroTrabajoDAO->obtenerDatosGeneralesConsolidado($obj));
    }

  }


?>
