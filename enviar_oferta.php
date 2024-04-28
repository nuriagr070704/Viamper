<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'PHPMailer/Exception.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/PHPMailer.php';

$nombre = $_POST["nombre"];
$correo = $_POST["correo"];
$oferta = $_POST["oferta"];
$codigo = $_POST["codigo"];

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp-mail.outlook.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'n.gurillo22563@culturalbadalona.com';                     //SMTP username
    $mail->Password   = 'Nvapeec_070704';                               //SMTP password
    $mail->SMTPSecure = 'starttls';            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('n.gurillo22563@culturalbadalona.com', 'Nuria');
    $mail->addAddress($correo, $nombre);     //Add a recipient
    //$mail->addAddress('ellen@example.com');               //Name is optional
    

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = '¡Gracias por tu reciente compra!';
    $mail->Body    = 'Te hemos preparado una sorpresa...<br> Te regalamos una oferta '.$oferta.' para que la disfrutes.<br>El código es el siguiente: '.$codigo;

    $mail->send();
    echo "<script>window.location.replace('Usuario.php');</script>";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}