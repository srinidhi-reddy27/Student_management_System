<?php
$servername = "localhost";
$username = "root"; // Change if different
$password = ""; // Change if your MySQL has a password
$dbname = "Students_for_Assesment";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    // Debug line (remove after testing)
    // echo "Database connection successful!<br>";
}
?>