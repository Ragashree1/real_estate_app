<?php 
require_once "partials/header.php"; 
require_once "partials/hero.php"; 
require_once "../controller/viewAgentReviewController.php";

$loggedInUsername = $_SESSION['username'];
$loggedInProfile = $_SESSION['profile'];
$agent_username;
$allReviews;
$viewAgentReviewController = new ViewAgentReviewController();

function getAllReviews()
{        
    global $agent_username;
    global $viewAgentReviewController;
    global $allReviews;

    $allReviews = $viewAgentReviewController->getAllReviews($agent_username);

}

if (isset($_POST['agent_username']))
    {
        global $agent_username;
        $agent_username = $_POST['agent_username'];

        getAllReviews();
    }


?>

<br>
<h2> &nbsp;Reviews</h2>
<br>

<!-- Navigation Bar -->
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" id="sellerReviewsTab" data-toggle="tab" href="#sellerReviews">Seller Reviews</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="buyerReviewsTab" data-toggle="tab" href="#buyerReviews">Buyer Reviews</a>
    </li>
</ul>

<!-- Tab Content -->
<div class="tab-content">
    <div id="sellerReviews" class="tab-pane fade show active">
        <?php foreach ($allReviews as $review): ?>
            <?php if ($review['profile'] === 'seller') : ?>
                <div class="card" style="max-height: 200px;">
                <br>
                    <div class="card-body">
                        <p><?php echo $review['review_text']; ?></p>
                    </div>
                    <h6 class="card-subtitle mb-2 text-muted" style="padding-left:15px;">
                        By: <?php echo $review['reviewer_username']; ?> &nbsp; &nbsp;
                        Date: <?php echo $review['date_reviewed']; ?>
                    </h6>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <div id="buyerReviews" class="tab-pane fade">
        <?php foreach ($allReviews as $review): ?>
            <?php if ($review['profile'] === 'buyer') : ?>
                <div class="card" style="max-height: 200px;">
                <br>
                    <div class="card-body">
                        <p><?php echo $review['review_text']; ?></p>
                    </div>
                    <h6 class="card-subtitle mb-2 text-muted" style="padding-left:15px;">
                        By: <?php echo $review['reviewer_username']; ?> &nbsp; &nbsp;
                        Date: <?php echo $review['date_reviewed']; ?>
                    </h6>
                </div>
                
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once "partials/footer.php"; ?>