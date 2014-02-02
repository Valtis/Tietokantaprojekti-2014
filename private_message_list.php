<?php
require_once 'libs/utility.php';
require_once 'libs/models/post.php';

if (!isLoggedIn() || getUser()->isBanned()) {
    redirect("index.php");
}

$param['title'] = "Private messages";

$messages = Post::loadPrivateMessages(getUser()->getID());

foreach ($messages as $m) {
    $param['posts'][$m->getPostID()]['postdata'] = $m;
    $param['posts'][$m->getPostID()]['showdelete'] = true;
}


showView('threadView.php', $param);