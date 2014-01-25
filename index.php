<?php
  require_once "libs/utility.php";
  require_once "libs/models/user.php";
  
  $param;
  if (isLoggedIn()) {
      $param = array(
        'links' => array(
         'Control panel' => "control_panel.php",
         'Log off' => 'logoff.php'   
        )  
          
      );
  } else {
      $param = array(
        'links' => array(
         'Control panel' => "control_panel.php",
         'Log in' => "login.php",
         'Register' => "register.php"
        )  
          
      );
  }
  
  
  
  showView("threadView.php", $param);