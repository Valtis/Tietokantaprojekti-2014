<?php
    /**
     * Controller which handles thread listing.
     * 
     * If topic id is missing, redirect user to index page
     */
    require_once "libs/utility.php";
    require_once "libs/models/thread.php";
    require_once "libs/models/user.php";
    require_once "libs/models/post.php";
    
    $topicID = htmlspecialchars($_GET['topicid']);
    
    if (empty($topicID)) {
        redirect("index.php");
    }
    
    
    $threads =  Thread::loadThreads($topicID);
    $param['topicid'] = $topicID;
    
    // if user is logged in and has moderator access, show delete/rename buttons for threads
    if (isLoggedIn()) {
        if (getUser()->hasModeratorAccess()) {
            $param['buttons'] = true;
        }
        // banned user is treated as not being logged in
        if (!getUser()->isBanned()) {
            $param['loggedin'] = true;        
        }
    }
    // load data from each thread
    foreach ($threads as $t) {
        // non-banned-users will see if thread has unread messages  
        if (isLoggedIn() && !getUser()->isBanned()) { 
            
            $post = Post::loadLastReadPostFromThread($t->getID(), getUser()->getID());

            $text = "Yes";
            // if user has read thread before, see if the read post is same than last post in thread
            // if so, change text to no
            if (!empty($post)) {
                $id = $post->getPostID();
                if ($post->getPostDate() == $t->getLastPostDate()) {
                    $text = "No";
                }
            } else {
                $id = -1; // set id to -1 as user has not read any posts. Will show first page of the thread
            }
        }
        $param['threads'][$t->getID()] = array('thread' => $t, 'lastreadtext' => $text, 'lastreadid' => $id );
    }
    
    
    
    showView("threadsListView.php", $param);