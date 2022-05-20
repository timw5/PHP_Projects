<?php 
session_start();
include("ConnectionInfo.php");
$conn = new mysqli($servername, $username, $password, $dbname);

$LoggedIn = $_SESSION["LoggedIn"];


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT Word, LetterCount FROM WordList ORDER BY RAND() LIMIT 1;";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$word = $row["Word"];
$letterCount = $row["LetterCount"];


$_SESSION["RightGuesses"] = 0;
$_SESSION["WrongGuesses"] = 0;
$_SESSION["WordArray"] = array();
for($i = 0; $i < $letterCount; $i++) {
    $_SESSION["WordArray"][$i] .= "_";
}
$_SESSION["Word"] = $word;
$_SESSION["LetterCount"] = $letterCount;

if($_SESSION["LoggedIn"] === FALSE || $_SESSION["LoggedIn"] == NULL ) {
    header("location: Login.php");
}
else {
    $_SESSION["LoggedIn"] = TRUE;
    header("location: Game.php");
}
exit;

?>