<?php
  require_once "libs/utility.php";
  require_once "libs/models/user.php";
  require_once "libs/models/post.php";
 
  $postID = htmlspecialchars($_GET['postid']);
  $threadID = htmlspecialchars($_GET['threadid']);
  $topicID = htmlspecialchars($_GET['topicid']);
  $submit = htmlspecialchars($_GET['submit']);
  if (!isLoggedIn() || getUser()->isBanned() || empty($postID) || empty($threadID) || empty($topicID)) {
      redirect("index.php");
  }
  
  $post = Post::loadPost($postID);
  
  if (!getUser()->hasModeratorAccess() && getUser()->getID() != $post->getPosterID()) {
      redirect("index.php");
  }
  
  if (!empty($submit)) {
      $text = htmlspecialchars($_POST['textarea']);
      $text = $text . "\nThis post was edited by " . getUser()->getName() . " at " . date('Y-m-d H:i:s', time());
      var_dump($post->isDeleted());
      $post->setPostText($text);
      $post->savePost();
      
      setMessage("You have edited a message");
      redirect("thread.php?threadid=" . $threadID . "&topicid=" . $topicID . "&postid=" . $postID);
  }
  
  $params['postid'] = $postID;
  $params['threadid'] = $threadID;
  $params['topicid'] = $topicID;
  $params['text'] = $post->getPostText();

  showView("editView.php", $params);
  