<?php
/**
 * Controller that handles logoffing.
 * 
 * User should never load this directly, rather this controller is loaded
 * asynchronously with jquery, hence the lack of redirect in the end.
 * 
 */
require_once 'libs/utility.php';

if (isLoggedIn()) {
    logOffUser();
    setMessage("You have been logged off");
}

