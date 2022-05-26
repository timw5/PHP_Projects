<!DOCTYPE html>
<html>
<head>
<!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

<?php
    session_start();
    $userError = $_SESSION["UserError"];
    $passError = $_SESSION["PassError"];
    $_SESSION["LoggedIn"] = FALSE;
    ?>

<div class="container mx-auto w-50">
    <h3 class = "mt-4 text-center"> Welcome to the Hangman Game! </h3><br>
    <form action = "Authenticate.php" method = "post">
        <div class="form-group">
            <label for="UserName">Username: </label>
            <input type="text" class="form-control" name = "Username" id="Username" placeholder="Username">
        </div>
        <div class="form-group">
            <label for="Password">Password: </label>
            <input type="password" class="form-control" name = "Pass" id="Pass" placeholder="Password">
        </div>
        <input class="btn btn-primary" type = "submit" value = "Submit">
    </form>

    <?php if($userError === TRUE) : ?>
        <div class="container mt-4 pt-2 mx-auto border border-warning text-muted text-center">
            <p>
                That is not a valid Username, 
                do you have an account?
                <br>
                Click the link below if you 
                need to create one. 
            </p>
        </div>
    <?php endif; ?>

    <?php if($passError === TRUE) : ?>
        <div class="container mt-4 pt-2 mx-auto border border-warning text-muted text-center">
            <p>
                Incorrect Password
                <br>
                If you need to make an account,
                use the link below. 
            </p>
        </div>
    <?php endif; ?>

    <?php
        if($userError || $passError) 
        {
        //remove all session vars
        session_unset();
        //destroy session
        session_destroy();
        session_start();
        $_SESSION["LoggedIn"] = FALSE;
        }
    ?>

    <br>
    <p> 
        Need an account? 
        <a href= "NewUser.php"> Create one Here </a> 
    </p>

</div>

<!-- Bootstrap -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
