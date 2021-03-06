<?php
session_start();
if(!empty($_POST["csrf_token"])) {
	if (!(hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']))) {
		// Reset token
		unset($_SESSION["csrf_token"]);
		die("CSRF token validation failed");
	}
}
if(!(isset($_POST['captcha_challenge']) && $_POST['captcha_challenge'] == $_SESSION['captcha_text'])) {
	die("captcha_challenge failed");
}
// server and db connection values
 $servername = "localhost";
 $rootUser="root";
 $db="socnet";
 $rootPassword ="";

// Create connection
$conn = new mysqli($servername, $rootUser, $rootPassword, $db);

// values come from user entry in webform
$username = $_POST['txtUsername'];
$password =  $_POST['txtPassword'];

// Check connection
if ($conn->connect_error) 
{
  die("Connection failed: " . $conn->connect_error);
}
// query
$userQuery = "SELECT * FROM SystemUser";
$userResult = $conn->query($userQuery);

// flag type variable 
$userFound = 0;

echo "<table border='1'>";
if ($userResult->num_rows > 0)
{
  while($userRow = $userResult->fetch_assoc()) 
    {
		if ($userRow['Username'] == $username)
		{
			$userFound = 1; 
			
			// compare stored value of password
			$getPasswordHash = $userRow['Password'];
			
			if (password_verify( $password, $getPasswordHash))
			{
				//check if password need hash update 
				if (password_needs_rehash($getPasswordHash, PASSWORD_DEFAULT))
				{
					$newPasswordHash = password_hash($password, PASSWORD_DEFAULT);
					echo $newPasswordHash;
				}
				session_regenerate_id();
				$_SESSION['loggedin'] = TRUE;
				$_SESSION['name'] = $_POST['txtUsername'];
				$_SESSION['id'] = $id;
				$_SESSION['wrong'] = FALSE;
				header('Location: login.php');
			}
			else
			{
				$_SESSION['wrong'] = TRUE;
				header('Location: login.php');
			}
		}
	}
}
if ($userFound == 0)
{
	echo "This user was not found in our Database";
}
 
 ?>
