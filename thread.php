<?php

    require_once "libs/utility.php";
    require_once "libs/models/post.php";
    require_once "libs/models/user.php";
    
    $threadID = htmlspecialchars($_GET['threadid']);
    $topicID = htmlspecialchars($_GET['topicid']);
    
    if (empty($threadID) || empty($topicID)) {
        redirect("index.php");
    }
    
    $param['topicid'] = $topicID;
    $param['threadid'] = $threadID;
    $posts = Post::loadPosts($threadID);
    
    $index = 0;
    foreach ($posts as $p) {
        // figure out which buttons to show
        // if mod/admin - show all
        // if owner of this post - show edit
        $u = getUser();
        if (!empty($u)) {
            // moderators, admins and people who have written the post will see edit button
            if ($u->hasModeratorAccess() || $p->getPosterID() == $u->getID()) {
                $param['posts'][$index]['showedit'] = true;
            }
            // only moderators and admins will see delete button
            if ($u->hasModeratorAccess()) {
                $param['posts'][$index]['showdelete'] = true;
            } 
            // anyone who is logged in and is not banned will se reply button
            if ($u->hasNormalAccess()) {
                 $param['posts'][$index]['showreply'] = true;
            }
            
        }
        
        $param['posts'][$index]['postdata'] = $p;
        $index++;
    }
    
    showView('threadView.php', $param);