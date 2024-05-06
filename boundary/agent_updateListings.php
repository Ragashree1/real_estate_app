<?php 
require_once "partials/header.php"; 
require_once "../controller/agentUpdateListingController.php";

$errors;
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
    global $errors;
    global $listing_id;
    global $agentUpdateListingController;

    // store each login field data in array
    foreach ($_POST as $key => $value) {
        $updateInfo[$key] = $value;
    }
    
    $updateInfo["listed_by"] = $loggedInUsername;

    $errors = $agentUpdateListingController->agentUpdateListings($updateInfo, $listing_id);
    
    // Check if there are any errors
    if (empty($errors)) {
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
    echo '<script>setTimeout(function() { window.location.href = "agent_manageListings.php"; }, 1500);</script>';
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

<div class="container">
    <h2>Update Listing</h2>
    <form id="updateListingForm" action="" method="post">
        <!-- Title -->
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo isset($listingToUpdate['title']) ? $listingToUpdate['title'] : ''; ?>">
            <?php if (isset($errors['title'])) : ?>
                <div class="text-danger"><?php echo $errors['title']; ?></div>
            <?php endif; ?>
        </div>
        <!-- Description -->
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?php echo isset($listingToUpdate['description']) ? $listingToUpdate['description'] : ''; ?></textarea>
            <?php if (isset($errors['description'])) : ?>
                <div class="text-danger"><?php echo $errors['description']; ?></div>
            <?php endif; ?>
        </div>
        <!-- Image URL -->
        <div class="form-group">
            <label for="image">Image URL</label>
            <input type="text" class="form-control" id="image" name="image" value="<?php echo isset($listingToUpdate['image']) ? $listingToUpdate['image'] : ''; ?>">
            <?php if (isset($errors['image'])) : ?>
                <div class="text-danger"><?php echo $errors['image']; ?></div>
            <?php endif; ?>
            <!-- Display image if available -->
            <?php if (isset($listingToUpdate['image'])) : ?>
                <img src="<?php echo $listingToUpdate['image']; ?>" alt="<no image>" style="max-width: 20%;">
            <?php endif; ?>
        </div>
        <!-- Type -->
        <div class="form-group">
            <label for="type">Type</label>
            <input type="text" class="form-control" id="type" name="type" value="<?php echo isset($listingToUpdate['type']) ? $listingToUpdate['type'] : ''; ?>">
            <?php if (isset($errors['type'])) : ?>
                <div class="text-danger"><?php echo $errors['type']; ?></div>
            <?php endif; ?>
        </div>
        <!-- Location -->
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" class="form-control" id="location" name="location" value="<?php echo isset($listingToUpdate['location']) ? $listingToUpdate['location'] : ''; ?>">
            <?php if (isset($errors['location'])) : ?>
                <div class="text-danger"><?php echo $errors['location']; ?></div>
            <?php endif; ?>
        </div>
        <!-- Price -->
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" class="form-control" id="price" name="price" value="<?php echo isset($listingToUpdate['price']) ? $listingToUpdate['price'] : ''; ?>">
            <?php if (isset($errors['price'])) : ?>
                <div class="text-danger"><?php echo $errors['price']; ?></div>
            <?php endif; ?>
        </div>
        <!-- Area -->
        <div class="form-group">
            <label for="area">Area</label>
            <input type="number" class="form-control" id="area" name="area" value="<?php echo isset($listingToUpdate['area']) ? $listingToUpdate['area'] : ''; ?>">
            <?php if (isset($errors['area'])) : ?>
                <div class="text-danger"><?php echo $errors['area']; ?></div>
            <?php endif; ?>
        </div>
        <!-- BHK -->
        <div class="form-group">
            <label for="bhk">BHK</label>
            <input type="number" class="form-control" id="bhk" name="bhk" value="<?php echo isset($listingToUpdate['bhk']) ? $listingToUpdate['bhk'] : ''; ?>">
            <?php if (isset($errors['bhk'])) : ?>
                <div class="text-danger"><?php echo $errors['bhk']; ?></div>
            <?php endif; ?>
        </div>
        <!-- Status -->
        <div class="form-group">
            <label for="status">Status</label>
            <input type="text" class="form-control" id="status" name="status" value="<?php echo isset($listingToUpdate['status']) ? $listingToUpdate['status'] : 'new'; ?>">
            <?php if (isset($errors['status'])) : ?>
                <div class="text-danger"><?php echo $errors['status']; ?></div>
            <?php endif; ?>
        </div>
        <!-- Sold By -->
        <div class="form-group">
            <label for="sold_by">Sold By</label>
            <input type="text" class="form-control" id="sold_by" name="sold_by" value="<?php echo isset($listingToUpdate['sold_by']) ? $listingToUpdate['sold_by'] : ''; ?>">
            <?php if (isset($errors['sold_by'])) : ?>
                <div class="text-danger"><?php echo $errors['sold_by']; ?></div>
            <?php endif; ?>
        </div>
        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary" name="updateListing" value="updateListing">Update</button>
    </form>
</div>



<?php require_once "partials/footer.php"; ?>