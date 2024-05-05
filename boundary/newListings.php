<?php 
require_once "partials/header.php"; 
require_once "partials/hero.php"; 
require_once "../controller/ViewListingController.php";
require_once "../controller/SearchListingController.php";
echo '<link rel="stylesheet" type="text/css" href="css/listingstyle.css">';

$ViewListingController = new ViewListingController();
$allListing;

// display new listings
function displayNewListings()
{
    global $ViewListingController;
    global $allListing;
    $allListing = $ViewListingController->getNewListing();  
}

function searchListings()
{
    global $allListing;

    $searchInfo = array();

    // store each login field data in array
    foreach ($_GET as $key => $value) {
        $searchInfo[$key] = $value;
    }

    $searchListingController = new SearchListingController();
    $allListing = $searchListingController->searchListings($searchInfo);
}



// search listings
if(isset($_GET['searchForm']))
{
    searchListings();
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
        <input class="form-control mr-sm-2" type="search" placeholder="Title/type/location/status" aria-label="Search" name="search" style="width: 25%;">
        <input class="form-control mr-sm-2" type="number" placeholder="Min Price" name="min_price" style="width: 15%;">
        <input class="form-control mr-sm-2" type="number" placeholder="Max Price" name="max_price" style="width: 15%;">
        <input class="form-control mr-sm-2" type="number" placeholder="Min Area" name="min_area" style="width: 15%;">
        <input class="form-control mr-sm-2" type="number" placeholder="bedroom+hall+kitchen num" name="bhk" style="width: 20;">
        <button class="btn btn-success my-2 my-sm-0" type="submit" name="searchForm" value="search" style="width: 10%;">Search</button>
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
                            <u> <a href ="singleListing.php?listing_id=<?php echo $listing['listing_id'] ?>"
                            style="color:black"><?= $listing['title'] ?></a>
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
                        <?php if (isset($listing['status']) && $listing['status'] === 'new') : ?>
                            <p class="listing-status" style="color: green;">
                                <i class="fa-solid fa-star"></i> New
                            </p>
                        <?php elseif (isset($listing['status']) && $listing['status'] === 'sold') : ?>
                            <p class="listing-status" style="color: red;">
                                <i class="fa-solid fa-tag"></i> Sold
                            </p>
                        <?php endif; ?>
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