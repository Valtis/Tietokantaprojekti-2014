<?php
/** 
 * Controller that deals with threads and their posts
 * 
 * If thread\topic id parameters are malformed, redirect user to index page
 * 
 */

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
    // if post id is given, find the page where this post is, and reload this controller
    if (!empty($postID)) {
        gotoPost($postID, $threadID, $topicID);
        exit();
    } else if (empty($page)) { // if no page is given, redirect to index
        redirect("index.php"); 
    }
    
    
    $param['title'] = "Messages"; // Set title as messages (view is shared with private messages, can't hardcode the name)
    $param['topicid'] = $topicID;
    $param['threadid'] = $threadID;
    $param['showThreadLinks'] = true;
    $param['page'] = $page;
    // how many pages there are 
    $param['pages'] = floor((Thread::getThreadPostCount($threadID) - 1)/POSTS_PER_PAGE) + 1;
    
    $posts = Post::loadPosts($threadID, POSTS_PER_PAGE, ($page - 1)*POSTS_PER_PAGE);
    
    $index = 0;
    $u = getUser();
    $lastPostID = -1;
    foreach ($posts as $p) {
        // figure out which buttons to show
        // if mod/admin - show all
        // if owner of this post - show edit
       
        if (!empty($u) && $p->isDeleted() === false) {
            // moderators, admins and people who have written the post will see edit button unless the post has been marked as deleted
            if ($u->hasModeratorAccess() || $p->getPosterID() == $u->getID()) {
                $param['posts'][$index]['showedit'] = true;
            }
            // only moderators and admins will see delete button unless the post has been marked as deleted
            if ($u->hasModeratorAccess()) {
                $param['posts'][$index]['showdelete'] = true;
            } 
            
            // anyone who is logged in and is not banned will see quote button unless the post has been marked as deleted
            if ($u->hasNormalAccess()) {
                 $param['posts'][$index]['showquote'] = true;
            }
        }
       
        // if this post is a reply to other post, load that post so that view can deal with it 
        if ($p->repliesToID() !== NULL) {
            $param['posts'][$index]['quote'] = Post::loadPost($p->repliesToID());
        }
        
        $param['posts'][$index]['postdata'] = $p;
        $index++;
        $lastPostID = $p->getPostID(); // update last post id
    }
    
    // show reply button as long as user is logged in and is not banned
    if (isLoggedIn() && !$u->isBanned()) {
        $param['showreply'] = true;
        $param['showPrivateUrl'] = true;
    }
    
    
    // mark thread as read, even if the user is banned
    if (isLoggedIn()) {
        Thread::markAsRead($threadID, $u->getID(), $lastPostID);
    }
    
    showView('threadView.php', $param);
    
    
    /**
     * Helper function. Deals with the case where controller was used with postid
     * field instead of page. Finds the page where post resides, and reloads the page
     * with that parameter.
     * 
     * Parameters are required for url construction
     * 
     * @param integer $postID
     * @param integer $threadID
     * @param integer $topicID
     */
    function gotoPost($postID, $threadID, $topicID) {
        
        if ($postID == -1) {
            redirect("thread.php?topicid=" . $topicID . "&threadid=" . $threadID . "&page=1");
        }

        $position = Post::getPostPositionInThread($postID);
        $page = floor($position/POSTS_PER_PAGE) + 1;
        
        redirect("thread.php?topicid=" . $topicID . "&threadid=" . $threadID . "&page=" . $page . "#" . $postID);
    }