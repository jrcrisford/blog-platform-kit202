<?php
require_once 'db_connect.php';

// Get post data
$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);


// Check if duplicate username or email
$check = $conn->prepare("SELECT * FROM `User` WHERE username = ? OR email = ?");
$check->bind_param("ss", $username, $email);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    $existingUser = $result->fetch_assoc();

    if ($existingUser['username'] === $username) {
        header("Location: register.html?error=username_taken");
        exit();
    }

    if ($existingUser['email'] === $email) {
        header("Location: register.html?error=email_taken");
        exit();
    }
}

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert new user into the database
$insert = $conn->prepare("INSERT INTO `User` (username, email, passwordHash, role) VALUES (?, ?, ?, 'member')");
$insert->bind_param("sss", $username, $email, $hashedPassword);

if ($insert->execute()) {
    // Registration successful
    header("Location: login.html?registered=1");
} else {
    // Registration failed
    echo "Error: " . $conn->error;
}

$conn->close();
?>