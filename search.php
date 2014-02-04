<?php

require_once "libs/utility.php";

$submit = htmlspecialchars($_GET['submit']);


if (!empty($submit)) {
    $username = htmlspecialchars($_POST['username']);
    $text = htmlspecialchars($_POST['text']);
    
    if (empty($username) && empty($text)) {
        setError("You have to search for something");
        showView("searchView.php");
    }
    
    $text = explode(" ", $text);
    
    
    if (empty ($username)) {
        $param = getPostsByText($text);        
    } else if (empty($text)) {
        $param = getPostsByUsername($username);
    } else {
        $param = getPostsByUsernameAndContent($username, $text);
    }
    
    showView("searchResultView.php", $param);
}

showView("searchView.php");

function getPostsByContent($text) {
    $param = array();
    foreach ($text as $t) {
        $posts = Post::findPostsByContent($t);
        merge_array($param, $posts);
    } 
    return $param;
}

function getPostsByUsername($username) {
    $posts = Post::findPostsByUsername($username);
    $param = array();
    merge_array($param, $posts);
    return $param;
}

function getPostsByUsernameAndContent($username, $text) {
    $param = array();
    foreach ($text as $t) {
        $posts = Post::findPostsByUsernameAndContent($username, $t);
        merge_array($param, $posts);
    } 
    return $param;
}