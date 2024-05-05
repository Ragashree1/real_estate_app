<?php 
require_once "partials/header.php"; 

if (isset($_GET['listing_id'])) {
    $listingId = $_GET['listing_id'];

    if ($listingDetails) {
        ?>
        <div>
            <h2><?= $listingDetails['title'] ?></h2>
            <!-- Display other details of the listing -->
        </div>
        <?php
    } else {
        echo "Listing not found";
    }
} else {
    echo "Listing ID not provided";
}

?>




<?php require_once "partials/footer.php"; ?>