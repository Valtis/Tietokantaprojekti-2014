<?php
    require_once "libs/utility.php";
    require_once "libs/models/user.php";
    require_once "libs/models/thread.php";

    $threadID = htmlspecialchars($_GET['threadid']);
    $topicID = htmlspecialchars($_GET['topicid']);
    
    if (empty($threadID) || empty($topicID)) {
        redirect("index.php");
    }
    
    $params['threadid'] = $threadID;
    $params['topicid'] = $topicID;
    
    
    
    $params['users'] = Thread::getReaders($threadID);
    
    showView("readerView.php", $params);