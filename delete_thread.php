<?

    require_once "libs/utility.php";
    require_once "libs/models/user.php";
    require_once "libs/models/thread.php";
    $threadID = htmlspecialchars($_GET['threadid']);
     
    if (empty($threadID) || !isLoggedIn() || !getUser()->hasModeratorAccess()) {
        exit();
    }
    
    Thread::deleteThread($threadID);
    
    
    
    