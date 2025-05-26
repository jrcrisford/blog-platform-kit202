<?php
    // Include database connection
    include_once 'db_connect.php';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // Check if the user is logged in
    if (!isset($_SESSION['username'])) {
        // Redirect to login page if not logged in
        header("Location: login.php");
        exit();
    }

    // Check if the user is an author
    if ($_SESSION['role'] !== 'author') {
        // Redirect to homepage if not an author
        header("Location: index.php");
        exit();
    }
    
    // Handle post creation
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the form data
        $title = trim($_POST['title']);
        $tags = trim($_POST['tags']);
        $content = trim($_POST['content']);
        
        $conn = connect();
        $result = insertPost($conn, $title, $content, $tags);
        disconnect($conn);

        if ($result) {
            // Redirect to homepage after successful post creation
            echo "<script>alert('Post created successfully!');</script>";
            header("Location: index.php");
            exit();
        } else {
            // Handle error (e.g., display an error message)
            echo "<script>alert('Error creating post. Please try again.');</script>";
            header("Location: write.php");
            exit();
        }
    }
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Joshua Crisford, Anmol Daulyal, Dipen Subedi">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script>// Apply dark mode before styles load to prevent flickering
            if (localStorage.getItem("theme") === "dark") {document.documentElement.classList.add("dark-mode");}
        </script> 
        <link rel="stylesheet" href="css/styles.css">
        <script src="javascript/validation.js" defer></script>
        <script src="javascript/ui_behaviour.js" defer></script>
        <title>Write Post Page</title>
    </head>
    <body>
        
        <!-- Navigation Bar -->
        <div class="navbar-container">
            <nav class="navbar">
                <div class="navbar-inner">

                    <!-- Logo -->
                    <div class="logo">
                        <a href="index.php">
                            <img src="logos/horizontal_logo_dark.png" id="site-logo" alt="Logo Horizonal Dark" class="site-logo">
                        </a>
                    </div>

                    <!-- Hamburger Menu (for mobile) -->
                    <button class="hamburger" id="hamburger" aria-label="Toggle navigation">
                        ☰
                    </button>

                    <!-- Navigation Links -->
                    <ul class="nav-links" id="navLinks">
                        <li><a href="index.php">Homepage</a></li>
                        <li><a href="older.php">Older Posts</a></li>
                        <li><a href="write.php" class="active">Write Post</a></li>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="our_story.php">Our Story</a></li>
                        
                        <!-- Theme Toggle Switch -->
                        <li class="theme-toggle-container">
                            <label class="theme-toggle">
                                <input type="checkbox" id="themeSwitch" />
                                <span class="slider"></span>
                            </label>
                            <span class="theme-toggle-label">Dark Mode</span>
                        </li>

                    </ul>
                </div>
            </nav>
        </div>
        
        <!-- Page content start -->
        <main class="container">

           <div class="form-container">
            <section class="page-header">
                <h2>Write Post</h2>
                <p> Please fill in the form to create new post.</p>
            </section>

            <!-- Post Creation -->
             <section>
            <form id="writePostForm" novalidate action="write.php" method="POST">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" maxlength="80">
                <span class="error-message" id="title-error"></span>

                <label for="tags">Tags/Keywords</label>
                <input type="text" id="tags" name="tags">
                <span class="error-message" id="tags-error"></span>

                <label for="content">Content:</label>
                <textarea id="content" name="content" rows="10"></textarea>
                <span class="error-message" id="content-error"></span>

                <button type="submit" class="publish-btn">Publish</button>
                <button type="reset">Clear</button>
            </form>
        </section>

        <footer>
            <p>KIT202 Assignment 1 | Everything Explained</p>
        </footer>

        <button id="scrollToTopBtn" title="Go to top">↑</button>
        
    </body>
</html>  