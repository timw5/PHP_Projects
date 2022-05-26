<?php
    session_start();
    include("ConnectionInfo.php");

    $_SESSION["LoggedIn"] = FALSE;
    $user = $_POST["Username"];
    $pass = $_POST["Pass"];
    $passConf = $_POST["PassConf"];
    $_SESSION["PassValid"] = TRUE;
    
    //if this is our first time visiting this page
    if($user != NULL && $pass != NULL && $passConf != NULL) 
    {
        //get the length of the password to 
        //ensure that it is at least 8 characters
        $passLength = strlen($pass);
        if($passLength < 8) 
        {
        $_SESSION["PassValid"] = FALSE;
        }

        
        //establish connection, and error check.
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) 
        {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM Login WHERE UserName = '$user'";
        $result = $conn->query($sql);

        //if there is a result, then the username
        //already exists
        if( $result->num_rows > 0) 
        {
            $_SESSION["UserError"] = TRUE;
        }
        //if the password matches the confirm password,
        //and the length requirement is met
        else if($pass == $passConf && $_SESSION["PassValid"]) 
        {
            //generate a random salt
            $salt = random_bytes(5);
            //hash the password + salt
            $hash = hash("sha256", $pass . $salt, FALSE);

            $sql = "INSERT INTO Login (UserName, Hash, Salt) 
                        Values('$user', '$hash', '$salt')";
            //store the hash, and salt in the DB
            //then kick "LoggedIn" to true.
            if ($conn->query($sql) === TRUE) 
            {
                $sql = 
                "SELECT Word, LetterCount FROM WordList ORDER BY RAND() LIMIT 1;";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $word = $row["Word"];
                $letterCount = $row["LetterCount"];
                $_SESSION["Word"] = $word;
                $_SESSION["WordArray"] = array();
                for($i = 0; $i < $letterCount; $i++) {
                    $_SESSION["WordArray"][$i] .= "_";
                }
                $_SESSION["LettersWrong"] = " ";
                $_SESSION["User"] = $user;
                $_SESSION["LetterCount"] = $letterCount;
                $_SESSION["LoggedIn"] = TRUE;
                $_SESSION["RightGuesses"] = 0;
                $_SESSION["WrongGuesses"] = 0;
                //redirect to game
                header("location: Game.php");
                exit;
            } 
            //otherwise we have an error
            else 
            {
            echo "Error: " . $sql . "<br>" . $conn->error;
            }
            //close the connection
            $conn->close();
        }
        //if we get here, there is a password error
        else 
        {
            $_SESSION["PassError"] = TRUE;
        }
    }
?>
<!DOCTYPE HTML>
<html>
<head>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div class="container mx-auto w-50">
    <h3 class = "mt-4 text-center"> Create a New Account </h3><br>
    <form action = "NewUser.php" method = "post">
        <div class="form-group">
            <label for="Username">Username: </label>
            <input type="text" class="form-control" name = "Username" id="Username" placeholder="Username">
        </div>
        <div class="form-group">
            <label for="Password">Password: </label>
            <input type="password" class="form-control" name = "Pass" id="Pass" placeholder="Password">
            <small id="PassHelp" class="form-text text-muted">
                Password must be at least 8 characters.
            </small>
        </div>
        <div class="form-group">
            <label for="PasswordConf">Confirm Password: </label>
            <input type="password" class="form-control" name = "PassConf" id="PassConf" placeholder="Confirm Password">
        </div>

        <input class="btn btn-primary"  type = "submit" value = "Submit">
    </form>

    <!-- 
        Below are to show the user which errors
        they have with their new login info.
     -->

     <!-- Passwords dont match error -->
    <?php if($_SESSION["PassError"]) : ?>
        <div class="container mt-4 pt-2 mx-auto border border-warning text-muted text-center">
            <p>
                Passwords don't match
                <br>
                Please fix your error and 
                try again.
            </p>
        </div>
        <?php $_SESSION["PassError"] = FALSE; ?>
    <?php endif; ?>

    <!-- password length requirement is not met -->
    <?php if($_SESSION["PassValid"] === FALSE) : ?>
        <div class="container mt-4 pt-2 mx-auto border border-warning text-muted text-center">
            <p>
                Password must be at least 8 characters.
            </p>
        </div>
       <?php $_SESSION["PassValid"] = TRUE; ?>
    <?php endif; ?>

    <!-- Username is already taken -->
    <?php if($_SESSION["UserError"]) : ?>
        <div class="container mt-4 pt-2 mx-auto border border-warning text-muted text-center">
            <p>
                That username is already taken,
                <br>
                Please enter a different username.
            </p>
        </div>
        <?php $_SESSION["UserError"] = FALSE; ?>
    <?php endif; ?>
    <br>
    <p> Already have an account? <a href= "Login.php"> Log in Here </a> </p>
</div>

<!-- Bootstrap -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>