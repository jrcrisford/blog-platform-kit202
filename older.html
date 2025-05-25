<?php
    include_once 'db_connect.php';
    session_start();
    $posts = getPosts(3,3);
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
        <script src="javascript/content_toggle.js" defer></script>
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
                        <li><a href="index.php">Homepage</a></li>
                        <li><a href="older.php" class="active">Older Posts</a></li>
                        <li><a href="write.html">Write Post</a></li>
                        <li><a href="login.html">Login</a></li>
                        <li><a href="our_story.html">Our Story</a></li>
                        
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
            
            <!-- Page Title -->
             <section class ="page-header">
                <h2>Older Posts</h2>
                <p> Here are some of the older posts.</p>
             </section>

            <?php
                if (empty($posts)){
                    echo '<article class="blog-post">';
                    echo '<p>No older posts available.</p>';
                    echo '</article>';
                } else {
                    foreach ($posts as $post){
                        echo '<article class="blog-post">';
                        echo '<h3>' . htmlspecialchars($post['title']) . '</h3>';
                        echo '<button class="toggle-content-btn" onclick="toggleContent(this)">Show Content</button>';
                        echo '<div class="post-content hidden">';
                        echo'<p>' . htmlspecialchars($post['content']) . '</p>';
                        echo '</div>';
                        echo '<p>Posted on' . htmlspecialchars($post['postDate']) . ' by ' . htmlspecialchars($post['author']) . '</p>';
                        echo '<p>';
                            foreach (explode(',', $post['tags']) as $tag){
                                    echo '<span class="tags">' . htmlspecialchars(trim($tag)) . '</span> ';
                                }
                        echo '</p>';
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