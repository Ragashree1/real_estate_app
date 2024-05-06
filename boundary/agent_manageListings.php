<?php 
require_once "partials/header.php"; 
require_once "../controller/agentViewListingController.php";
require_once "../controller/agentSearchListingController.php";
require_once "../controller/agentDeleteListingController.php";

$loggedInUsername = $_SESSION["username"];
$agentViewListingController = new agentViewListingController();
$allListing;
$errors;

// display new listings
function displayCreatedListings()
{
    global $loggedInUsername;
    global $agentViewListingController;
    global $allListing;

    $allListing = $agentViewListingController->getCreatedListings($loggedInUsername);  
}

function searchCreatedListings()
{
    global $allListing;

    $searchInfo = array();

    // store each login field data in array
    foreach ($_GET as $key => $value) {
        $searchInfo[$key] = $value;
    }

    $agentSearchListingController = new AgentSearchListingController();
    $allListing = $agentSearchListingController->agentSearchListings($searchInfo);
}

function deleteCreatedListings()
{
    $agentDeleteListingController = new AgentDeleteListingController();
    $deleted = $agentDeleteListingController->agentDeleteListings($_GET["delete_id"]);

    if($deleted)
    {

        deleteSuccess();
    }
    else
    {
        deleteFail();
    }
}

function deleteSuccess()
{
    echo '<div class="alert alert-success" role="alert">
            Deleted successfully, refreshing...
        </div>';

    // Redirect using JavaScript after the alert is closed
    echo '<script>setTimeout(function() { window.location.href = "agent_manageListings.php"; }, 1000);</script>';
}

function deleteFail()
{
    echo '<div class="alert alert-danger" role="alert">
            Delete fail..try again!
        </div>';
}



// search listings created by agent
if(isset($_GET['searchForm']))
{
    searchCreatedListings();
}
else
{
    displayCreatedListings();
}

if(isset($_GET['delete_id']))
{
    deleteCreatedListings();
}

?>

<!-- search bar -->
<div class="container-fluid mt-3">
    <form class="form-inline" method="GET" action=""
            style="background-color: grey; padding: 10px; border-radius: 5px; width: 90vw;">
        <input class="form-control mr-sm-2" type="search" placeholder="Title/type/location/status/seller" aria-label="Search" name="search" style="width: 25%;">
        <input class="form-control mr-sm-2" type="number" placeholder="Min Price" name="min_price" style="width: 15%;">
        <input class="form-control mr-sm-2" type="number" placeholder="Max Price" name="max_price" style="width: 15%;">
        <input class="form-control mr-sm-2" type="number" placeholder="Min Area" name="min_area" style="width: 15%;">
        <input class="form-control mr-sm-2" type="number" placeholder="bedroom+hall+kitchen num" name="bhk" style="width: 20;">
        <button class="btn btn-success my-2 my-sm-0" type="submit" name="searchForm" value="search" style="width: 10%;">
            <i class="fas fa-search"></i> Search
        </button>
    </form>
</div>
<br>

<!-- Create listings -->
<a href="agent_createListings.php" class="btn btn-primary">
    <i class="fas fa-plus"></i> Create Listing
</a>
<br/><br/>

<?php
// Check if $allListing is empty
if (empty($allListing)) {
    echo "No property listings found";
} else {
    ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Type</th>
                <th>bhk</th>
                <th>Price</th>
                <th>Area</th>
                <th>Location</th>
                <th>Status</th>
                <th>Sold by</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($allListing as $listing) : ?>
                <tr>
                    <td><?php echo $listing['listing_id']; ?></td>
                    <td>
                        <div class="text-wrap" style="max-width: 100px;"><?php echo $listing['title']; ?></div>
                    </td>
                    <td><?php echo $listing['type']; ?></td>
                    <td><?php echo $listing['bhk']; ?></td>
                    <td><?php echo $listing['price']; ?></td>
                    <td><?php echo $listing['area']; ?></td>
                    <td><?php echo $listing['location']; ?></td>
                    <td><?php echo $listing['status']; ?></td>
                    <td><?php echo $listing['sold_by']; ?></td>
                    <td>
                        <a href="agent_viewSingleListing.php?listing_id=<?php echo $listing['listing_id']; ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye"></i>View</a>
                        <a href="agent_updateListings.php?listing_id=<?php echo $listing['listing_id']; ?>" class="btn btn-success btn-sm">
                        <i class="fas fa-pencil"></i>Update</a>
                        <a href="?delete_id=<?php echo $listing['listing_id']; ?>" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i>Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
}
?>


<?php require_once "partials/footer.php"; ?>


