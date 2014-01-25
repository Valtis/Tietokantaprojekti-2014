<?php

require_once "libs/utility.php";
require_once "libs/models/user.php";

if (isLoggedIn())
{
    redirect("index.php");
}

if (empty($_POST["username"]) && empty($_POST["password"]) && empty($_POST["password_retype"]) && empty($_POST["email"])) {
    showView("registerView.php");
    exit();
} else if (empty($_POST["username"])) {
    setError("Please insert your username");
    showView("registerView.php");
    exit();
}  else if (empty($_POST["email"])) {
    setError("Please insert your email");
    showView("registerView.php");
    exit();
} else if (empty($_POST["password"])) {
    setError("Please insert your password");
    showView("registerView.php");
    exit();
} else if (empty($_POST["password_retype"])) {
    setError("Please retype your password");
    showView("registerView.php");
    exit();
}

$username = htmlspecialchars($_POST["username"]);
$email = htmlspecialchars($_POST["email"]);
$password = htmlspecialchars($_POST["password"]);
$password_retype = htmlspecialchars($_POST["password_retype"]);

if ($password !== $password_retype) {
    setError("The password fields do not match");
    showView("registerView.php");
    exit();
}

if (User::userExists($username)) {
    setError("The user name is already taken, sorry!");
    showView("registerView.php");
    exit();
}

User::createNewUser($username, $email, $password);


setMessage("Your account has been created!");
redirect("index.php");

