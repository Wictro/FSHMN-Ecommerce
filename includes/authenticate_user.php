<?php
  session_start();

  if(is_null($_SESSION['user'])){
    header("Location: login.php");
    die();
  }

  $user = $_SESSION['user'];
?>