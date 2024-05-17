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

    public function shortlist(string $buyer_username, int $listing_id): bool
    {
        // Prepare the SQL statement to insert into the Shortlist table
        $sql = "INSERT INTO Shortlist (buyer_username, listing_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $buyer_username, $listing_id);

        // Execute the query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function removeShortlist(string $buyer_username, int $listing_id): bool
    {
        // Prepare the SQL statement to delete from the Shortlist table
        $sql = "DELETE FROM Shortlist WHERE buyer_username = ? AND listing_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $buyer_username, $listing_id);

        // Execute the query
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                return true;
            }
        }
        return false;
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

    function getShortlistedNewListings(string $buyer_username): array
    {
        // Create an empty array to store the listings
        $listings = [];

        // Create the query
        $query = "SELECT pl.* 
                FROM PropertyListing pl
                JOIN Shortlist s ON pl.listing_id = s.listing_id
                WHERE s.buyer_username = ? AND pl.status = 'new' order by s.date_shortlisted desc";

        // Prepare the statement
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $buyer_username);

        // Execute the query
        $stmt->execute();
        $result = $stmt->get_result();

        // fetch results and store to array
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $listings[] = $row;
            }
        }

        // Close the statement
        $stmt->close();

        return $listings;
    }

    function getShortlistedSoldListings(string $buyer_username): array
    {
        // Create an empty array to store the listings
        $listings = [];

        // Create the query
        $query = "SELECT pl.* 
                FROM PropertyListing pl
                JOIN Shortlist s ON pl.listing_id = s.listing_id
                WHERE s.buyer_username = ? AND pl.status = 'sold' order by s.date_shortlisted desc";

        // Prepare the statement
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $buyer_username);

        // Execute the query
        $stmt->execute();
        $result = $stmt->get_result();

        // fetch results and store to array
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $listings[] = $row;
            }
        }

        // Close the statement
        $stmt->close();

        return $listings;
    }
}
