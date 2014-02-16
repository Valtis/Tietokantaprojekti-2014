<?php
  /**
   * This controller handles post editing.
   * 
   * If user is not logged in or does not have the right to edit the given post
   * or if the url is malformed, user is redirected to index page.
   * 
   * 
   */  

  require_once "libs/utility.php";
  require_once "libs/models/user.php";
  require_once "libs/models/post.php";
 
  // load associated parameters
  $postID = htmlspecialchars($_GET['postid']);
  $threadID = htmlspecialchars($_GET['threadid']);
  $topicID = htmlspecialchars($_GET['topicid']);
  // optional parameter, see below
  $submit = htmlspecialchars($_GET['submit']);
  
  // check that user is logged in and that parameters are correct
  if (!isLoggedIn() || getUser()->isBanned() || empty($postID) || empty($threadID) || empty($topicID)) {
      redirect("index.php");
  }
  
  $post = Post::loadPost($postID);
  // if user is neither moderator or owns this post, redirect to index page
  if (!getUser()->hasModeratorAccess() && getUser()->getID() != $post->getPosterID()) {
      redirect("index.php");
  }
  
  
  // if submit parameter was specified, submit the edited version and redirect back to thread.
  if (!empty($submit)) {
      $text = htmlspecialchars($_POST['textarea']);
      $text = $text . "\nThis post was edited by " . getUser()->getName() . " at " . date('Y-m-d H:i:s', time());
      $post->setPostText($text);
      $post->savePost();
      
      setMessage("You have edited a message"); // this does not actually work - why?
      redirect("thread.php?threadid=" . $threadID . "&topicid=" . $topicID . "&postid=" . $postID);
  }
  
  
  // no submit parameter was given - send the parameters to view so that links can be 
  // formed and show the view.
  $params['postid'] = $postID;
  $params['threadid'] = $threadID;
  $params['topicid'] = $topicID;
  $params['text'] = $post->getPostText();

  showView("editView.php", $params);
  