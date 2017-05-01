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
	* Plantilla para la creacion de objetos de tipo Centro de Trabajo
	*/
	class CentroTrabajoDTO {

		private $identificador_empresa;
		private $nombre_centro;
		private $departamento_centro;
		private $municipio_centro;
		private $direccion_centro;
		private $telefono_centro;

		/**
		* Constructor de la clase CetroTrabajo donde se inicializaran sus atributos
		* @param $identificador_empresa - Referencia a la empresa que pertenece el centro
		* @param $nombre_centro - Nombre del centro de trabajo
		* @param $departamento_centro - Departamento donde se encuentra el centro de trabajo
		* @param $municipio_centro - Municipio donde se encuentra el centro de trabajo
		* @param $direccion_centro - Direccion donde se encuentra el centro de trabajo
		* @param $telefono_centro - Telefono del centro de trabajo
		*/
		public function __construct($identificador_empresa = null ,$nombre_centro = null,$departamento_centro = null,$municipio_centro = null,$direccion_centro=null ,$telefono_centro = null)
		{
			$this->identificador_empresa = $identificador_empresa;
			$this->nombre_centro = $nombre_centro;
			$this->departamento_centro = $departamento_centro;
			$this->municipio_centro = $municipio_centro;
			$this->direccion_centro = $direccion_centro;
			$this->telefono_centro = $telefono_centro;
		}

		/**
		* Medoto destructor del Obj
		*/
		public function __destruct(){
			unset($this);

		}

		/**
		*Metodos get y set
		*/

		public function get_identificador_empresa()
		{
			return $this->identificador_empresa;
		}

		public function set_identificador_empresa($identificador_empresa)
		{
			$this->identificador_empresa = $identificador_empresa;
		}

		public function get_nombre_centro()
		{
			return $this->nombre_centro;
		}

		public function set_nombre_centro($nombre_centro)
		{
			$this->nombre_centro = $nombre_centro;
		}

		public function get_departamento_centro()
		{
			return $this->departamento_centro;
		}

		public function set_departamento_centro($departamento_centro)
		{
			$this->departamento_centro = $departamento_centro;
		}

		public function get_municipio_centro()
		{
			return $this->municipio_centro;
		}

		public function set_municipio_centro($municipio_centro)
		{
			$this->municipio_centro = $municipio_centro;
		}

		public function get_direccion_centro()
		{
			return $this->direccion_centro;
		}

		public function set_direccion_centro($direccion_centro)
		{
			$this->direccion_centro = $direccion_centro;
		}

		public function get_telefono_centro()
		{
			return $this->telefono_centro;
		}

		public function set_telefono_centro($telefono_centro)
		{
			$this->telefono_centro = $telefono_centro;
		}







	}

?>
