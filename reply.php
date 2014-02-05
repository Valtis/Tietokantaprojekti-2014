<?php 
require_once "libs/utility.php";
require_once "libs/models/user.php";
require_once "libs/models/post.php";

$threadID = htmlspecialchars($_GET['threadid']);
$topicID = htmlspecialchars($_GET['topicid']);
$page = htmlspecialchars($_GET['page']);
$submit = htmlspecialchars($_GET['submit']);


if (!isLoggedIn() || getUser()->isBanned() || empty($threadID) || empty($topicID) || empty($page)) {
    redirect("index.php");
}

// we allow emptyposting if user really wants to do that
if (!empty($submit)) {    
    $postText = htmlspecialchars($_POST['textarea']);
    $newPostID = Post::createNewPost(getUser()->getID(), $threadID, $postText);
    showMessage("You have posted a message");
    
    redirect("thread.php?threadid=" . $threadID . "&topicid=" . $topicID . "&postid=" . $newPostID);
}

$param['threadid'] = $threadID;
$param['topicid'] = $topicID;
$param['page'] = $page;
showView("replyView.php", $param);