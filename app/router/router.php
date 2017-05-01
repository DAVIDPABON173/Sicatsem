<?php
/*
 * SICATSEM
 * Sistema de Informacion para el Control de Accidentes de Trabajo en el Sector Minero
 * Ingeniería de Sistemas de la UFPS.
 * Autor: William Schnaider Torres Bermon <williamschnaidertb@ufps.edu.co>
 * V1.0.0
 * 2016
 */


  require_once 'app/controllers/accidenteTrabajoController.php';
  require_once 'app/controllers/centroTrabajoController.php';
  require_once 'app/controllers/cuentaController.php';
  require_once 'app/controllers/empleadoController.php';
  require_once 'app/controllers/empresaController.php';
  require_once 'app/controllers/valoracionMedicaController.php';
  require_once 'app/controllers/visualizadorController.php';

  /**
   *
   */

  class Router
  {

    /*
    Controlador del accidente de Trabajo
     */
    private $at;

    /*
    Controlador del centro de Trabajo
     */
    private $centro;

    /*
    Controlador de la cuenta de la empresa
     */
    private $cuenta;

    /*
    Controlador del empleado
     */
    private $empleado;

    /*
    Controlador de empresa
     */
    private $empresa;

    /*
    Controlador de la valoracion medica del empleado
     */
    private $valoracionMedica;

    /*
    Controlador de las visualizaciones y flujo de datos de los desplegables de las vistas
     */
    private $visual;

    /*
      Método constructor. Crea los controladores de la aplicacion e implementa el metodo redireccionar
    */
    function __construct()
    {
    $this->at = new AccidenteTrabajoController();
      $this->centro = new CentroTrabajoController();
      $this->cuenta = new CuentaController();
      $this->empleado = new EmpleadoController();
      $this->empresa = new EmpresaController();
      $this->valoracionMedica = new ValoracionMedicaController();
      $this->visual = new Visualizador();
      //$this->visual->prueba($this->at,$this->empleado,2);
      $this->redireccionar();

    }

    /*
    *  Método redireccionar. Toda petición iniciará el enrutador, y mediante este metodo será
    *  redirigido a la función o ruta requerida.
    */
    public function redireccionar(){

      if(sizeof($_GET)== 0 && sizeof($_POST) == 0 && isset($_SESSION['id_empresa']))
      {
        $this->visual->showAdmin();

      }else if (sizeof($_GET)== 0 && sizeof($_POST) == 0 ) {
        $this->visual->showHome();

      }else if (isset($_GET['mode'])){

        # Registros - POST

          if(isset($_POST['ope']) && $_POST['ope']=='reg'){

            if($_GET['mode']=='reg_empr'){
                 $res_empresa = array();

                 $res_empresa = $this->empresa->registrarEmpresa_C($_POST['nombre_empresa'], $_POST['razon_social'], $_POST['nit_empresa'],
                                                            $_POST['direccion_empresa'], $_POST['telefono_empresa']);

                 $this->cuenta->registrarCuenta_C($_POST['email_empresa'], $_POST['pass_cuenta'], $res_empresa);

            }else if($_GET['mode']=='reg_cent' && isset($_SESSION['id_empresa'])){
                 $this->centro-> registrarCentroTrabajo_C($_SESSION['id_empresa'], $_POST['nombre_centro'], $_POST['departamento_centro'],
                 $_POST['municipio_centro'], $_POST['direccion_centro'], $_POST['telefono_centro']);

            }else if($_GET['mode']=='reg_empl' && isset($_SESSION['id_empresa'])){
                 $this->empleado->registrarEmpleado_C($_POST['nombres_em'], $_POST['apellido_em'], $_POST['apellido_2_em'], $_POST['tipo_doc'],
                 $_POST['numero_doc'], $_POST['salario_base'], $_POST['fecha_nacimiento'], $_POST['genero_em'], $_POST['eps_ips'],
                 $_POST['entidad_salud'], $_POST['tipo_cargo_em'], $_POST['cargo_em'], $_POST['centro_trabajo']);

            }else if($_GET['mode']=='reg_acci' && isset($_SESSION['id_empresa'])){
                 $this->at->registrarAccidenteTrabajo_C($_POST['fiatep_at'], $_POST['identificador_empleado'], $_POST['fecha_at'], $_POST['jornada_at'], $_POST['muerte_em'],
                  $_POST['labor_habitual_em'], $_POST['tipo_at'], $_POST['zona_at'], $_POST['lugar_at'], $_POST['sitio_at'], $_POST['tipo_lesion_at'], $_POST['parte_cuerpo_em'], $_POST['agente_at'],
                  $_POST['mecanismo_at'], $_POST['con_amb_peligrosa'], $_POST['acto_inseguro'],   $_POST['fisiologica_inadecuada'], $_POST['mental_inadecuada'], $_POST['tension_fisica'],
                  $_POST['tension_mental'], $_POST['falta_conocimiento'], $_POST['falta_habilidad'], $_POST['motivacion_deficiente'], $_POST['sup_deficiente'], $_POST['ing_inadecuada'],
                  $_POST['deficiencia_adquisiciones'], $_POST['mant_deficiente'], $_POST['equipos_inadecuados'], $_POST['estand_deficientes_trab'], $_POST['desgaste'], $_POST['maltrato'],
                  $_POST['limpieza_equipo'], $_POST['omitir_proteccion'], $_POST['no_asegurar'], $_POST['bromas'], $_POST['uso_impropio_manos'],$_POST['uso_impropio_equipos'],$_POST['falta_atencion'], $_POST['inop_disp_seguridad'],
                  $_POST['opera_vel_inseguras'], $_POST['adoptar_pos_insegura'], $_POST['errores_conduccion'], $_POST['colocar_inseguramente'], $_POST['usar_equipo_inseguro'],
                  $_POST['defecto_agente'], $_POST['riesgos_ropa'], $_POST['riesgos_ambientales'], $_POST['metodos_peligrosos'],$_POST['riesgos_colocacion'], $_POST['inadecuada_proteccion'],
                  $_POST['riesgos_publicos']);

            }else if($_GET['mode']=='reg_valo' && isset($_SESSION['id_empresa'])){
                 $this->valoracionMedica->registrarValoracionMedica_C($_POST['identificador_at'], $_POST['codigo_valoracion'], $_POST['dias_incapacidad'],
                 $_POST['observacion']);
            }

        #Modificiaciones - POST

          }else if(isset($_POST['ope']) && $_POST['ope']=='mod' && isset($_SESSION['id_empresa'])){

            if($_GET['mode']=='mod_empr'){

                 $this->empresa->editarEmpresa_C($_POST['nombre_empresa'], $_POST['razon_social'], $_POST['nit_empresa'], $_POST['direccion_empresa'],
                 $_POST['telefono_empresa'] , $_SESSION['id_empresa']);


            }else if($_GET['mode']=='mod_cent'){
                 $this->centro->editarCentroTrabajo_C($_SESSION['id_empresa'], $_POST['nombre_centro'], $_POST['departamento_centro'],
                 $_POST['municipio_centro'], $_POST['direccion_centro'], $_POST['telefono_centro'], $_POST['identificador_centro']);

            }else if($_GET['mode']=='mod_empl'){
                 $this->empleado->editarEmpleado_C($_POST['nombres_em'], $_POST['apellido_em'], $_POST['apellido_2_em'], $_POST['tipo_doc'],
                 $_POST['numero_doc'], $_POST['salario_base'],$_POST['fecha_nacimiento'], $_POST['genero_em'], $_POST['eps_ips'],
                 $_POST['entidad_salud'], $_POST['tipo_cargo_em'], $_POST['cargo_em'], $_POST['centro_trabajo'], $_POST['estado_em'] ,$_POST['identificador_empleado']);

            }else if($_GET['mode']=='mod_acci'){
                 $this->at->editarAccidenteTrabajo_C($_POST['fiatep_at'], $_POST['identificador_empleado'], $_POST['fecha_at'], $_POST['jornada_at'], $_POST['muerte_em'],
                  $_POST['labor_habitual_em'], $_POST['tipo_at'], $_POST['zona_at'], $_POST['lugar_at'], $_POST['sitio_at'], $_POST['tipo_lesion_at'], $_POST['parte_cuerpo_em'], $_POST['agente_at'],
                  $_POST['mecanismo_at'], $_POST['con_amb_peligrosa'], $_POST['acto_inseguro'],   $_POST['fisiologica_inadecuada'], $_POST['mental_inadecuada'], $_POST['tension_fisica'],
                  $_POST['tension_mental'], $_POST['falta_conocimiento'], $_POST['falta_habilidad'], $_POST['motivacion_deficiente'], $_POST['sup_deficiente'], $_POST['ing_inadecuada'],
                  $_POST['deficiencia_adquisiciones'], $_POST['mant_deficiente'], $_POST['equipos_inadecuados'], $_POST['estand_deficientes_trab'], $_POST['desgaste'], $_POST['maltrato'],
                  $_POST['limpieza_equipo '], $_POST['omitir_proteccion'], $_POST['no_asegurar'], $_POST['bromas'] , $_POST['uso_impropio_manos'] , $_POST['uso_impropio_equipos'],$_POST['falta_atencion'], $_POST['inop_disp_seguridad'],
                  $_POST['opera_vel_inseguras'], $_POST['adoptar_pos_insegura'], $_POST['errores_conduccion'], $_POST['colocar_inseguramente'], $_POST['usar_equipo_inseguro'],
                  $_POST['defecto_agente'], $_POST['riesgos_ropa'], $_POST['riesgos_ambientales'], $_POST['metodos_peligrosos'],$_POST['riesgos_colocacion'], $_POST['inadecuada_proteccion'],
                  $_POST['riesgos_publicos'], $_POST['fiatep_at_anterior']);

            }else if($_GET['mode']=='mod_valo'){
                 $this->valoracionMedica->editarValoracionMedica_C($_POST['identificador_at'], $_POST['codigo_valoracion'], $_POST['dias_incapacidad'],
                 $_POST['dias_prorroga'], $_POST['observacion']);
            }
         #Consultas - POST

          }else if(isset($_POST['ope']) && $_POST['ope']=='con' && isset($_SESSION['id_empresa'])){

            if($_GET['mode']=='con_empr'){
              $this->empresa->obtenerEmpresa_C($_SESSION['id_empresa']);

            }else if($_GET['mode']=='con_cent'){
              $this->centro->obtenerCentroTrabajo_C($_POST['nombre_centro']);

            }else if($_GET['mode']=='con_empl'){
              $this->empleado->obtenerEmpleado_C($_POST['nombres_em'], $_POST['apellido_em'], $_POST['apellido_2_em']);

            }else if($_GET['mode']=='con_acci'){
              $this->at->obtenerAccidenteTrabajo_C($_POST['fiatep_at']);

            }else if($_GET['mode']=='con_valo'){
              $this->valoracionMedica->obtenerValoracionMedica_C($_POST['identificador_at']);

            }else if($_GET['mode']=='con_cod_valo'){
              $this->valoracionMedica->consultarCodigoValoracion_C($_POST['cod_valo']);

            }

          }else{

            # Cargar Vistas - Sin POST

            if ($_GET['mode']=='registrar_empresa') {
              $this->visual->publishView('registrar_empresa.html');

            }else if ($_GET['mode']=='recuperar_cuenta') {
              $this->visual->publishView('recuperar_cuenta.html');

            }else if(isset($_SESSION['id_empresa'])){

              if($_GET['mode']=='consolidado'){
                  $this->visual->publishView('estadisticasConsolidado.html');

              }elseif ($_GET['mode']=='estadisticas') {
                  $this->visual->publishView('estadisticas.html');

              }elseif ($_GET['mode']=='consultar_centro') {
                $this->visual->publishView('consulta_centroTrabajo.html');

              }else if($_GET['mode']=='consultar_empleado'){
                $this->visual->publishView('consulta_empleado.html');

              }elseif ($_GET['mode']=='consultar_accidente') {
                $this->visual->publishView('consulta_at.html');

              }elseif ($_GET['mode']=='consultar_valoracion') {
                $this->visual->publishView('consulta_valoracion.html');

              }elseif ($_GET['mode']=='registro_centro') {
                $this->visual->publishView('registro_centroTrabajo.html');

              }elseif ($_GET['mode']=='registro_empleado') {
                $this->visual->publishView('registro_empleado.html');

              }elseif ($_GET['mode']=='registro_accidente') {
                $this->visual->publishView('registro_at.html');

              }elseif ($_GET['mode']=='registro_valoracion') {
                $this->visual->publishView('registro_valoracion.html');

              }elseif ($_GET['mode']=='configuraciones') {
                $this->visual->publishView('configuraciones.html');

              }elseif ($_GET['mode']=='close') {
                $this->cuenta->cerrarSesion_C();

              }elseif ($_GET['mode']=='generacion_consolidado') {
                $this->visual->publishConsolidado($_POST['id_centro'], $_POST['fecha1'], $_POST['fecha2']);
              }

            }else {
              $this->visual->showHome();
            }
          }

      }else if(isset($_POST['mode'])){

        if($_POST['mode']=='login'){
          $this->cuenta->iniciarSesion_C($_POST['email_empresa'], $_POST['pass_cuenta'], $_POST['sesion']);

        }else if ($_POST['mode']=='rec_cuenta') {
          $this->cuenta->recuperarCuenta_C($_POST['email_cuenta_lostpass']);

        }else {

          if(isset($_SESSION['id_empresa'])){

            if ($_POST['mode']=='changePassword') {
              $this->cuenta->changePassword_C($_POST['email_cuenta'],$_POST['pass_cuenta'], $_POST['pass_cuenta_2'], $_POST['pass_ant']);

            } else if($_POST['mode']=='changeEmail'){
              $this->cuenta->changeEmail_C($_POST['email_cuenta'], $_POST['email_anterior']);

            }elseif ($_POST['mode']=='generacion_consolidado' && isset($_POST['html'])) {
              $this->visual->generarConsolidadoPDF($_POST['html']);
              
            }else if ($_POST['mode']=='est') {

              if($_POST['num_est'] == 1){
                $this->at->estadisticaVariablexFechas_C($_SESSION['id_empresa'] ,$_POST['nom_tabla'], $_POST['nom_id_tabla'], $_POST['nom_var_tabla'], $_POST['nom_var_at'], $_POST['fecha1'],$_POST['fecha2']);

              } else if($_POST['num_est'] == 2){
                $this->at->estadisticaVariablexCentros_C($_SESSION['id_empresa'] ,$_POST['nom_tabla'], $_POST['nom_id_tabla'], $_POST['nom_var_tabla'], $_POST['nom_var_at'], $_POST['id_centro']);

              } else if($_POST['num_est'] == 3){
                $this->at->estadisticaVariablexFechasCentros_C($_SESSION['id_empresa'], $_POST['nom_tabla'], $_POST['nom_id_tabla'], $_POST['nom_var_tabla'], $_POST['nom_var_at'], $_POST['id_centro'], $_POST['fecha1'], $_POST['fecha2']);

              } else if($_POST['num_est'] == 4){
                $this->at->estadisticaCantidadATxFechas_C($_SESSION['id_empresa'] ,$_POST['fecha1'],$_POST['fecha2']);

              } else if($_POST['num_est'] == 5){
                $this->at->estadisticaCantidadATxCentros_C($_SESSION['id_empresa'],$_POST['id_centro']);

              } else if($_POST['num_est'] == 6){
                $this->at->estadisticaCantidadATxFechasCentros_C($_SESSION['id_empresa'],$_POST['id_centro'],$_POST['fecha1'],$_POST['fecha2']);

              }elseif ($_POST['num_est']== 7) {
                $this->at->generarConsolidado($_SESSION['id_empresa'], $_POST['id_centro'],$_POST['fecha1'],$_POST['fecha2']);
              }



            }

            if(isset($_POST['ope']) && $_POST['ope']=='cmb'){

              if($_POST['mode']=='cmb_reg_cent' || $_POST['mode']=='cmb_mod_cent'){
                $this->centro->cargarDatosRegistroModificacion_C($_POST['departamento_centro']);

              }else if($_POST['mode']=='cmb_reg_empl' || $_POST['mode']=='cmb_mod_empl'){
                $this->empleado->cargarDatosRegistroModificacion_C($_SESSION['id_empresa']);

              }else if($_POST['mode']=='cmb_reg_acci' || $_POST['mode']=='cmb_mod_acci'){
                $this->visual->cargarDatosRegistroModificacionAT_C($this->at , $this->empleado, $_SESSION['id_empresa']);

              }else if($_POST['mode']=='cmb_con_cent'){
                $this->centro->cargarDatosConsulta_C($_SESSION['id_empresa']);

              }else if($_POST['mode']=='cmb_con_acci' || $_POST['mode']=='cmb_con_valo'){
                $this->at->cargarDatosConsulta_C_2($_SESSION['id_empresa']);

              }else if($_POST['mode']=='cmb_reg_valo'){
                $this->at->cargarDatosConsulta_C($_SESSION['id_empresa']);

              }else if($_POST['mode']=='cmb_reg_acc'){
               $this->empleado->cargarDatosEmpleados_C($_SESSION['id_empresa']);

              }else if($_POST['mode']=='cmb_sub_agente'){
               $this->at->obtenerSubTipoAgenteAT_C($_POST['super_agente']);

              }else if($_POST['mode']=='cmb_sub_lesion'){
               $this->at->obtenerSubTipoLesionAT_C($_POST['super_tipo_lesion']);

              }else if($_POST['mode']=='cmb_sub_parte'){
               $this->at->obtenerSubTipoParteCuerpo_C($_POST['super_tipo_parte']);

              }

            } else if (isset($_POST['ope']) && $_POST['ope']=='sub') {

              if ($_POST['mode']=='con_sub_lesion') {
                $this->at->obtenerSubTipoLesionAT_C($_POST['tipo_lesion_at']);

              } else if ($_POST['mode']=='con_sub_parte') {
                $this->at->obtenerSubTipoParteCuerpo_C($_POST['parte_cuerpo_em']);

              } else if ($_POST['mode']=='con_sub_agente') {
                $this->at->obtenerSubTipoAgenteAT_C($_POST['agente_at']);
              }

            }
        }
      }

      }else {
        $this->visual->showHome();
      }
    }

  }


?>
