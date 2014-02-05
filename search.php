<?php

require_once "libs/utility.php";
require_once "libs/models/post.php";

$submit = htmlspecialchars($_GET['submit']);


if (!empty($submit)) {
    $username = htmlspecialchars($_POST['username']);
    $text = htmlspecialchars($_POST['text']);
    
    if (empty($username) && empty($text)) {
        setError("You have to search for something");
        showView("searchView.php");
    }
    
    if (!empty($text)) {
        $text = explode(" ", $text);
    }
    
    if (empty ($username)) {
        $param = getPostsByContent($text);        
    } else if (empty($text)) {
        $param = getPostsByUsername($username);
    } else {
        $param = getPostsByUsernameAndContent($username, $text);
    }
    $param = attachQuotes($param);

    showView("searchResultView.php", $param);
}

showView("searchView.php");

function getPostsByContent($text) {
    $param = array();
    foreach ($text as $t) {
        if (strlen($t) <= 3) {
            continue;
        }
        $posts = Post::findPostsByContent($t);
        $param = $param + $posts;
    } 
    return $param;
}

function getPostsByUsername($username) {
    return Post::findPostsByUsername($username);
}

function getPostsByUsernameAndContent($username, $text) {
    $param = array();
    foreach ($text as $t) {
        if (strlen($t) <= 3) {
            continue;
        }
        $posts = Post::findPostsByUsernameAndContent($username, $t);
        $param = $param + $posts;
    } 
    return $param;
}

function attachQuotes($param) {
    
    foreach ($param as $p) {
        if ($p['post']->repliesToID() !== NULL) {
            $param[$p['post']->getPostID()]['quote'] = Post::loadPost($p['post']->repliesToID());
        }
    }
    return $param;  
}