<?php 
require_once "partials/header.php";  
require_once "../controller/reviewAgentController.php";

$loggedInUsername = $_SESSION['username'];
$loggedInProfile = $_SESSION['profile'];

$reviewed;

function reviewAgent()
{
    $reviewInfo = array();
    global $reviewed;

    // store each login field data in array
    foreach ($_POST as $key => $value) {
        $reviewInfo[$key] = $value;
    }

    $reviewAgentController = new ReviewAgentController();
    $reviewed = $reviewAgentController->reviewAgent($reviewInfo);
    
    // check if creation success
    if ($reviewed) {
        reviewSuccess();
    }
    else
        reviewFail();
}

function reviewSuccess()
{
    echo '<div class="alert alert-success" role="alert">
            Reviewed successfully, redirecting...
        </div>';

    // Redirect using JavaScript after the alert is closed
    echo '<script>setTimeout(function() { history.go(-2); }, 2000);</script>';
}

function reviewFail()
{
    echo '<div class="alert alert-danger" role="alert">
            Fail to review, try again!
        </div>';
}

if(isset($_POST['submit']))
{
    reviewAgent();
}
?>

<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    <form id="reviewAgentForm" action="" method="post" style="background-color: #f0f0f0; padding: 20px; border-radius: 10px; width: 50%;">
        <h2>Review agent: <?php if(isset($_POST['agent_fullname'])): 
                                    echo $_POST['agent_fullname'] ;
                                endif;?></h2>
        <br>
        <input type="hidden" name="agent_username" value="<?= $_POST['agent_username'] ?>">
        <input type="hidden" name="reviewer_username" value="<?= $loggedInUsername ?>">
        <input type="hidden" name="profile" value="<?= $loggedInProfile ?>">

    <div class="form-group">
            <label for="review">Review:</label>
            <textarea class="form-control" id="review_text" name="review_text" rows="5" required></textarea>
    </div>

    <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit Review</button>
        <button type="button" class="btn btn-secondary" onclick="window.history.back();">Cancel</button>
    </form>
</div>

<?php require_once "partials/footer.php"; ?>