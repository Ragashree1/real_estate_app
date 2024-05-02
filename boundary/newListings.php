<?php 
require_once "partials/header.php"; 
require_once "partials/hero.php"; 
require_once "../controller/viewListingController.php";

$ViewListingController = new ViewListingController();
$allListing = $ViewListingController->getNewListing();

?>

<!-- search bar -->
<div class="container-fluid mt-3">
    <form class="form-inline" method="GET" action="search.php" style="background-color: grey; padding: 10px; border-radius: 5px; width: 90vw;">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search" style="width: 25%;">
        <input class="form-control mr-sm-2" type="number" placeholder="Min Price" name="min_price" style="width: 15%;">
        <input class="form-control mr-sm-2" type="number" placeholder="Max Price" name="max_price" style="width: 15%;">
        <input class="form-control mr-sm-2" type="number" placeholder="Min Area" name="min_area" style="width: 15%;">
        <input class="form-control mr-sm-2" type="number" placeholder="bedroom+hall+kitchen num" name="bhk" style="width: 20;">
        <button class="btn btn-success my-2 my-sm-0" type="submit" style="width: 10%;">Search</button>
    </form>
</div>
<br>

<!-- DISPLAY LISTINGS -->
<?php
// Check if $allListing is empty
if (empty($allListing)) {
    echo "No property listings found";
} else {
    // Open the row div
    echo '<div class="row" style="display: flex; flex-wrap: wrap; justify-content: space-between;">';

    // Iterate over the array and display each listing
    foreach ($allListing as $listing) {
        ?>
        <div class="listing" style="width: calc(33.33% - 20px); margin-bottom: 40px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s;">
            <div class="listing-inner" style="background: linear-gradient(to bottom, #ffffff, #f5f5f5); padding: 20px;">
                <?php if (isset($listing['image'])) : ?>
                    <img src="<?= $listing['image'] ?>" alt="Listing Image" class="listing-image" style="width: 100%; height: 300px; object-fit: cover; border-radius: 10px 10px 0 0;">
                <?php endif; ?>
                <div class="listing-details" style="padding: 20px;">
                    <?php if (isset($listing['title'])) : ?>
                        <h2 class="listing-title" style="margin: 0; font-size: 24px; font-weight: bold; color: #333; text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">
                            <u> <a href ="singleListing.php?listing_id=<?php echo $listing['listing_id'] ?>"
                            style="color:black"><?= $listing['title'] ?></a>
                        </h2> </u>
                    <?php endif; ?>
                    <div class="listing-meta" style="display: flex; align-items: center; margin-top: 10px;">
                        <?php if (isset($listing['type'])) : ?>
                            <span class="listing-icon" style="color: #4CAF50; margin-right: 5px;"></span>
                            <span class="listing-tag" style="background-color: #4CAF50; color: white; padding: 5px 10px; 
                                                            border-radius: 20px; font-size: 14px; font-weight: bold; margin-right: 10px;">
                                <i class="fa-solid fa-building"></i> 
                                <?= $listing['type'] ?>
                                </span>
                        <?php endif; ?>
                        <?php if (isset($listing['bhk'])) : ?>
                            <span class="listing-icon" style="color: #FF9800; margin-right: 5px;"></span>
                            <span class="listing-tag" style="background-color: #FF9800; color: white; padding: 5px 10px; 
                                                            border-radius: 20px; font-size: 14px; font-weight: bold; margin-right: 10px;"> 
                                <i class="fa-solid fa-bed"></i>&nbsp;<i class="fa-solid fa-couch"></i> <i class="fa-solid fa-utensils"></i> 
                                BHK: <?= $listing['bhk'] ?></span>
                        <?php endif; ?>
                    </div>
                    <?php if (isset($listing['location'])) : ?>
                        <p class="listing-location" style="margin: 10px 0; font-size: 18px; font-weight: bold; color: #666;">
                            <i class="fa-solid fa-location-dot" style="color: #2196F3;"></i> 
                            Location: <?= $listing['location'] ?></p>
                    <?php endif; ?>
                    <div class="listing-price" style="margin: 10px 0;">
                        <i class="fa-solid fa-tag" style="color: #FF5722;"></i>
                        <span style="font-size: 22px; font-weight: bold; color: #FF5722;"> $<?= $listing['price'] ?></span>
                    </div>
                    <div class="listing-footer" style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 20px;">
                        <?php if (isset($listing['date_listed'])) : ?>
                            <p class="listing-date" style="font-size: 14px; color: #666; margin: 0;"><i class="fa-solid fa-calendar"></i> Posted on: <?= $listing['date_listed'] ?></p>
                        <?php endif; ?>
                        <?php if (isset($listing['status']) && $listing['status'] === 'new') : ?>
                            <p class="listing-status" style="font-size: 14px; color: #4CAF50; margin: 0;"><i class="fa-solid fa-star"></i> New</p>
                        <?php endif; ?>
                    </div>
                </div> 
            </div> 
        </div> 
        <?php
    }

    // Close the row div
    echo '</div>'; // Close .row
}
?>

<?php require_once "partials/footer.php"; ?>