<?php
session_start();

require_once "../controller/loginController.php";

// Define displayError function
function displayError()
{
    return "Invalid credentials, try again."; // You can customize this message as needed
}

if (isset($_POST["login"])) 
{
    $loginInfo = array();

    // store each login field data in array
    foreach ($_POST as $key => $value) {
        $loginInfo[$key] = $value;
    }

    // create controller object
    $loginController = new LoginController();
    $validated = $loginController->validateLogin($loginInfo);

    if ($validated) {
		// Store username in session
        $_SESSION['username'] = $loginInfo['username'];
        $_SESSION['profile'] = strtolower($loginInfo['profile']);

		header("Location: dashboard.php"); // Redirect to dashboard page
		exit();
	}
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
				<option selected>Admin</option>
				<option>Agent</option>
				<option>Buyer</option>
				<option>Seller</option>
			</select>
			<?php if(isset($validated) && !$validated) { echo "<span style='color:red'>" . displayError() . "</span>"; } ?>
			<input type="submit" value="login" name="login">
		</form>
	</div>



</body>
</html>