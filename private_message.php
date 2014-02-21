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


$userID = htmlspecialchars($_GET['userid']);
$submit = htmlspecialchars($_GET['submit']);

if (empty($userID) || !isLoggedIn() || getUser()->isBanned()) {
    setError("precondition failure");
    redirect("index.php");
}

// if submit parameter exists, send the private message
// we allow emptyposting if user really wants to do that
if (!empty($submit))
{
    // if no redirect page is set - redirect to index
    // should only happen if user tampers with the url parameters
    if (empty($_SESSION['redirectPage']))
    {
        redirect("index.php");
    }
    
    $postText = htmlspecialchars($_POST['textarea']);
    Post::createNewPrivateMessage(getUser()->getID(), $userID, $postText);
    setMessage("You have sent a private message");
    redirectHelper();    
}

setRedirectPage();

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
$param['userid'] = $userID;
showView("privateMessageView.php", $param);


/**
 * Helper function for redirects
 * Picks the page stored in session, empties the value and then redirects the user
 */
function redirectHelper() {
    $redirect = $_SESSION['redirectPage'];
    unset($_SESSION['redirectPage']);
    redirect($redirect);
}
/**
 * Helper function that sets the redirect page based on redirect-parameter
 * Checks parameters and calls the set up function if everything is in order
 */
function setRedirectPage()
{
    $redirect = htmlspecialchars($_GET['redirect']);
    // no redirect page given - redirect to index
    if (empty($redirect)) {
        redirect("index.php");
    }
    
    setRedirects($redirect);
}
/**
 * Sets up the correct redirect page
 * 
 * @param type $redirect redirect parameter
 */
function setRedirects($redirect) {
    if ($redirect === "thread") {
        threadAndReadersRedirect("thread.php");
    } else if ($redirect === "readers") {
        threadAndReadersRedirect("readers.php");
    } else if ($redirect === "userlist") {
        userListRedirect();
    } else if ($redirect === "privatemessagelist") {
        privateMessageRedirect();
    } else {
        redirect("index.php");
    } 
}

function threadAndReadersRedirect($pageUrl) {
    $page = htmlspecialchars($_GET['page']);
    $threadID = htmlspecialchars($_GET['threadid']);
    $topicID = htmlspecialchars($_GET['topicid']);
    // missing parameters - redirect to url
    if (empty($page) || empty($threadID) || empty($topicID)) {
        redirect("index.php");
    }
    $_SESSION['redirectPage'] = $pageUrl . "?threadid=" . $threadID. "&topicid=" . $topicID . "&page=" . $page;  
}

function userListRedirect() {
    $_SESSION['redirectPage'] = "user_management.php";
}

function privateMessageRedirect() {
    $_SESSION['redirectPage'] = "private_message_list.php";
}