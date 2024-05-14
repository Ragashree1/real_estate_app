<?php
session_start();
require_once "../controller/loginController.php";

$validated = null; 

function login()
{
	global $validated;
	$loginInfo = array();

    // store each login field data in array
    foreach ($_POST as $key => $value) {
        $loginInfo[$key] = $value;
    }

    // create controller object
    $loginController = new LoginController();
    $validated = $loginController->login($loginInfo);

	if ($validated) {
		$validated = true;
		loginSuccess();
	}
	else 
	{
		$validated = false;
	}
}

// Define displayError function
function loginError()
{
    return "Invalid credentials, try again."; 
}

function loginSuccess()
{
	// Store username in session
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['profile'] = strtolower($_POST['profile']);

	header("Location: dashboard.php"); // Redirect to dashboard page
	exit();
}


if (isset($_POST["login"])) 
{
	login();
}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>User Login</title>
	<!-- style -->
	<link rel="stylesheet" type="text/css" href="css/loginstyle.css">
</head>
<body style="background-image: url(images/loginBackground.png); background-repeat:no-repeat;  background-attachment: fixed;
  background-size: cover;">

	<div class="form-login">
		<p class="lead">Login</p>
		<form action="#" method="POST">

			<input type="text" placeholder="username or email" id="username" name="username" required>
			<input type="password" placeholder="password" id="password" name="password" required>
			<select id="profile" name="profile" required>
				<option value="" selected disabled>-- Select Profile --</option>
				<option>Admin</option>
				<option>Agent</option>
				<option>Buyer</option>
				<option>Seller</option>
			</select>
			<?php if(isset($validated) && !$validated) { echo "<span style='color:red'>" . loginError() . "</span>"; } ?>
			<input type="submit" value="login" name="login">
		</form>
	</div>



</body>
</html>