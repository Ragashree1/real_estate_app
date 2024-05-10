<?php
function generateRandomListingData() {
    $descriptions = ['Near the MRT', 'Near the Shopping Center', 'Various footcourts nearby', 'Nearby Hospital'];
    $types = ['Landed Property', 'Condo', 'HDB'];
    $locations = ['Bedok', 'Woodlands', 'Tampinese', 'Jurong East', 'Toapayoh', 'Yishun'];
    $bhk = mt_rand(1, 10); // Random number of bedrooms
    $area = mt_rand(1000,9999); // Random area
    $title = "Block ".mt_rand(100, 999)." - $bhk Room Estate";
    $status = ['New', 'Old'];

    $listing = array(
        'title' => $title, 
        'description' => $descriptions[array_rand($descriptions)], 
        'image' => 'images/' . mt_rand(0, 11) . '.png', 
        'type' => $types[array_rand($types)], 
        'location' => $locations[array_rand($locations)], 
        'price' => mt_rand(100000, 1000000),
        'area' => $area,
        'bhk' => $bhk, 
        'listed_by' => 'agent'.mt_rand(1, 100), 
        'sold_by' => 'seller'.mt_rand(1, 100), 
        'status' => $status[array_rand($status)],
        'num_views' => mt_rand(0, 1000), 
        'num_shortlist' => 0 
    );

    return $listing;
}

function generateRandomDate() {
    $start_date = strtotime('1950-01-01');
    $end_date = strtotime('2000-01-01');
    $random_date = mt_rand($start_date, $end_date);

    return date('Y-m-d', $random_date);
}

function generateRandomName() {
    $firstNames = ['John', 'Jane', 'David', 'Emily', 'Michael', 'Sarah', 'Robert', 'Olivia', 'William', 'Emma'];
    $lastNames = ['Smith', 'Johnson', 'Williams', 'Jones', 'Brown', 'Davis', 'Miller', 'Wilson', 'Moore', 'Taylor'];
    $firstName = $firstNames[array_rand($firstNames)];
    $lastName = $lastNames[array_rand($lastNames)];
    return $firstName . ' ' . $lastName;
}


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
        echo "Profile for {$profile['profile_name']} successfully\n";
    } else {
        echo "Error inserting record: " . $conn->error . "\n";
    }
}

// Generate and insert account records for each user profile
$profileNames = ['admin', 'agent', 'buyer', 'seller'];
foreach ($profileNames as $profileName) {
    $isInserted = true; // Initialize the flag outside the loop

    for ($i = 1; $i <= 100; $i++) {
        $username = $profileName . $i; 
        $password = 'password123'; 
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $dob = generateRandomDate();
        $fullname = generateRandomName();
        $email = $username . '@abc.com'; 
        $contact = mt_rand(10000000, 99999999); 
        $status = 'active';

        $accountInsert = "INSERT INTO UserAccount (username, passwordHash, dob, fullname, email, contact, profile, status) 
                          VALUES ('$username', '$passwordHash', '$dob', '$fullname', '$email', '$contact', '$profileName', '$status')";

        if ($conn->query($accountInsert) !== TRUE) {
            $isInserted = false; 
            break; 
        }
    }

    if ($isInserted){
        echo "Account for $profileName is inserted successfully\n";
    } else{
        echo "Error inserting record: $profileName\n";
    }
}

// Generate and insert listing records
$isInserted = true; // Initialize the flag
for ($i = 0; $i < 100; $i++) {
    $listing = generateRandomListingData();

    $listingInsert = "INSERT INTO PropertyListing (title, description, image, type, location, price, area, bhk, listed_by, sold_by, status, num_views, num_shortlist) 
                      VALUES ('{$listing['title']}', '{$listing['description']}', '{$listing['image']}', '{$listing['type']}', '{$listing['location']}', '{$listing['price']}', '{$listing['area']}', '{$listing['bhk']}', '{$listing['listed_by']}', '{$listing['sold_by']}', '{$listing['status']}', '{$listing['num_views']}', '{$listing['num_shortlist']}')";

    if ($conn->query($listingInsert) !== TRUE) {
        $isInserted = false; 
        break; 
    }
}

if ($isInserted){
    echo "All listings inserted successfully\n";
} else{
    echo "Error inserting one or more records\n";
}


?>

