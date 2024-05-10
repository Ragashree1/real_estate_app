<?php
// Set a seed for random number generation
mt_srand(microtime(true) * 1000000);
function generateRandomListingData() {
    $descriptions = [
        'Discover your own private sanctuary amidst lush greenery and tranquil surroundings, offering the perfect retreat from the hustle and bustle of city life. Immerse yourself in the beauty of nature while enjoying modern comforts and amenities tailored to elevate your lifestyle.',
        'Indulge in the epitome of luxury living with breathtaking panoramic views of the city skyline as your backdrop. Experience the ultimate in sophistication and elegance, with meticulously designed interiors and state-of-the-art facilities that redefine urban living. Welcome to your exclusive haven of opulence and style.',
        'Experience the best of both worlds in a dynamic community that seamlessly blends convenience and connectivity with a vibrant lifestyle. From world-class dining and entertainment options to sprawling parks and recreational facilities, every aspect of your life is enriched with endless possibilities and excitement.',
        'Embark on a journey of limitless opportunities in a neighborhood that fosters growth and development. With top-tier educational institutions and innovative learning centers just steps away, provide your family with the gift of knowledge and empowerment, ensuring a brighter future for generations to come.',
        'Embrace the ease of modern living in a prime location that puts everything within reach. Whether it’s effortless commutes via well-connected transportation networks or convenient access to a myriad of amenities and services, enjoy the ultimate convenience at your fingertips, every day.',
        'Immerse yourself in a vibrant cultural tapestry, where tradition meets modernity in perfect harmony. Explore bustling markets, vibrant festivals, and rich historical landmarks, all within easy reach of your doorstep. Experience the vibrant energy and diversity of city living like never before.',
        'Elevate your lifestyle with unparalleled convenience and luxury in a cosmopolitan metropolis that never sleeps. Indulge in world-class dining, shopping, and entertainment options, all just moments away from your doorstep. Experience the epitome of urban living in the heart of the city.',
        'Escape to a serene oasis of tranquility and beauty, where lush landscapes and pristine beaches await. Bask in the warm embrace of the sun, as gentle sea breezes caress your skin. Discover a paradise retreat where relaxation and rejuvenation are always on the agenda.',
        'Experience the perfect blend of modern elegance and timeless charm in a historic neighborhood steeped in culture and heritage. Wander down cobblestone streets lined with charming cafes and boutiques, or explore centuries-old landmarks and architectural wonders. Live amidst the rich tapestry of the past, while embracing the conveniences of modern living.',
        'Uncover the hidden gems of a vibrant neighborhood brimming with creativity and innovation. From trendy art galleries and artisanal cafes to eclectic boutiques and indie music venues, every corner offers a new adventure waiting to be discovered. Immerse yourself in the dynamic energy of urban exploration and cultural discovery.'
    ];
    
    
    
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
        'listed_by' => 'agent'.sprintf('%03d',mt_rand(2, 100)), 
        'sold_by' => 'seller'.sprintf('%03d',mt_rand(2, 100)), 
        'status' => $status[array_rand($status)],
        'num_views' => mt_rand(0, 1000), 
        'num_shortlist' => mt_rand(0, 100)
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
for ($i = 0; $i < 10; $i++) {
    $listing = generateRandomListingData();
    $soldBy = 'seller'.sprintf('%03d',mt_rand(2, 100));

    $listingInsert = "INSERT INTO PropertyListing (title, description, image, type, location, price, area, bhk, listed_by, sold_by, status, num_views, num_shortlist) 
                      VALUES ('{$listing['title']}', '{$listing['description']}', '{$listing['image']}', '{$listing['type']}', '{$listing['location']}', '{$listing['price']}', '{$listing['area']}', '{$listing['bhk']}', 'agent001', '$soldBy', '{$listing['status']}', '{$listing['num_views']}', '{$listing['num_shortlist']}')";

    if ($conn->query($listingInsert) !== TRUE) {
        $isInserted = false; 
        break; 
    }
}

for ($i = 0; $i < 10; $i++) {
    $listing = generateRandomListingData();
    $listBy = 'agent'.sprintf('%03d',mt_rand(2, 100));

    $listingInsert = "INSERT INTO PropertyListing (title, description, image, type, location, price, area, bhk, listed_by, sold_by, status, num_views, num_shortlist) 
                      VALUES ('{$listing['title']}', '{$listing['description']}', '{$listing['image']}', '{$listing['type']}', '{$listing['location']}', '{$listing['price']}', '{$listing['area']}', '{$listing['bhk']}', '$listBy', 'seller001', '{$listing['status']}', '{$listing['num_views']}', '{$listing['num_shortlist']}')";

    if ($conn->query($listingInsert) !== TRUE) {
        $isInserted = false; 
        break; 
    }
}

for ($i = 0; $i < 80; $i++) {
    $listing = generateRandomListingData();
    $listBy = 'agent'.sprintf('%03d',mt_rand(2, 100));
    $soldBy = 'seller'.sprintf('%03d',mt_rand(2, 100));

    $listingInsert = "INSERT INTO PropertyListing (title, description, image, type, location, price, area, bhk, listed_by, sold_by, status, num_views, num_shortlist) 
                      VALUES ('{$listing['title']}', '{$listing['description']}', '{$listing['image']}', '{$listing['type']}', '{$listing['location']}', '{$listing['price']}', '{$listing['area']}', '{$listing['bhk']}', '$listBy', '$soldBy', '{$listing['status']}', '{$listing['num_views']}', '{$listing['num_shortlist']}')";

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

    $numShortlist = mt_rand(30, 60);

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
    'I cannot thank the agent enough for their dedication and commitment to helping me find the perfect home. From the initial consultation to the final closing, they were with me every step of the way, providing valuable insights and guidance. Their knowledge of the market and attention to detail ensured that I found a property that exceeded my expectations. I highly recommend their services to anyone in search of their dream home.',
    'Working with the agent was an absolute pleasure. Their professionalism and expertise made the entire home buying process seamless and stress-free. They took the time to understand my needs and preferences, and went above and beyond to find properties that aligned with my requirements. Their proactive approach and excellent communication skills kept me informed throughout the process, and I felt confident knowing that I was in good hands. I am thrilled with my new home and grateful for the agent exceptional service.',
    'I had the pleasure of working with the agent, and I must say, they exceeded all my expectations. From our first meeting, it was evident that they were passionate about real estate and genuinely cared about helping me find the perfect property. They took the time to listen to my needs and preferences, and their extensive knowledge of the market ensured that I found a home that checked all the boxes. Throughout the process, they were responsive, attentive, and always had my best interests at heart. I cannot recommend them highly enough.',
    'I recently had the pleasure of working with the agent, and I must say, it was an outstanding experience from start to finish. Their attention to detail and dedication to their clients set them apart from the rest. They took the time to understand my unique needs and preferences, and their proactive approach ensured that I found the perfect home in no time. Their communication skills were top-notch, keeping me informed every step of the way. I am incredibly grateful for their expertise and professionalism, and I would highly recommend their services to anyone in need of a reliable real estate agent.',
    'I had the pleasure of working with the agent, and I cannot speak highly enough of their professionalism and dedication. From our initial consultation to the closing of the deal, they were with me every step of the way, providing valuable guidance and support. They took the time to understand my needs and preferences, and their attention to detail ensured that I found a property that exceeded my expectations. Their proactive approach and excellent communication skills made the entire process seamless and stress-free. I am thrilled with my new home, and I owe it all to the agent expertise and hard work.',
    'I recently had the pleasure of working with the agent, and I must say, they made the entire home buying process a breeze. From our first meeting, it was clear that they were dedicated to helping me find the perfect property. They took the time to understand my needs and preferences, and their extensive knowledge of the market ensured that I found a home that met all my criteria. Throughout the process, they were responsive, attentive, and always had my best interests at heart. I am incredibly grateful for their professionalism and expertise, and I would highly recommend their services to anyone in search of their dream home.',
    'I cannot thank the agent enough for their exceptional service and professionalism. From our initial consultation to the final closing, they were with me every step of the way, providing valuable guidance and support. They took the time to understand my unique needs and preferences, and their proactive approach ensured that I found the perfect home in no time. Their attention to detail and excellent communication skills made the entire process seamless and stress-free. I am thrilled with my new home, and I owe it all to the agent expertise and hard work.',
];


// Insert ratings and reviews
for ($i = 1; $i <= 100; $i++) {
    $agentUsername = 'agent' . sprintf('%03d', $i);
    
    for ($j = 80; $j >= 4; $j -= 2) { 
        $buyerUsername = 'buyer' . sprintf('%03d', $j); 
        $sellerUsername = 'seller' . sprintf('%03d', $j);
        $ratingBuyerCommunication = mt_rand(1, 5);
        $ratingBuyerProfessionalism = mt_rand(1, 5);
        $ratingBuyerMarketKnowledge = mt_rand(1, 5);
        $ratingSellerCommunication = mt_rand(1, 5);
        $ratingSellerProfessionalism = mt_rand(1, 5);
        $ratingSellerMarketKnowledge = mt_rand(1, 5);

        $sqlInsertRating = "INSERT INTO Rating (rater_username, agent_username, profile, rating_communication, rating_professionalism, rating_marketKnowledge)
                            VALUES ('$buyerUsername', '$agentUsername', 'buyer', $ratingBuyerCommunication, $ratingBuyerProfessionalism, $ratingBuyerMarketKnowledge),
                                   ('$sellerUsername', '$agentUsername', 'seller', $ratingSellerCommunication, $ratingSellerProfessionalism, $ratingSellerMarketKnowledge)";

        if ($conn->query($sqlInsertRating) !== TRUE) {
            $isInserted = false;
            break 2; 
        }
    }

    for ($k = 80; $k >= 4; $k -= 2) { 
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

