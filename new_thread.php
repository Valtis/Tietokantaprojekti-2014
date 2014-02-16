<?
/**
 * This controller handles new thread creation. 
 * 
 * If user is not logged in or if they are banned, or if the url is malformed,
 * redirect them to index page
 * 
 * 
 */


require_once 'libs/utility.php';
require_once 'libs/models/thread.php';
require_once 'libs/models/post.php';

$topicID = htmlspecialchars($_GET['topicid']);
$submit = htmlspecialchars($_GET['submit']);

if (empty($topicID) || !isLoggedIn() || getUser()->isBanned()) {
    redirect("index.php");
}
// if submit parameter was in the url, submit new thread and redirect user to this thread
if (!empty($submit)) {
    $title = htmlspecialchars($_POST['threadtitle']);
    $text = htmlspecialchars($_POST['textarea']);
    
    // check for valid title and text. Unlike regular post, we require the post
    // to be not empty as thread without opening post is worthless.
    
    if (empty($title)) {
        setError("You need a thread title");
    } else if (empty($text)) {
         setError("Thread needs a starting post");
    } else {
        $threadID = Thread::createNewThread(getUser()->getID(), $topicID, $title, $text);
        setMessage("You have posted a thread! ");
        redirect("thread.php?topicid=" . $topicID . "&threadid=" . $threadID . "&postid=-1");
    }
}

// if no submit parameter was specified, 
$param['topicid'] = $topicID;


showView("newThreadView.php", $param);
