<?php 
require_once "partials/header.php"; 
require_once "partials/hero.php"; 

$loggedInUsername = $_SESSION['username'];
$allRatings;


?>

<br>
<h2> &nbsp;My Shortlist</h2>
<br>

<!-- Navigation Bar -->
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" id="sellerRatingsTab" data-toggle="tab" href="#sellerRatings">Seller Ratings</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="buyerRatingsTab" data-toggle="tab" href="#buyerRatings">Buyer Ratings</a>
    </li>
</ul>

<!-- Tab Content -->
<div class="tab-content">
    <!-- shortlisted new listings -->
    <div id="sellerRatings" class="tab-pane fade show active">
        <!-- DISPLAY LISTINGS -->

    </div>

    <!-- Sold Listings Tab -->
    <div id="buyerRatings" class="tab-pane fade">
        <!-- shortlisted old listings -->
        
    </div>
</div>




<?php require_once "partials/footer.php"; ?>