<?php

require_once 'libs/utility.php';

if (isLoggedIn()) {
    logOffUser();
    setMessage("You have been logged off");
}

redirect("index.php");    
