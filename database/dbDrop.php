<?php
// drop profile
$dropShortlist= "DROP TABLE IF EXISTS Shortlist";

if ($conn->query($dropShortlist) === TRUE) {
    echo "Table Shortlist dropped successfully\n";
} else {
    echo "Error dropping table: " . $conn->error . "\n";
}

// drop listing
$dropListing = "DROP TABLE IF EXISTS PropertyListing";

if ($conn->query($dropListing) === TRUE) {
    echo "Table PropertyListing dropped successfully\n";
} else {
    echo "Error dropping table: " . $conn->error . "\n";
}

// drop account 
$dropAccount = "DROP TABLE IF EXISTS UserAccount";
if ($conn->query($dropAccount) === TRUE) {
    echo "Table UserAccount dropped successfully\n";
} else {
    echo "Error dropping table: " . $conn->error . "\n";
}

// drop profile
$dropProfile = "DROP TABLE IF EXISTS UserProfile";

if ($conn->query($dropProfile) === TRUE) {
    echo "Table UserProfile dropped successfully\n";
} else {
    echo "Error dropping table: " . $conn->error . "\n";
}
?>