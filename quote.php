<?php

    require_once "libs/utility.php";
    require_once "libs/models/post.php";
    require_once "libs/models/user.php";
    
    $threadID = htmlspecialchars($_GET['threadid']);
    $topicID = htmlspecialchars($_GET['topicid']);
    $postID = htmlspecialchars($_GET['postid']);
    $submit = htmlspecialchars($_GET['submit']);
    $page = htmlspecialchars($_GET['page']);
    
    if (!isLoggedIn() || getUser()->isBanned() || empty($threadID) || empty($topicID) || empty($postID) || empty($page)) {
        redirect("index.php");
    }
    
    if (!empty($submit)) {    
        $postText = htmlspecialchars($_POST['textarea']);
        $newPostID = Post::createNewPost(getUser()->getID(), $threadID, $postText, $postID);
        setMessage("You have posted a message");
        redirect("thread.php?threadid=" . $threadID . "&topicid=" . $topicID . "&postid=" . $newPostID);
    }
    
    $post = Post::loadPost($postID);
    
    if ($post == NULL) {
        redirect("index.php");   
    }
    
    
    $param['threadid'] = $threadID;
    $param['topicid'] = $topicID;
    $param['postid'] = $postID;
    $param['post'] = $post;
    showView("quoteView.php", $param);