<?php
    /**
     * Controller for the index.  
     */

  require_once "libs/utility.php";
  require_once "libs/models/user.php";
  require_once "libs/models/topic.php";
   
  // if user is moderator, show topic edit/delete/create buttons for them
  if (isLoggedIn() && getUser()->hasModeratorAccess()) {
      $param['showTopicButtons'] = true;
  }
   
  $param['topics'] = Topic::loadTopics();
  showView("mainView.php", $param);
