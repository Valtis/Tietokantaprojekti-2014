<?php
    $muuttuja = "Moi";
    // testataan tagien poistoa
    $teksti = '<p>Test paragraph.</p><!-- Comment --> <a href="#fragment">Other text</a>';
    $pw = "salasana2";
    $salt = "0123456789012345678901234567890123456789";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $muuttuja; ?></title>
    </head>
    <body>        
        <?php 
            for ($i = 0; $i < 100; $i++) {
                $pw = sha1($pw . $salt);                
            }
            
            echo "Passu: " . $pw;
        ?>
    </body>
</html>
