<?php
class Rating
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


    function getAllRatings(string $agent_username): array
    {
        $ratings = [];

        // Prepare the query
        $query = "SELECT * FROM Rating WHERE agent_username = ? ORDER BY date_rated DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $agent_username);

        // Execute the query
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $ratings[] = $row;
            }
        }
        $stmt->close();

        return $ratings;
    }

    function rateAgent(array $rateInfo): bool
    {
        // Extract rating information from the array
        $rater_username = $rateInfo['rater_username'];
        $agent_username = $rateInfo['agent_username'];
        $profile = $rateInfo['profile'];
        $rating_communication = $rateInfo['rating_communication'];
        $rating_professionalism = $rateInfo['rating_professionalism'];
        $rating_marketKnowledge = $rateInfo['rating_marketKnowledge'];

        // Prepare the SQL query
        $query = "INSERT INTO Rating (rater_username, agent_username, profile, rating_communication, rating_professionalism, rating_marketKnowledge) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssiii", $rater_username, $agent_username, $profile, $rating_communication, $rating_professionalism, $rating_marketKnowledge);

        // return false if any errors occured
        try {
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }

    public function isRated(string $rater_username, string $agent_username): bool
    {
        // check if is already rated
        $sql = "SELECT * FROM Rating WHERE rater_username = ? AND agent_username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $rater_username, $agent_username);

        // execute and get result
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
}
