<?php 
require_once "libs/utility.php";
require_once "libs/models/user.php";
require_once "libs/models/post.php";

$threadID = htmlspecialchars($_GET['threadid']);
$topicID = htmlspecialchars($_GET['topicid']);
$userID = htmlspecialchars($_GET['userid']);
$submit = htmlspecialchars($_GET['submit']);


if (empty($userID) || !isLoggedIn() || getUser()->isBanned()) {
    redirect("index.php");
}


// todo - find a better way for this, feels really hacky
// basically we can send private messages from a page under the control panel, or from 2 page under thread view
// we need these values to decide where to redirect after submitting the private message
if (!empty($threadID) && !empty($topicID)) {
    $_SESSION['redirectPage'] = 'thread.php?threadid=' . $threadID . '&topicid=' . $topicID;
} else {
    $_SESSION['redirectPage'] = 'user_management.php';
}

if (getUser()->getID() == $userID) {
    $redirect = $_SESSION['redirectPage'];
    $_SESSION['redirectPage'] = NULL;
    redirect($redirect);
}

$u = User::loadUserByID($userID);
if ($u == NULL) {
    redirect("index.php");
}

$param['name'] = $u->getName();

// we allow emptyposting if user really wants to do that
if (!empty($submit)) {    
    $postText = htmlspecialchars($_POST['textarea']);
    Post::createNewPrivateMessage(getUser()->getID(), $userID, $postText);
    setMessage("You have sent a private message");
    
    $redirect = $_SESSION['redirectPage'];
    $_SESSION['redirectPage'] = NULL;
    redirect($redirect);
}

$param['threadid'] = $threadID;
$param['topicid'] = $topicID;
$param['userid'] = $userID;
showView("privateMessageView.php", $param);