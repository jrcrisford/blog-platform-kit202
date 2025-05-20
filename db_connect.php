<?php
// Start session only if it hasn't already been started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database creds
$host = 'localhost';
$user = "kit202-group-26";
$password = "VwDePHbkyUxM";
$dbname = "kit202-group-26";

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check for errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>