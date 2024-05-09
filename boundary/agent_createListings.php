<?php 
require_once "partials/header.php"; 
require_once "../controller/agentCreateListingController.php";

$created = true;
$loggedInUsername = $_SESSION["username"];

function createListing()
{
    $createInfo = array();
    global $created;
    global $loggedInUsername;

    // store each login field data in array
    foreach ($_POST as $key => $value) {
        $createInfo[$key] = $value;
    }
    
    // Check if sold_by is empty
    if (isset($_POST['sold_by']) && !empty($_POST['sold_by'])) {
        $createInfo['sold_by'] = $createInfo['sold_by'];
    } else {
        $createInfo['sold_by'] = NULL;
    }

    $createInfo["listed_by"] = $loggedInUsername;

    $agentCreateListingController = new AgentCreateListingController();
    $created = $agentCreateListingController->agentCreateListings($createInfo);
    
    // check if creation success
    if ($created) {
        createSuccess();
    }
    else
        createFail();
}

function createSuccess()
{
    echo '<div class="alert alert-success" role="alert">
            Created successfully, redirecting...
        </div>';

    // Redirect using JavaScript after the alert is closed
    echo '<script>setTimeout(function() { window.location.href = "agent_manageCreatedListings.php"; }, 2000);</script>';
}

function createFail()
{
    echo '<div class="alert alert-danger" role="alert">
            Fail to create..try again
        </div>';
}

if(isset($_POST['createListing']))
{
    createListing();
}
?>

<div class="container" style="background-color: #f8f9fa; padding: 20px;">
    <h2>Create New Listing</h2>
    <form id="createListingForm" action="" method="post">
        <!-- Title -->
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo isset($_POST['title']) ? $_POST['title'] : ''; ?>" required>
        </div>
        <!-- Description -->
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required><?php echo isset($_POST['description']) ? $_POST['description'] : ''; ?></textarea>
        </div>
        <!-- Image URL -->
        <div class="form-group">
            <label for="image">Image URL</label>
            <input type="text" class="form-control" id="image" name="image" value="<?php echo isset($_POST['image']) ? $_POST['image'] : ''; ?>">
        </div>
        <!-- Type -->
        <div class="form-group">
            <label for="type">Type</label>
            <input type="text" class="form-control" id="type" name="type" value="<?php echo isset($_POST['type']) ? $_POST['type'] : ''; ?>" required>
        </div>
        <!-- Location -->
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" class="form-control" id="location" name="location" value="<?php echo isset($_POST['location']) ? $_POST['location'] : ''; ?>" required>
        </div>
        <!-- Price -->
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" class="form-control" id="price" name="price" value="<?php echo isset($_POST['price']) ? $_POST['price'] : ''; ?>" min="0" required >
        </div>
        <!-- Area -->
        <div class="form-group">
            <label for="area">Area</label>
            <input type="number" class="form-control" id="area" name="area" value="<?php echo isset($_POST['area']) ? $_POST['area'] : ''; ?>" min="0" required>
        </div>
        <!-- BHK -->
        <div class="form-group">
            <label for="bhk">BHK</label>
            <input type="number" class="form-control" id="bhk" name="bhk" value="<?php echo isset($_POST['bhk']) ? $_POST['bhk'] : ''; ?>"  min="0" required>
        </div>
        <!-- Status -->
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="new" <?php echo isset($_POST['status']) && $_POST['status'] === 'new' ? 'selected' : ''; ?>>New</option>
                <option value="sold" <?php echo isset($_POST['status']) && $_POST['status'] === 'sold' ? 'selected' : ''; ?>>Sold</option>
            </select>
        </div>
        <!-- Sold By -->
        <div class="form-group">
            <label for="sold_by">Sold By</label>
            <input type="text" class="form-control" id="sold_by" name="sold_by" value="<?php echo isset($_POST['sold_by']) ? $_POST['sold_by'] : ''; ?>"> 
            <?php if (!$created) : ?>
                <div class="text-danger"> Error: Seller username might not exist </div>
            <?php endif; ?>
        </div>
        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary" name="createListing" value="createListing">Create</button>

        <!-- cancel !-->
        <button type="button" class="btn btn-secondary" onclick="window.history.back();">Cancel</button>
    </form>
</div>




<?php require_once "partials/footer.php"; ?>