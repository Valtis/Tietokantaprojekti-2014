<?php
/**
 * Controller which handles topic management
 * 
 * User should never load this directly, rather this controller is loaded
 * asynchronously with jquery, hence the lack of redirect in the end.
 *   
 * If user is not logged in or lacks credentials or if url is malformed, 
 * this controller does nothing.
 */
    require_once "libs/utility.php";
    require_once "libs/models/topic.php";


if (!isLoggedIn() || !getUser()->hasModeratorAccess()) {
    redirect("index.php");
}
    
$action = htmlspecialchars($_GET['action']);

if (empty($action)) {
    redirect("index.php");
}
// create new topic
if ($action === "new") {
    $name = htmlspecialchars($_GET['name']);
    if (empty($name)) {
        redirect("index.php");
    }
    
    Topic::newTopic($name);
    setMessage("New topic has been created");
    exit();
}
// rename existing topic
if ($action === "rename") {
    $name = htmlspecialchars($_GET['name']);
    $topicID = htmlspecialchars($_GET['topicid']);
    
    if (empty($name) || empty($topicID)) {
        redirect("index.php");
    }
    
    Topic::renameTopic($topicID, $name);
    setMessage("Topic has been renamed");
    exit();
}
// delete topic
if ($action === "delete") {

    $topicID = htmlspecialchars($_GET['topicid']);
   
    if (empty($topicID)) {
        redirect("index.php");
    }
    
    Topic::deleteTopic($topicID);
    setMessage("Topic has been deleted");
    exit();
}