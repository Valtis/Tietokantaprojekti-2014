<?
require_once 'libs/utility.php';
$topicID = htmlspecialchars($_GET['topicid']);

if (empty($topicID) || !loggedIn() || getUser()->isBanned()) {
    redirect("index.php");
}


showView("newThreadView.php", $param);