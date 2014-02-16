<?php
/**
 * Controller that handles user role changes. 
 * 
 * If user is not logged in or if the user does not have moderator access, this
 * controller does nothing
 * 
 * User should never load this directly, rather this controller is loaded
 * asynchronously with jquery, hence the lack of redirect in the end.
 * 
 */
    require_once "libs/utility.php";
    require_once "libs/models/user.php";
    $role = htmlspecialchars($_GET['role']);
    $userID = htmlspecialchars($_GET['userid']);
    
    if (!isLoggedIn() || !getUser()->hasModeratorAccess() || empty($role) || empty($userID)) {
        exit();
    }
    
    $user = User::loadUserByID($userID);
    
    // if user does not exists or current user role is insufficient 
    // (need to be admin to change mod\admin access levels), do nothing
    if (empty($user) || ($user->hasModeratorAccess() && !getUser()->hasAdminAccess())) {
        exit();
    }
    // kinda bad way to handle this - probably should rethink
    $accessLevel = -1;
    if ($role === "Normal") {
        $accessLevel = AccessLevel::NORMAL;
    } else if ($role === "Banned") {
        $accessLevel = AccessLevel::BANNED;
    } else if ($role === "Moderator") {
        $accessLevel = AccessLevel::MODERATOR;
    } else if ($role === "Admin") {
        $accessLevel = AccessLevel::ADMIN;
    }
    
    // access name is invalid, do nothing
    if ($accessLevel === -1) {
        exit();        
    }
    
    $user->setAccessLevel($accessLevel);
    $user->saveUser();
    
    setMessage("Role for user " . $user->getName() . " has been successfully changed to " . $role);