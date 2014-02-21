<?php
    /**
     * This controller handles replies with quote.
     * 
     * If user is not logged in or if they are banned, or if the url is malformed,
     * redirect them to index page
     */
    require_once "libs/utility.php";
    require_once "libs/models/post.php";
    require_once "libs/models/user.php";
    
    $threadID = htmlspecialchars($_GET['threadid']);
    $topicID = htmlspecialchars($_GET['topicid']);
    $postID = htmlspecialchars($_GET['postid']);
    $submit = htmlspecialchars($_GET['submit']);
    
    if (!isLoggedIn() || getUser()->isBanned() || empty($threadID) || empty($topicID) || empty($postID)) {
        redirect("index.php");
    }
    

    // if the submit field exists, submit the reply
    if (!empty($submit)) {    
        $postText = htmlspecialchars($_POST['textarea']);
        $newPostID = Post::createNewPost(getUser()->getID(), $threadID, $postText, $postID);
        setMessage("You have posted a message");
        redirect("thread.php?threadid=" . $threadID . "&topicid=" . $topicID . "&postid=" . $newPostID);
    }
    // check that the quoted post actually exists; if not, redirect to index
    $post = Post::loadPost($postID);
    
    if ($post == NULL) {
        redirect("index.php");   
    }
    

    // if submit field does not exists, show the associated view
    
    $param['threadid'] = $threadID;
    $param['topicid'] = $topicID;
    $param['postid'] = $postID;
    $param['post'] = $post;
    showView("quoteView.php", $param);