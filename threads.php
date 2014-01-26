<?php
    require_once "libs/utility.php";
    require_once "libs/models/thread.php";
    
    $topicID = htmlspecialchars($_GET['topicid']);
    
    if (empty($topicID)) {
        redirect("index.php");
    }
    
    
    $param['threads'] =  Thread::loadThreads($topicID);
    
    showView("threadsListView.php", $param);