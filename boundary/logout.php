<?php
require_once "../controller/logoutController.php";

function logout()
{
    $logoutController = new LogoutController();
    $logoutController->logout();

    header("Location: login.php");
    exit;
}

logout();
?>
