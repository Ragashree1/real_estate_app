<?php 
require_once "partials/header.php"; 
require_once "../controller/agentCreateListingController.php";

$errors;
$loggedInUsername = $_SESSION["username"];

function createListing()
{
    $createInfo = array();
    global $errors;
    global $loggedInUsername;

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
            Created successfully, redirecting...
        </div>';

    // Redirect using JavaScript after the alert is closed
    echo '<script>setTimeout(function() { window.location.href = "agent_manageListings.php"; }, 2000);</script>';
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

<div class="container">
    <h2>Create New Listing</h2>
    <form id="createListingForm" action="" method="post">
        <!-- Title -->
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo isset($_POST['title']) ? $_POST['title'] : ''; ?>">
            <?php if (isset($errors['title'])) : ?>
                <div class="text-danger"><?php echo $errors['title']; ?></div>
            <?php endif; ?>
        </div>
        <!-- Description -->
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?php echo isset($_POST['description']) ? $_POST['description'] : ''; ?></textarea>
            <?php if (isset($errors['description'])) : ?>
                <div class="text-danger"><?php echo $errors['description']; ?></div>
            <?php endif; ?>
        </div>
        <!-- Image URL -->
        <div class="form-group">
            <label for="image">Image URL</label>
            <input type="text" class="form-control" id="image" name="image" value="<?php echo isset($_POST['image']) ? $_POST['image'] : ''; ?>">
            <?php if (isset($errors['image'])) : ?>
                <div class="text-danger"><?php echo $errors['image']; ?></div>
            <?php endif; ?>
        </div>
        <!-- Type -->
        <div class="form-group">
            <label for="type">Type</label>
            <input type="text" class="form-control" id="type" name="type" value="<?php echo isset($_POST['type']) ? $_POST['type'] : ''; ?>">
            <?php if (isset($errors['type'])) : ?>
                <div class="text-danger"><?php echo $errors['type']; ?></div>
            <?php endif; ?>
        </div>
        <!-- Location -->
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" class="form-control" id="location" name="location" value="<?php echo isset($_POST['location']) ? $_POST['location'] : ''; ?>">
            <?php if (isset($errors['location'])) : ?>
                <div class="text-danger"><?php echo $errors['location']; ?></div>
            <?php endif; ?>
        </div>
        <!-- Price -->
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" class="form-control" id="price" name="price" value="<?php echo isset($_POST['price']) ? $_POST['price'] : ''; ?>">
            <?php if (isset($errors['price'])) : ?>
                <div class="text-danger"><?php echo $errors['price']; ?></div>
            <?php endif; ?>
        </div>
        <!-- Area -->
        <div class="form-group">
            <label for="area">Area</label>
            <input type="number" class="form-control" id="area" name="area" value="<?php echo isset($_POST['area']) ? $_POST['area'] : ''; ?>">
            <?php if (isset($errors['area'])) : ?>
                <div class="text-danger"><?php echo $errors['area']; ?></div>
            <?php endif; ?>
        </div>
        <!-- BHK -->
        <div class="form-group">
            <label for="bhk">BHK</label>
            <input type="number" class="form-control" id="bhk" name="bhk" value="<?php echo isset($_POST['bhk']) ? $_POST['bhk'] : ''; ?>">
            <?php if (isset($errors['bhk'])) : ?>
                <div class="text-danger"><?php echo $errors['bhk']; ?></div>
            <?php endif; ?>
        </div>
        <!-- Status -->
        <div class="form-group">
            <label for="status">Status</label>
            <input type="text" class="form-control" id="status" name="status" value="<?php echo isset($_POST['status']) ? $_POST['status'] : 'new'; ?>">
            <?php if (isset($errors['status'])) : ?>
                <div class="text-danger"><?php echo $errors['status']; ?></div>
            <?php endif; ?>
        </div>
        <!-- Sold By -->
        <div class="form-group">
            <label for="sold_by">Sold By</label>
            <input type="text" class="form-control" id="sold_by" name="sold_by" value="<?php echo isset($_POST['sold_by']) ? $_POST['sold_by'] : ''; ?>">
            <?php if (isset($errors['sold_by'])) : ?>
                <div class="text-danger"><?php echo $errors['sold_by']; ?></div>
            <?php endif; ?>
        </div>
        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary" name="createListing" value="createListing">Create</button>
    </form>
</div>



<?php require_once "partials/footer.php"; ?>