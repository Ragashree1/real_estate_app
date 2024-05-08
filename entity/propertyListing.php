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

    // get all listings with status = sold
    public function getSoldListing(): array
    {
         $allListings = [];

         // Perform a database query to fetch all listings
         $query = "SELECT * FROM PropertyListing WHERE status = 'sold' ORDER BY date_listed DESC";
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
        $query = "  SELECT PropertyListing.*, UserAccount.fullname, UserAccount.contact, UserAccount.email  
                    FROM PropertyListing LEFT JOIN UserAccount 
                        ON PropertyListing.listed_by = UserAccount.username 
                    WHERE listing_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $listing_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // return empty array if not found
        if ($result->num_rows == 1) {
            // Increment the view count
            $sql = "UPDATE PropertyListing SET num_views = num_views + 1 WHERE listing_id = $listing_id";
            $this->conn->query($sql);

            $listingData = $result->fetch_assoc();
            return $listingData;
        } else {
            return [];
        }
    }

    // search listings for new properties
    function searchNewListings(array $searchInfo): array
    {
        // Initialize an empty array to store the search results
        $searchResults = [];

        // create sql query statement
        $sql = "SELECT * FROM PropertyListing WHERE status = 'new'"; 

        // Add conditions based on search parameters
        if (!empty($searchInfo['search'])) {
            $searchTerm = $this->conn->real_escape_string($searchInfo['search']);
            $sql .= " AND (title LIKE '%$searchTerm%' 
                    OR type LIKE '%$searchTerm%' 
                    OR location LIKE '%$searchTerm%')";
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
            while ($row = $result->fetch_assoc()) {
                $searchResults[] = $row;
            }
        }

        $this->conn->close();
        return $searchResults;
    }

    // search listings for sold properties
    function searchSoldListings(array $searchInfo): array
    {
        // Initialize an empty array to store the search results
        $searchResults = [];

        // Build the SQL query based on search parameters
        $sql = "SELECT * FROM PropertyListing WHERE status = 'sold'"; 

        // create sql statement
        if (!empty($searchInfo['search'])) {
            $searchTerm = $this->conn->real_escape_string($searchInfo['search']);
            $sql .= " AND (title LIKE '%$searchTerm%' 
                    OR type LIKE '%$searchTerm%' 
                    OR location LIKE '%$searchTerm%')";
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
            while ($row = $result->fetch_assoc()) {
                $searchResults[] = $row;
            }
        }

        $this->conn->close();
        return $searchResults;
    }

    public function agentGetSingleListing(int $listing_id): array
    {
        // Perform a database query to fetch the listing data
        $query = "SELECT PropertyListing.*, UserAccount.fullname, UserAccount.contact, UserAccount.email  
                    FROM PropertyListing LEFT JOIN UserAccount 
                        ON PropertyListing.sold_by = UserAccount.username 
                    WHERE listing_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $listing_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // return empty array if not found
        if ($result->num_rows == 1) {
            // Increment the view count
            $sql = "UPDATE PropertyListing SET num_views = num_views + 1 WHERE listing_id = $listing_id";
            $this->conn->query($sql);

            $listingData = $result->fetch_assoc();
            return $listingData;
        } else {
            return [];
        }
    }

    // get all listings created by agent
    public function agentGetCreatedListing(string $agent_username): array
    {
        $allListings = [];

        // Prepare the SQL query with a parameterized query to avoid SQL injection
        $query = "SELECT * FROM PropertyListing WHERE listed_by = ? ORDER BY date_listed DESC";

        // Prepare the statement
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $agent_username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if there are any listings
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $allListings[] = $row;
            }
        }

        $stmt->close();

        return $allListings;
    }


    // search listings
    function agentSearchListings(array $searchInfo): array
    {
        $searchResults = [];

        // Build the SQL query based on search parameters
        $sql = "SELECT * FROM PropertyListing WHERE 1=1"; 

        // Add conditions based on search parameters
        if (!empty($searchInfo['search'])) {
            $searchTerm = $this->conn->real_escape_string($searchInfo['search']);
            $sql .= " AND (title LIKE '%$searchTerm%' 
                    OR type LIKE '%$searchTerm%' 
                    OR location LIKE '%$searchTerm%' 
                    OR status LIKE '%$searchTerm%'
                    OR sold_by LIKE '%$searchTerm%')";
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

        if (!empty($searchInfo['listed_by'])) {
            $listed_by = $searchInfo['listed_by'];
            $sql .= " AND listed_by = '$listed_by'";
        }

        // Order the results by create_date in descending order
        $sql .= " ORDER BY date_listed DESC";

        // Execute the query
        $result = $this->conn->query($sql);

        // Check if any rows are returned
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $searchResults[] = $row;
            }
        }

        // Close the database connection
        $this->conn->close();

        return $searchResults;
    }

    // agent create a listing
    function agentCreateListings(array $createInfo): bool
    {
        // Extract data from the $createInfo array
        $title = $createInfo['title'];
        $description = $createInfo['description'];
        $image = $createInfo['image'];
        $type = $createInfo['type'];
        $location = $createInfo['location'];
        $price = $createInfo['price'];
        $area = $createInfo['area'];
        $bhk = $createInfo['bhk'];
        $status = $createInfo['status'];
        $listed_by = $createInfo['listed_by'];
        $sold_by = $createInfo['sold_by'];

       // Prepare the SQL query with placeholders
        $sql = "INSERT INTO PropertyListing (title, description, image, type, location, price, area, bhk, listed_by, status, sold_by) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare the statement
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssssssss", $title, $description, $image, $type, $location, $price, $area, $bhk, $listed_by, $status, $sold_by);

        // Execute the statement
        try {
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $e) {
            return false;
        }

        // Close the statement
        $stmt->close();

    }

    // agent delete a listing
    function agentDeleteListings(int $listing_id): bool
    {
        // Prepare the DELETE query
        $query = "DELETE FROM PropertyListing WHERE listing_id = ?";
        
        // Prepare the statement
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            // If preparation fails, return false
            return false;
        }
        $stmt->bind_param("i", $listing_id);
        $result = $stmt->execute();
        
        // Check if the deletion was successful
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    // agent update a listing
    function agentUpdateListings(array $updateInfo, int $listing_id): bool
    {
        // Extract data from the $updateInfo array
        $title = $updateInfo['title'];
        $description = $updateInfo['description'];
        $image = $updateInfo['image'];
        $type = $updateInfo['type'];
        $location = $updateInfo['location'];
        $price = $updateInfo['price'];
        $area = $updateInfo['area'];
        $bhk = $updateInfo['bhk'];
        $status = $updateInfo['status'];
        $listed_by = $updateInfo['listed_by'];
        $sold_by = $updateInfo['sold_by'];

       // Prepare the SQL query with placeholders
        $sql = "UPDATE PropertyListing 
        SET title=?, description=?, image=?, type=?, location=?, price=?, area=?, bhk=?, listed_by=?, status=?, sold_by=?
        WHERE listing_id=?";

        // Prepare the statement
        $stmt = $this->conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("sssssssssssi", $title, $description, $image, $type, $location, 
                        $price, $area, $bhk, $listed_by, $status, $sold_by, $listing_id);

        // Execute the statement
        try {
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $e) {
            return false;
        }

        $stmt->close();

    }

    // get listed properties of a seller
    public function sellerGetListedProperties(string $seller_username): array
    {
        $allListings = [];

        // Prepare the SQL query with a parameterized query to avoid SQL injection
        $query = "SELECT * FROM PropertyListing WHERE sold_by = ? ORDER BY date_listed DESC";

        // Prepare the statement
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $seller_username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if there are any listings
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $allListings[] = $row;
            }
        }

        $stmt->close();

        return $allListings;
    }

    // search listings
    function sellerSearchListedProperties(array $searchInfo): array
    {
        $searchResults = [];

        // Build the SQL query based on search parameters
        $sql = "SELECT * FROM PropertyListing WHERE 1=1"; 

        // Add conditions based on search parameters
        if (!empty($searchInfo['search'])) {
            $searchTerm = $this->conn->real_escape_string($searchInfo['search']);
            $sql .= " AND (title LIKE '%$searchTerm%' 
                    OR type LIKE '%$searchTerm%' 
                    OR location LIKE '%$searchTerm%' 
                    OR status LIKE '%$searchTerm%'
                    OR listed_by LIKE '%$searchTerm%')";
        }

        if (!empty($searchInfo['sold_by'])) {
            $sold_by = $searchInfo['sold_by'];
            $sql .= " AND sold_by = '$sold_by'";
        }

        if (!empty($searchInfo['num_views'])) {
            $num_views = (float) $searchInfo['num_views'];
            $sql .= " AND num_views >= '$num_views'";
        }

        if (!empty($searchInfo['num_shortlist'])) {
            $num_shortlist = (float) $searchInfo['num_shortlist'];
            $sql .= " AND num_shortlist >= '$num_shortlist'";
        }

        // Order the results by create_date in descending order
        $sql .= " ORDER BY date_listed DESC";

        // Execute the query
        $result = $this->conn->query($sql);

        // Check if any rows are returned
        if ($result->num_rows > 0) {
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