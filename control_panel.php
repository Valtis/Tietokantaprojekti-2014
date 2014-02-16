<?php
    /**
     * Controller for the control panel. 
     * 
     * If user is not logged in or if they are banned, user is redirected to main page
     * 
     * This controller has no major functionality other than checking credentials. 
     * Associated view will be shown.
     * 
     */
    require_once "libs/utility.php";
    require_once "libs/models/user.php";
    
    if (!isLoggedIn() || getUser()->isBanned()) {
        redirect("index.php");
    }
    
    showView("controlPanelView.php", $param);