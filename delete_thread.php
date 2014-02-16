<?
    /**
     * This controller deletes thread with given id.
     * 
     * User should never load this directly, rather this controller is loaded
     * asynchronously with jquery, hence the lack of redirect in the end.
     *   
     * If user is not logged in or lacks credentials or if url is malformed, 
     * this controller does nothing.
     * 
     * 
     */
    require_once "libs/utility.php";
    require_once "libs/models/user.php";
    require_once "libs/models/thread.php";
    
    $threadID = htmlspecialchars($_GET['threadid']);
     
    if (empty($threadID) || !isLoggedIn() || !getUser()->hasModeratorAccess()) {
        exit();
    }
    
    Thread::deleteThread($threadID);
    
    
    
    