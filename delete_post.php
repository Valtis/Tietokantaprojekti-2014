<?php
    /**
     * This controller is in charge of deleting posts.
     * 
     * User should never load this directly, rather this controller is loaded
     * asynchronously with jquery, hence the lack of redirect in the end.
     * 
     * If user is not logged in or lacks proper credentials or if the request
     * url is missing parameters, this controller does nothing.
     * 
     */
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
    