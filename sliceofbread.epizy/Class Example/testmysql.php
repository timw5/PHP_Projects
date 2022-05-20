<?php

include("ConnectionInfo.php");
$first = "Tim";
$last = "Williams";

//create a connection to DB

$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error) {
    die("Connection Failed: " . $conn->connection_error);

}

$sql = "INSERT INTO TestTable (First, Last) VALUES ('$first', '$last')";

if($conn->query($sql) === TRUE) {
    echo "New Record Created Successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn_error;
}

$sql = "SELECT * FROM TestTable";
$result = $conn->query($sql);
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        echo "ID: " . $row["ID"] . " First: " . $row["First"] . " Last: " $row["Last"] . "<br>";
    }
} else {
    echo "0 results found";
}
$conn->close();

?>