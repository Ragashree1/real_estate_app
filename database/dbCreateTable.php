<?php

// SQL to create UserProfile table
$sqlProfile = "CREATE TABLE IF NOT EXISTS UserProfile (
    profile_id INT(6) UNSIGNED AUTO_INCREMENT UNIQUE KEY,
    profile_name VARCHAR(100) PRIMARY KEY,
    description VARCHAR(255) NOT NULL,
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sqlProfile) === TRUE) {
    echo "Table Profile created successfully\n";
} else {
    echo "Error creating table Profile: " . $conn->error;
}

// SQL to create UserAccount table
$sqlUser = "CREATE TABLE IF NOT EXISTS UserAccount (
    username VARCHAR(100) PRIMARY KEY,
    account_id INT(6) UNSIGNED AUTO_INCREMENT UNIQUE KEY,
    passwordHash VARCHAR(255) NOT NULL,
    dob DATE,
    fullname VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    contact VARCHAR(255),
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    profile VARCHAR(100), 
    status VARCHAR(50) DEFAULT 'active',
    FOREIGN KEY (profile) REFERENCES UserProfile(profile_name) ON DELETE SET NULL ON UPDATE CASCADE
    )";


if ($conn->query($sqlUser) === TRUE) {
    echo "Table UserAccount created successfully\n";
} else {
    echo "Error creating table UserAccount: " . $conn->error;
}

// SQL to create PropertyListing table
$sqlListing = "CREATE TABLE IF NOT EXISTS PropertyListing (
    listing_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255),
    type VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    price DECIMAL(10) NOT NULL,
    area DECIMAL(10) NOT NULL,
    bhk INT NOT NULL,
    date_listed TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    num_views INT DEFAULT 0,
    num_shortlist INT DEFAULT 0,
    status VARCHAR(50) DEFAULT 'new' NOT NULL,
    listed_by VARCHAR(100),
    sold_by VARCHAR(100) NULL,
    FOREIGN KEY (listed_by) REFERENCES UserAccount(username) ON DELETE CASCADE,
    FOREIGN KEY (sold_by) REFERENCES UserAccount(username) ON DELETE CASCADE
)";


if ($conn->query($sqlListing) === TRUE) {
    echo "Table PropertyListing created successfully\n";
} else {
    echo "Error creating table PropertyListing: " . $conn->error;
}


// create shortlist table
$sqlshortlist = "CREATE TABLE IF NOT EXISTS Shortlist (
    buyer_username VARCHAR(100),
    listing_id INT(6) UNSIGNED,
    date_shortlisted TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (buyer_username, listing_id),
    FOREIGN KEY (buyer_username) REFERENCES UserAccount(username) ON DELETE CASCADE,
    FOREIGN KEY (listing_id) REFERENCES PropertyListing(listing_id) ON DELETE CASCADE
)";

if ($conn->query($sqlshortlist) === TRUE) {
    echo "Table Shortlist created successfully\n";
} else {
    echo "Error creating table Shortlist: " . $conn->error;
}


// Create a trigger to increment num_shortlist when a new row is inserted into the Shortlist table
$sqltrigger1 = "CREATE TRIGGER increment_num_shortlist
AFTER INSERT ON Shortlist
FOR EACH ROW
BEGIN
    UPDATE PropertyListing
    SET num_shortlist = num_shortlist + 1
    WHERE listing_id = NEW.listing_id;
END";

// Execute the SQL statement to create the trigger
if ($conn->query($sqltrigger1) === TRUE) {
    echo "Trigger created successfully\n";
} else {
    echo "Error creating trigger: " . $conn->error;
}

// Create a trigger to increment num_shortlist when a new row is deleted into the Shortlist table
$sqltrigger2 = "CREATE TRIGGER decrement_num_shortlist
AFTER DELETE ON Shortlist
FOR EACH ROW
BEGIN
    UPDATE PropertyListing
    SET num_shortlist = num_shortlist - 1
    WHERE listing_id = OLD.listing_id;
END";

// Execute the SQL statement to create the trigger
if ($conn->query($sqltrigger2) === TRUE) {
    echo "Trigger created successfully\n";
} else {
    echo "Error creating trigger: " . $conn->error;
}

// create ratings table
$sqlRatings = "CREATE TABLE IF NOT EXISTS Rating (
    rater_username VARCHAR(100),
    agent_username VARCHAR(100),
    profile VARCHAR(100),
    rating_communication INT,
    rating_professionalism INT,
    rating_marketKnowledge INT,
    date_rated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (rater_username, agent_username),
    FOREIGN KEY (rater_username) REFERENCES UserAccount(username) ON DELETE CASCADE,
    FOREIGN KEY (agent_username) REFERENCES UserAccount(username) ON DELETE CASCADE
)" ;

if ($conn->query($sqlRatings) === TRUE) {
    echo "Table Rating created successfully\n";
} else {
    echo "Error creating table Rating: " . $conn->error;
}


// create reviews table
$sqlReviews = "CREATE TABLE IF NOT EXISTS Review (
    reviewer_username VARCHAR(100),
    agent_username VARCHAR(100),
    profile VARCHAR(100),
    review_text TEXT,
    date_reviewed TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (reviewer_username, agent_username),
    FOREIGN KEY (reviewer_username) REFERENCES UserAccount(username) ON DELETE CASCADE,
    FOREIGN KEY (agent_username) REFERENCES UserAccount(username) ON DELETE CASCADE
)" ;

if ($conn->query($sqlReviews) === TRUE) {
    echo "Table Reviews created successfully\n";
} else {
    echo "Error creating table Reviews: " . $conn->error;
}


?>
