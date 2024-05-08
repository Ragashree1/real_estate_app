<?php
// drop rating
$dropReview= "DROP TABLE IF EXISTS Review";

if ($conn->query($dropReview) === TRUE) {
    echo "Table Review dropped successfully\n";
} else {
    echo "Error dropping table Review: " . $conn->error . "\n";
}

// drop rating
$dropRating= "DROP TABLE IF EXISTS Rating";

if ($conn->query($dropRating) === TRUE) {
    echo "Table Rating dropped successfully\n";
} else {
    echo "Error dropping table Rating: " . $conn->error . "\n";
}

// drop shortlist
$dropShortlist= "DROP TABLE IF EXISTS Shortlist";

if ($conn->query($dropShortlist) === TRUE) {
    echo "Table Shortlist dropped successfully\n";
} else {
    echo "Error dropping table Shortlist: " . $conn->error . "\n";
}

// drop listing
$dropListing = "DROP TABLE IF EXISTS PropertyListing";

if ($conn->query($dropListing) === TRUE) {
    echo "Table PropertyListing dropped successfully\n";
} else {
    echo "Error dropping table PropertyListing: " . $conn->error . "\n";
}

// drop account 
$dropAccount = "DROP TABLE IF EXISTS UserAccount";
if ($conn->query($dropAccount) === TRUE) {
    echo "Table UserAccount dropped successfully\n";
} else {
    echo "Error dropping table UserAccount: " . $conn->error . "\n";
}

// drop profile
$dropProfile = "DROP TABLE IF EXISTS UserProfile";

if ($conn->query($dropProfile) === TRUE) {
    echo "Table UserProfile dropped successfully\n";
} else {
    echo "Error dropping table Profile: " . $conn->error . "\n";
}
?>