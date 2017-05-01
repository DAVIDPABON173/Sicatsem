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
	* Plantilla para la creacion de objetos de tipo Valoracion Medica
	*/
	class ValoracionMedicaDTO {

		private $identificador_at;
		private $codigo_valoracion;
		private $dias_incapacidad;
		private $dias_prorroga;
		private $observacion;

		/**
		* Constructor de la clase ValoracionMedica donde se inicializaran sus atributos.
		* @param $identificador_at -	Numero que referencia la Valoracion Medica con un accidente
		* @param $codigo_valoracion - Numero que identifica la valoracion medica del accidente
		* @param $dias_incapacidad - Dias de incapacidad que se asignan en la valoracion medica del accidentea un empleado accidentado
		* @param $dias_prorroga - Dias extendidos a los dias de incapacidad
		* @param $observacion - anotaciones u observaciones de la valoracion medica
		*/
		public function __construct( $identificador_at = null, $codigo_valoracion = null, $dias_incapacidad = null, $dias_prorroga = null, $observacion = null)
		{
			$this->identificador_at = $identificador_at;
			$this->codigo_valoracion = $codigo_valoracion;
			$this->dias_incapacidad = $dias_incapacidad;
			$this->dias_prorroga = $dias_prorroga;
			$this->observacion = $observacion;
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

		public function get_identificador_at()
		{
			return $this->identificador_at;
		}

		public function set_identificador_at($identificador_at)
		{
			$this->identificador_at = $identificador_at;
		}

		public function get_codigo_valoracion()
		{
			return $this->codigo_valoracion;
		}

		public function set_codigo_valoracion($codigo_valoracion)
		{
			$this->codigo_valoracion = $codigo_valoracion;
		}

		public function get_dias_incapacidad()
		{
			return $this->dias_incapacidad;
		}

		public function set_dias_incapacidad($dias_incapacidad)
		{
			$this->dias_incapacidad = $dias_incapacidad;
		}

		public function get_dias_prorroga()
		{
			return $this->dias_prorroga;
		}

		public function set_dias_prorroga($dias_prorroga)
		{
			$this->dias_prorroga = $dias_prorroga;
		}

		public function get_observacion()
		{
			return $this->observacion;
		}

		public function set_observacion($observacion)
		{
			$this->observacion = $observacion;
		}

	}

 ?>
