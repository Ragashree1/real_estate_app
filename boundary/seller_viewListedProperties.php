<?php 
require_once "partials/header.php"; 
require_once "partials/hero.php"; 
require_once "../controller/sellerViewListedPropertyController.php";
require_once "../controller/sellerSearchListedPropertyController.php";
require_once "../controller/sellerTrackNumViewsController.php";
require_once "../controller/sellerTrackNumShortlistController.php";

$loggedInUsername = $_SESSION["username"];
$allListing;
$current_listing;

// display new listings
function displayListedProperties()
{
    global $loggedInUsername;
    global $allListing;

    $viewListedPropertyController = new SellerViewListedPropertyController();
    $allListing = $viewListedPropertyController->sellerGetListedProperties($loggedInUsername);  
}

function searchListedProperties()
{
    global $allListing;
    global $loggedInUsername;

    $searchInfo = array();

    // store each login field data in array
    foreach ($_GET as $key => $value) {
        $searchInfo[$key] = $value;
    }

    $searchInfo['sold_by'] = $loggedInUsername;

    $searchListedPropertyr = new SellerSearchListedPropertyController();
    $allListing = $searchListedPropertyr->searchListedProperty($searchInfo);
}

function getNumViews()
{
    global $current_listing;
    global $numViews;

    $sellerTrackNumViewsController = new SellerTrackNumViewsController();
    $numViews = $sellerTrackNumViewsController->getNumViews($current_listing);
}

function getNumShortlist()
{
    global $current_listing;
    global $numShortlist;

    $sellerTrackNumShortlistController = new SellerTrackNumShortlistController();
    $numShortlist = $sellerTrackNumShortlistController->getNumShortlist($current_listing);
}


// search listings created by agent
if(isset($_GET['searchForm']))
{
    searchListedProperties();
}
else
{
    displayListedProperties();
}
?>


<br>
<h2> &nbsp;My Listed Properties</h2>

<!-- search bar -->
<div class="container-fluid mt-3">
    <form class="form-inline" method="GET" action=""
            style="background-color: grey; padding: 10px; border-radius: 5px; width: 90vw;">
        <input class="form-control mr-sm-2" type="search" placeholder="Title/type/location/status/agent" aria-label="Search" name="search" style="width: 55%;">
        <input class="form-control mr-sm-2" type="number" placeholder="No. of views" name="num_views" style="width: 15%;" min="0">
        <input class="form-control mr-sm-2" type="number" placeholder="No. of shortlists" name="num_shortlist" style="width: 15%;" min="0">
        <button class="btn btn-success my-2 my-sm-0" type="submit" name="searchForm" value="search" style="width: 10%;">
            <i class="fas fa-search"></i> Search
        </button>
    </form>
</div>
<br>

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
                <th>Status</th>
                <th>Listed by</th>
                <th>Number of Views</th>
                <th>Number of Shortlists</th>
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
                    <td><?php echo $listing['status']; ?></td>
                    <td><?php echo $listing['listed_by']; ?></td>
                    <td>
                        <span class="badge badge-pill badge-primary p-2">
                            <i class="fas fa-eye"></i>
                            <span class="font-weight-bold ml-2" style="font-size: 1.2rem;">
                                <?php 
                                    $current_listing = $listing['listing_id'];
                                    getNumViews();
                                    echo $numViews;
                                ?>
                            </span>
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-pill badge-warning p-2">
                            <i class="fas fa-heart fa-lg"></i>
                            <span class="font-weight-bold ml-2" style="font-size: 1.2rem;">
                                <?php 
                                    $current_listing = $listing['listing_id'];
                                    getNumShortlist();
                                    echo $numShortlist;
                                ?>
                            </span>
                        </span>
                    </td>
                    <td>
                        <a href="seller_viewSingleListedProperty.php?listing_id=<?php echo $listing['listing_id']; ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-info-circle"></i>Details</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
}
?>


<?php require_once "partials/footer.php"; ?>


