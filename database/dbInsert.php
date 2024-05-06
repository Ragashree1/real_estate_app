<?php
// profile data
$profileData = array(
    array('profile_name' => "admin", "description" => "perform CRUDS on accounts"),
    array('profile_name' => "agent", "description" => "perform CRUDS on listings"),
    array('profile_name' => "buyer", "description" => "perform actions on listings of interest"),
    array('profile_name' => "seller", "description" => "perform actions on their listed properties"),
);

// insert profile records
foreach ($profileData as $profile) {

    $profileInsert = "INSERT INTO UserProfile (profile_name, description)
    VALUES ('{$profile['profile_name']}', '{$profile['description']}')";

    if ($conn->query($profileInsert) === TRUE) {
        echo "Profile inserted successfully\n";
    } else {
        echo "Error inserting record: " . $conn->error . "\n";
    }
}

// account data
$accountData = array(
    array('username' => 'admin001', 'passwordHash' => password_hash('password123', PASSWORD_DEFAULT), 'dob' => '1990-05-15', 'fullname' => 'John Doe', 
                'email' => 'admin@example.com', 'contact' => '1234567890', 'profile' => 'admin', 'status' => 'active'),
    array('username' => 'agent001', 'passwordHash' => password_hash('password123', PASSWORD_DEFAULT), 'dob' => '1985-10-20', 'fullname' => 'Jane Smith', 
                'email' => 'agent@example.com', 'contact' => '9876543210', 'profile' => 'agent', 'status' => 'active'),
    array('username' => 'buyer001', 'passwordHash' => password_hash('password123', PASSWORD_DEFAULT), 'dob' => '1999-10-16', 'fullname' => 'Mary Goh', 
                'email' => 'buyer@example.com', 'contact' => '9876543210', 'profile' => 'buyer', 'status' => 'active'),
    array('username' => 'seller001', 'passwordHash' => password_hash('password123', PASSWORD_DEFAULT), 'dob' => '1975-11-22', 'fullname' => 'Harry Styles', 
                'email' => 'seller@example.com', 'contact' => '9876543210', 'profile' => 'seller', 'status' => 'active')
);

// insert account records
foreach ($accountData as $account) {
    $username = $account['username'];
    $passwordHash = $account['passwordHash'];
    $dob = $account['dob'];
    $fullname = $account['fullname'];
    $email = $account['email'];
    $contact = $account['contact'];
    $profile = $account['profile'];
    $status = $account['status'];

    $accountInsert = "INSERT INTO UserAccount (username, passwordHash, dob, fullname, email, contact, profile, status) 
        VALUES ('$username', '$passwordHash', '$dob', '$fullname', '$email', '$contact', '$profile', '$status')";

    if ($conn->query($accountInsert) === TRUE) {
        echo "Account inserted successfully\n";
    } else {
        echo "Error inserting record: " . $conn->error . "\n";
    }
}

// insert listing records
$listings = [
    [
        'title' => 'Beautiful Villa',
        'description' => 'Spacious villa with garden',
        'image' => 'images/image1.png',
        'type' => 'Villa',
        'location' => 'City Center',
        'price' => 500000,
        'area' => 3000,
        'bhk' => 4,
        'listed_by' => 'agent001', // Listed by agent
        'sold_by' => 'seller001', // Sold by seller
        'status' => 'new',
        'num_views' => 100,
        'num_shortlist' => 20
    ],
    [
        'title' => 'Luxury Apartment',
        'description' => 'Modern apartment with amenities',
        'image' => 'images/image2.png',
        'type' => 'Apartment',
        'location' => 'Suburb',
        'price' => 300000,
        'area' => 1500,
        'bhk' => 6,
        'listed_by' => 'agent001', // Listed by agent
        'sold_by' => 'seller001', // Sold by seller
        'status' => 'new',
        'num_views' => 50,
        'num_shortlist' => 5
    ],
    [
        'title' => 'Condo 21st floor quiet',
        'description' => 'Condo with swimming pool and park',
        'image' => 'images/image3.png',
        'type' => 'Condo',
        'location' => '1 Rosewood woodlands street',
        'price' => 450000,
        'area' => 750,
        'bhk' => 3,
        'listed_by' => 'agent001', // Listed by agent
        'sold_by' => 'seller001', // Sold by seller
        'status' => 'new',
        'num_views' => 200,
        'num_shortlist' => 50
    ],
    [
        'title' => 'Santorini Villa',
        'description' => 'cool blue and white themed villa good for holiday travels',
        'image' => 'images/image4.png',
        'type' => 'Villa',
        'location' => 'Southern Greench Argean Sea',
        'price' => 900000,
        'area' => 900,
        'bhk' => 9,
        'listed_by' => 'agent001', // Listed by agent
        'sold_by' => 'seller001', // Sold by seller
        'status' => 'new',
        'num_views' => 600,
        'num_shortlist' => 505
    ],
];

// Prepare and execute INSERT statements
foreach ($listings as $listing) {
    $title = $listing['title'];
    $description = $listing['description'];
    $image = $listing['image'];
    $type = $listing['type'];
    $location = $listing['location'];
    $price = $listing['price'];
    $area = $listing['area'];
    $bhk = $listing['bhk'];
    $listed_by = $listing['listed_by'];
    $sold_by = $listing['sold_by'];
    $status = $listing['status'];
    $num_views = $listing['num_views'];
    $num_shortlist = $listing['num_shortlist'];

    $sqlInsert = "INSERT INTO PropertyListing (title, description, image, type, location, price, area, bhk, listed_by, sold_by, status, num_views, num_shortlist) 
                  VALUES ('$title', '$description', '$image', '$type', '$location', $price, $area, $bhk, '$listed_by', '$sold_by', '$status', '$num_views', '$num_shortlist')";

    if ($conn->query($sqlInsert) === TRUE) {
        echo "Listing inserted successfully\n";
    } else {
        echo "Error inserting listing: " . $conn->error;
    }
}

?>
