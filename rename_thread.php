<?    
    require_once "libs/utility.php";
    require_once "libs/models/user.php";
    require_once "libs/models/thread.php";
    
    $threadID = htmlspecialchars($_GET['threadid']);
    $name = htmlspecialchars($_GET['name']);
    
    if (empty($threadID) || empty($name) || !isLoggedIn() || !getUser()->hasModeratorAccess()) {
        exit();
    }
    
    Thread::renameThread($threadID, $name);
    setMessage("Thread has been renamed");