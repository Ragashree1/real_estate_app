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

    public function login(array $loginInfo): bool
    {
        $username = $loginInfo['username'];
        $password = $loginInfo['password'];
        $profile = $loginInfo['profile'];

        //SQL query to validate login
        $query = "SELECT * FROM UserAccount WHERE (username = '$username' OR email = '$username') 
                                                AND profile = '$profile'";
        $result = $this->conn->query($query);

        // return false when no records found
        if ($result->num_rows <= 0) {
            return false;
        }

        // Retrieve the user's hashed password from the database
        $row = $result->fetch_assoc();
        $hashedPassword = $row['passwordHash'];
        if (!password_verify($password, $hashedPassword)) {
            return false;
        }
        return true; // Login credentials are valid
    }

    public function getAccounts(): array
    {
        $allUsers = [];

        // Perform a database query to fetch all accounts
        $query = "SELECT * FROM UserAccount order by created_on desc";
        $result = $this->conn->query($query);

        // Check if there are any accounts
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $allUsers[] = $row;
            }
        }

        return $allUsers;
    }

    public function searchAccounts(string $searchInfo): array
    {
        $allUsers = [];


        // Perform a database query to fetch all accounts
        // Perform a database query to fetch all data
        $query = "SELECT * FROM UserAccount WHERE 
        username LIKE '%" . $searchInfo . "%' 
        OR profile LIKE '%" . $searchInfo . "%' 
        OR contact LIKE '%" . $searchInfo . "%' 
        OR status LIKE '%" . $searchInfo . "%' 
        ORDER BY created_on DESC";

        $result = $this->conn->query($query);

        // Check if there are any accounts
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $allUsers[] = $row;
            }
        }

        return $allUsers;
    }

    public function deleteAccount(string $username): bool
    {

        $query = "DELETE FROM UserAccount WHERE username = '$username'";


        $result = $this->conn->query($query);

        return $result;
    }


    public function suspendAccount(string $username): bool
    {

        $query = "UPDATE UserAccount SET status = 'suspended' WHERE username = '$username'";

        $result = $this->conn->query($query);

        return $result;
    }

    public function createAccount(array $userDetails): bool
    {
        //check if username or email is already used
        $username = $userDetails['username'];
        $email = $userDetails['email'];
        $query = "SELECT * FROM UserAccount WHERE email = '$email' OR username = '$username'";

        $result = $this->conn->query($query);
        if ($result && $result->num_rows > 0) {
            return false;
        }

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


    public function updateAccount(array $userDetails): bool
    {
        //check if username or email is already used by another account
        $username = $userDetails['username'];
        $email = $userDetails['email'];
        $account_id = $userDetails['account_id'];
        $query = "SELECT * FROM UserAccount WHERE (email = '$email' OR username = '$username') AND account_id != '$account_id'";

        $result = $this->conn->query($query);
        if ($result && $result->num_rows > 0) {
            return false;
        }


        $username = isset($userDetails["username"]) ?  $userDetails['username'] : null;
        $dob =  isset($userDetails["dob"]) ? $userDetails['dob'] : null;
        $fullname = isset($userDetails["fullname"]) ? $userDetails['fullname'] : null;
        $email = isset($userDetails["email"]) ? $userDetails['email'] : null;
        $contact = isset($userDetails["contact"]) ?  $userDetails['contact'] : null;
        $profile =  isset($userDetails["profile"]) ? $userDetails['profile'] : null;
        $status =  isset($userDetails["status"]) ? $userDetails['status'] : null;

        $query = "UPDATE UserAccount 
        SET username='$username', dob='$dob', fullname='$fullname', email='$email', contact='$contact', profile='$profile', status='$status'
        WHERE account_id='$account_id'";
        $result = $this->conn->query($query);

        if (!empty($userDetails["password"])) {
            $passwordHash = password_hash($userDetails['password'], PASSWORD_DEFAULT);
            $query = "UPDATE UserAccount SET passwordHash=? WHERE account_id=?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("si", $passwordHash, $account_id);
            $result = $stmt->execute();
            $stmt->close();
        }

        return $result;
    }
}
