<?php 
require_once "partials/header.php"; 
require_once "partials/hero.php"; 
require_once "../controller/buyerViewShortlistedNewListingController.php";
require_once "../controller/buyerViewShortlistedSoldListingController.php";
echo '<link rel="stylesheet" type="text/css" href="css/listingstyle.css">';

$loggedInUsername = $_SESSION['username'];
$shortlistedNewListings;
$shortlistedSoldListings;

function getShortlistedNewListings()
{
    global $shortlistedNewListings;
    global $loggedInUsername;

    $shortlistedNewListingController = new BuyerViewShortlistedNewListingController();
    $shortlistedNewListings = $shortlistedNewListingController->getShortlistedNewListings($loggedInUsername);

}

function getShortlistedSoldListings()
{
    global $shortlistedSoldListings;
    global $loggedInUsername;

    $shortlistedSoldListingController = new BuyerViewShortlistedSoldListingController();
    $shortlistedSoldListings = $shortlistedSoldListingController->getShortlistedSoldListings($loggedInUsername);
}

getShortlistedNewListings();
getShortlistedSoldListings();
?>

<br>
<h2> &nbsp;My Shortlist</h2>
<br>

<!-- Navigation Bar -->
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" id="newListingsTab" data-toggle="tab" href="#newListings">New Properties</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="soldListingsTab" data-toggle="tab" href="#soldListings">Sold Properties</a>
    </li>
</ul>

<!-- Tab Content -->
<div class="tab-content">
    <!-- shortlisted new listings -->
    <div id="newListings" class="tab-pane fade show active">
        <!-- DISPLAY LISTINGS -->
        <?php
        // Check if $allListing is empty
        if (empty($shortlistedNewListings)) {
            echo "You have not shortlist any property";
        } else {
            $counter = 0;

            // Open the row div
            echo '<div class="row">';

            // Iterate over the array and display each listing
            foreach ($shortlistedNewListings as $listing) {
                ?>
                <div class="listing" >
                    <div class="listing-inner" style="background: linear-gradient(to bottom, #ffffff, #f5f5f5); padding: 20px;">
                        <?php if (isset($listing['image'])) : ?>
                            <img src="<?= $listing['image'] ?>" alt="Listing Image" class="listing-image" >
                        <?php endif; ?>
                        <div class="listing-details" style="padding: 20px;">
                            <?php if (isset($listing['title'])) : ?>
                                <h2 class="listing-title">
                                    <?php if ($loggedInProfile == 'seller'): ?>
                                        <u><a href="seller_viewSingleNewListing.php?listing_id=<?php echo $listing['listing_id']; ?>" style="color:black"><?= $listing['title']; ?></a></u>
                                    <?php else: ?>
                                        <u><a href="buyer_viewSingleNewListing.php?listing_id=<?php echo $listing['listing_id']; ?>" style="color:black"><?= $listing['title']; ?></a></u>
                                    <?php endif; ?>
                                </h2> </u>
                            <?php endif; ?>
                            <div class="listing-meta" style="display: flex; align-items: center; margin-top: 10px;">
                                <?php if (isset($listing['type'])) : ?>
                                    <span class="listing-tag" style="background-color: #4CAF50; color: white;">
                                        <i class="fa-solid fa-building"></i> 
                                        <?= $listing['type'] ?>
                                        </span>
                                <?php endif; ?>
                                <?php if (isset($listing['bhk'])) : ?>
                                    <span class="listing-tag" style="background-color: #FF9800; color: white;"> 
                                        <i class="fa-solid fa-bed"></i>&nbsp;<i class="fa-solid fa-couch"></i> <i class="fa-solid fa-utensils"></i> 
                                        BHK: <?= $listing['bhk'] ?></span>
                                <?php endif; ?>
                                <?php if (isset($listing['area'])) : ?>
                                    <span class="listing-area" style="font-size: 16px; font-weight: bold; color: #666;">
                                        <i class="fa-solid fa-expand"></i> 
                                        Area: <?= $listing['area'] ?> sqft
                                    </span>
                                <?php endif; ?>
                            </div>
                            <?php if (isset($listing['location'])) : ?>
                                <p class="listing-location">
                                    <i class="fa-solid fa-location-dot" style="color: #2196F3;"></i> 
                                    Location: <?= $listing['location'] ?>
                                </p>
                            <?php endif; ?>
                            <div class="listing-price" style="margin: 10px 0;">
                                <i class="fa-solid fa-tag" style="color: #FF5722;"></i>
                                <span> 
                                    $<?= $listing['price'] ?>
                                </span>
                            </div>
                            
                            <div class="listing-footer">
                                <?php if (isset($listing['date_listed'])) : ?>
                                    <p class="listing-date">
                                        <i class="fa-solid fa-calendar"></i> 
                                        Listed on: <?= $listing['date_listed'] ?>
                                    </p>
                                <?php endif; ?>
                                <p class="listing-status" style="color: green;">
                                    <i class="fa-solid fa-star"></i> New
                                </p>
                            </div>

                        </div> 
                    </div> 
                </div> 
                <?php
                $counter++;
            }

            // Close the row div
            echo '</div>'; // Close .row
        }
        ?>
    </div>

    <!-- Sold Listings Tab -->
    <div id="soldListings" class="tab-pane fade">
        <!-- shortlisted old listings -->
        <?php
        // Check if $allListing is empty
        if (empty($shortlistedSoldListings)) {
            echo "You have not shortlist any property";
        } else {
            $counter = 0;

            // Open the row div
            echo '<div class="row">';

            // Iterate over the array and display each listing
            foreach ($shortlistedSoldListings as $listing) {
                ?>
                <div class="listing" >
                    <div class="listing-inner" style="background: linear-gradient(to bottom, #ffffff, #f5f5f5); padding: 20px;">
                        <?php if (isset($listing['image'])) : ?>
                            <img src="<?= $listing['image'] ?>" alt="Listing Image" class="listing-image" >
                        <?php endif; ?>
                        <div class="listing-details" style="padding: 20px;">
                            <?php if (isset($listing['title'])) : ?>
                                <h2 class="listing-title">
                                    <?php if ($loggedInProfile == 'seller'): ?>
                                        <u><a href="seller_viewSingleNewListing.php?listing_id=<?php echo $listing['listing_id']; ?>" style="color:black"><?= $listing['title']; ?></a></u>
                                    <?php else: ?>
                                        <u><a href="buyer_viewSingleNewListing.php?listing_id=<?php echo $listing['listing_id']; ?>" style="color:black"><?= $listing['title']; ?></a></u>
                                    <?php endif; ?>
                                </h2> </u>
                            <?php endif; ?>
                            <div class="listing-meta" style="display: flex; align-items: center; margin-top: 10px;">
                                <?php if (isset($listing['type'])) : ?>
                                    <span class="listing-tag" style="background-color: #4CAF50; color: white;">
                                        <i class="fa-solid fa-building"></i> 
                                        <?= $listing['type'] ?>
                                        </span>
                                <?php endif; ?>
                                <?php if (isset($listing['bhk'])) : ?>
                                    <span class="listing-tag" style="background-color: #FF9800; color: white;"> 
                                        <i class="fa-solid fa-bed"></i>&nbsp;<i class="fa-solid fa-couch"></i> <i class="fa-solid fa-utensils"></i> 
                                        BHK: <?= $listing['bhk'] ?></span>
                                <?php endif; ?>
                                <?php if (isset($listing['area'])) : ?>
                                    <span class="listing-area" style="font-size: 16px; font-weight: bold; color: #666;">
                                        <i class="fa-solid fa-expand"></i> 
                                        Area: <?= $listing['area'] ?> sqft
                                    </span>
                                <?php endif; ?>
                            </div>
                            <?php if (isset($listing['location'])) : ?>
                                <p class="listing-location">
                                    <i class="fa-solid fa-location-dot" style="color: #2196F3;"></i> 
                                    Location: <?= $listing['location'] ?>
                                </p>
                            <?php endif; ?>
                            <div class="listing-price" style="margin: 10px 0;">
                                <i class="fa-solid fa-tag" style="color: #FF5722;"></i>
                                <span> 
                                    $<?= $listing['price'] ?>
                                </span>
                            </div>
                            
                            <div class="listing-footer">
                                <?php if (isset($listing['date_listed'])) : ?>
                                    <p class="listing-date">
                                        <i class="fa-solid fa-calendar"></i> 
                                        Listed on: <?= $listing['date_listed'] ?>
                                    </p>
                                <?php endif; ?>
                                <p class="listing-status" style="color: green;">
                                    <i class="fa-solid fa-star"></i> New
                                </p>
                            </div>

                        </div> 
                    </div> 
                </div> 
                <?php
                $counter++;
            }

            // Close the row div
            echo '</div>'; // Close .row
        }
        ?>
    </div>
</div>




<?php require_once "partials/footer.php"; ?>