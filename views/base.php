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
            echo "<div class=\"right\">\n";
            
             // create login\register\logout-links
            $main_bar = getMainBar();
            foreach ($main_bar as $key => $value) {
                echo '<a href="' . $value . '">' . $key . '</a>' . "\n";
            }
            
            echo "</div>\n";
            require($page);
        ?>
    </body>
</html>

