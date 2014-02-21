<?php
/**
 * This controller handles thread reader list.
 * 
 * If parameters are malformed, redirect user to index page
 */
    require_once "libs/utility.php";
    require_once "libs/models/user.php";
    require_once "libs/models/thread.php";

    $threadID = htmlspecialchars($_GET['threadid']);
    $topicID = htmlspecialchars($_GET['topicid']);
    $page = htmlspecialchars($_GET['page']);
    
    if (empty($threadID) || empty($topicID) || empty($page)) {
        redirect("index.php");
    }
    
    $params['title'] = "Readers";
    $params['threadid'] = $threadID;
    $params['topicid'] = $topicID;
    $params['page'] = $page;
    $params['users'] = Thread::getReaders($threadID);
    $params['pagetype'] = "readers";
    
    showView("usersView.php", $params);