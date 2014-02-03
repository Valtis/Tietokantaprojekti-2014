<?php

    require_once "libs/utility.php";
    require_once "libs/models/user.php";
    require_once "libs/models/post.php";
    
    $postID = htmlspecialchars($_GET['postid']);
         
    if (empty($postID) || !isLoggedIn() || getUser()->isBanned()) {
        exit();
    }    

    
    if (Post::isPrivateMessage($postID, getUser()->getID())) {
        Post::deletePost($postID);        
    } else if (getUser()->hasModeratorAccess()) {
        $post = Post::loadPost($postID);
        $post->markAsDeleted(getUser()->getName());
        $post->savePost();
    }
    