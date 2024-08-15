<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/autoload.php";

$mail = new PHPMailer(true);

// $mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail->isSMTP();
$mail->SMTPAuth = true;


// Include the configuration file
require_once('./config.php');

// Now you can access the variables defined in config.php
$host = $config['host'];
$smtp_secure = $config['smtp_secure'];
$port = $config['port'];
$username = $config['username'];
$password = $config['password'];

// Use these variables in your PHPMailer setup or wherever needed
$mail->Host = $host;
$mail->SMTPSecure = $smtp_secure;
$mail->Port = $port;
$mail->Username = $username;
$mail->Password = $password;

$mail->isHTML(true);

return $mail;