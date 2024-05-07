<?php 
require_once "partials/header.php"; 
require_once "../controller/agentUpdateListingController.php";

$updated = true;
$loggedInUsername = $_SESSION["username"];
$agentUpdateListingController = new AgentUpdateListingController();
$listing_id = isset($_GET['listing_id']) ? $_GET['listing_id'] : null;
$listingToUpdate;
 
function getListingToUpdate()
{
    global $listingToUpdate;
    global $listing_id;
    global $agentUpdateListingController;

    $listingToUpdate = $agentUpdateListingController->getListingToUpdate($listing_id);
}

function updateListing()
{
    $updateInfo = array();
    global $loggedInUsername;
    global $updated;
    global $listing_id;
    global $agentUpdateListingController;

    // store each login field data in array
    foreach ($_POST as $key => $value) {
        $updateInfo[$key] = $value;
    }

    // Check if sold_by is empty
    if (isset($_POST['sold_by']) && !empty($_POST['sold_by'])) {
        $updateInfo['sold_by'] = $updateInfo['sold_by'];
    } else {
        $updateInfo['sold_by'] = NULL;
    }
    
    $updateInfo["listed_by"] = $loggedInUsername;

    $updated = $agentUpdateListingController->agentUpdateListings($updateInfo, $listing_id);
    
    // Check if there are any errors
    if ($updated) {
        updateSuccess();
    }
    else
        updateFail();
}

function updateSuccess()
{
    echo '<div class="alert alert-success" role="alert">
            Updated successfully, redirecting...
        </div>';

    // Redirect using JavaScript after the alert is closed
    echo '<script>setTimeout(function() { window.location.href = "agent_manageAllListings.php"; }, 1500);</script>';
}

function updateFail()
{
    echo '<div class="alert alert-danger" role="alert">
            Update fail..try again
        </div>';
}

getListingToUpdate();

if(isset($_POST['updateListing']))
{

    updateListing();
}
?>

<br>
<div class="container" style="background-color: #f8f9fa; padding: 20px;">
    <h2>Update Listing</h2>
    <form id="updateListingForm" action="" method="post">
        <!-- Title -->
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo isset($listingToUpdate['title']) ? $listingToUpdate['title'] : ''; ?>" required>
        </div>
        <!-- Description -->
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required><?php echo isset($listingToUpdate['description']) ? $listingToUpdate['description'] : ''; ?></textarea>
        </div>
        <!-- Image URL -->
        <div class="form-group">
            <label for="image">Image URL</label>
            <input type="text" class="form-control" id="image" name="image" value="<?php echo isset($listingToUpdate['image']) ? $listingToUpdate['image'] : ''; ?>">
            <!-- Display image if available -->
            <?php if (isset($listingToUpdate['image'])) : ?>
                <img src="<?php echo $listingToUpdate['image']; ?>" alt="<no image>" style="max-width: 20%;" required>
            <?php endif; ?>
        </div>
        <!-- Type -->
        <div class="form-group">
            <label for="type">Type</label>
            <input type="text" class="form-control" id="type" name="type" value="<?php echo isset($listingToUpdate['type']) ? $listingToUpdate['type'] : ''; ?>" required>
        </div>
        <!-- Location -->
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" class="form-control" id="location" name="location" value="<?php echo isset($listingToUpdate['location']) ? $listingToUpdate['location'] : ''; ?>" required>
        </div>
        <!-- Price -->
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" class="form-control" id="price" name="price" value="<?php echo isset($listingToUpdate['price']) ? $listingToUpdate['price'] : ''; ?>" required>
        </div>
        <!-- Area -->
        <div class="form-group">
            <label for="area">Area</label>
            <input type="number" class="form-control" id="area" name="area" value="<?php echo isset($listingToUpdate['area']) ? $listingToUpdate['area'] : ''; ?>" required>
        </div>
        <!-- BHK -->
        <div class="form-group">
            <label for="bhk">BHK</label>
            <input type="number" class="form-control" id="bhk" name="bhk" value="<?php echo isset($listingToUpdate['bhk']) ? $listingToUpdate['bhk'] : ''; ?>" required>
        </div>
        <!-- Status -->
        <div class="form-group">
            <label for="status">Status</label>
            <input type="text" class="form-control" id="status" name="status" value="<?php echo isset($listingToUpdate['status']) ? $listingToUpdate['status'] : 'new'; ?>" required>
        </div>
        <!-- Sold By -->
        <div class="form-group">
            <label for="sold_by">Sold By</label>
            <input type="text" class="form-control" id="sold_by" name="sold_by" value="<?php echo isset($listingToUpdate['sold_by']) ? $listingToUpdate['sold_by'] : ''; ?>">
            <?php if(!$updated): ?>
                <div class="text-danger"> Error: Seller username might not exist </div>
            <?php endif; ?>
        </div>
        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary" name="updateListing" value="updateListing">Update</button>
        
        <!-- cancel !-->
        <a href="agent_manageAllListings.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php require_once "partials/footer.php"; ?>