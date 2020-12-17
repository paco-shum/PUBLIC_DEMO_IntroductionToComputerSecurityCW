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
            <li><a href="changePassword.php"><p class="active">Change Password</p></a></li>
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
            echo "<form action='process_change.php' method='POST'>";
            echo "<pre>";
            echo "Username ";
            echo "<input name='txtUsername' type='text'>";

            echo "<br/>"; 
            echo "Old Password ";
            echo "<input name='txtOldPassword' type='password'>";

            echo "<br/>"; 
            echo "New Password ";
            echo "<input name='txtNewPassword' type='password'>";

            echo "<br/><br/>"; 
            echo "<input type='submit' value='Change Password'>";

            echo "</pre>";
            echo "</form>";

            if (isset($_SESSION['change_error'])) {
                echo "<h3>".$_SESSION['change_error'].", please cheak you've filled in all text field and met the requirements listed.</h3>";
            }
        ?>
        </div>
        
        
    </div>
    <div class="footer"><p>© Copyright 2020</p></div>
</body>