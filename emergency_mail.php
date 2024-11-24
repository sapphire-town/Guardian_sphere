<?php

//$name = $_POST["name"];
$name ="Guardian Sphere";

//$email = $_POST["email"];
$email = "revathi.ci22@bmsce.ac.in";
$subject = "emergency alert";
$message = "I'm in danger. Please send help https://www.google.com/maps?q=12.9414466,77.5652949&z=17&hl=en ";

require "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);

 //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
  
 
$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = "smtp.gmail.com";
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;

$mail->Username = "revathin355@gmail.com";
$mail->Password = "benpqkmblswpzefn";

$mail->setFrom($email, $name);
$mail->addAddress("revathinandish6113@gmail.com", "Police");

$mail->Subject = $subject;
$mail->Body = $message;

$mail->send();

header("Location: help.html");