<?php
    // Start session only if it hasn't already been started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Database connection function
    function connect() {
        $host = 'localhost';
        $user = "kit202-group-26";
        $password = "VwDePHbkyUxM";
        $dbname = "kit202-group-26";

        // Connect to the database
        $conn = new mysqli($host, $user, $password, $dbname);
        // Check for errors
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
    
    // Create a new user
    function insertUser($username, $email, $password) {
        $conn = connect();

        //Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user into the database
        $stmt = $conn->prepare("INSERT INTO `User` (username, email, passwordHash, role) VALUES (?, ?, ?, 'member')");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("sss", $username, $email, $hashedPassword);
        if($stmt->execute()) {
            return true;
        } else {
            return false;
    }
}