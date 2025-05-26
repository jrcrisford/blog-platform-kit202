<?php
include_once 'db_connect.php';
session_start();
$posts = getPosts(3,3);

if (empty($posts)){
    echo '<article class="blog-post">';
    echo '<p>No older posts available.</p>';
    echo '</article>';
} else {
    foreach ($posts as $post) {
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