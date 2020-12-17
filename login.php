<?php
session_start();
// Check if a token is present for the current session
if(empty($_SESSION["csrf_token"])) {
    // No token present, generate a new one
    $token = bin2hex(random_bytes(64));
    $_SESSION["csrf_token"] = $token;
} else {
    // Reuse the token
    $token = $_SESSION["csrf_token"];
}
?>
<!DOCTYPE html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Computer Security</title>
<link href="stylesheet.css" rel="stylesheet">
<meta name="theme-color" content="#383838">

</head>
<body>
    <div class="main">
        <ul class="nav" id="navid">
            <li class="name"><h1>Computer Security</h1></li>
            <li class="name menu"><p>Menu</p></li>
            <li><a href="login.php"><p class="active">Login</p></a></li>
            <li><a href="changePassword.php"><p>Change Password</p></a></li>
            <li><a href="index.php"><p>User Register</p></a></li>
        </ul>
        
        <div class="home_banner">
            <img src="media/brighton.jpg" alt="brighton city">
            <h6>Brighton</h6>
        </div>
        <div class="main_text">
            <h2>A coursework project</h2>
            <p>In this site you can find all the lab work I have done.</p>
            <br>
            <?php
                if (!isset($_SESSION['loggedin'])) {
                    echo "<form action='process_login.php' method='POST'>";
                    echo "Username: ";
                    echo "<input name='txtUsername' type='text'>";
                    echo "<br />Password: ";
                    echo "<input name='txtPassword' type='password'>";
                    echo "<br/><br/>"; 
                    echo "<input type='hidden' name='csrf_token' value=".$_SESSION["csrf_token"].">"; 
                    echo "<input type='submit' value='Login'>";
                    echo "</form>";
                    if (isset($_SESSION['wrong'])) {
                        echo "<h3>Error, something is not right. Please check your details again.</h3>";
                    }
                } elseif (isset($_SESSION['loggedin'])) {
                    echo "<h2>Hi "  .$_SESSION['name'] . ", You are logged-in</h2>";
                    echo "<form action='process_logout.php' method='post'>";
                    echo "<pre>";

                    echo "<br/><br/>"; 
                    echo "<input type='submit' value='Logout'>";

                    echo "</pre>";
                    echo "</form>";
                } 
            ?>
        </div>
        
        
    </div>
    <div class="footer"><p>© Copyright 2020</p></div>
</body>