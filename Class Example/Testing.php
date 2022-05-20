<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <body>
        <?php
            $first = $_POST["FirstName"];
            $last = $_POST["LastName"];
            echo "Got first name and last name: " . $first . " " . $last . " " . "<br>";
            $_SESSION["first"] = $first;
            $_SESSION["last"] = $last;
            echo "Set Session Variables<br>";
        ?>
        <a href="testsession.php">Go To TestSession.php</a>
    </body>
</html>
