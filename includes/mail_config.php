<?php
  require $_SERVER['DOCUMENT_ROOT'] . '/ecommerce/vendor/phpmailer/phpmailer/src/Exception.php';
  require $_SERVER['DOCUMENT_ROOT'] . '/ecommerce/vendor/phpmailer/phpmailer/src/PHPMailer.php';
  require $_SERVER['DOCUMENT_ROOT'] . '/ecommerce/vendor/phpmailer/phpmailer/src/SMTP.php';

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

	$phpmailer = new PHPMailer();
	$phpmailer->isSMTP();
	$phpmailer->Host = 'sandbox.smtp.mailtrap.io';
	$phpmailer->SMTPAuth = true;
	$phpmailer->Port = 2525;
	$phpmailer->Username = '';
	$phpmailer->Password = '';
	$phpmailer->SMTPSecure = 'tls';
?>