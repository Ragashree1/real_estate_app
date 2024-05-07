<?php
class Shortlist
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

    public function shortlist(string $buyer_username, int $listing_id)
    {        
        // Prepare the SQL statement to insert into the Shortlist table
        $sql = "INSERT INTO Shortlist (buyer_username, listing_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $buyer_username, $listing_id);
        
        // Execute the query
        if ($stmt->execute()) {
            echo 'success shortlist';
        } else {
            echo 'fail shortlist';
        }
    }

    public function removeShortlist(string $buyer_username, int $listing_id)
    {   
        // Prepare the SQL statement to delete from the Shortlist table
        $sql = "DELETE FROM Shortlist WHERE buyer_username = ? AND listing_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $buyer_username, $listing_id);
        
        // Execute the query
        if ($stmt->execute()) {
            echo 'success remove';
        } else {
            echo 'fail remove';
        }
    }

    public function isShortlisted(string $buyer_username, int $listing_id): bool
    {
        // Prepare the SQL statement to check if the listing is shortlisted by the buyer
        $sql = "SELECT * FROM Shortlist WHERE buyer_username = ? AND listing_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $buyer_username, $listing_id);

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


?>