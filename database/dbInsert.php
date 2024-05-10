<?php
function generateRandomListingData() {
    $descriptions = ['Near the MRT', 'Near the Shopping Center', 'Various footcourts nearby', 'Nearby Hospital'];
    $types = ['Landed Property', 'Condo', 'HDB'];
    $locations = ['Bedok', 'Woodlands', 'Tampinese', 'Jurong East', 'Toapayoh', 'Yishun'];
    $bhk = mt_rand(1, 10); // Random number of bedrooms
    $area = mt_rand(1000,9999); // Random area
    $title = "Block ".mt_rand(100, 999)." - $bhk Room Estate";
    $status = ['new', 'sold'];
    

    $listing = array(
        'title' => $title, 
        'description' => $descriptions[array_rand($descriptions)], 
        'image' => 'images/' . mt_rand(0, 11) . '.png', 
        'type' => $types[array_rand($types)], 
        'location' => $locations[array_rand($locations)], 
        'price' => mt_rand(100000, 1000000),
        'area' => $area,
        'bhk' => $bhk, 
        'listed_by' => 'agent'.sprintf('%03d',mt_rand(1, 100)), 
        'sold_by' => 'seller'.sprintf('%03d',mt_rand(1, 100)), 
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


/*********  User Profile  *********/

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

/*********  User Accounts  *********/

$profileNames = ['admin', 'agent', 'buyer', 'seller'];
foreach ($profileNames as $profileName) {
    $isInserted = true; 

    for ($i = 1; $i <= 100; $i++) {
        $username = $profileName . sprintf('%03d', $i); 
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

$isInserted = true; 

/*********  Listings  *********/

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


/*********  Shortlist  *********/

for ($i = 1; $i <= 100; $i++) {
    $buyerUsername = 'buyer' . sprintf('%03d', $i);

    $numShortlist = mt_rand(20, 50);

    for ($j = $numShortlist; $j >= 20; $j--) {
        $listingId = $j; 

        $sqlInsertShortlist = "INSERT INTO Shortlist (buyer_username, listing_id)
                               VALUES ('$buyerUsername', $listingId)";

        if ($conn->query($sqlInsertShortlist) !== TRUE) {
            $isInserted = false; 
            break 2; // Break out of both loops
        }
    }
}

if ($isInserted){
    echo "All Shortlists inserted successfully\n";
} else{
    echo "Error inserting one or more records\n";
}


/*********  Ratings & Reviews  *********/

$reviewMessages = [
    'Agent went above and beyond to help me find my dream home. Highly impressed!',
    'Outstanding service from the agent. Made the whole process smooth and stress-free.',
    'Very knowledgeable and proactive agent. Guided me through every step with expertise.',
    'Impressive attention to detail and excellent communication from the agent.',
    'I could not have asked for a better agent. Exceptional service throughout.',
    'The agent was a pleasure to work with. Professional, courteous, and reliable.',
    'Highly recommend this agent to anyone looking to buy or sell a property.',
    'Fantastic experience working with the agent. Will definitely work with them again in the future.',
    'Efficient and effective service from the agent. Delivered exactly what I needed.',
    'The agent exceeded my expectations in every way. Could not be happier with the outcome.',
];

// Insert ratings and reviews
for ($i = 1; $i <= 100; $i++) {
    $agentUsername = 'agent' . sprintf('%03d', $i);

    // Insert 30 ratings for each agent
    for ($j = 1; $j <= 30; $j += 2) { 
        $buyerUsername = 'buyer' . sprintf('%03d', $j); 
        $sellerUsername = 'seller' . sprintf('%03d', $j);
        $ratingCommunication = mt_rand(1, 5);
        $ratingProfessionalism = mt_rand(1, 5);
        $ratingMarketKnowledge = mt_rand(1, 5);

        $sqlInsertRating = "INSERT INTO Rating (rater_username, agent_username, profile, rating_communication, rating_professionalism, rating_marketKnowledge)
                            VALUES ('$buyerUsername', '$agentUsername', 'buyer', $ratingCommunication, $ratingProfessionalism, $ratingMarketKnowledge),
                                   ('$sellerUsername', '$agentUsername', 'seller', $ratingCommunication, $ratingProfessionalism, $ratingMarketKnowledge)";

        if ($conn->query($sqlInsertRating) !== TRUE) {
            $isInserted = false;
            break 2; 
        }
    }

    // Insert 30 reviews for each agent
    for ($k = 1; $k <= 30; $k += 2) { 
        $reviewMessage = $reviewMessages[array_rand($reviewMessages)];
        $buyerUsername = 'buyer' . sprintf('%03d', $k);
        $sellerUsername = 'seller' . sprintf('%03d', $k);
        $buyerReviewMessage = $reviewMessages[array_rand($reviewMessages)];
        $sellerReviewMessage = $reviewMessages[array_rand($reviewMessages)];

        $sqlInsertReview = "INSERT INTO Review (reviewer_username, agent_username, profile, review_text)
                            VALUES ('$buyerUsername', '$agentUsername', 'buyer', '$buyerReviewMessage'),
                                ('$sellerUsername', '$agentUsername', 'seller', '$sellerReviewMessage')";

        if ($conn->query($sqlInsertReview) !== TRUE) {
            $isInserted = false;
            break 2; 
        }
    }
}

if ($isInserted) {
    echo "All ratings and reviews inserted successfully\n";
} else {
    echo "Ratings and Reviews were not inserted successfully\n";
}


?>

