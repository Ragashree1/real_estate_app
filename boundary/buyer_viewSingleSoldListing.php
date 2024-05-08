<?php 
require_once "partials/header.php"; 
require_once "../controller/buyerViewSingleSoldListingController.php";
require_once "../controller/buyerShortlistSoldListingController.php";
require_once "../controller/buyerRemoveShortlistSoldListingController.php";
echo '<link rel="stylesheet" type="text/css" href="css/singlelistingstyle.css">';

$singleListing;
$loggedInUsername = $_SESSION['username'];
$listing_id = $_GET['listing_id'];
$buyerShortlistController = new BuyerShortlistSoldListingController();
$buyerRemoveShortlistController = new BuyerRemoveShortlistSoldListingController();
$shortlisted;

function displaySingleListing()
{
    global $singleListing;
    global $listing_id;

    // get selected listing
    $ViewSingleListingController = new BuyerViewSingleSoldListingController();
    $singleListing = $ViewSingleListingController->getSingleListing($listing_id);
}

function shortlist()
{
    global $buyerShortlistController;
    global $listing_id;
    global $loggedInUsername;
 
    $shortlistSuccess = $buyerShortlistController->shortlist($loggedInUsername, $listing_id);

    if ($shortlistSuccess){
        // Redirect 
        echo '<script>window.location.href = "buyer_viewSingleSoldListing.php?listing_id='. $listing_id . '";</script>';
    }
    else
    {
        // Display an error message
        echo '<script>alert("An error occurred. Please try again.");</script>';
    }
}

function removeShortlist()
{
    global $buyerRemoveShortlistController;
    global $listing_id;
    global $loggedInUsername;

    $removeSuccess = $buyerRemoveShortlistController->removeShortlist($loggedInUsername, $listing_id);

    if ($removeSuccess){
        // Redirect 
        echo '<script>window.location.href = "buyer_viewSingleSoldListing.php?listing_id='. $listing_id . '";</script>';
    }
    else
    {
        // Display an error message
        echo '<script>alert("An error occurred. Please try again.");</script>';
    }
}

function isShortlisted()
{
    global $buyerShortlistController;
    global $listing_id;
    global $loggedInUsername;
    global $shortlisted;

    $shortlisted = $buyerShortlistController->isShortListed($loggedInUsername, $listing_id);;
}

if (isset($_GET['listing_id'])) {
    isShortlisted();
    displaySingleListing();
}

if (isset($_GET['like'])) {
    shortlist();
}

if (isset($_GET['unlike'])) {
    removeShortlist();
}
    
?>

<br/> &nbsp;
<a href="buyer_soldListings.php"><i class="fas fa-arrow-left"></i> Back</a>
<br/>
<br>
<!-- DISPLAY SINGLE LISTING -->
<?php
// Check if $singleListing is empty
if (empty($singleListing)) {
    echo "No property listing found";
} else {
    ?>
    <div class="row" style="padding-left: 50px; padding-right:50px;">
    <div class="single-listing" style="position: relative;">
        <!-- Like Button -->
        <?php if ($shortlisted) : ?>
             <!-- If the item is shortlisted -->
            <a href="buyer_viewSingleSoldListing.php?listing_id=<?php echo $listing_id . '&' . 'unlike=true' ?>" class="btn btn-success like-button btn-lg" style="position: absolute; top: 10px; right: 50px;" >
                <i class="fas fa-check"></i> shortlisted
            </a>
        <?php else : ?>
            <!-- If the item is not shortlisted -->
            <a href="buyer_viewSingleSoldListing.php?listing_id=<?php echo $listing_id . '&' . 'like=true' ?>" class="btn btn-outline-primary like-button btn-lg" style="position: absolute; top: 10px; right: 50px;">
                <i class="far fa-heart"></i> shortlist
            </a>
        <?php endif; ?>
            <div class="single-listing-inner">
                <?php if (isset($singleListing['image'])) : ?>
                    <img src="<?= $singleListing['image'] ?>" alt="Listing Image" class="single-listing-image"
                    style="height:500px; width:500px;">
                <?php endif; ?>
                <div class="single-listing-details">
                    <?php if (isset($singleListing['title'])) : ?>
                        <h2 class="single-listing-title"><a href="singleListing.php?listing_id=<?= $singleListing['listing_id'] ?>"><?= $singleListing['title'] ?></a></h2>
                    <?php endif; ?>
                    <div class="single-listing-meta">
                        <?php if (isset($singleListing['type'])) : ?>
                            <span class="single-listing-tag" style="background-color: #4CAF50; color: white;">
                            <i class="fa-solid fa-building"></i> <?= $singleListing['type'] ?></span>
                        <?php endif; ?>
                        <?php if (isset($singleListing['bhk'])) : ?>
                            <span class="single-listing-tag" style="background-color: #FF9800; color: white;">
                            <i class="fa-solid fa-bed"></i>&nbsp;<i class="fa-solid fa-couch"></i> <i class="fa-solid fa-utensils"></i> 
                                BHK: <?= $singleListing['bhk'] ?></span>
                        <?php endif; ?>
                        <?php if (isset($singleListing['area'])) : ?>
                            <span class="single-listing-tag" style="font-size: 16px; font-weight: bold; color: #666;">
                                <i class="fa-solid fa-expand"></i>
                                Area: <?= $singleListing['area'] ?> sqft</span>
                        <?php endif; ?>
                        <br />
                        <br />
                        <?php if (isset($singleListing['location'])) : ?>
                            <span class="single-listing-location"><i class="fa-solid fa-location-dot"></i>Location: <?= $singleListing['location'] ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="single-listing-price">$<?= $singleListing['price'] ?></div>
                    <div class="single-listing-description"><i class="fas fa-pencil"> </i>
                        Description: <?= $singleListing['description'] ?></div>
                    <div class="single-listing-footer">
                        <?php if (isset($singleListing['date_listed'])) : ?>
                            <p class="single-listing-date"><i class="fa-solid fa-calendar"></i> Listed on: <?= $singleListing['date_listed'] ?></p>
                        <?php endif; ?>
                        <p class="listing-status" style="color: red;">
                            <i class="fa-solid fa-tag"></i> Sold
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- display agent info !-->
    <div style="padding-left:35px; padding-right:35px;">
        <div class="agent-card" style="display: flex; flex-direction: column; margin-top: 10px; padding: 20px; border: 1px solid #ccc; border-radius: 10px; background-color: #f9f9f9;">
            <h2 class="agent-name" style="font-size: 24px; font-weight: bold; margin-bottom: 10px;">Agent Information</h2>
            <div class="agent-details" style="display: flex; align-items: center;">
                <img src="images/agent.png" alt="Agent Image" class="agent-image" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 2px solid #ccc; margin-right: 20px;">
                <div class="agent-info">
                    <?php if (isset($singleListing['fullname'])) : ?>
                        <p class="agent-name" style="font-size: 20px; font-weight: bold; color: #333;"><i class="fas fa-user"></i> <?= $singleListing['fullname'] ?></p>
                    <?php endif; ?>
                    <?php if (isset($singleListing['email'])) : ?>
                        <p class="agent-email" style="font-size: 18px; color: #666;"><i class="fas fa-envelope"></i> <?= $singleListing['email'] ?></p>
                    <?php endif; ?>
                    <?php if (isset($singleListing['contact'])) : ?>
                        <p class="agent-phone" style="font-size: 18px; color: #666;"><i class="fas fa-phone"></i> <?= $singleListing['contact'] ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>


    <?php
}
?>


<?php require_once "partials/footer.php"; ?>