<?php

/**
 * Controller that handles user private message list
 * 
 * If user is not logged in or if they are banned, redirect user to index page
 * 
 */
require_once 'libs/utility.php';
require_once 'libs/models/post.php';

if (!isLoggedIn() || getUser()->isBanned()) {
    redirect("index.php");
}

$param['title'] = "Private messages";

$messages = Post::loadPrivateMessages(getUser()->getID());


// key-value pairs of post id - postdata, showdelete value
// showdelete is hardcoded to true as user can always delete their own private messages
// see thread.php for more info
foreach ($messages as $m) {
    $param['posts'][$m->getPostID()]['postdata'] = $m;
    $param['posts'][$m->getPostID()]['showdelete'] = true;
}

$param['showPrivateUrl'] = true;
$param['privateMessageRedirect'] = true;

// we reuse threadView.php for this purpose
showView('threadView.php', $param);