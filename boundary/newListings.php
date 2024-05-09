<?php 
require_once "partials/header.php"; 
require_once "partials/hero.php"; 
require_once "../controller/ViewNewListingController.php";
require_once "../controller/SearchNewListingController.php";
echo '<link rel="stylesheet" type="text/css" href="css/listingstyle.css">';

$loggedInProfile = $_SESSION['profile'];
$allListing;

// display new listings
function displayNewListings()
{
    global $allListing;

    $ViewListingController = new ViewNewListingController();
    $allListing = $ViewListingController->getNewListing();  
}

function searchNewListings()
{
    global $allListing;

    $searchInfo = array();

    // store each login field data in array
    foreach ($_GET as $key => $value) {
        $searchInfo[$key] = $value;
    }

    $searchNewListingController = new SearchNewListingController();
    $allListing = $searchNewListingController->searchNewListings($searchInfo);
}



// search listings
if(isset($_GET['searchForm']))
{
    searchNewListings();
}
else
{
    displayNewListings();
}



?>

<!-- search bar -->
<div class="container-fluid mt-3">
    <form class="form-inline" method="GET" action=""
            style="background-color: grey; padding: 10px; border-radius: 5px; width: 90vw;">
        <input class="form-control mr-sm-2" type="search" placeholder="Title/type/location" aria-label="Search" name="search" style="width: 25%;">
        <input class="form-control mr-sm-2" type="number" placeholder="Min Price" name="min_price" style="width: 15%;" min="0">
        <input class="form-control mr-sm-2" type="number" placeholder="Max Price" name="max_price" style="width: 15%;" min="0">
        <input class="form-control mr-sm-2" type="number" placeholder="Min Area" name="min_area" style="width: 15%;" min="0">
        <input class="form-control mr-sm-2" type="number" placeholder="bedroom+hall+kitchen num" name="bhk" style="width: 15%;" min="0">
        <button class="btn btn-success my-2 my-sm-0" type="submit" name="searchForm" value="search" style="width: 10%;">
            <i class="fas fa-search"></i> Search
        </button>
    </form>
</div>
<br>

<!-- DISPLAY LISTINGS -->
<?php
// Check if $allListing is empty
if (empty($allListing)) {
    echo "No property listings found";
} else {
    $counter = 0;

    // Open the row div
    echo '<div class="row">';

    // Iterate over the array and display each listing
    foreach ($allListing as $listing) {
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

<?php require_once "partials/footer.php"; ?>