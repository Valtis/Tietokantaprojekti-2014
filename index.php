<?php
  require_once "libs/utility.php";
  require_once "libs/models/user.php";
  require_once "libs/models/topic.php";
   
  if (isLoggedIn() && getUser()->hasModeratorAccess()) {
      $param['showTopicButtons'] = true;
  }
   
  $param['topics'] = Topic::loadTopics();
  showView("mainView.php", $param);
