<?php
    require_once "libs/utility.php";
    require_once "libs/models/thread.php";
    require_once "libs/models/user.php";
    
    $topicID = htmlspecialchars($_GET['topicid']);
    
    if (empty($topicID)) {
        redirect("index.php");
    }
    
    
    $param['threads'] =  Thread::loadThreads($topicID);
    $param['topicid'] = $topicID;
    
    if (isLoggedIn() && getUser()->hasModeratorAccess()) {
        $param['buttons'] = true;
    }
    
    
    showView("threadsListView.php", $param);