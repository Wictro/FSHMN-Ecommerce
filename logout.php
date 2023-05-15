<?php
	include 'includes/authenticate_user.php';
	session_destroy();
	header("Location: index.php");
?>