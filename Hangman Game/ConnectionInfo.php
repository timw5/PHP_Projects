<?php
$servername = "";
$username = "";
$password = "";
$dbname = "";


function resetSession() {
    session_start();
    session_unset();
    session_destroy();
    header("location: Login.php");
}
?>
