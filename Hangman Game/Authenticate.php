<?php
    session_start();
    echo "Authenticating...";
    include("ConnectionInfo.php");
    $user = $_POST["Username"];
    $pass = $_POST["Pass"];

    $sql = "SELECT Hash, Salt FROM Login WHERE UserName = '$user'";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //get the salt, and the hashed password from the db
    $result = $conn->query($sql);

    //if there are results, then parse out the necessary
    //information
    if( $result->num_rows > 0) 
    {
        
        $row = $result->fetch_assoc();
        $hash = $row["Hash"];
        $salt = $row["Salt"];
        //use sha256, hash the pass + salt
        $test = hash("sha256", $pass . $salt, FALSE);
       
        //if the hashed above matches the entry in
        //the db, then we are good to log in.
        //"LoggedIn" is managed to ensure that
        //the game cannot be accessed unless they
        //have logged in.
        if($test === $hash) {

            $sql = 
            "SELECT Word, LetterCount FROM WordList ORDER BY RAND() LIMIT 1;";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $word = $row["Word"];
            $letterCount = $row["LetterCount"];
            $_SESSION["User"] = $user;
            $_SESSION["RightGuesses"] = 0;
            $_SESSION["LettersWrong"] = " ";
            $_SESSION["WordArray"] = array();
            for($i = 0; $i < $letterCount; $i++) {
                $_SESSION["WordArray"][$i] .= "_";
            }
            $_SESSION["Word"] = $word;
            $_SESSION["LetterCount"] = $letterCount;
            $_SESSION["LoggedIn"] = TRUE;
            $_SESSION["WrongGuesses"] = 0;
            header("location: Game.php");
            exit;
        }
        else {
            $_SESSION["PassError"] = TRUE;
            header("location: Login.php");
            exit;
        }
        
    }
    //if there arent any, then the user doesnt exist, and we need to make a new account.
    else {
        $_SESSION["UserError"] = TRUE;
        header("location: Login.php");
        exit;
    }
    $conn->close();
?>