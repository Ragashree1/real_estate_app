<?php

// SQL to create UserProfile table
$sqlProfile = "CREATE TABLE IF NOT EXISTS UserProfile (
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
    FOREIGN KEY (profile) REFERENCES UserProfile(profile_name) 
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
    FOREIGN KEY (listed_by) REFERENCES UserAccount(username),
    FOREIGN KEY (sold_by) REFERENCES UserAccount(username)
)";

if ($conn->query($sqlListing) === TRUE) {
    echo "Table PropertyListing created successfully\n";
} else {
    echo "Error creating table PropertyListing: " . $conn->error;
}
?>
