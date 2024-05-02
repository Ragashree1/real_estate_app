<?php
class PropertyListing
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
    
    public function getNewListing(): array
    {
         $allListings = [];

         // Perform a database query to fetch all listings
         $query = "SELECT * FROM PropertyListing WHERE status = 'new' ORDER BY date_listed DESC";
         $result = $this->conn->query($query);
 
         // Check if there are any listings
         if ($result->num_rows > 0) {
             while ($row = $result->fetch_assoc()) {
                 $allListings[] = $row;
             }
         }
 
         return $allListings;
    }


    public function getSingleListing(int $listing_id): array
    {
        // Perform a database query to fetch the listing data
        $query = "SELECT * FROM PropertyListing WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $listing_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // return empty array if not found
        if ($result->num_rows == 1) {
            $listingData = $result->fetch_assoc();
            return $listingData;
        } else {
            return [];
        }
    }

}
?>