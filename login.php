<?php
  require_once "libs/utility.php";
  
  $username = $_POST["inputUserName"];
  $password = $_POST["inputPassword"];

  
  
  echo "Username: " . $username . "<br>";
  echo "Password: " . $password . "<br>";
  echo '$_POST: ';
  echo var_dump($_POST) . "<br>";
  echo '$_GET: ';
  echo var_dump($_GET) . "<br>";
  
  
  if (empty($_POST["inputUsername"]) && !empty($_POST["inputPassword"])) {
      showView("loginView.php", array('error' => "Please insert your username"));
  
      exit();
  } 
  else if (!empty($_POST["inputUsername"]) && empty($_POST["inputPassword"])) {
     showView("loginView.php", array('error' => "Please insert your password"));
     
     exit();
  }
  else if (empty($_POST["inputUsername"]) && empty($_POST["inputPassword"])) {
    showView("loginView.php", array('error' => "Username and pw"));
   
    exit(); 
  }
  
  

  
?>