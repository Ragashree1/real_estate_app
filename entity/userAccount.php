<?php
class UserAccount
{
    private $conn;

    // connect to database
    public function __construct()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "lucky7property";
        $port = 3310;

        // Create connection
        $this->conn = new mysqli($servername, $username, $password, $dbname, $port);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function validateLogin(array $loginInfo): bool
    {
        // check for spacing values
        foreach ($loginInfo as $value) {
            if (trim($value) === '') {
                return false;
            }
        }
        
        $username = $loginInfo['username'];
        $password = $loginInfo['password'];
        $profile = $loginInfo['profile'];

        // Example SQL query to validate login
        $query = "SELECT * FROM UserAccount WHERE (username = '$username' OR email = '$username') 
                                                AND profile = '$profile'";
        $result = $this->conn->query($query);

        if ($result->num_rows <= 0) {
            return false; // No matching user found
        }

        // Retrieve the user's hashed password from the database
        $row = $result->fetch_assoc();
        $hashedPassword = $row['passwordHash'];

        // Verify the provided password against the hashed password
        if (!password_verify($password, $hashedPassword)) {
            return false; 
        }

        return true; 
    }

}


?>