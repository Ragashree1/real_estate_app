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
    
    // get all listings with status = new
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
        $query = "SELECT * FROM PropertyListing WHERE listing_id = ?";
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

    //fetch the agent information associated with the listing
    function getAgentInfo($listing_id): array
    {

        $query = "SELECT ua.username, ua.fullname, ua.email, ua.contact 
                  FROM UserAccount ua 
                  JOIN PropertyListing pl ON ua.username = pl.listed_by 
                  WHERE pl.listing_id = ?";

        // Prepare the statement
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bind_param("i", $listing_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch the agent information as an associative array
        $agentInfo = $result->fetch_assoc();

        // Close the statement
        $stmt->close();

        return $agentInfo;
    }

    // search listings
    function searchListings(array $searchInfo): array
    {
        // Initialize an empty array to store the search results
        $searchResults = [];

        // Build the SQL query based on search parameters
        $sql = "SELECT * FROM PropertyListing WHERE 1=1"; 

        // Add conditions based on search parameters
        if (!empty($searchInfo['search'])) {
            $searchTerm = $this->conn->real_escape_string($searchInfo['search']);
            $sql .= " AND (title LIKE '%$searchTerm%' 
                    OR type LIKE '%$searchTerm%' 
                    OR location LIKE '%$searchTerm%' 
                    OR status LIKE '%$searchTerm%')";
        }

        if (!empty($searchInfo['min_price'])) {
            $minPrice = (float) $searchInfo['min_price'];
            $sql .= " AND price >= $minPrice";
        }

        if (!empty($searchInfo['max_price'])) {
            $maxPrice = (float) $searchInfo['max_price'];
            $sql .= " AND price <= $maxPrice";
        }

        if (!empty($searchInfo['min_area'])) {
            $minArea = (float) $searchInfo['min_area'];
            $sql .= " AND area >= $minArea";
        }

        if (!empty($searchInfo['bhk'])) {
            $bhk = (float) $searchInfo['bhk'];
            $sql .= " AND bhk >= $bhk";
        }

        // Order the results by create_date in descending order
        $sql .= " ORDER BY date_listed DESC";

        // Execute the query
        $result = $this->conn->query($sql);

        // Check if any rows are returned
        if ($result->num_rows > 0) {
            // Fetch rows and add them to the search results array
            while ($row = $result->fetch_assoc()) {
                $searchResults[] = $row;
            }
        }

        // Close the database connection
        $this->conn->close();

        return $searchResults;
    }

}
?>