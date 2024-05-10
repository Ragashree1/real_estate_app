<?php 
require_once "partials/header.php"; 
require_once "../controller/sellerViewSingleListedPropertyController.php";
require_once "../controller/rateAgentController.php";
require_once "../controller/reviewAgentController.php";
require_once "../controller/sellerTrackNumViewsController.php";
require_once "../controller/sellerTrackNumShortlistController.php";
echo '<link rel="stylesheet" type="text/css" href="css/singlelistingstyle.css">';

$singleListing;
$rated;
$reviewed;
$num_views;
$num_shortlists;

function displaySingleListing()
{
    global $singleListing;
    $listing_id = $_GET['listing_id'];

    // get selected listing
    $ViewSingleListingController = new SellerViewSingleListedPropertyController();
    $singleListing = $ViewSingleListingController->getSingleListedProperty($listing_id);
}

function isRated()
{
    global $rated;
    global $loggedInUsername;
    global $singleListing;

    $rateAgentController = new RateAgentController();
    $rated = $rateAgentController->isRated($loggedInUsername, $singleListing['username']);
}

function isReviewed()
{
    global $reviewed;
    global $loggedInUsername;
    global $singleListing;

    $reviewAgentController = new ReviewAgentController();
    $reviewed = $reviewAgentController->isReviewed($loggedInUsername, $singleListing['username']);
}

function getNumViews()
{
    global $singleListing;
    global $numViews;

    $sellerTrackNumViewsController = new SellerTrackNumViewsController();
    $numViews = $sellerTrackNumViewsController->getNumViews($singleListing['listing_id']);
}

function getNumShortlist()
{
    global $singleListing;
    global $num_shortlists;

    $sellerTrackNumShortlistController = new SellerTrackNumShortlistController();
    $num_shortlists = $sellerTrackNumShortlistController->getNumShortlist($singleListing['listing_id']);
}

if (isset($_GET['listing_id'])) {
    displaySingleListing();
}
    
?>

<br/> &nbsp;
<a href="#" onclick="window.history.back();"><i class="fas fa-arrow-left"></i> Back</a>
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
            <button class="btn btn-primary btn-lg" style="position: absolute; top: 10px; right: 230px;" >
                <i class="fas fa-eye"></i> Views:  
                <?php 
                    getNumViews();
                    echo $numViews;
                ?>
            </button>
            <button class="btn btn-warning btn-lg" style="position: absolute; top: 10px; right: 50px;" >
                <i class="fas fa-heart"></i> Shortlists: 
                <?php 
                    getNumShortlist();
                    echo $num_shortlists;
                ?>
            </button>
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
                        <p class="listing-status" style="color: green;">
                            <i class="fa-solid fa-star"></i> New
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- display agent info !-->
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

        <div class="agent-buttons" style="margin-top: 20px;">
                <div class="d-flex flex-row">
                    <!-- View rating -->
                    <form id="viewRatingForm" action="viewAgentRatings.php" method="post" class="mr-2">
                        <input type="hidden" name="agent_username" value="<?= $singleListing['username'] ?>">
                        <input type="hidden" name="fullname" value="<?= $singleListing['fullname'] ?>">
                        <input type="hidden" name="contact" value="<?= $singleListing['contact'] ?>">
                        <input type="hidden" name="email" value="<?= $singleListing['email'] ?>">
                        <button type="submit" class="btn btn-primary"> <i class="far fa-eye"></i> View Rating</button>
                    </form>

                    <!-- View reviews -->
                    <form id="viewReviewForm" action="viewAgentReviews.php" method="post" class="mr-2">
                        <input type="hidden" name="agent_username" value="<?= $singleListing['username'] ?>">
                        <input type="hidden" name="fullname" value="<?= $singleListing['fullname'] ?>">
                        <input type="hidden" name="contact" value="<?= $singleListing['contact'] ?>">
                        <input type="hidden" name="email" value="<?= $singleListing['email'] ?>">
                        <button type="submit" class="btn btn-primary"> <i class="far fa-eye"></i> View Review</button>
                    </form>

                    <!-- Rate agent -->
                    <form id="leaveRatingForm" action="rateAgent.php" method="post" class="mr-2">
                        <input type="hidden" name="agent_username" value="<?= $singleListing['username'] ?>">
                        <input type="hidden" name="agent_fullname" value="<?= $singleListing['fullname'] ?>">
                        <?php isRated(); if($rated):?>
                            <button type="button" class="btn btn-success"> <i class="fas fa-check"></i> You've rated this agent</button>
                        <?php else: ?>
                            <button type="submit" class="btn btn-success"> <i class="far fa-star"></i> Leave a Rating</button>
                        <?php endif; ?>
                    </form>

                    <!-- Review agent -->
                    <form id="leaveReviewForm" action="reviewAgent.php" method="post">
                        <input type="hidden" name="agent_username" value="<?= $singleListing['username'] ?>">
                        <input type="hidden" name="agent_fullname" value="<?= $singleListing['fullname'] ?>">
                        <?php isReviewed(); if($reviewed):?>
                            <button type="button" class="btn btn-success"> <i class="fas fa-check"></i> You've reviewed this agent</button>
                        <?php else: ?>
                            <button type="submit" class="btn btn-success"> <i class="far fa-star"></i> Leave a Review</button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

    </div>


    <?php
}
?>


<?php require_once "partials/footer.php"; ?>