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
 $servername = "localhost";
 $rootuser="root";
 $db="socnet";
 $rootpassword ="";
// Create connection
$conn = new mysqli($servername, $rootuser, $rootpassword, $db);
// Check connection
if ($conn->connect_error) 
{
  die("Connection failed: " . $conn->connect_error);
}

//Values from form
$username= $_POST['txtUsername'];
$forname = $_POST['txtForename'];
$surname = $_POST['txtSurname']; 
$email = $_POST['txtEmail']; 
$password = $_POST['txtPassword']; 


if (($username !== '' )&&($forname !== '' )&&($surname !== '' )&&($email !== '' )&&($password !== '')) {
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);
    if((!preg_match("#[a-zA-Z]+#", $password)) || (!preg_match("#[0-9]+#", $password)) || (strlen($password) < 8)) {
        $_SESSION['registered_error'] = "Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.";
        header('Location: index.php');
    }
    else {
        //password encryption
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        //  INSERT query   , check hash variable in the Values statement 
        $stmt = $conn->prepare("INSERT INTO systemuser (Username, Password, Forename, Surname, Email) Values(? , ? , ? , ? , ?)");
        $stmt->bind_param("sssss", $username, $passwordHash, $forname, $surname, $email);
        //$userQuery = "INSERT INTO systemuser (Username, Password, Forename, Surname, Email) Values('$username', '$passwordHash', '$forname', '$surname', '$email')";

        if ($stmt->execute())
        {
            session_regenerate_id();
            $_SESSION['registered'] = TRUE;
            $_SESSION['name'] = $_POST['txtUsername'];
            $_SESSION['id'] = $id;
            header('Location: submitted.php');
        }
        else
        {
            $_SESSION['registered_error'] = "Somethings Wrong";
            header('Location: index.php');
        }
    }
}else{
    $_SESSION['registered_error'] = "Somethings Wrong";
    header('Location: index.php');
}
?>

