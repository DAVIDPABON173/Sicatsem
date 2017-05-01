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
	* Plantilla para la creacion de objetos de tipo Empresa
	*/
	class EmpresaDTO {

		private $nombre_empresa;
		private $razon_social;
		private $nit_empresa;
		private $direccion_empresa;
		private $telefono_empresa;


		/**
		* Constructor de la clase Empresa donde se inicializar sus atributos
		* @param $nombre_empresa - Nombre de la Empresa
		* @param $razon_social - Razon soocial con que se identifica la Empresa
		* @param $nit_empresa - Numero de identificacion tributaria de la Empresa
		* @param $direccion_empresa - Direccion donde esta ubicada la Empresa
		* @param $telefono_empresa - Telefono de la Empresa
		*/
		public function __construct( $nombre_empresa = null, $razon_social = null, $nit_empresa = null, $direccion_empresa = null, $telefono_empresa = null)
		{
			$this->nombre_empresa = $nombre_empresa;
			$this->razon_social = $razon_social;
			$this->nit_empresa = $nit_empresa;
			$this->direccion_empresa = $direccion_empresa;
			$this->telefono_empresa = $telefono_empresa;

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

		public function get_nombre_empresa()
		{
			return $this->nombre_empresa;
		}

		public function set_nombre_empresa($nombre_empresa)
		{
			$this->nombre_empresa = $nombre_empresa;
		}

		public function get_razon_social()
		{
			return $this->razon_social;
		}

		public function set_razon_social($razon_social)
		{
			$this->razon_social = $razon_social;
		}

		public function get_nit_empresa()
		{
			return $this->nit_empresa;
		}

		public function set_nit_empresa($nit_empresa)
		{
			$this->nit_empresa = $nit_empresa;
		}

		public function get_direccion_empresa()
		{
			return $this->direccion_empresa;
		}

		public function set_direccion_empresa($direccion_empresa)
		{
			$this->direccion_empresa = $direccion_empresa;
		}

		public function get_telefono_empresa()
		{
			return $this->telefono_empresa;
		}

		public function set_telefono_empresa($telefono_empresa)
		{
			$this->telefono_empresa = $telefono_empresa;
		}



	}

?>
