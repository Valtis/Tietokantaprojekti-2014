<?php
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