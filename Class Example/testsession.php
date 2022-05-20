<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <body>
    <?php 
        if(isset($_SESSION["first"])) {
            echo "My Session Variables are: " . $_SESSION["first"] . " " . $_SESSION["last"] . "<br>";
        }
        else {
            echo "Session variables not set<br>";
        }
    ?>
        <a href="resetsession.php"> Go To ResetSession.php</a>
    </body>
</html>