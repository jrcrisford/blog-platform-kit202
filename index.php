<?php
    include_once 'db_connect.php';
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Check the user's role
    $role = $_SESSION['role'] ?? 'visitor';

    $postsPerPage = 3;


    //Fetch most recent posts from the database
    $conn = connect();
    $posts = getPosts($conn, $postsPerPage, 0);
    disconnect($conn);

    //Handle comment submission
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
    header("Location: index.php");
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
        <title>Homepage</title>
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
                        <li><a href="index.php" class="active">Homepage</a></li>

                        <!-- Older Page Link -->
                        <?php if ($role === 'member' || $role === 'author'): ?>
                        <li><a href="older.php">Older Posts</a></li>
                        <?php endif; ?>

                        <!-- Write Post Link -->
                        <?php if ($role === 'author'): ?>
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

        <!-- Success/Error Messages -->
         <?php include 'message.php'; ?>

            <!-- Page Title -->
            <section class="page-header">
                <h2>Homepage</h2>
                <p>Welcome to our blog! Here you can find the latest posts and updates.</p>
            </section>

            <!-- Blog Post Section -->
            <section id="latest-posts">

                <?php
                // Display the most recent post
                if ($posts) {
                    foreach ($posts as $post) {
                        echo '<article class="blog-post">';
                        echo '<h3>' . htmlspecialchars($post['title']) . '</h3>';
                        echo '<div class="post-content">';
                        echo '<p>' . htmlspecialchars($post['content']) . '</p>';
                        echo '</div>';
                        echo '<p>Posted on ' . htmlspecialchars($post['postDate']) . ' by ' . htmlspecialchars($post['author']) . '</p>';
                        echo '<p>';
                        foreach (explode(',', $post['tags']) as $tag) {
                            echo '<span class="tags">' . htmlspecialchars(trim($tag)) . '</span> ';
                        }
                        echo '</p>';

                        //Ratings and Comments
                        $conn = connect();
                        $comments = getCommentsAndRatingsByPostID($conn, $post['postID']);
                        disconnect($conn);

                        $sectionID = 'comments_' . $post['postID'];

                        echo '<div class="comments-wrapper">';
                        echo '<button class="toggle-comments" onclick="toggleComments(\'' . $sectionID . '\')">Show/Hide Comments & Ratings</button>';
                        
                        echo '<div id="' . $sectionID . '" class="comments-section" style="display: none;">';
                        echo '<h4>Comments and Ratings</h4>';

                        if ($comments !== null && count($comments) > 0) {
                            foreach ($comments as $comment) {
                                echo '<div class="comment post-content">';
                                echo '<p><strong>' . htmlspecialchars($comment['username']) . '</strong> ';
                                echo 'rated <strong>' . htmlspecialchars($comment['rating']) . '/5</strong> ';
                                echo 'on ' . htmlspecialchars(getDateFromDateTime($comment['commentDate'])) . ' by ' . htmlspecialchars($comment['username']) . '</p>';
                                echo '<p>' . nl2br(htmlspecialchars($comment['content'])) . '</p>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p class="post-content">No comments yet.</p>';
                        }

                        // Comment form (if logged in)
                        if (isset($_SESSION['userID'])) {
                            echo '<form method="POST" action="index.php" class="comment-form" style="max-width: 100%; margin-bottom: 40px;">';
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

                        echo '</div>'; // Close comments-section
                        echo '</div>'; // Close comments-wrapper
                        echo '</article>';
                }
            }
                else {
                    echo '<article class="blog-post">';
                    echo '<p>No posts available.</p>';
                    echo '</article>';
                }
                ?>

               <!-- <article class="blog-post">
                    <h3>Arsenal win Big against Real Madrid on Champions League Quarter Finals</h3>
                    <div class="post-content">
                        <p>Arsenal and Madrid, giants of their own leagues played a match last Wednesday on Emirates stadium. The home team bagged a victory against 
                            the Champions League royalty 15 times winning, Real Madrid. It was a 3-0 victory against the Spanish giants. The hero of the game was Declan
                            Rice netting two fabulous free kick goals all within ten minutes intervals by themselves. The game started with Arsenal being the underdogs 
                            between the two team but as the match progressed there was no doubt in anyone mind that Arsenal came to win that day and snagged a wonderful 
                            3 goal victory while keeping a clean sheet.<br/>
                            The win was praised by a lot of pundits who believed that the win was surely in name of Real Madrid. The game was a domination from London giants 
                            They face again soon a week later in Madrid home ground where they have had insane comeback of 4-3 against Manchester City back in 2023. Some fans still
                            believe Madrid have a chance but all that will be displayed on coming Wednesday, 5000 AEST.                     
                        </p>
                    </div>
                    <p>Posted on April 10, 2025 by Anmol Daulyal</p>
                    <p>
                        <span class="tags">Champions League</span>
                        <span class="tags">Football</span>
                        <span class="tags">UCL</span>
                    </p>
                </article>

                <article class="blog-post">
                    <h3>"Daredevil: The Blind Vigilante Who Sees Through the Darkness"</h3>
                    <div class="post-content">
                        <p>Daredevil, aka Matt Murdock, is one of Marvel’s most captivating heroes. Blinded by an accident as a child, Matt's remaining senses are heightened to superhuman levels, allowing him to "see" through sound and touch. By day, he's a lawyer in Hell's Kitchen, fighting for justice in the courtroom; by night, he’s the masked vigilante protecting the streets.

                            What sets Daredevil apart is his raw, gritty approach to crime-fighting—relying on his agility, senses, and martial arts skills instead of high-tech gadgets. His battles, both physical and moral, reflect his deep sense of duty to protect the vulnerable.
                            
                            Despite his blindness, Daredevil’s story is one of resilience and sacrifice. He shows us that true strength often comes from within, proving that even in the darkest places, there’s always room for hope.
                        </p>
                    </div>
                    <p>Posted on April 09, 2025 by Jane Doe</p>
                    <p>
                        <span class="tags">Matt</span>
                        <span class="tags">Daredevil</span>
                        <span class="tags">Marvel</span>
                    </p>
                </article>

                <article class="blog-post">
                    <h3>US and China Tariff-Off</h3>
                    <div class="post-content">
                        <p>President Trump has been on a different war lately. He has been playing Tariff-off with the chinese Prime Minister Xi-Jing Ping. 
                            The war started when president Trump threatened to increase Tariffs on goods all over. Trump had threatened with the Tariffs before he 
                            was elected as the President of The United States of America. When he rose to power he kept his promised and increased the promised Tariffs 
                            on the world. After he imposed on April 9th an announcement was made that he will suspend the Tariff due to positive response from the world leaders
                            but he increased the chinese tariffs to 125% which he stated as,"Disrespect from Beijing.<br/>
                            In Retaliation China also increased the Tariffs by 84% they have now been in this constant state of fight for two weeks now starting from 34% now has grown to 125%. 
                            And the worst part is it looks like a beginning of a very long war which will already affect the strained relationship further between the two big nations of the world.
        
                        </p>
                    </div>
                    <p>Posted on April 08th, 2025 by Dnmol Aulyal</p>
                    <p>
                        <span class="tags">Earum</span>
                        <span class="tags">Quam</span>
                        <span class="tags">Quidem</span>
                    </p>
                </article>
            -->
            </section>
        </main>

        <footer>
            <p>KIT202 Assignment 1 | Everything</p>
        </footer>

        <button id="scrollToTopBtn" title="Go to top">↑</button>


    </body>
</html>