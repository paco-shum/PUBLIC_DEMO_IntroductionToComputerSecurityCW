<?php
session_start();
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
            <li><a href="login.php"><p>Login</p></a></li>
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
            if (isset($_SESSION['registered'])) {
                echo "<h3>Hi ".$_SESSION['name'].", you've now registered!</h3>";
                session_destroy();
            }elseif (isset($_SESSION['changed'])) {
                echo "<h3>Hi ".$_SESSION['name'].", you've now changed your password!</h3>";
                session_destroy();
            }else {
                session_destroy();
                header('Location: login.php');
            }
            ?>
        </div>
        
        
    </div>
    <div class="footer"><p>© Copyright 2020</p></div>
</body>