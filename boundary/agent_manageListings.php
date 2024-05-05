<?php 
require_once "partials/header.php"; 
require_once "../controller/agentViewListingController.php";
require_once "../controller/agentSearchListingController.php";
require_once "../controller/agentCreateListingController.php";
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

function createListing()
{
    $createInfo = array();
    global $loggedInUsername;
    global $errors;

    // store each login field data in array
    foreach ($_POST as $key => $value) {
        $createInfo[$key] = $value;
    }
    
    $createInfo["listed_by"] = $loggedInUsername;

    $agentCreateListingController = new AgentCreateListingController();
    $errors = $agentCreateListingController->agentCreateListings($createInfo);
    
    // Check if there are any errors
    if (empty($errors)) {
        createSuccess();
    }
    else
        createFail();
}

function createSuccess()
{
    echo '<div class="alert alert-success" role="alert">
            Created successfully, refreshing...
        </div>';

    // Redirect using JavaScript after the alert is closed
    echo '<script>setTimeout(function() { window.location.href = "agent_manageListings.php"; }, 2000);</script>';
}

function createFail()
{
    echo '<div class="alert alert-danger" role="alert">
            Created fail..
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

if(isset($_POST['createListing']))
{
    createListing();
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

<!-- Create listings button -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createListingModal">
<i class="fas fa-plus"></i>
  Create Listing
</button>
<br />
<br/>

<!-- Create listings Modal -->
<div class="modal fade" id="createListingModal" tabindex="-1" role="dialog" aria-labelledby="createListingModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createListingModalLabel">Create New Listing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createListingForm" action="" method="post">
                    <!-- Form fields -->
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required value="<?php echo isset($_POST['title']) ? $_POST['title'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required><?php echo isset($_POST['description']) ? $_POST['description'] : ''; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Image URL</label>
                        <input type="text" class="form-control" id="image" name="image" value="<?php echo isset($_POST['image']) ? $_POST['image'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="type">Type</label>
                        <input type="text" class="form-control" id="type" name="type" required value="<?php echo isset($_POST['type']) ? $_POST['type'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" class="form-control" id="location" name="location" required value="<?php echo isset($_POST['location']) ? $_POST['location'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" id="price" name="price" step="100000" required value="<?php echo isset($_POST['price']) ? $_POST['price'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="area">Area</label>
                        <input type="number" class="form-control" id="area" name="area" required value="<?php echo isset($_POST['area']) ? $_POST['area'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="bhk">BHK</label>
                        <input type="number" class="form-control" id="bhk" name="bhk" required value="<?php echo isset($_POST['bhk']) ? $_POST['bhk'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <input type="text" class="form-control" id="status" name="status" value="new" value="<?php echo isset($_POST['status']) ? $_POST['status'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="sold_by">Sold By</label>
                        <input type="text" class="form-control" id="sold_by" name="sold_by" required value="<?php echo isset($_POST['sold_by']) ? $_POST['sold_by'] : ''; ?>">
                    </div>

                    <!-- Display errors for each field -->
                    <?php if (isset($errors) && !empty($errors)) : ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach ($errors as $error) : ?>
                                    <li><?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <button type="submit" class="btn btn-primary" name="createListing" value="createListing">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>



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
                        <a href="agent_updateListings?listing_id=<?php echo $listing['listing_id']; ?>" class="btn btn-success btn-sm">
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


