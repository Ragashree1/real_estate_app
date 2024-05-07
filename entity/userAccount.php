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
        return true; // Login credentials are valid
    }

    public function getUsers(): array
    {
        $allUsers = [];

        // Perform a database query to fetch all listings
        $query = "SELECT * FROM UserAccount";
        $result = $this->conn->query($query);

        // Check if there are any listings
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $allUsers[] = $row;
            }
        }

        return $allUsers;
    }

    public function searchUsers(string $username)
    {
        $allUsers = [];


        // Perform a database query to fetch all listings
        $query = "SELECT * FROM UserAccount WHERE username LIKE '%" . $username . "%'";

        $result = $this->conn->query($query);

        // Check if there are any listings
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $allUsers[] = $row;
            }
        }

        return $allUsers;
    }

    public function deleteUser(string $username)
    {

        $query = "DELETE FROM UserAccount WHERE username = '$username'";


        $result = $this->conn->query($query);

        return $result;
    }


    public function suspendUser(string $username)
    {

        $query = "UPDATE UserAccount SET status = 'suspended' WHERE username = '$username'";

        $result = $this->conn->query($query);

        return $result;
    }

    public function createUser(array $userDetails)
    {

        $username = isset($userDetails["username"]) ?  $userDetails['username'] : null;
        $passwordHash =  isset($userDetails["password"]) ? password_hash($userDetails['password'], PASSWORD_DEFAULT) : 'password123';
        $dob =  isset($userDetails["dob"]) ? $userDetails['dob'] : null;
        $fullname = isset($userDetails["fullname"]) ? $userDetails['fullname'] : null;
        $email = isset($userDetails["email"]) ? $userDetails['email'] : null;
        $contact = isset($userDetails["contact"]) ?  $userDetails['contact'] : null;
        $profile =  isset($userDetails["profile"]) ? $userDetails['profile'] : null;
        $status =  isset($userDetails["status"]) ? $userDetails['status'] : null;

        $query = "INSERT INTO UserAccount (username, passwordHash, dob, fullname, email, contact, profile, status) 
                VALUES ('$username', '$passwordHash', '$dob', '$fullname', '$email', '$contact', '$profile', '$status')";

        $result = $this->conn->query($query);

        return $result;
    }
}
