<?php
/**
 * Controller in charge of user list. 
 * If user is not logged in, redirect to index page
 */
require_once "libs/utility.php";
require_once "libs/models/user.php";

if (!isLoggedIn()) {
   redirect("index.php"); 
}

$params['users'] = User::loadUsers();
showView("usersView.php", $params);