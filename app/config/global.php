<?php

/*
 * SICATSEM
 * Sistema de Informacion para el Control de Accidentes de Trabajo en el Sector Minero
 * Ingeniería de Sistemas de la UFPS.
 * Autor: William Schnaider Torres Bermon <williamschnaidertb@ufps.edu.co>
 * V2.0.0
 * 2017
 */


 /**
 * Se requieren los DAO
 */
 require_once 'app/model/DAO/accidenteTrabajoDAO.php';
 require_once 'app/model/DAO/centroTrabajoDAO.php';
 require_once 'app/model/DAO/cuentaDAO.php';
 require_once 'app/model/DAO/empleadoDAO.php';
 require_once 'app/model/DAO/empresaDAO.php';
 require_once 'app/model/DAO/valoracionMedicaDAO.php';
 require_once 'app/model/DAO/model.php';

 /**
 * Se requieren los DTO
 */
 require_once 'app/model/DTO/accidenteTrabajoDTO.php';
 require_once 'app/model/DTO/centroTrabajoDTO.php';
 require_once 'app/model/DTO/cuentaDTO.php';
 require_once 'app/model/DTO/empleadoDTO.php';
 require_once 'app/model/DTO/empresaDTO.php';
 require_once 'app/model/DTO/valoracionMedicaDTO.php';


 /*
 * Se requieren los Controladores
 */

 require_once 'app/controllers/accidenteTrabajoController.php';
 require_once 'app/controllers/centroTrabajoController.php';
 require_once 'app/controllers/cuentaController.php';
 require_once 'app/controllers/empleadoController.php';
 require_once 'app/controllers/empresaController.php';
 require_once 'app/controllers/valoracionMedicaController.php';
 require_once 'app/controllers/visualizadorController.php';


 require 'vendor/autoload.php';



?>
