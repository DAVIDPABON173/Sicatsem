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
	* Plantilla para la creacion de objetos de tipo Cuenta
	*/
	class CuentaDTO {

	 	private $email_cuenta;
	 	private $pass_cuenta;
	 	private $identificador_empresa;

	 	/**
	 	* Constructor de la clase Cuenta donde se inicializaran todos sus atributos
	 	* @param $email_cuenta - Correo electronico de la Cuenta
	 	* @param $pass_cuenta -  Clave de acceso
	 	* @param $identificador_empresa - Llave primaria de la empresa en la base de datos
		*/
	 	public function __construct($email_cuenta = null ,$pass_cuenta = null ,$identificador_empresa = null)
		{
			$this->email_cuenta = $email_cuenta;
		 	$this->pass_cuenta = $pass_cuenta;
		 	$this->identificador_empresa = $identificador_empresa;
		}

		/**
		* Medoto destructor del Obj
		*/
		public function __destruct(){
			unset($this);

		}

		/**
		* Metodos get y set
		*/

		public function get_email_cuenta()
		{
			return $this->email_cuenta;
		}

		public function set_email_cuenta($email_cuenta)
		{
			$this->email_cuenta = $email_cuenta;
		}

		public function get_pass_cuenta()
		{
			return $this->pass_cuenta;
		}

		public function set_pass_cuenta($pass_cuenta)
		{
			$this->pass_cuenta = $pass_cuenta;
		}

		public function get_key_activacion()
		{
			return $this->key_activacion;
		}

		public function set_key_activacion($key_activacion)
		{
			$this->key_activacion = $key_activacion;
		}

		public function get_key_loss_pass()
		{
			return $this->key_loss_pass;
		}

		public function set_key_loss_pass($key_loss_pass)
		{
			$this->key_loss_pass = $key_loss_pass;
		}

		public function get_new_pass()
		{
			return $this->new_pass;
		}

		public function set_new_pass($new_pass)
		{
			$this->new_pass = $new_pass;
		}

	}

 ?>
