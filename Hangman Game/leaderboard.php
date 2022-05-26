<?php 
    session_start();
    include("ConnectionInfo.php");
    
    if($_SESSION["LoggedIn"] === FALSE || $_SESSION["LoggedIn"] == NULL || $_SESSION["LetterCount"] == 0 || $_SESSION["LetterCount"] == NULL) {
        $_SESSION["LoggedIn"] = FALSE;
        header("location: Login.php");
    }
    $letterCount = intval($_SESSION["LetterCount"]);
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    }

    //	ScoreID	Word Count TotalGuesses	RightGuesses, User
    $sql = "SELECT * FROM HighScores WHERE Count = $letterCount ORDER BY Count / TotalGuesses desc LIMIT 10";
    $result = $conn->query($sql);
    $rows = array();
    if($result->num_rows > 0) {
        $i = 0;
        while($row = $result->fetch_assoc()){
            $score = round($letterCount / intval($row["TotalGuesses"]) * 100, 2);
            $rows[$i++] = "<td>" . $row["User"] . "</td>" . "<td>" . $row["Word"] . "</td>" . "<td>" . $score . "</td>"; 
        }

    }


?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
<body>
<div class="container mx-auto-mt-4">


    <table class="table mx-auto border mt-4 w-50">
        <h1 class = "text-center mt-4 mb-4"> Leaderboard </h1>
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">User</th>
                <th scope="col">Word Guessed</th>
                <th scope="col">Score (Char count / Total Guesses)</th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($rows) > 0) {
                
                for($i = 0; $i < count($rows); $i++) {
                    $num = $i + 1;
                    echo "<tr>" . "<th scope=\"row\">" . "$num" . "</th>" . $rows[$i] . "</tr>";
                }
            }
            else {
                echo "no scores...";
            }
            ?>

        </tbody>
    </table>

    <div class="container mx-auto m-4">
        <h1 class = "text-center"> 
            <?php echo $_SESSION["endGameMsg"]; ?> 
        </h1>
        <h4 class = "text-center"> 
            The word was "<?php echo $_SESSION["Word"] . "\".<br>"; ?> 
        </h4>
        <p class = "text-center mt-4 mb-4"> 
        </p>
        <div class="w-50 text-center mx-auto">
        <a class = "btn btn-success mr-4" href="playagain.php">Play Again </a>

        <a class="btn btn-danger" href="?sendcode2=true" role="button">Logout</a>
            <?php 
            if(isset($_GET['sendcode2'])) {
                resetSession();
            }        
            ?>
            </div>
    </div>

</div>
<!-- Bootstrap -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>