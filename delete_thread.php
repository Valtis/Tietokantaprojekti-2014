<?

    require_once "libs/utility.php";
    require_once "libs/models/user.php";
    require_once "libs/models/thread.php";
    $threadid = htmlspecialchars($_GET['threadid']);
     
    if (empty($threadid) || !isLoggedIn() || !getUser()->hasModeratorAccess()) {
        exit();
    }
    
    Thread::deleteThread($threadid);
    
    
    
    