<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" type="text/css" href="css/main.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
        <script type="text/javascript" src="js/utility.js"></script>
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Forum</title>
    </head>
    <body>
        
        
        <?php
       
        showMessage();
        ?>
                
        <div class="right">
            
        <?php    
         // create login\register\logout-links
        $main_bar = getMainBar();
        foreach ($main_bar as $key => $value) {
            
            if (!empty($value['onclick'])) {
                $onclick = 'onclick="' . $value['onclick'] .  '" ';
            }
            echo '<a href="' . $value['page'] . '" ' . $onclick . '>' . $key . '</a>' . "\n";
        }
        
        ?>
        </div>
            
        
        <div class="left-margin">
        <?php require($page); ?>
        </div>
        
    </body>
</html>

