<?php

    require_once "libs/utility.php";
    require_once "libs/models/post.php";
    require_once "libs/models/user.php";
    require_once "libs/models/thread.php";
    
    $threadID = htmlspecialchars($_GET['threadid']);
    $topicID = htmlspecialchars($_GET['topicid']);
    $page = htmlspecialchars($_GET['page']);
    $postID = htmlspecialchars($_GET['postid']);
    if (empty($threadID) || empty($topicID)) {
        redirect("index.php");
    }
    
    if (!empty($postID)) {
        gotoPost($postID, $threadID, $topicID);
        exit();
    } else if (empty($page)) {
        redirect("index.php");
    }
    
    
    $param['title'] = "Messages";
    $param['topicid'] = $topicID;
    $param['threadid'] = $threadID;
    $param['showThreadLinks'] = true;
    $param['page'] = $page;
    $param['pages'] = floor((Thread::getThreadPostCount($threadID) - 1)/POSTS_PER_PAGE) + 1;
    
    $posts = Post::loadPosts($threadID, POSTS_PER_PAGE, ($page - 1)*POSTS_PER_PAGE);
    
    $index = 0;
    $u = getUser();
    $lastPostID = -1;
    foreach ($posts as $p) {
        // figure out which buttons to show
        // if mod/admin - show all
        // if owner of this post - show edit
       
        if (!empty($u)) {
            // moderators, admins and people who have written the post will see edit button unless the post has been marked as deleted
            if ($p->isDeleted() === false && ($u->hasModeratorAccess() || $p->getPosterID() == $u->getID())) {
                $param['posts'][$index]['showedit'] = true;
            }
            // only moderators and admins will see delete button
            if ($u->hasModeratorAccess() && $p->isDeleted() === false) {
                $param['posts'][$index]['showdelete'] = true;
            } 
            
            // anyone who is logged in and is not banned will se reply button
            if ($u->hasNormalAccess()) {
                 $param['posts'][$index]['showquote'] = true;
            }
            
        }
       
        if ($p->repliesToID() !== NULL) {
            $param['posts'][$index]['quote'] = Post::loadPost($p->repliesToID());
        }
        
        $param['posts'][$index]['postdata'] = $p;
        $index++;
        $lastPostID = $p->getPostID();
    }
    
    if (isLoggedIn() && !$u->isBanned()) {
        $param['showreply'] = true;
    }
    
    // mark thread as read, even if the user is banned
    if (isLoggedIn()) {
        Thread::markAsRead($threadID, $u->getID(), $lastPostID);
    }
    
    showView('threadView.php', $param);
    
    
    
    function gotoPost($postID, $threadID, $topicID) {
        $posts = Post::loadPosts($threadID, 30000, 0);
        
        $position = 0;
        foreach ($posts as $p) {
            
            if ($p->getPostID() == $postID) {
                break;
            }
            $position++;
        }
        $page = floor($position/POSTS_PER_PAGE) + 1;
        
        redirect("thread.php?topicid=" . $topicID . "&threadid=" . $threadID . "&page=" . $page . "#" . $postID);
    }