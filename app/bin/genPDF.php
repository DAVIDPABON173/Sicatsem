<?php

/*
* SICATSEM
* Sistema de Informacion para el Control de Accidentes de Trabajo en el Sector Minero
* Ingeniería de Sistemas de la UFPS.
* Autor: William Schnaider Torres Bermon <williamschnaidertb@ufps.edu.co>
* V2.0.0
* 2017
*/

require 'app/config/resourcesPDF.php';

/**
 *
 */
class PDF
{

  public static function generarPdf($view)
  {
    $pdf = new mPDF('c','A4');
    $css = file_get_contents(FORMAT_CSS);

/*
    if(!$css && $view != null){
      
    }
*/

    $pdf->writeHTML($css,1);
    $pdf->writeHTML($view);
    $pdf->Output('consolidado' . date('d/m/Y', time()).'.pdf','I');

  }



}



?>
