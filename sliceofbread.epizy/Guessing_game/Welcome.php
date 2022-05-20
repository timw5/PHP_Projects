<?php

//start session
include("ConnectionInfo.php");
session_start();
$_SESSION["won"] = FALSE;

//generate random number
$random = rand(0, 100);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

//insert random value into the table
$sql = "INSERT INTO Random ( RandomNumber )
VALUES ($random)";

//get ID from random value, store it in our session variable's
if ($conn->query($sql) === TRUE) 
{
  $_SESSION["ID"] = $conn->insert_id;
} 

//if there is an error, just print error
else 
{
  echo "Error: " . $sql . "<br>" . $conn->error;
}

//close the connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<body>
    
<h1>Welcome to the Guessing Game <br></h1>
    <form action = "Check.php" method = "post">
        <p>
            FirstName
            <input type = "text" name = "FirstName">
        </p>
        <input type = "submit" value = "Submit"/>
    </form>
</body>
</html>