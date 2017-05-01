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
  * Controlador encargado de realizar las operaciones propias de la empresa.
  * @extends Controller - herramientas genericas para los Controladores
  */

  class EmpresaController extends controller
  {

    /**
    * DAO encargado de las operaciones propias de la empresa.
    */
    private $empresaDAO;


    /**
    * Constructor de EmpresaController. Inicializa el DAO empresaDAO.
    */
    function __construct()
    {
      $this->empresaDAO = new empresaDAO();
    }

    /**
    * Metodo que valida las entradas del formulario de registro de Empresa,
    * instancia un objeto EmpresaDTO e invoca un metodo de EmpresaDAO.
    * @param $nombre_empresa - Nombre de la Empresa
    * @param $razon_social - Razon soocial con que se identifica la Empresa
    * @param $nit_empresa - Numero de identificacion tributaria de la Empresa
    * @param $direccion_empresa - Direccion donde esta ubicada la Empresa
    * @param $telefono_empresa - Telefono de la Empresa
    */
    public function registrarEmpresa_C($nombre_empresa, $razon_social, $nit_empresa, $direccion_empresa, $telefono_empresa)
    {
        if($nombre_empresa != '' && $razon_social != '' && $nit_empresa != ''  && $direccion_empresa != '' && $telefono_empresa != '')
        {

          if(is_string($nombre_empresa) && is_string($razon_social) && is_string($direccion_empresa)
             && is_numeric($telefono_empresa))
          {
            $empresa = new EmpresaDTO($nombre_empresa, $razon_social, $nit_empresa, $direccion_empresa, $telefono_empresa);
            return $this->empresaDAO->registrarEmpresa($empresa);
          }else {
            #Datos erroneos
            $jsondata['success']=-2;
            echo $jsondata;
          }

        }else{
          #Respuesta de que faltan datos
          $jsondata['success']=-3;
          echo $jsondata;
        }
    }


    /**
    * Metodo que valida las entradas del formulario de consulta y modificacion de Empresa,
    * instancia un objeto EmpresaDTO e invoca un metodo de EmpresaDAO.
    * @param $nombre_empresa - Nombre de la Empresa
    * @param $razon_social - Razon soocial con que se identifica la Empresa
    * @param $nit_empresa - Numero de identificacion tributaria de la Empresa
    * @param $direccion_empresa - Direccion donde esta ubicada la Empresa
    * @param $telefono_empresa - Telefono de la Empresa
    */
    public function editarEmpresa_C($nombre_empresa, $razon_social, $nit_empresa, $direccion_empresa, $telefono_empresa , $identificador_empresa)
    {

      if($nombre_empresa != '' && $razon_social != '' && $nit_empresa != '' && $direccion_empresa != '' && $telefono_empresa != '')
      {

        if(is_string($nombre_empresa) && is_string($razon_social) && is_string($direccion_empresa)
        && is_numeric($telefono_empresa) && is_numeric($identificador_empresa))
        {
          $empresa = new EmpresaDTO($nombre_empresa, $razon_social, $nit_empresa, $direccion_empresa, $telefono_empresa);
          echo $this->empresaDAO->editarEmpresa($empresa, $identificador_empresa);
        }else {
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
    * Metodo que captura el identificador de la empresa para proceder a buscar la informacion de la misma,
    * se instancia un objeto EmpresaDTO e invoca un metodo de EmpresaDAO.
    * @param $nombre_empresa - Nombre de la empresa.
    */
    public function obtenerEmpresa_C($identificador_empresa)
    {
      if($identificador_empresa != ''){

        if(is_string($identificador_empresa))
        {
          echo $this->empresaDAO->consultarEmpresa($identificador_empresa);
        }else{
          #Datos erroneos
          $jsondata['success']=-2;
          echo json_encode($jsondata);
        }
      }else {
        #Faltan datos
        $jsondata['success']=-3;
        echo json_encode($jsondata);
      }

    }
}
