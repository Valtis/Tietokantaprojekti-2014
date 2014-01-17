<?php
  require_once "libs/utility.php";
 
  
  if (empty($_POST[userName]) && !empty($_POST["password"])) {
     showView("login.php", array('error' => "Please insert your username"));
  } 
  else if (!empty($_POST[userName]) && empty($_POST["password"])) {
     showView("login.php", array('error' => "Please insert your password"));
  }
  else if (empty($_POST["userName"]) || empty($_POST["password"])) {
    showView("login.php");
    exit(); 
  }
  
  
  $username = $_POST["username"];
  $password = $_POST["password"];

  
?>