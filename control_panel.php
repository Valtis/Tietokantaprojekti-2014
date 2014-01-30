<?php
    require_once "libs/utility.php";
    require_once "libs/models/user.php";
    
    if (!isLoggedIn() || getUser()->isBanned()) {
        redirect("index.php");
    }
    
    if (isLoggedIn()) {
        $param['showPrivateMessages'] = true;
    }
    showView("controlPanelView.php", $param);