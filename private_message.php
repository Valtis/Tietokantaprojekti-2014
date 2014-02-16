<?php 
/**
 * Controller in charge of private message sending.
 * 
 *  If user is not logged in or if they are banned, or if url is malformed,
 *  redirect user to index page
 */

require_once "libs/utility.php";
require_once "libs/models/user.php";
require_once "libs/models/post.php";

$threadID = htmlspecialchars($_GET['threadid']);
$topicID = htmlspecialchars($_GET['topicid']);
$userID = htmlspecialchars($_GET['userid']);
$page = htmlspecialchars($_GET['page']);
$submit = htmlspecialchars($_GET['submit']);


if (empty($userID) || !isLoggedIn() || getUser()->isBanned()) {
    redirect("index.php");
}


// todo - find a better way for this, feels really hacky - should probably include redirect-parameter or something
// basically we can send private messages by clicking user name in thread view, 
// control panel user listand thread reader list
// we need these values to decide where to redirect after submitting the private message
// Reader view redirect is not implemented - now redirects to user_management.php - FIXME

if (!empty($threadID) && !empty($topicID) && !empty($page)) {
    $_SESSION['redirectPage'] = 'thread.php?threadid=' . $threadID . '&topicid=' . $topicID . "&page=" . $page;
} else {
    $_SESSION['redirectPage'] = 'user_management.php';
}
// if user attempts to send private messages to themselves, redirect them back to
// previous page
if (getUser()->getID() == $userID) {
    redirectHelper();  
}

// if target user does not exist, redirect the user
$u = User::loadUserByID($userID);
if ($u == NULL) {
    redirectHelper();  
}

$param['name'] = $u->getName();

// if submit parameter exists, send the private message
// we allow emptyposting if user really wants to do that
if (!empty($submit)) {    
    $postText = htmlspecialchars($_POST['textarea']);
    Post::createNewPrivateMessage(getUser()->getID(), $userID, $postText);
    setMessage("You have sent a private message");
    redirectHelper();    
}
// if no submit was specified, show the page view
$param['threadid'] = $threadID;
$param['topicid'] = $topicID;
$param['userid'] = $userID;
$param['page'] = $page;
showView("privateMessageView.php", $param);


/**
 * Helper function for redirects
 * Picks the page stored in session, empties the value and then redirects the user
 */
function redirectHelper() {
    $redirect = $_SESSION['redirectPage'];
    $_SESSION['redirectPage'] = NULL;
    redirect($redirect);
}