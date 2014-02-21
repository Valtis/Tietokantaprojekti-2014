<?php
  require_once 'models/user.php'; 
  session_start();
  
  const POSTS_PER_PAGE = 10;
  /**
   * Helper function; shows requested view and passes parameters forward
   * 
   * @param string $page view name
   * @param array $data. Contains data that view will use
   */
  function showView($page, $data = array()) {
    $page = "views/" . $page; 
    $raw_data = $data; // data in raw form
    $data = (object)$data; // data in object form
    require 'views/base.php';
    exit();
  }
  
  /**
   *  removes user from session data
   */
  function logOffUser() {
      $_SESSION['user'] = NULL;
  }
  /**
   * Adds user to session
   * 
   * @param User $user. User object
   */
  function logInUser($user) {
      $_SESSION['user'] = $user;
  }
  /**
   * Returns user object from session.
   * @return User. User object
   */
  function getUser() {
      return $_SESSION['user'];
  }
  /**
   * Helper function. Creates the "Hello, username" string for main link bar
   * Also appends (BANNED) if user is banned.
   * @return string. User name string
   */
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
  /**
   * Decides which links will be shown in the main bar. Depends on if user is logged in
   * or not. Main page and search will always be shown. Control panel, log off, log in 
   * and register links depend on login status.
   * 
   * 
   * @return map containing page name - link data pairs. Link data contains key-value-pairs
   * such as 'page' - page link or 'onclick' - function name
   */
  function getMainBar() {
    $param;
    if (isLoggedIn()) {
        $param = array(
            'Log off' => array('page' => "#", 'onclick' => 'logoff()')
          );
        if (!getUser()->isBanned()) {
            $param['Control panel'] = array('page' => "control_panel.php");
        }
    } else {
        $param = array(
           'Log in' => array('page' => "login.php"),
           'Register' => array('page' => "register.php")
        );
    }
    $param['Main page'] = array('page' => "index.php");
    $param['Search'] = array('page' => "search.php");
    return $param;
 }
  /**
   * Returns true if user is logged in, false otherwise
   * 
   * @return boolean
   */
  function isLoggedIn() {
      return !empty($_SESSION['user']);
  }
  /**
   * Sets error message. Old message is overridden
   * 
   * @param string $msg Error message
   */
  function setError($msg) {
      $_SESSION['error'] = $msg;
  }
  
  /**
   * Sets regular message. Old message is overriden
   * @param string $msg. Message
   */
  function setMessage($msg) {
      $_SESSION['msg'] = $msg;
  }
  /**
   * Shows messages
   */
  function getMessages() {
      
      // somewhat ugly. I don't really like how there is html code here. Probably 
      // should be refactored.
      if (isset($_SESSION['error'])) {
          $param['error'] = $_SESSION['error'];
          unset($_SESSION['error']);
      }   
      
      if (isset($_SESSION['msg'])) {
          $param['msg'] = $_SESSION['msg'];   
          unset($_SESSION['msg']);
      }      
      return $param;
  }
  /**
   * Opens new page in same tab
   * @param type $controller. Page controller which should be opened
   */
  function redirect($controller) {
      header("Location: " . $controller);  
      exit();
  }