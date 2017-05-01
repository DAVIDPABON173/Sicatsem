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
	* Plantilla para la creacion de objetos de tipo Acidente de Trabajo
	*/
	class AccidenteTrabajoDTO {

		private $fiatep_at;
		private $identificador_empleado;
		private $fecha_at;
		private $jornada_at;
		private $muerte_em;
		private $labor_habitual_em;
		private $tipo_at;
		private $zona_at;
		private $lugar_at;
		private $sitio_at;
		private $tipo_lesion_at;
		private $parte_cuerpo_em;
		private $agente_at;
		private $mecanismo_at;
		private $con_amb_peligrosa;
		private $acto_inseguro;
		private $causa_factor_personal;
		private $causa_factor_trabajo;
		private $causa_acto_sub_subestandar;
		private $causa_cond_amb_sub;



		/**
    * Constructor de la clase Accidentes de  trabajos donde se inicializaran todos sus atributos
    * @param $fiatep_at - Codigo del accidente de trabajo
    * @param $identificador_empleado - Id que referencia al empleado
    * @param $fecha_at - Fecha de ocurrencia del accidente
    * @param $jornada_at - Tipo de jornada en que sucede el accidente
    * @param $muerte_em - Si/No
    * @param $labor_habitual_em - Si/No
    * @param $tipo_at - Tipo de accidente
    * @param $zona_at - Zona del accidente
    * @param $lugar_at - Lugar de ocurrencia del accidente
    * @param $sitio_at - Sitipo del accidente
    * @param $tipo_lesion_at - Tipo de lesion que sufre el empleado
    * @param $parte_cuerpo_em - Parte del cuerpodel empleado
    * @param $agente_at - Agente del accidente
    * @param $mecanismo_at - Mecanismo o forma de accidente
    * @param $con_amb_peligrosa - Condicion ambiental peligrosa
    * @param $acto_inseguro - Acto inseguo realizado
    */
		public function __construct($fiatep_at = null ,$identificador_empleado = null , $fecha_at = null , $jornada_at = null , $muerte_em = null ,
		 	 $labor_habitual_em = null , $tipo_at = null, $zona_at = null, $lugar_at = null, $sitio_at = null,$tipo_lesion_at = null ,
			 $parte_cuerpo_em = null,$agente_at = null ,$mecanismo_at = null ,$con_amb_peligrosa = null ,$acto_inseguro = null, $causa_factor_personal = null,
	 		 $causa_factor_trabajo = null, $causa_acto_sub_subestandar = null, $causa_cond_amb_sub = null)
		{
			$this->fiatep_at = $fiatep_at;
			$this->identificador_empleado = $identificador_empleado;
			$this->fecha_at = $fecha_at;
			$this->jornada_at = $jornada_at;
			$this->muerte_em = $muerte_em;
			$this->labor_habitual_em = $labor_habitual_em;
			$this->tipo_at = $tipo_at;
			$this->zona_at = $zona_at;
			$this->lugar_at = $lugar_at;
			$this->sitio_at = $sitio_at;
			$this->tipo_lesion_at = $tipo_lesion_at;
			$this->parte_cuerpo_em = $parte_cuerpo_em;
			$this->agente_at = $agente_at;
			$this->mecanismo_at = $mecanismo_at;
			$this->con_amb_peligrosa = $con_amb_peligrosa;
			$this->acto_inseguro = $acto_inseguro;
			$this->causa_factor_personal = $causa_factor_personal;
			$this->causa_factor_trabajo = $causa_factor_trabajo;
			$this->causa_acto_sub_subestandar = $causa_acto_sub_subestandar;
			$this->causa_cond_amb_sub =  $causa_cond_amb_sub;
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

		public function get_fiatep_at()
		{
			return $this->fiatep_at;
		}

		public function set_fiatep_at($fiatep_at)
		{
			$this->fiatep_at = $fiatep_at;
		}

		public function get_identificador_empleado()
		{
			return $this->identificador_empleado;
		}

		public function set_identificador_empleado($identificador_empleado)
		{
			$this->identificador_empleado = $identificador_empleado;
		}

		public function get_fecha_at()
		{
			return $this->fecha_at;
		}

		public function set_fecha_at($fecha_at)
		{
			$this->fecha_at = $fecha_at;
		}

		public function get_jornada_at()
		{
			return $this->jornada_at;
		}

		public function set_jornada_at($jornada_at)
		{
			$this->jornada_at = $jornada_at;
		}

		public function get_muerte_em()
		{
			return $this->muerte_em;
		}

		public function set_muerte_em($muerte_em)
		{
			$this->muerte_em = $muerte_em;
		}

		public function get_labor_habitual_em()
		{
			return $this->labor_habitual_em;
		}

		public function set_labor_habitual_em($labor_habitual_em)
		{
			$this->labor_habitual_em = $labor_habitual_em;
		}

		public function get_tipo_at()
		{
			return $this->tipo_at;
		}

		public function set_tipo_at($tipo_at)
		{
			$this->tipo_at = $tipo_at;
		}

		public function get_zona_at()
		{
			return $this->zona_at;
		}

		public function set_zona_at($zona_at)
		{
			$this->zona_at = $zona_at;
		}

		public function get_lugar_at()
		{
			return $this->lugar_at;
		}

		public function set_lugar_at($lugar_at)
		{
			$this->lugar_at = $lugar_at;
		}

		public function get_sitio_at()
		{
			return $this->sitio_at;
		}

		public function set_sitio_at($sitio_at)
		{
			$this->sitio_at = $sitio_at;
		}

		public function get_tipo_lesion_at()
		{
			return $this->tipo_lesion_at;
		}

		public function set_tipo_lesion_at($tipo_lesion_at)
		{
			$this->tipo_lesion_at = $tipo_lesion_at;
		}

		public function get_parte_cuerpo_em()
		{
			return $this->parte_cuerpo_em;
		}

		public function set_parte_cuerpo_em($parte_cuerpo_em)
		{
			$this->parte_cuerpo_em = $parte_cuerpo_em;
		}

		public function get_agente_at()
		{
			return $this->agente_at;
		}

		public function set_agente_at($agente_at)
		{
			$this->agente_at = $agente_at;
		}

		public function get_mecanismo_at()
		{
			return $this->mecanismo_at;
		}

		public function set_mecanismo_at($mecanismo_at)
		{
			$this->mecanismo_at = $mecanismo_at;
		}

		public function get_con_amb_peligrosa()
		{
			return $this->con_amb_peligrosa;
		}

		public function set_con_amb_peligrosa($con_amb_peligrosa)
		{
			$this->con_amb_peligrosa = $con_amb_peligrosa;
		}

		public function get_acto_inseguro()
		{
			return $this->acto_inseguro;
		}

		public function set_acto_inseguro($acto_inseguro)
		{
			$this->acto_inseguro = $acto_inseguro;
		}

		public function get_causa_factor_personal()
		{
			return $this->causa_factor_personal;
		}

		public function set_causa_factor_personal($causa_factor_personal)
		{
			$this->causa_factor_personal = $causa_factor_personal;
		}

		public function get_causa_factor_trabajo()
		{
			return $this->causa_factor_trabajo;
		}

		public function set_causa_factor_trabajo($causa_factor_trabajo)
		{
			$this->causa_factor_trabajo = $causa_factor_trabajo;
		}

		public function get_causa_acto_sub_subestandar()
		{
			return $this->causa_acto_sub_subestandar;
		}

		public function set_causa_acto_sub_subestandar($causa_acto_sub_subestandar)
		{
			$this->causa_acto_sub_subestandar = $causa_acto_sub_subestandar;
		}

		public function get_causa_cond_amb_sub()
		{
			return $this->causa_cond_amb_sub;
		}

		public function set_causa_cond_amb_sub($causa_cond_amb_sub)
		{
			$this->causa_cond_amb_sub = $causa_cond_amb_sub;
		}




}

 ?>
