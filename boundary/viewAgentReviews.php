<?php 
require_once "partials/header.php"; 
require_once "partials/hero.php"; 
require_once "../controller/viewAgentReviewController.php";

$loggedInUsername = $_SESSION['username'];
$loggedInProfile = $_SESSION['profile'];
$agent_username;
$allReviews;

function getAllReviews()
{        
    global $agent_username;
    global $allReviews;

    $viewAgentReviewController = new ViewAgentReviewController();
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
<h2 style='padding-left:20px;'> &nbsp;Reviews</h2>
<br>

<!-- display agent info !-->
<?php if($loggedInProfile != 'agent'): ?>
<a href="#" onclick="window.history.back();" style='padding-left:20px;'><i class="fas fa-arrow-left"></i> Back</a>
<div style="padding-left:20px; padding-right:20px;">
        <div class="agent-card" style="display: flex; flex-direction: column; margin-top: 10px; padding: 20px; border: 1px solid #ccc; border-radius: 10px; background-color: #f9f9f9;">
            <h2 class="agent-name" style="font-size: 24px; font-weight: bold; margin-bottom: 10px;">Agent Information</h2>
            <div class="agent-details" style="display: flex; align-items: center;">
                <img src="images/agent.png" alt="Agent Image" class="agent-image" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 2px solid #ccc; margin-right: 20px;">
                <div class="agent-info">
                    <?php if (isset($_POST['fullname'])) : ?>
                        <p class="agent-name" style="font-size: 20px; font-weight: bold; color: #333;"><i class="fas fa-user"></i> <?= $_POST['fullname'] ?></p>
                    <?php endif; ?>
                    <?php if (isset($_POST['email'])) : ?>
                        <p class="agent-email" style="font-size: 18px; color: #666;"><i class="fas fa-envelope"></i> <?= $_POST['email'] ?></p>
                    <?php endif; ?>
                    <?php if (isset($_POST['contact'])) : ?>
                        <p class="agent-phone" style="font-size: 18px; color: #666;"><i class="fas fa-phone"></i> <?= $_POST['contact'] ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
</div>
<?php endif; ?>
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