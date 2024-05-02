<?php
require_once "../controller/logoutController.php";

$logoutController = new LogoutController();
$logoutController->logout();

header("Location: login.php");
exit;
?>
