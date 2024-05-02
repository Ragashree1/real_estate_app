<?php
// Inititate sql connection
require_once 'dbConnect.php';

// create database
require_once 'dbCreateDB.php';

// drop existing table
require_once 'dbDrop.php';

// create table
require_once 'dbCreateTable.php';

// Insert records
require_once 'dbInsert.php';

echo "Database management operations completed successfully.";

$conn->close();
?>
