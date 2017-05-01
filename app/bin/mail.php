<?php

/*
* SICATSEM
* Sistema de Informacion para el Control de Accidentes de Trabajo en el Sector Minero
* Ingeniería de Sistemas de la UFPS.
* Autor: William Schnaider Torres Bermon <williamschnaidertb@ufps.edu.co>
* V2.0.0
* 2017
*/


require 'app/config/phpmailer.php';

class Mail
{

  public static function sendMail($emisor, $message, $asunto_correo, $correo_cuenta)
  {
    $jsondata = array();

    $mail = new PHPMailer;

    $mail->isSMTP();
    $mail->Host = PHPMailer_HOST;
    $mail->SMTPAuth = PHPMailer_SMTPAuth;
    $mail->Username = PHPMailer_USER;
    $mail->Password = PHPMailer_PASS;
    $mail->SMTPSecure = PHPMailer_SMTPSecure;
    $mail->Port = PHPMailer_PUERTO;

    $mail->setFrom('sicatsem@gmail.com', $emisor);
    $mail->addAddress($correo_cuenta);

    $mail->isHTML(PHPMailer_isHTML);

    $mail->Subject = $asunto_correo;
    $mail->Body    = $message;
    #$mail->AltBody = static::getMessage(false);
    $mail->CharSet = PHPMailer_CharSet;

    if(!$mail->send()) {
      $jsondata['answer'] = -1;
      $jsondata['data']= $mail->ErrorInfo;
    } else {
      $jsondata['answer']=1;
    }
    return $jsondata;
  }

}

?>
