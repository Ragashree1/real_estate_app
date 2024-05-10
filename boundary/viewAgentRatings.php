<?php 
require_once "partials/header.php"; 
require_once "partials/hero.php"; 
require_once "../controller/viewAgentRatingController.php";

$loggedInUsername = $_SESSION['username'];
$loggedInProfile = $_SESSION['profile'];
$agent_username;
$allRatings;

function getAllRatings()
{        
    global $agent_username;
    global $allRatings;

    $viewAgentRatingController = new ViewAgentRatingController();
    $allRatings = $viewAgentRatingController->getAllRatings($agent_username);

}

if (isset($_POST['agent_username']))
{
    global $agent_username;
    $agent_username = $_POST['agent_username'];

    getAllRatings();
}


?>

<br>
<h2 style='padding-left:20px;'> Ratings</h2>

<!-- display agent info !-->
<?php if(!$loggedInProfile == 'agent'): ?>
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
<ul class="nav nav-tabs" style="padding-left:20px; padding-right:20px;">
    <li class="nav-item">
        <a class="nav-link active" id="sellerRatingsTab" data-toggle="tab" href="#sellerRatings">Seller Ratings</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="buyerRatingsTab" data-toggle="tab" href="#buyerRatings">Buyer Ratings</a>
    </li>
</ul>

<!-- Tab Content -->
<div class="tab-content">
    <div id="sellerRatings" class="tab-pane fade show active">
        <?php foreach ($allRatings as $rating): ?>
            <?php if ($rating['profile'] === 'seller') : ?>
                <div class="card" style="max-height: 200px;">
                <br>
                    <div class="card-body" style="display: flex; align-items: center;">
                            <h5 class="card-title" style="margin-right: 10px;">Communication: </h5>
                            <span style="font-size: 24px; color: yellow;" >
                                <?php 
                                    // Display stars for market knowledge rating
                                    $ratingValue = $rating['rating_communication'];
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $ratingValue) {
                                            echo '<i class="fas fa-star" style="color: orange; padding-bottom:20px;"></i>';
                                        } else {
                                            echo '<i class="far fa-star" style="color: black;"></i>'; 
                                        }
                                    }
                                ?>
                            </span>
                        </div>

                    <div class="card-body" style="display: flex; align-items: center;">
                        <h5 class="card-title" style="margin-right: 10px;">Professionalism: </h5>
                        <span style="font-size: 24px; color: yellow;" >
                            <?php 
                                // Display stars for market knowledge rating
                                $ratingValue = $rating['rating_professionalism'];
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $ratingValue) {
                                        echo '<i class="fas fa-star" style="color: orange; padding-bottom:20px;"></i>';
                                    } else {
                                        echo '<i class="far fa-star" style="color: black;"></i>'; 
                                    }
                                }
                            ?>
                        </span>
                    </div>

                    <div class="card-body" style="display: flex; align-items: center;">
                        <h5 class="card-title" style="margin-right: 10px;">Market Knowledge: </h5>
                        <span style="font-size: 24px; color: yellow;" >
                            <?php 
                                // Display stars for market knowledge rating
                                $ratingValue = $rating['rating_marketKnowledge'];
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $ratingValue) {
                                        echo '<i class="fas fa-star" style="color: orange; padding-bottom:20px;"></i>';
                                    } else {
                                        echo '<i class="far fa-star" style="color: black;"></i>'; 
                                    }
                                }
                            ?>
                        </span>
                    </div>
                    <br>
                    <h6 class="card-subtitle mb-2 text-muted" style="padding-left:15px;">
                        By: <?php echo $rating['rater_username']; ?> &nbsp; &nbsp;
                        Date: <?php echo $rating['date_rated']; ?>
                    </h6>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- buyer ratings -->
    <div id="buyerRatings" class="tab-pane fade">
        <?php foreach ($allRatings as $rating):?>
            <?php if ($rating['profile'] === 'buyer') : ?>
                <div class="card" style="max-height: 200px;">
                <br>
                    <div class="card-body" style="display: flex; align-items: center;">
                            <h5 class="card-title" style="margin-right: 10px;">Communication: </h5>
                            <span style="font-size: 24px; color: yellow;" >
                                <?php 
                                    // Display stars for market knowledge rating
                                    $ratingValue = $rating['rating_communication'];
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $ratingValue) {
                                            echo '<i class="fas fa-star" style="color: orange; padding-bottom:20px;"></i>';
                                        } else {
                                            echo '<i class="far fa-star" style="color: black;"></i>'; 
                                        }
                                    }
                                ?>
                            </span>
                        </div>

                    <div class="card-body" style="display: flex; align-items: center;">
                        <h5 class="card-title" style="margin-right: 10px;">Professionalism: </h5>
                        <span style="font-size: 24px; color: yellow;" >
                            <?php 
                                // Display stars for market knowledge rating
                                $ratingValue = $rating['rating_professionalism'];
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $ratingValue) {
                                        echo '<i class="fas fa-star" style="color: orange; padding-bottom:20px;"></i>';
                                    } else {
                                        echo '<i class="far fa-star" style="color: black;"></i>'; 
                                    }
                                }
                            ?>
                        </span>
                    </div>

                    <div class="card-body" style="display: flex; align-items: center;">
                        <h5 class="card-title" style="margin-right: 10px;">Market Knowledge: </h5>
                        <span style="font-size: 24px; color: yellow;" >
                            <?php 
                                // Display stars for market knowledge rating
                                $ratingValue = $rating['rating_marketKnowledge'];
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $ratingValue) {
                                        echo '<i class="fas fa-star" style="color: orange; padding-bottom:20px;"></i>';
                                    } else {
                                        echo '<i class="far fa-star" style="color: black;"></i>'; 
                                    }
                                }
                            ?>
                        </span>
                    </div>
                    <br>
                    <h6 class="card-subtitle mb-2 text-muted" style="padding-left:15px;">
                        By: <?php echo $rating['rater_username']; ?> &nbsp; &nbsp;
                        Date: <?php echo $rating['date_rated']; ?>
                    </h6>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once "partials/footer.php"; ?>