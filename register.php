<?php
require_once 'db_connect.php';

// Get post data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);


    // Check if duplicate username or email
    $existingUser = getUserByUsername($username);
    if (!$existingUser) {
        $existingUser = getUserByEmail($email);
    }

    if ($existingUser) {

        if ($existingUser['username'] === $username) {
            header("Location: register.html?error=username_taken");
            exit();
        }

        if ($existingUser['email'] === $email) {
            header("Location: register.html?error=email_taken");
            exit();
        }
    }

    if (insertUser($username, $email, $password)) {
        // Registration successful
        header("Location: login.html?registered=1");
    } else {
        // Registration failed
        header("Location: register.html?error=registration_failed");
    }

}