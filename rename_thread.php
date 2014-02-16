<?    
/**
 * This controller handles thread renaming.
 * 
 * User should never load this directly, rather this controller is loaded
 * asynchronously with jquery, hence the lack of redirect in the end.
 * 
 * If user is not logged in or lacks proper credentials or if the request
 * url is missing parameters, this controller does nothing.
 */
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