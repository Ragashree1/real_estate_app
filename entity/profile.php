<?php
class Profile
{
    private $conn;

    // connect to database
    public function __construct()
    {
        $servername = "localhost";
        $profileName = "root";
        $password = "";
        $dbname = "lucky7property";
        $port = 3310;

        // Create connection
        $this->conn = new mysqli($servername, $profileName, $password, $dbname, $port);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getProfiles(): array
    {
        $allProfiles = [];

        // Perform a database query to fetch all data
        $query = "SELECT * FROM UserProfile";
        $result = $this->conn->query($query);

        // Check if there are any data
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $allProfiles[] = $row;
            }
        }

        return $allProfiles;
    }

    public function searchProfiles(string $profileName)
    {
        $allProfiles = [];


        // Perform a database query to fetch all data
        $query = "SELECT * FROM UserProfile WHERE profile_name LIKE '%" . $profileName . "%'";

        $result = $this->conn->query($query);

        // Check if there are any data
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $allProfiles[] = $row;
            }
        }

        return $allProfiles;
    }

    public function deleteProfile(string $profileName)
    {

        $query = "DELETE FROM UserProfile WHERE profile_name = '$profileName'";


        $result = $this->conn->query($query);

        return $result;
    }


    public function createProfile(array $profileDetails)
    {
        //check if profile_name or email is already used
        $profileName = $profileDetails['profile_name'];
        $query = "SELECT * FROM UserProfile WHERE profile_name = '$profileName'";

        $result = $this->conn->query($query);
        if ($result && $result->num_rows > 0)  {
            return false;
        }

        $profileName = isset($profileDetails["profile_name"]) ?  $profileDetails['profile_name'] : null;
        $description =  isset($profileDetails["description"]) ? $profileDetails['description'] : null;

        $query = "INSERT INTO UserProfile (profile_name, description) 
                VALUES ('$profileName', '$description')";

        $result = $this->conn->query($query);

        return $result ? true : false;
    }


    public function updateProfile(array $profileDetails)
    {
        //check if profile_name or email is already used by another account
        $profileName = $profileDetails['profile_name'];
        $profile_id = $profileDetails['profile_id'];
        $query = "SELECT * FROM UserProfile WHERE profile_name = '$profileName' AND profile_id != '$profile_id'";

        $result = $this->conn->query($query);
        if ($result && $result->num_rows > 0)  {
            return false;
        }

        $profileName = isset($profileDetails["profile_name"]) ?  $profileDetails['profile_name'] : null;
        $description =  isset($profileDetails["description"]) ? $profileDetails['description'] : null;

        $query = "UPDATE UserProfile 
        SET profile_name='$profileName', description='$description'
        WHERE profile_id='$profile_id'";
        $result = $this->conn->query($query);
        
        return $result ? true : false;
    }
}
