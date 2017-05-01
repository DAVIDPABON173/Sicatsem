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
  * Controlador encargado de realizar las operaciones propias del empleado.
  * @extends Controller - herramientas genericas para los Controladores
  */

  class EmpleadoController extends controller
  {

    /**
    * DAO encargado de las operaciones propias del empleado.
    */
    private $empleadoDAO;


    /**
    * Constructor de EmpleadoController. Inicializa el DAO empleadoDAO.
    */
    function __construct()
    {
      $this->empleadoDAO = new EmpleadoDAO();

    }


    /**
    * Metodo que valida las entradas del formulario de registro de Empleado,
    * instancia un objeto EmpleadoDTO e invoca un metodo de EmpleadoDAO.
		* @param $nombres_em - Nombre del Empleado
		* @param $apellido_em - Primer apellido del Empleado
		* @param $apellido2_em - Segundo apellido del Empleado
		* @param $tipo_doc - Tipo de documento del Empleado
		* @param $numero_doc - Numero de identificacion del Empleado
		* @param $salario_base - Salario Base del Empleado
		* @param $fecha_nacimiento - Fecha de Nacimiento del Empleado
		* @param $genero_em - Genero del Empleado
		* @param $eps_ips - EPS ó IPS donde se encuentra afiliado el Empleado
		* @param $entidad_salud - Entidad de Salud a la cual ertence el Empleado
		* @param $tipo_cargo_em - Tipo de cargo del Empleado
		* @param $cargo_em - Cargo del Empleado
		* @param $centro_trabajo - Centro de trabajo al cual pertenece el Empleado
		*/
    public function registrarEmpleado_C($nombres_em, $apellido_em, $apellido_2_em, $tipo_doc, $numero_doc, $salario_base,
    $fecha_nacimiento, $genero_em, $eps_ips, $entidad_salud, $tipo_cargo_em, $cargo_em, $centro_trabajo)
    {
      $jsondata = array();
      if($nombres_em != '' && $apellido_em != '' && $apellido_2_em != '' && $tipo_doc != '' && $numero_doc != ''
         && $salario_base != '' && $fecha_nacimiento != '' && $genero_em != '' && $eps_ips != '' && $entidad_salud != ''
         && $tipo_cargo_em != '' && $cargo_em != '' && $centro_trabajo != '')
      {
        #No meti fecha, el estado no se pide
        if(is_string($nombres_em) && is_string($apellido_em) && is_string($apellido_2_em) && is_string($tipo_doc) && is_numeric($numero_doc)
           && is_numeric($salario_base) && is_string($genero_em) && is_string($eps_ips) && is_string($entidad_salud) && is_string($tipo_cargo_em)
           && is_numeric($cargo_em) && is_numeric($centro_trabajo))
        {
            $empleado = new empleadoDTO(trim($nombres_em), $apellido_em, $apellido_2_em, $tipo_doc, $numero_doc, $salario_base,
            $fecha_nacimiento, $genero_em, $eps_ips, trim($entidad_salud), $tipo_cargo_em, $cargo_em, $centro_trabajo);
          echo $this->empleadoDAO->registrarEmpleado($empleado);

        }else {
          #datos incorrectos
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
    * Metodo que valida las entradas del formulario de consulta y modificacion de Empleado,
    * instancia un objeto EmpleadoDTO e invoca un metodo de EmpleadoDAO.
    * @param $nombres_em - Nombre del Empleado
    * @param $apellido_em - Primer apellido del Empleado
    * @param $apellido2_em - Segundo apellido del Empleado
    * @param $tipo_doc - Tipo de documento del Empleado
    * @param $numero_doc - Numero de identificacion del Empleado
    * @param $salario_base - Salario Base del Empleado
    * @param $fecha_nacimiento - Fecha de Nacimiento del Empleado
    * @param $genero_em - Genero del Empleado
    * @param $eps_ips - EPS ó IPS donde se encuentra afiliado el Empleado
    * @param $entidad_salud - Entidad de Salud a la cual ertence el Empleado
    * @param $tipo_cargo_em - Tipo de cargo del Empleado
    * @param $cargo_em - Cargo del Empleado
    * @param $centro_trabajo - Centro de trabajo al cual pertenece el Empleado
    */
    public function editarEmpleado_C($nombres_em, $apellido_em, $apellido_2_em, $tipo_doc, $numero_doc, $salario_base,
    $fecha_nacimiento, $genero_em, $eps_ips, $entidad_salud, $tipo_cargo_em, $cargo_em, $centro_trabajo, $estado_em , $identificador_empleado)
    {
      $jsondata = array();
      if($nombres_em != '' && $apellido_em != '' && $apellido_2_em != '' && $tipo_doc != '' && $numero_doc != ''
         && $salario_base != '' && $fecha_nacimiento != '' && $genero_em != '' && $eps_ips != '' && $entidad_salud != ''
         && $tipo_cargo_em != '' && $cargo_em != '' && $centro_trabajo != '' && $identificador_empleado != '')
      {
        #No meti fecha, el estado no se pide
        if(is_string($nombres_em) && is_string($apellido_em) && is_string($apellido_2_em) && is_string($tipo_doc) && is_numeric($numero_doc)
           && is_numeric($salario_base) && is_string($genero_em) && is_string($eps_ips) && is_string($entidad_salud) && is_string($tipo_cargo_em)
           && is_numeric($cargo_em) && is_numeric($centro_trabajo) && is_string($estado_em) && is_numeric($identificador_empleado))
        {
           $empleado = new empleadoDTO(trim($nombres_em), $apellido_em, $apellido_2_em, $tipo_doc, $numero_doc, $salario_base,
           $fecha_nacimiento, $genero_em, $eps_ips, trim($entidad_salud), $tipo_cargo_em, $cargo_em, $centro_trabajo, $estado_em);
           echo $this->empleadoDAO->editarEmpleado($empleado, $identificador_empleado);

        }else {
          #datos incorrectos
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
    * Metodo que depura las entrada proveniente del formulario de consulta y modificacion del empleado,
    * instancia un objeto de EmpleadoDTO y llama una funcion de EmpleadoDAO.
    * @param $identificador_empleado - identificador del empleado en la base de datos
    */
    public function obtenerEmpleado_C($nombres_em, $apellido_em, $apellido_2_em)
    {

      $jsondata = array();
      if($nombres_em != '' && $apellido_em!='' && $apellido_2_em)
      {
         if(is_string($nombres_em) && is_string($apellido_em) && is_string($apellido_2_em)){
           $empleado = new EmpleadoDTO($nombres_em, $apellido_em, $apellido_2_em);
           echo $this->empleadoDAO->consultarEmpleado($empleado);
         }else {
           #Dato incorrecto
           $jsondata['success']=-2;
           echo json_encode($jsondata);
         }

      }else{
        #Datos incompleto
        $jsondata['success']=-3;
        echo json_encode($jsondata);
      }
    }

    /**
    * Metodo que en lista los dotos necesarios para registrar o modificar un empleado
    */
    public function cargarDatosRegistroModificacion_C($id_empresa)
    {
      echo $this->empleadoDAO->cargarDatosRegistroModificacion($id_empresa);
    }

    /**
    * Devuelve un vector con los nombres, apellidos e identificador de cada empleado en la base de datos
    */
    public function cargarDatosEmpleados($id_empresa)
    {
      return $this->empleadoDAO->cargarDatosEmpleados($id_empresa);
      
    }
    
    public function cargarDatosEmpleados_C($id_empresa)
    {
      echo json_encode($this->cargarDatosEmpleados($id_empresa));      
    }


  }


?>
