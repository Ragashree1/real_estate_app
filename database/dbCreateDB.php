<?php 
// Create the database if it doesn't exist
$sqlCreateDb = "CREATE DATABASE IF NOT EXISTS lucky7property";
if ($conn->query($sqlCreateDb) === TRUE) {
    echo "Database created successfully\n";
} else {
    echo "Error creating database: " . $conn->error;
}

// Select the database
$conn->select_db("lucky7property");
?>