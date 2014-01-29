<?
require_once 'libs/utility.php';
require_once 'libs/models/thread.php';
$topicID = htmlspecialchars($_GET['topicid']);
$submit = htmlspecialchars($_GET['submit']);
if (empty($topicID) || !isLoggedIn() || getUser()->isBanned()) {
    redirect("index.php");
}

if (!empty($submit)) {
    $title = htmlspecialchars($_POST['threadtitle']);
    $text = htmlspecialchars($_POST['textarea']);
    
    if (empty($title)) {
        setError("You need a thread title");
    } else if (empty($text)) {
         setError("Thread needs a starting post");
    } else {
        $threadID = Thread::createNewThread(getUser()->getID(), $topicID, $title, $text);
        setMessage("You have posted a thread! ");
        redirect("thread.php?topicid=" . $topicID . "&threadid=" . $threadID);
    }
}


$param['topicid'] = $topicID;


showView("newThreadView.php", $param);
