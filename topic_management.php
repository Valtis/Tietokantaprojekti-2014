<?php
    require_once "libs/utility.php";
    require_once "libs/models/topic.php";


if (!isLoggedIn() || !getUser()->hasModeratorAccess()) {
    redirect("index.php");
}
    
$action = htmlspecialchars($_GET['action']);

if (empty($action)) {
    redirect("index.php");
}

if ($action === "new") {
    $name = htmlspecialchars($_GET['name']);
    if (empty($name)) {
        redirect("index.php");
    }
    
    Topic::newTopic($name);
    setMessage("New topic has been created");
    exit();
}

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

if ($action === "delete") {

    $topicID = htmlspecialchars($_GET['topicid']);
   
    if (empty($topicID)) {
        redirect("index.php");
    }
    
    Topic::deleteTopic($topicID);
    setMessage("Topic has been deleted");
    exit();
}