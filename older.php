<?php
    include_once 'db_connect.php';
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Check the user's role
    $role = $_SESSION['role'] ?? 'visitor';
    if ($role === 'visitor') {
        $_SESSION['error_message'] = "You must be logged to view this page.";
        header("Location: index.php");
        exit();
    }

    $LIMIT = 100; //Limit for posts per page
    $PAGE = 3; //Page number for older posts

    $conn = connect();
    if (isset($_GET['search']) && trim($_GET['search']) !== '') {
        $searchTerm = trim($_GET['search']);
        $posts = searchPosts($conn, $searchTerm);
    } else {
        $posts = getPosts($conn, $LIMIT, $PAGE);
    }

    disconnect($conn);

    // Handle comment submission

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['userID'])) {
        $postID = $_POST['postID'] ?? null;
        $userID = $_SESSION['userID'];
        $rating = isset($_POST['rating']) && $_POST['rating'] !== '' ? $_POST['rating'] : null;
        $comment = isset($_POST['comment']) && trim($_POST['comment']) !== '' ? trim($_POST['comment']) : null;

        $conn = connect();
        $success = false;

        if (isset($_POST['submitRating'])) {
            if ($rating !== null) {
                if (insertRating($conn, $userID, $postID, $rating)) {
                    $_SESSION['success_message'] = "Rating submitted!";
                    $success = true;
                } else {
                    $_SESSION['error_message'] = "You have already rated this post.";
                }
            } else {
                $_SESSION['error_message'] = "Please select a rating before submitting.";
            }
        }

        if (isset($_POST['submitComment'])) {
            if ($comment !== null) {
                insertComment($conn, $userID, $postID, $comment);
                $_SESSION['success_message'] = "Comment submitted!";
                $success = true;
            } else {
                $_SESSION['error_message'] = "Please enter a comment before submitting.";
            }
        }

        disconnect($conn);
        header("Location: older.php");
        exit();
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
        <script src="javascript/content_toggle.js?V=2" defer></script>
        <script src="javascript/ui_behaviour.js" defer></script>
        <title>Older Posts Page</title>
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

                        <!-- Home Page Link -->
                        <li><a href="index.php">Homepage</a></li>

                        <!-- Older Page Link -->
                         <!-- Only authors and members can access the older posts -->
                        <?php if (isset($_SESSION['role'])  && ($_SESSION['role'] === 'member' || $_SESSION['role'] === 'author')): ?>
                        <li><a href="older.php" class="active">Older Posts</a></li>
                        <?php endif; ?>

                        <!-- Write Post Link -->
                         <!-- Only authors can access the write post page -->
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'author'): ?>
                        <li><a href="write.php">Write Post</a></li>
                        <?php endif; ?>

                        <!-- Our Story Page Link -->
                        <li><a href="our_story.php">Our Story</a></li>

                        <!-- Login/Register/Logout Links -->
                        <?php if ($role === 'member' || $role === 'author'): ?>
                            <li>Logged in as <?php echo htmlspecialchars($_SESSION['username']); ?></li>
                            <li><a href="logout.php">Logout</a></li>
                        <?php else: ?>
                            <li><a href="login.php">Login</a></li>
                             <li><a href="register.php">Register</a></li>
                        <?php endif; ?>

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

        <!-- Display error or success messages-->
        <?php include_once 'message.php'; ?>
            
            <!-- Page Title -->
            <section class ="page-header">
                <h2>Older Posts</h2>
                <p>View all posts here</p>
            </section>

            <section class="search-bar">
                <form method="GET" action="older.php" 
                    style="display: flex; justify-content: center; margin-bottom: 20px;">
                    <div style="display: flex; gap: 10px; align-items: center; width: 100%; max-width: 800px;">
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Search by title or tag..." 
                            value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>"
                            style="padding: 10px; flex-grow: 1; font-size: 16px; height: 42px; vertical-align: middle;"
                        >
                        <button type="submit" style="height: 38px; font-size: 16px; vertical-align: middle;">Search</button>
                        <button type="button" onclick="window.location.href='older.php'" style="height: 38px; font-size: 16px; vertical-align: middle;">Clear</button>
                    </div>
                </form>
            </section>


            <?php
                if (empty($posts)){
                    echo '<article class="blog-post">';
                    echo '<p>No posts found for search.</p>';
                    echo '</article>';
                } else {
                    foreach ($posts as $post){
                        echo '<article class="blog-post">';
                        echo '<h3>' . htmlspecialchars($post['title']) . '</h3>';
                        echo '<button class="toggle-content-btn" onclick="toggleContent(this)">Show Content</button>';
                        echo '<div class="post-content hidden">';
                        echo'<p>' . htmlspecialchars($post['content']) . '</p>';
                        echo '</div>';
                        echo '<p>Posted on ' . htmlspecialchars($post['postDate']) . ' by ' . htmlspecialchars($post['author']) . '</p>';
                        echo '<p>';
                            foreach (explode(',', $post['tags']) as $tag){
                                    echo '<span class="tags">' . htmlspecialchars(trim($tag)) . '</span> ';
                                }
                        echo '</p>';

                        //Ratings and comments
                        $conn = connect();
                        $comments = getCommentsAndRatingsByPostID($conn, $post['postID']);
                        disconnect($conn);

                        $sectionID = "comments_" . $post['postID'];

                        echo '<div class="comments-wrapper">';
                        echo '<button class="toggle-comments" onclick="toggleComments(\'' . $sectionID . '\')">Show/Hide Comments & Ratings</button>';

                        echo '<div id="' . $sectionID . '" class="comments-section" style="display: none;">';
                        echo '<h4>Comments and Ratings:</h4>';

                        if ($comments !== null && count($comments) > 0) {
                            foreach ($comments as $comment) {
                                echo '<div class="comment post-content">';
                                echo '<p><strong>' . htmlspecialchars($comment['username']) . '</strong>';

                                if (isset($comment['rating'])) {
                                    echo ' rated this post <strong>' . htmlspecialchars($comment['rating']) . '/5</strong> ';
                                }
                                
                                if (isset($comment['commentDate'])) {
                                    echo 'on ' . htmlspecialchars(getDateFromDateTime($comment['commentDate'])) . '</p>';
                                } 
                                
                                echo '<p>';
                                
                                if (isset($comment['content']) && !empty($comment['content'])) {
                                    echo '<p>' . nl2br(htmlspecialchars($comment['content'])) . '</p>';
                                }

                                echo '</div>';
                            }
                        } else {
                            echo '<p>No comments or ratings yet.</p>';
                        }

                        // Comment form (if logged in)

                        if(isset($_SESSION['userID'])) {
                            echo '<form method="POST" action="older.php" class="comment-form" style="max-width: 100%; margin-bottom: 40px;">';
                            echo '<input type="hidden" name="postID" value="' . $post['postID'] . '">';

                            echo '<div style="display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 20px;">';
                            echo '  <input type="range" id="rating_' . $post['postID'] . '" name="rating" min="1" max="5" value="3" ';
                            echo '    style="width: 200px; max-width: 100%; margin: 0;" ';
                            echo '    oninput="document.getElementById(\'ratingValue_' . $post['postID'] . '\').textContent = this.value + \'/5\'">';
                            echo '  <span id="ratingValue_' . $post['postID'] . '" style="min-width: 40px; text-align: center;">3/5</span>';
                            echo '  <button type="submit" name="submitRating" style="height: 36px; margin-top: 2px;">Post Rating</button>';
                            echo '</div>';

                            echo '<div style="width: 100%; max-width: 1000px; padding: 0 1rem; margin: 0 auto;">';
                            echo '<textarea name="comment" rows="6" placeholder="Write your comment here..." style="width: 100%; min-height: 150px; resize: vertical; font-size: 1rem;"></textarea>';
                            echo '</div>';

                            echo '<button type="submit" name="submitComment" style="height: 36px;">Post Comment</button>';
                            echo '</form>';

                        } else {
                            echo '<p><a href="login.php">Login</a> to rate and comment.</p>';
                        }

                        echo '</div>'; // Close comments section
                        echo '</div>'; // Close comments wrapper


                        echo '</article>';
                    }
                }
             ?>

            <!--
            <article class="blog-post">

                <h3>Old Post One</h3>
                <button class="toggle-content-btn" onclick="toggleContent(this)">Show Content</button>
                <div class="post-content hidden">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean vitae ante sit amet leo egestas 
                        hendrerit. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis 
                        egestas. Cras vel lacinia sapien. Sed in tellus eget leo tincidunt congue. Nullam imperdiet justo 
                        vel massa porta, at eleifend nulla euismod. Phasellus iaculis erat vel dui vehicula, sit amet 
                        pulvinar ligula suscipit. Sed dignissim, metus at fermentum blandit, justo augue facilisis neque, 
                        ac iaculis sapien risus nec sem. Curabitur vel nunc vitae nisi lacinia lacinia ac id arcu.
                    </p>
                </div>
                <p>Posted on March 10, 2025 by John Doe</p>
                <p>
                    <span class="tags">Lorem</span>
                    <span class="tags">Mollitia</span>
                    <span class="tags">Doloribus</span>
                </p>
            </article>
        

          
             <article class="blog-post">

                <h3>Old Post Two</h3>
                <button class="toggle-content-btn" onclick="toggleContent(this)">Show Content</button>
                <div class="post-content hidden">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vulputate erat eu justo 
                        eleifend, vitae sagittis libero ornare. Maecenas nec ex ac magna faucibus blandit non eget 
                        justo. Nullam in tellus elit. Sed sed diam sit amet nisl iaculis volutpat at nec justo. Morbi 
                        gravida dui at neque finibus, in congue sapien facilisis. Pellentesque habitant morbi tristique 
                        senectus et netus et malesuada fames ac turpis egestas. Suspendisse porta dui et massa luctus, 
                        non fermentum sapien fringilla.
                    </p>
                </div>
                <p>Posted on February 9, 2025 by John Doe</p>
                <p>
                    <span class="tags">Sunt</span>
                    <span class="tags">Mollitia</span>
                    <span class="tags">Inventore</span>
                </p>
             </article>

            
            <article class="blog-post">

                <h3>Old Post Three</h3>
                <button class="toggle-content-btn" onclick="toggleContent(this)">Show Content</button>
                <div class="post-content hidden">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam erat volutpat. Vestibulum ante 
                        ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec id erat nec elit 
                        feugiat gravida sit amet eget ex. Pellentesque habitant morbi tristique senectus et netus et 
                        malesuada fames ac turpis egestas. Fusce luctus mauris vel erat blandit, nec vestibulum velit 
                        malesuada. Vivamus convallis tincidunt risus, a ultrices purus tincidunt non. Donec non justo 
                        quis nulla ultrices commodo ac vel lorem.
                    </p>
                </div>
                <p>Posted on November 10, 2024 by John Smith</p>
                <p>
                    <span class="tags">Magni</span>
                    <span class="tags">Numquam</span>
                    <span class="tags">Deserunt</span>
                </p>
            </article>

            
            <article class="blog-post">

                <h3>Old Post Four</h3>
                <button class="toggle-content-btn" onclick="toggleContent(this)">Show Content</button>
                <div class="post-content hidden">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean vitae ante sit amet leo egestas 
                        hendrerit. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis 
                        egestas. Cras vel lacinia sapien. Sed in tellus eget leo tincidunt congue. Nullam imperdiet justo 
                        vel massa porta, at eleifend nulla euismod. Phasellus iaculis erat vel dui vehicula, sit amet 
                        pulvinar ligula suscipit. Sed dignissim, metus at fermentum blandit, justo augue facilisis neque, 
                        ac iaculis sapien risus nec sem. Curabitur vel nunc vitae nisi lacinia lacinia ac id arcu.
                    </p>
                </div>
                <p>Posted on March 10, 2025 by John Doe</p>
                <p>
                    <span class="tags">Animi</span>
                    <span class="tags">Ullam</span>
                    <span class="tags">Alias</span>
                </p>
            </article>
        -->

        </main>

        <footer>
            <p>KIT202 Assignment 1 | Everything Explained</p>
        </footer>

        <button id="scrollToTopBtn" title="Go to top">↑</button>

    </body>
</html>  