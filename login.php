<?php
    /**
     * Controller that handles login requests. 
     */
  require_once "libs/utility.php";
  require_once "libs/models/user.php";
  
  if (isLoggedIn()) {
      redirect("index.php");
  }
  // if username is missing but not the password, show error message
  if (empty($_POST["username"]) && !empty($_POST["password"])) {
      setError("Please insert your username");
      showView("loginView.php");
  
      exit();
  } // password is missing
  else if (!empty($_POST["username"]) && empty($_POST["password"])) {
      setError("Please insert your password");
      showView("loginView.php");
     
      exit();
  } // botth username and password are missing - show the view without error message
  // as this could very well be the initial page load
  else if (empty($_POST["username"]) && empty($_POST["password"])) {
     showView("loginView.php");
     exit(); 
  }
  
  $username = htmlspecialchars($_POST["username"]);
  $password = htmlspecialchars($_POST["password"]);
  
  $user = User::loadUser($username, $password);
  
  // no user was found with this username/pw-combo
  if ($user == NULL) {
      setError("Incorrect username or password");
      showView("loginView.php");
  }
  
  // store the user into session
  logInUser($user); 
  
  setMessage("Welcome " . $user->getName());
  redirect("index.php");
    