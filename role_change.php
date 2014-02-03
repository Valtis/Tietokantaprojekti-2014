<?php

    require_once "libs/utility.php";
    require_once "libs/models/user.php";
    $role = htmlspecialchars($_GET['role']);
    $userID = htmlspecialchars($_GET['userid']);
    
    if (!isLoggedIn() || !getUser()->hasModeratorAccess() || empty($role) || empty($userID)) {
        exit();
    }
    
    $user = User::loadUserByID($userID);
    
    // need to be admin to change mod\admin access levels
    if (empty($user) || ($user->hasModeratorAccess() && !getUser()->hasAdminAccess())) {
        exit();
    }
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
    
    if ($accessLevel === -1) {
        exit();        
    }
    
    $user->setAccessLevel($accessLevel);
    $user->saveUser();
    
    setMessage("Role for user " . $user->getName() . " has been successfully changed to " . $role);