<?php
class Review
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


    function getAllReviews(string $agent_username): array
    {
        $reviews = [];

        // Prepare the query
        $query = "SELECT * FROM Review WHERE agent_username = ? ORDER BY date_reviewed DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $agent_username);

        // Execute the query
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $reviews[] = $row;
            }
        }

        // Close the statement
        $stmt->close();
        return $reviews;
    }

    function reviewAgent(array $reviewInfo): bool
    {
        // Extract review information from the array
        $reviewer_username = $reviewInfo['reviewer_username'];
        $agent_username = $reviewInfo['agent_username'];
        $profile = $reviewInfo['profile'];
        $review = $reviewInfo['review_text'];

        // Prepare the SQL query
        $query = "INSERT INTO Review (reviewer_username, agent_username, profile, review_text) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bind_param("ssss", $reviewer_username, $agent_username, $profile, $review);

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

    public function isReviewed(string $reviewer_username, string $agent_username): bool
    {
        // check if is alr reviewed
        $sql = "SELECT * FROM Review WHERE reviewer_username = ? AND agent_username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $reviewer_username, $agent_username);

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
