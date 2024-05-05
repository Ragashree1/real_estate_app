<?php
session_start();

// Check if user is not logged in, then redirect to login page
function checkLoggedin(): bool
{
    // if not log in go to home
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }

    return true;
}

$loggedIn = checkLoggedin();

if($loggedIn)
{
    $loggedInUsername = $_SESSION['username'];
    $loggedInProfile = $_SESSION['profile'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lucky7 Property</title>
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <img src="images/logo.png" alt="To Dashboard" height="30">
    <a class="navbar-brand" href="dashboard.php">Lucky7Property</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" 
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="dashboard.php" style="color: white;"><i class="fas fa-bars"></i> Dashboard</a></li>';
            <?php
            // Check user's profile and display corresponding navigation items
            if (isset($loggedInProfile)) {
                $profile = $_SESSION['profile'];
                if ($profile === 'agent') {
                    echo '<li class="nav-item"><a class="nav-link" href="newListings.php" style="color: white;"><i class="fas fa-house"></i> New Properties</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="agent_manageListings.php" style="color: white;"><i class="fas fa-gear"></i> Manage Listings</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="agent_ratingsReviews.php" style="color: white;"><i class="fas fa-comments"></i> Ratings & Reviews</a></li>';
                } elseif ($profile === 'buyer') {
                    echo '<li class="nav-item"><a class="nav-link" href="newListings.php" style="color: white;"><i class="fas fa-house"></i> New Properties</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="buyer_soldListings.php"  style="color: white;"><i class="fas fa-gavel"></i> Sold Properties</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="buyer_favourites.php" style="color: white;"><i class="fas fa-heart" ></i> Favourites</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="" style="color: white;"><i class="fas fa-calculator" ></i> Calculate Mortgage</a></li>';
                } elseif ($profile === 'seller') {
                    echo '<li class="nav-item"><a class="nav-link" href="newListings.php" style="color: white;"><i class="fas fa-house"></i> New Properties</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="buyer_listings.php" style="color: white;"><i class="fas fa-tasks"></i> My Listings</a></li>';
                } elseif ($profile === 'admin') {
                    echo '<li class="nav-item"><a class="nav-link" href="admin_manageAccounts.php" style="color: white;"><i class="fas fa-user-cog"></i> Manage Account</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="admin_manageProfiles.php" style="color: white;"><i class="fas fa-cog"></i> Manage Profile</a></li>';
                }
            }
            ?>
        </ul>
    </div>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            
			<?php
            // Check if user is logged in
            if (isset($loggedInUsername)) {
                echo '<li class="nav-item dropdown">';
                echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white;"><i class="fas fa-user"></i> Welcome ' . $_SESSION['username'] . '</a>';
                echo '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                echo '<div class="dropdown-divider"></div>';
                echo '<a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>';
                echo '</div>';
                echo '</li>';
            } 
            ?>
            
    
        </ul>
    </div>
    
</nav>



