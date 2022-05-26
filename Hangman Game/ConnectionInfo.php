<?php
$servername = "sql102.epizy.com";
$username = "epiz_31690265";
$password = "mfnBMhQPilk";
$dbname = "epiz_31690265_Hangman";


function resetSession() {
    session_start();
    session_unset();
    session_destroy();
    header("location: Login.php");
}
?>