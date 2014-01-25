<?php
    require_once "libs/models/user.php";
    $muuttuja = "Moi";
    // testataan tagien poistoa
    $teksti = '<p>Test paragraph.</p><!-- Comment --> <a href="#fragment">Other text</a>';
    $pw = "adminpassu";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $muuttuja; ?></title>
    </head>
    <body>        
        <?php 
            echo "Passu ennen hashausta: " . $pw . "<br>";
            $u = new User();
            echo "Suola: " . $u->getSalt() . "<br>";
            $u->setPassword($pw);
            echo "Passu hashauksen jälkeen: (" . $u->getIterations() . " iteraatiota): " . $u->getPassword() . "<br>"
            
            
            
        ?>
    </body>
</html>
