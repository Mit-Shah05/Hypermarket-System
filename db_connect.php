<?php
$host = "localhost";         // Apache is typically hosted locally
$username = "root";          // Default for XAMPP/WAMP
$password = "";              // Default is blank for root in XAMPP/WAMP
$database = "hypermarketdb"; // Change this to your actual database name

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully to MySQL database!";
?>
