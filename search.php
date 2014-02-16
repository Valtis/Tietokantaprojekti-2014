<?php
/**
 * This controller handles searching
 * 
 */
require_once "libs/utility.php";
require_once "libs/models/post.php";

$submit = htmlspecialchars($_GET['submit']);

// if submit field exists, perform search and redirect user to result page
if (!empty($submit)) {
    $username = htmlspecialchars($_POST['username']);
    $text = htmlspecialchars($_POST['text']);
    
    
    if (empty($username) && empty($text)) {
        setError("You have to search for something");
        showView("searchView.php");
    }
    // tokenize the search string
    if (!empty($text)) {
        $text = explode(" ", $text);
    }
    // pick proper search
    if (empty ($username)) {
        $param = getPostsByContent($text);        
    } else if (empty($text)) {
        $param = getPostsByUsername($username);
    } else {
        $param = getPostsByUsernameAndContent($username, $text);
    }
    // attach quotes to text if needed
    $param = attachQuotes($param);

    showView("searchResultView.php", $param);
}
// if submit field does not exist, show user the view
showView("searchView.php");


/**
 * Helper function; performs search by content only. Search terms that are shorter
 * than 3 character are ignored
 * 
 * @param array of strings $text. Contains search terms
 * @return array of posts. Returns posts that had one or more search terms.
 * 
 */ 
function getPostsByContent($text) {
    $param = array();
    
    foreach ($text as $t) {
        if (strlen($t) < 3) {
            continue;
        }
        $posts = Post::findPostsByContent($t);
        $param = $param + $posts;
    } 
    return $param;
}
/**
 * Helper function; finds all posts made by users whose names matches search term
 * 
 * @param String $username. Posters user name must contain this
 * @return type
 */
function getPostsByUsername($username) {
    return Post::findPostsByUsername($username);
}
/**
 * Helper function; returns posts which content and name contains given user name
 * and one or more search terms
 * 
 * @param string $username. Posters user name must contain this
 * @param array of strings $text. List of search terms
 * @return type
 */
function getPostsByUsernameAndContent($username, $text) {
    $param = array();
    foreach ($text as $t) {
        if (strlen($t) < 3) {
            continue;
        }
        $posts = Post::findPostsByUsernameAndContent($username, $t);
        $param = $param + $posts;
    } 
    return $param;
}
/**
 * Helper function. Attaches quotes to posts if post contains quote.
 * 
 * @param list of Posts $param. List that contains posts 
 * @return List of Posts with quotes attached if post contains quotes
 */
function attachQuotes($param) {
    
    foreach ($param as $p) {
        if ($p['post']->repliesToID() !== NULL) {
            $param[$p['post']->getPostID()]['quote'] = Post::loadPost($p['post']->repliesToID());
        }
    }
    return $param;  
}