<?php

/*
 * SICATSEM
 * Sistema de Informacion para el Control de Accidentes de Trabajo en el Sector Minero
 * Ingeniería de Sistemas de la UFPS.
 * Autor: William Schnaider Torres Bermon <williamschnaidertb@ufps.edu.co>
 * V1.0.0
 * 2016
 */

  /**
  * Controlador encargado de realizar las operaciones propias de la cuenta.
  * @extends Controller - herramientas genericas para los Controladores
  */

  class CuentaController extends controller
  {

    /**
    * DAO encargado de las operaciones propias de la cuenta.
    */
    private $cuentaDAO;


    /**
    * Constructor de CuentaController. Inicializa el DAO cuentaDAO.
    */
    function __construct()
    {
      $this->cuentaDAO = new CuentaDAO();
    }

    /**
	 	* Metodo que valida las entradas del formulario de registro de Empresay y Cuenta,
    * instancia un objeto CuentaDTO e invoca un metodo de CuentaDAO.
	 	* @param $email_cuenta - Correo electronico de la Cuenta
	 	* @param $pass_cuenta -  Clave de acceso
    * @param $res_empresa - Respuesta de registra de la empresa
	 	*/
    public function registrarCuenta_C($email_cuenta, $pass_cuenta, $res_empresa)
    {
      $jsondata = array();
      if($email_cuenta != '' && $pass_cuenta != '')
      {
        if(filter_var($email_cuenta, FILTER_VALIDATE_EMAIL) )
        {
          $email_cuenta = htmlspecialchars($email_cuenta);
          $pass_cuenta = htmlspecialchars($pass_cuenta);
          $cuenta = new cuentaDTO($email_cuenta, $pass_cuenta);
          echo $this->cuentaDAO->registrarCuenta($cuenta ,$res_empresa);
        }else{
          #correo no valido
          $jsondata['success']=-2;
          echo json_encode($jsondata);
        }

      }else{
        #faltan datos
        $jsondata['success']=-3;
        echo json_encode($jsondata);
      }
    }

    public function changeEmail_C($email_cuenta, $email_anterior)
    {
      $jsondata = array();
      if($email_cuenta != '')
      {

        if(filter_var($email_cuenta, FILTER_VALIDATE_EMAIL) )
        {
          $email_cuenta = htmlspecialchars($email_cuenta);
          $email_anterior = htmlspecialchars($email_anterior);
          $cuenta = new cuentaDTO($email_cuenta);
          echo $this->cuentaDAO->changeEmail($cuenta, $email_anterior);
        }else{
          #correo no valido
          $jsondata['success']=-2;
          echo json_encode($jsondata);
        }

      }else{
        #faltan datos
        $jsondata['success']=-3;
        echo json_encode($jsondata);
      }

    }

    public function changePassword_C($email_cuenta, $pass_cuenta, $pass_cuenta_2, $pass_ant)
    {
      $jsondata = array();
      if($pass_cuenta != '' && $pass_cuenta_2 != '' &&  $email_cuenta != '' && filter_var($email_cuenta, FILTER_VALIDATE_EMAIL))
      {
        if($pass_cuenta == $pass_cuenta_2)
        {
          $pass_cuenta= htmlspecialchars($pass_cuenta);
          $cuenta = new cuentaDTO($email_cuenta, $pass_cuenta);
          echo $this->cuentaDAO->changePassword($cuenta, $pass_ant);
        }else{
          #contraseñas diferentes
          $jsondata['success']=-2;
          echo json_encode($jsondata);
        }

      }else{
        #faltan datos
        $jsondata['success']=-3;
        echo json_encode($jsondata);
      }

    }

    /**
	 	* Metodo que valida las entradas del formulario de inicio de sesion,
    * instancia un objeto CuentaDTO e invoca un metodo de CuentaDAO.
	 	* @param $email_cuenta - Correo electronico de la Cuenta
	 	* @param $pass_cuenta -  Clave de acceso
	 	*/
    public function iniciarSesion_C($email_cuenta, $pass_cuenta, $sesion)
    {
      $jsondata = array();
      if($email_cuenta != '' && $pass_cuenta != '')
      {
        if(filter_var($email_cuenta, FILTER_VALIDATE_EMAIL) )
        {
          $email_cuenta = htmlspecialchars($email_cuenta);
          $pass_cuenta = htmlspecialchars($pass_cuenta);
          $cuenta = new cuentaDTO($email_cuenta, $pass_cuenta);
          echo $this->cuentaDAO->iniciarSesion($cuenta, $sesion);
        }else{
          #correo no valido
          $jsondata['success']=-2;
          echo json_encode($jsondata);
        }

      }else{
        #faltan datos
        $jsondata['success']=-3;
        echo json_encode($jsondata);
      }

    }


    /**
    * Cierra la sesión actualmente iniciada, y redirige a la vista de inicio de sesión.
    */
    public function cerrarSesion_C() {
      $this->cuentaDAO->cerrarSesion();
      header('Location: index.php');
    }

    /**
	 	* Metodo que valida la entrada proveniente del formulario de recuperacion de cuenta,
    * instancia un objeto CuentaDTO e invoca un metodo de CuentaDAO.
    * @param $email_cuenta_lostpass - Correo electronico de la Cuenta
	 	*/
    public function recuperarCuenta_C($email_cuenta_lostpass)
    {
      $jsondata = array();
      if($email_cuenta_lostpass != '')
      {
        if(filter_var($email_cuenta_lostpass, FILTER_VALIDATE_EMAIL))
        {
          $email_cuenta_lostpass = htmlspecialchars($email_cuenta_lostpass);
          $cuenta = new CuentaDTO($email_cuenta_lostpass);
          echo $this->cuentaDAO->recuperarCuenta($cuenta);
          #respuesta
        }else {
        #correo no valido
        $jsondata['success']=-2;
        echo json_encode($jsondata);
        }

      }else{
        #faltan datos
        $jsondata['success']=-3;
        echo json_encode($jsondata);
      }

    }

  }





?>
