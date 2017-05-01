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
	* Plantilla para la creacion de objetos de tipo Empleado
	*/
	class EmpleadoDTO {

		private $nombres_em;
		private $apellido_em;
		private $apellido_2_em;
		private $tipo_doc;
		private $numero_doc;
		private $salario_base;
		private $fecha_nacimiento;
		private $genero_em;
		private $eps_ips;
		private $entidad_salud;
		private $tipo_cargo_em;
		private $cargo_em;
		private $centro_trabajo;
		private $estado_em;

		/**
		* Constructor de la clase Empleado donde se inicializaran sus atributos
		* @param $nombre_em - Nombre del Empleado
		* @param $apellido_em - Primer apellido del Empleado
		* @param $apellido_2_em - Segundo apellido del Empleado
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
		public function __construct($nombres_em = null, $apellido_em =null, $apellido_2_em = null, $tipo_doc = null, $numero_doc = null , $salario_base =null, $fecha_nacimiento = null, $genero_em = null, $eps_ips =null, $entidad_salud = null, $tipo_cargo_em =null, $cargo_em =null, $centro_trabajo = null,$estado_em = null)
		{
			$this->nombres_em = $nombres_em;
			$this->apellido_em = $apellido_em;
			$this->apellido_2_em = $apellido_2_em;
			$this->tipo_doc = $tipo_doc;
			$this->numero_doc = $numero_doc;
			$this->salario_base = $salario_base;
			$this->fecha_nacimiento = $fecha_nacimiento;
			$this->genero_em = $genero_em;
			$this->eps_ips = $eps_ips;
			$this->entidad_salud = $entidad_salud;
			$this->tipo_cargo_em = $tipo_cargo_em;
			$this->cargo_em = $cargo_em;
			$this->centro_trabajo = $centro_trabajo;
			$this->estado_em = $estado_em;

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

		public function get_nombres_em()
		{
			return $this->nombres_em;
		}

		public function set_nombres_em($nombres_em)
		{
			$this->nombres_em = $nombres_em;
		}

		public function get_apellido_em()
		{
			return $this->apellido_em;
		}

		public function set_apellido_em($apellido_em)
		{
			$this->apellido_em = $apellido_em;
		}

		public function get_apellido_2_em()
		{
			return $this->apellido_2_em;
		}

		public function set_apellido_2_em($apellido_2_em)
		{
			$this->apellido_2_em = $apellido_2_em;
		}

		public function get_tipo_doc()
		{
			return $this->tipo_doc;
		}

		public function set_tipo_doc($tipo_doc)
		{
			$this->tipo_doc = $tipo_doc;
		}

		public function get_numero_doc()
		{
			return $this->numero_doc;
		}

		public function set_numero_doc($numero_doc)
		{
			$this->numero_doc = $numero_doc;
		}

		public function get_salario_base()
		{
			return $this->salario_base;
		}

		public function set_salario_base($salario_base)
		{
			$this->salario_base = $salario_base;
		}

		public function get_fecha_nacimiento()
		{
			return $this->fecha_nacimiento;
		}

		public function set_fecha_nacimiento($fecha_nacimiento)
		{
			$this->fecha_nacimiento = $fecha_nacimiento;
		}

		public function get_genero_em()
		{
			return $this->genero_em;
		}

		public function set_genero_em($genero_em)
		{
			$this->genero_em = $genero_em;
		}

		public function get_eps_ips()
		{
			return $this->eps_ips;
		}

		public function set_eps_ips($eps_ips)
		{
			$this->eps_ips = $eps_ips;
		}

		public function get_entidad_salud()
		{
			return $this->entidad_salud;
		}

		public function set_entidad_salud($entidad_salud)
		{
			$this->entidad_salud = $entidad_salud;
		}

		public function get_tipo_cargo_em()
		{
			return $this->tipo_cargo_em;
		}

		public function set_tipo_cargo_em($tipo_cargo_em)
		{
			$this->tipo_cargo_em = $tipo_cargo_em;
		}

		public function get_cargo_em()
		{
			return $this->cargo_em;
		}

		public function set_cargo_em($cargo_em)
		{
			$this->cargo_em = $cargo_em;
		}

		public function get_centro_trabajo()
		{
			return $this->centro_trabajo;
		}

		public function set_centro_trabajo($centro_trabajo)
		{
			$this->centro_trabajo = $centro_trabajo;
		}


		public function get_estado_em()
		{
			return $this->estado_em;
		}

		public function set_estado_em($estado_em)
		{
			$this->estado_em = $estado_em;
		}
	}

 ?>
