<?php
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
    
    if (isLoggedIn()) {
        if (getUser()->hasModeratorAccess()) {
            $param['buttons'] = true;
        }
        if (!getUser()->isBanned()) {
            $param['loggedin'] = true;        
        }
    }
    
    foreach ($threads as $t) {
        if (isLoggedIn() && !getUser()->isBanned()) { 
            $post = Post::loadLastReadPostFromThread($t->getID(), getUser()->getID());

            $text = "Yes";
            if (!empty($post)) {
                $id = $post->getPostID();
                if ($post->getPostDate() == $t->getLastPostDate()) {
                    $text = "No";
                }
            } else {
                $id = -1;
            }

            
        }
        $param['threads'][$t->getID()] = array('thread' => $t, 'lastreadtext' => $text, 'lastreadid' => $id );
    }
    
    
    
    showView("threadsListView.php", $param);