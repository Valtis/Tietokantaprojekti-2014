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
    
    if (isLoggedIn()) {
        if (getUser()->hasModeratorAccess()) {
            $param['buttons'] = true;
        }
        if (!getUser()->isBanned()) {
            $param['shownewthread'] = true;
        }
    }
    
    
    showView("threadsListView.php", $param);