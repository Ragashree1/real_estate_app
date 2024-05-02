<?php

class LogoutController
{
    public function logout()
    {
        session_start();

        // Destroy the session
        $_SESSION = array();
        session_destroy();
    }
}

?>