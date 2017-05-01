<?php

/*
 * SICATSEM
 * Sistema de Informacion para el Control de Accidentes de Trabajo en el Sector Minero
 * Ingeniería de Sistemas de la UFPS.
 * Autor: William Schnaider Torres Bermon <williamschnaidertb@ufps.edu.co>
 * V1.0.0
 * 2016
 */

class Controller {

    /*
    * Folder donde se encuentran las vistas
    */
     private $folderViews = 'public/html/';
     private $folderViewsPDF = 'public/formatPDF/html/';
     private $folderOverall = 'public/overall/';
     /**
     * Muestra en pantalla una vista (previamente debe haber sido renderizada)
     * @param $view - Vista a mostrar.
     */
     function showView ($view) {
         echo $view;
     }

     /**
     * Obtiene una vista desde un archivo para ser compilada y desplegada.
     * @param $fileView - Archivo a leer. Este debe ubicarse en la ruta indicada por la variable $folderViews
     * @param $case - Define que tipo de ruta raiz implementar
     * @return String con la vista cargada o falso si la vista no ha sido encontrada.
     */
     function getView ($fileView, $case) {
       if($case == 1){
         if(file_exists($this->folderViews.$fileView)) {
             return file_get_contents($this->folderViews.$fileView);
         } else {
             return false;
         }
       }elseif($case == 2){
         if(file_exists($this->folderViewsPDF.$fileView)) {
             return file_get_contents($this->folderViewsPDF.$fileView);
         } else {
             return false;
         }
       }else{
         if(file_exists($this->folderOverall.$fileView)) {
             return file_get_contents($this->folderOverall.$fileView);
         } else {
             return false;
         }
       }

     }

     /**
     * Reemplaza palabras claves de la plantilla por el contenido dinámico generado.
     * @param $archivo - Vista en la cual se realizará el reemplazo.
     * @param $clave - Palabra clave con la cual se reemplazará el contenido.
     * @param $reemplazo - Contenido dinámico que se insertará en la vista.
     * @return Vista renderizada con la inserción.
     */
     function insert($archivo, $clave, $reemplazo) {
         return str_replace($clave, $reemplazo, $archivo);
     }
 }

?>
