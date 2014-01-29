<?php
  require_once 'models/user.php';
  session_start();

  function showView($page, $data = array()) {
    $page = "views/" . $page;
    $raw_data = $data;
    $data = (object)$data;
    require 'views/base.php';
    exit();
  }
  
  function useController($controller, $data = array()) {
      $this->_redirect($controller);
  }
   function logOffUser() {
      $_SESSION['user'] = NULL;
  }
  
  function logInUser($user) {
      $_SESSION['user'] = $user;
  }
  
  function getUser() {
      return $_SESSION['user'];
  }
  
  function getName() {
      if (isLoggedIn()) {
          $u = getUser();
          if ($u->isBanned()) {
            return $u->getName() . " (BANNED)";  
          } else {
            return "Hello, "  . $u->getName();
          }
      }
      
      return "";     
  }
  
  function getMainBar() {
    $param;
    if (isLoggedIn()) {
        $param = array(
            'Control panel' => array('page' => "control_panel.php"),
            'Log off' => array('page' => "#", 'onclick' => 'logoff()')
          );
    } else {
        $param = array(
           'Log in' => array('page' => "login.php"),
           'Register' => array('page' => "register.php")
        );
    }
    $param['Main page'] = array('page' => "index.php");
    return $param;
 }
  
  function isLoggedIn() {
      return !empty($_SESSION['user']);
  }
    
  function setError($msg) {
      $_SESSION['error'] = $msg;
  }
  
  
  function setMessage($msg) {
      $_SESSION['msg'] = $msg;
  }
  
  function showMessage() {
      // todo: clean up
      if (!(empty($_SESSION['error']))) {
          
          echo '<div class="alert-danger">';
          echo '<div class="left-margin">' . $_SESSION['error'] . '</div>';
          echo '</div>';          
          $_SESSION['error'] = NULL;
      }   
      
      if (!(empty($_SESSION['msg']))) {
          
          echo '<div class="alert-success">';
          echo '<div class="left-margin">' . $_SESSION['msg'] . '</div>';
          echo '</div>';          
          $_SESSION['msg'] = NULL;
      }      
  }
  
  function redirect($controller) {
      header("Location: " . $controller);  
  }