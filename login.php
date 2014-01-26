<?php
  require_once "libs/utility.php";
  require_once "libs/models/user.php";
  
  if (isLoggedIn()) {
      redirect("index.php");
  }
  
  if (empty($_POST["username"]) && !empty($_POST["password"])) {
      setError("Please insert your username");
      showView("loginView.php");
  
      exit();
  } 
  else if (!empty($_POST["username"]) && empty($_POST["password"])) {
      setError("Please insert your password");
      showView("loginView.php");
     
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
      setError("Incorrect username or password");
      showView("loginView.php");
  }
  
  logInUser($user);
  
  setMessage("Welcome " . $user->getName());
  redirect("index.php");
    