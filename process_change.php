<?php
session_start();
if(!empty($_POST["csrf_token"])) {
	if (!(hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']))) {
		// Reset token
		unset($_SESSION["csrf_token"]);
		die("CSRF token validation failed");
	}
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
$oldpassword = $_POST['txtOldPassword'];
$newpassword = $_POST['txtNewPassword'];

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
			
			// decode Base64 stored value of password
			$getPasswordHash = $userRow['Password'];
			
			if (password_verify( $oldpassword, $getPasswordHash))
			{
                //password encryption
                $newpasswordHash = password_hash($newpassword, PASSWORD_DEFAULT);
				//  update query   , check hash variable in the Values statement 
				$stmt = $conn->prepare("UPDATE SystemUser SET Password = ? WHERE Username = ? ");
				$stmt->bind_param("ss", $newpasswordHash, $username);
                //$userQuery = "UPDATE SystemUser SET Password = '$newpasswordHash' WHERE Username = '$username'";
                if ($stmt->execute())
                {
					session_regenerate_id();
					$_SESSION['name'] = $_POST['txtUsername'];
					$_SESSION['id'] = $id;
					$_SESSION['changed'] = TRUE;
					header('Location: submitted.php');
                }
                else
                {
					$_SESSION['change_error'] = "Error, something is not right. Please check your details again.";
					header('Location: changePassword.php');
                }
			}
			else
			{
                $_SESSION['change_error'] = "Error, something is not right. Please check your details again.";
				header('Location: changePassword.php');
			}
		}
	}
}
if ($userFound == 0)
{
	$_SESSION['change_error'] = "Error, something is not right. Please check your details again.";
	header('Location: changePassword.php');
}
$stmt->close();
$conn->close();
 ?>

