<?php
    //start session, and include connection info
    session_start();
    include("ConnectionInfo.php");

    //set "won" variable to false (not totally necessary)
    $_SESSION["won"] = FALSE;

    //get the id from the session variables
    $ID = $_SESSION["ID"];

    //if the first name isn't set already, then set it.
    if(!isset($_SESSION["FirstName"])) {
        $firstname = $_POST["FirstName"];
        $_SESSION["FirstName"] = $firstname;
    }
    else {
        $firstname = $_SESSION["FirstName"];
    }

    //get guess from the post, if we are coming from
    //welcome.php, then guess will = null.
    $guess = $_POST["Guess"];

    //if we are not initially coming from welcome.php,
    //then get the random value from the DB
    if($guess != null) { 

        //cast guess to an int
        $guess = intval($guess);

        //store it in the session variables
        $_SESSION["guess"] = $guess;
        
        $sql = "SELECT RandomNumber FROM Random WHERE ID = $ID";
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            echo "error";
            die("Connection failed: " . $conn->connect_error);
        }

        //get the random value from the DB,
        //and store it in the session variable
        $result = $conn->query($sql);

        //ensure that we actually got a result
        if( $result->num_rows > 0) 
        {
            //grab the random value from result, and store it
            $row = $result->fetch_assoc();
            $random = intval($row["RandomNumber"]);
            $_SESSION["random"] = $random;
        }

        //otherwise, we have an error
        else 
        {
            echo "error";
        }

        //close connection to DB
        $conn->close();
    }
?>

<!DOCTYPE html>
<html>
<body>

    <h1> Hello <?php echo " " . $_SESSION["FirstName"] . ", " ?> Guess A number between 0 and 100 <br></h1>
    <form action ="Check.php" method = "post">
            <p>
                Guess: 
                <input type = "number" name = "Guess">
            </p>
            <input type = "submit" value = "Submit"/>
        </form>
        <br>
        
        <?php

        //if we have a guess stored in the session variable,
        //then determine if higher or lower.
            if(isset($_SESSION["guess"])) {
                
                if($guess === $random) 
                {
                    //if we win, kick the session win flag
                    //to true
                    echo "You Win!<br>";
                    $won = TRUE;
                    $_SESSION["won"] = $won;
                }
                else if ($random > $guess) 
                {
                    echo "Higher! <br>";
                }
                else if($random < $guess)
                {
                    echo "Lower! <br>";
                }
            }

            //if we win then go to reset.php to 
            //reset all session variables
            if($_SESSION["won"] === TRUE) {
                header('location: Reset.php');
                exit;
            }
        ?>
</body>
</html>



