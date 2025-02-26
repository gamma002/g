<?php
// Database Configuration
define('DB_SERVER', 'localhost');  // Database host
define('DB_USERNAME', 'root');     // Database username (default is 'root' for local setups)
define('DB_PASSWORD', '');         // Database password (leave empty for default setup)
define('DB_DATABASE', 'godsintenation_db'); // The database name

// Create a connection to the database using MySQLi
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the character set to UTF-8 to handle special characters
$conn->set_charset('utf8');

// Optionally, check if the connection is working
// echo "Connected successfully"; 

?>
