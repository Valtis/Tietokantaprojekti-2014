<?php
  function showView($page, $data = array()) {
    $page = "views/" . $page;
    $data = (object)$data;
    require 'views/base.php';
    exit();
  }
  
?>