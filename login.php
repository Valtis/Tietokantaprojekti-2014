<?php
  require_once "libs/utility.php";
  require_once "libs/models/user.php";
  
  
  if (empty($_POST["username"]) && !empty($_POST["password"])) {
      showView("loginView.php", array('error' => "Please insert your username"));
  
      exit();
  } 
  else if (!empty($_POST["username"]) && empty($_POST["password"])) {
     showView("loginView.php", array('error' => "Please insert your password"));
     
     exit();
  }
  else if (empty($_POST["username"]) && empty($_POST["password"])) {
    showView("loginView.php");
    exit(); 
  }
  
  $username = htmlspecialchars($_POST["username"]);
  $password = htmlspecialchars($_POST["password"]);
  
  $user = User::loadUser($username, $password);
  
  if ($user == NULL) {
      showView("loginView.php", array('error' => "Incorrect username or password"));
  } 
  
  showView("loginView.php", array('error' => "Logged in as " . $user->getName() . " (add redirect to correct page!)"));
