<?php 
require_once "partials/header.php";  
require_once "../controller/rateAgentController.php";

$loggedInUsername = $_SESSION['username'];
$loggedInProfile = $_SESSION['profile'];

$rated;

function rateAgent()
{
    $rateInfo = array();
    global $rated;

    // store each login field data in array
    foreach ($_POST as $key => $value) {
        $rateInfo[$key] = $value;
    }

    $rateAgentController = new RateAgentController();
    $rated = $rateAgentController->rateAgent($rateInfo);
    
    // check if creation success
    if ($rated) {
        createSuccess();
    }
    else
        createFail();
}

function createSuccess()
{
    echo '<div class="alert alert-success" role="alert">
            Rated successfully, redirecting...
        </div>';

    // Redirect using JavaScript after the alert is closed
    echo '<script>setTimeout(function() { history.go(-2); }, 2000);</script>';
}

function createFail()
{
    echo '<div class="alert alert-danger" role="alert">
            Fail to rate, try again!
        </div>';
}

if(isset($_POST['submit']))
{
    rateAgent();
}

?>
<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    <form id="rateAgentForm" action="" method="post" style="background-color: #f0f0f0; padding: 20px; border-radius: 10px; width: 50%;">
        <h2>Review agent: <?php if (isset($_POST['agent_fullname'])): echo $_POST['agent_fullname'];  endif; ?></h2>
        <br>
        <input type="hidden" name="agent_username" value="<?= $_POST['agent_username'] ?>">
        <input type="hidden" name="rater_username" value="<?= $loggedInUsername ?>">
        <input type="hidden" name="profile" value="<?= $loggedInProfile ?>">
        
        <div class="form-group">
            <b><label>Communication:</label><br></b>
            <?php for ($i = 1; $i <= 5; $i++) : ?>
                <label class="radio-inline">
                    <input type="radio" name="rating_communication" value="<?= $i ?>" required><?= $i ?> Star
                </label>&nbsp;&nbsp;
            <?php endfor; ?>
        </div>
        
        <div class="form-group">
            <b><label>Professionalism:</label><br></b>
            <?php for ($i = 1; $i <= 5; $i++) : ?>
                <label class="radio-inline">
                    <input type="radio" name="rating_professionalism" value="<?= $i ?>" required><?= $i ?> Star
                </label>&nbsp;&nbsp;
            <?php endfor; ?>
        </div>
        
        <div class="form-group">
            <b><label>Market Knowledge:</label><br></b>
            <?php for ($i = 1; $i <= 5; $i++) : ?>
                <label class="radio-inline">
                    <input type="radio" name="rating_marketKnowledge" value="<?= $i ?>" required><?= $i ?> Star
                </label>&nbsp;&nbsp;
            <?php endfor; ?>
        </div>
        
        <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit Rating</button>
        <button type="button" class="btn btn-secondary" onclick="window.history.back();">Cancel</button>
    </form>
</div>

<?php require_once "partials/footer.php"; ?>