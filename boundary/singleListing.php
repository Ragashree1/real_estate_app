<?php 
require_once "partials/header.php"; 
require_once "../controller/viewListingController.php";
echo '<link rel="stylesheet" type="text/css" href="css/singlelistingstyle.css">';

if (isset($_GET['listing_id'])) {
    $listing_id = $_GET['listing_id'];

    // get selected listing
    $ViewListingController = new ViewListingController();
    $singleListing = $ViewListingController->getSingleListing($listing_id);

    // get agent info who created the listing
    $agentInfo = $ViewListingController->getAgentInfo($listing_id);
}
?>

<br/> &nbsp;
<a href="newListings.php"><i class="fas fa-arrow-left"></i> Back</a>
<br/>
<br>
<!-- DISPLAY SINGLE LISTING -->
<?php
// Check if $singleListing is empty
if (empty($singleListing)) {
    echo "No property listing found";
} else {
    ?>
    <div class="row">
        <div class="single-listing">
            <div class="single-listing-inner">
                <?php if (isset($singleListing['image'])) : ?>
                    <img src="<?= $singleListing['image'] ?>" alt="Listing Image" class="single-listing-image">
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
                    <div class="single-listing-footer">
                        <?php if (isset($singleListing['date_listed'])) : ?>
                            <p class="single-listing-date"><i class="fa-solid fa-calendar"></i> Listed on: <?= $singleListing['date_listed'] ?></p>
                        <?php endif; ?>
                        <?php if (isset($singleListing['status']) && $singleListing['status'] === 'new') : ?>
                            <p class="listing-status" style="color: green;">
                                <i class="fa-solid fa-star"></i> New
                            </p>
                        <?php elseif (isset($singleListing['status']) && $singleListing['status'] === 'sold') : ?>
                            <p class="listing-status" style="color: red;">
                                <i class="fa-solid fa-tag"></i> Sold
                            </p>
                        <?php endif; ?>
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
                <?php if (isset($agentInfo['username'])) : ?>
                    <p class="agent-name" style="font-size: 20px; font-weight: bold; color: #333;"><i class="fas fa-user"></i> <?= $agentInfo['username'] ?></p>
                <?php endif; ?>
                <?php if (isset($agentInfo['email'])) : ?>
                    <p class="agent-email" style="font-size: 18px; color: #666;"><i class="fas fa-envelope"></i> <?= $agentInfo['email'] ?></p>
                <?php endif; ?>
                <?php if (isset($agentInfo['contact'])) : ?>
                    <p class="agent-phone" style="font-size: 18px; color: #666;"><i class="fas fa-phone"></i> <?= $agentInfo['contact'] ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>


    <?php
}
?>


<?php require_once "partials/footer.php"; ?>