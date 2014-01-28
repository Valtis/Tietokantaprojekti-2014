<?php

    require_once "libs/utility.php";
    require_once "libs/models/user.php";
    require_once "libs/models/post.php";
    $postID = htmlspecialchars($_GET['postid']);
     
    if (empty($postID) || !isLoggedIn() || !getUser()->hasModeratorAccess()) {
        exit();
    }
    
    $post = Post::loadPost($postID);
    $post->markAsDeleted(getUser()->getName());
    $post->savePost();
    
    