<?php
    session_start();
    //remove all session vars
    session_unset();

    //destroy session
    session_destroy();
?>
<!DOCTYPE html>
<html>
<body>
        <p> Session variables reset </p>
        <a href="testsession.php">Go Back to testsession.php</a>
</body>
</html>

