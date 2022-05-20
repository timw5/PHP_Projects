<?php
session_start();
include("ConnectionInfo.php");

$loggedIn = $_SESSION["LoggedIn"];
if($loggedIn === FALSE || $loggedIn === NULL) {
    header("location: Login.php");
}
$user = $_SESSION["User"];
$space = "&nbsp;";
$wordCount = intval($_SESSION["LetterCount"]);
$word = $_SESSION["Word"];

$wrongGuesses = intval($_SESSION["WrongGuesses"]);
$rightGuesses = intval($_SESSION["RightGuesses"]);
$guess = substr($_POST["Guess"], 0, 1);
if($guess === NULL || $_SESSION["WrongGuesses"] === NULL) {
    $_SESSION["WrongGuesses"] = 0;
}

$_SESSION["rightGuess"] = FALSE;
$rightGuess = FALSE;

$offset = 0;
while(($pos = stripos($_SESSION["Word"], $guess, $offset))!== FALSE) {
    $_SESSION["WordArray"][$pos] = $guess;
    $offset = $pos+1;
    $_SESSION["rightGuess"] = TRUE;
    $rightGuess = TRUE;
    $_SESSION["RightGuesses"]++;
    $rightGuesses++;
}

if($rightGuesses == $wordCount || $_SESSION["RightGuesses"] == $_SESSION["LetterCount"]) {
    $_SESSION["endGameMsg"] = "You Won!";
    $_SESSION["LoggedIn"] = FALSE;
    
    if($wrongGuesses < 0) {
        $wrongGuesses = 0;
    }
    if($rightGuesses < 0) {
        $rightGuesses = 0;
    }

    $totalGuesses = $rightGuesses + $wrongGuesses;

    $sql = "INSERT INTO HighScores (Word, Count, TotalGuesses, RightGuesses, User)
            VALUES('$word', $wordCount, $totalGuesses, $rightGuesses, '$user')";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    }
    if($conn->query($sql)) 
    {
        $conn->close();
        $_SESSION["LoggedIn"] = TRUE;
        header("location: leaderboard.php");

    }
    else 
    {
        $conn->close(); 
        echo "error...";
    }

}

if($wrongGuesses == 7 || $_SESSION["WrongGuesses"] == 7) {
    $_SESSION["endGameMsg"] = "You Lost!";
    $_SESSION["LoggedIn"] = TRUE;
    if($wrongGuesses < 0) {
        $wrongGuesses = 0;
    }
    if($rightGuesses < 0) {
        $rightGuesses = 0;
    }
    $totalGuesses = $rightGuesses + $wrongGuesses;

    $sql = "INSERT INTO HighScores (Word, Count, TotalGuesses, RightGuesses, User)
            VALUES('$word', $wordCount, $totalGuesses, $rightGuesses, '$user')";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    }
    $result = $conn->query($sql);
    $_SESSION["LoggedIn"] = True;
    $conn->close();
    header("location: leaderboard.php");
    
}

$hang = array(
'<h3> </h3>',

'<h3><br><br><br><br><br><br>=========</h3> ',

'<h3>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+---+<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'========='.
'</h3>',

'<h3>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+---+<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'========='.
'</h3>',

'<h3>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+---+<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'========='.
'</h3>',

'<h3>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+---+<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;|\&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'========='.
'</h3>',

'<h3>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+---+<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp/|\&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'========='.
'</h3>',

'<h3>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+---+<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp/|\&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'========='.
'</h3>',

'<h3>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+---+<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;/|\&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;\&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|<br>'.
'========='.
'</h3>',



);


?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
    <div class="container mx-auto mt-4 w-100">
        <h1 class="text-center mb-4"> Hangman&emsp; <a class="btn btn-danger" href="Login.php" role="button">Logout</a>
 </h1>
        <hr class = "mb-4">
        <div class="row p-4">
            <div class="col text-center mx-auto align-self-center mr-4">
                <form action = "Game.php" method = "post">
                    <div class="form-group">
                        <label class = "mb-4" for="Guess">Guess a Letter: </label>
                        <input type="text" name = "Guess" class="form-control w-50 mx-auto mb-4" id="Guess" >
                        <input class="btn btn-primary"  type = "submit" value = "Submit">
                    </div>
                </form>
            </div>
            <div class="col border-left ml-4 pl-4">
                <?php 
                    if($rightGuess === FALSE || $_SESSION["rightGuess"] === FALSE) {
                        $_SESSION["WrongGuesses"]++;
                        $wrongGuesses++;
                    }
                    echo $hang[$wrongGuesses];

 
                    ?>

            </div>

        </div>
        <hr>
        <h1 class = "text-center mt-4 mb-4"> 
            <?php 


                // for($i = 0; $i < $wordCount; $i++) {
                //     if($guess === $_SESSION["WordArray"][$i]) {

                //     }
                // }


                echo implode("&nbsp;&nbsp",$_SESSION["WordArray"]);
            ?>
        </h1>
        <br>
        <hr>

    </div>


    <!-- Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>

