<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css">
        <link rel="stylesheet" type="text/css" href="css/main.css">
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Forum</title>
    </head>
    <body>
        
        
        <?php
        
        require_once "libs/utility.php";
        showMessage();
        
        ?>
                
        <div class="right">
            
        <?php    
         // create login\register\logout-links
        $main_bar = getMainBar();
        foreach ($main_bar as $key => $value) {
            echo '<a href="' . $value . '">' . $key . '</a>' . "\n";
        }
        
        ?>
        </div>
            
        
        <div class="left-margin">
        <?php require($page); ?>
        </div>
        
    </body>
</html>

