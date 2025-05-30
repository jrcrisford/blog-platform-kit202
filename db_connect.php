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

    function getDateFromDateTime($dateTime) {
        // Convert datetime to date
        $date = new DateTime($dateTime);
        return $date->format('Y-m-d');
    }

    // Create a new user
    function insertUser($conn, $username, $email, $password) {
        $conn = connect();
        //Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user into the database
        $stmt = $conn->prepare("INSERT INTO `User` (username, email, passwordHash, role) VALUES (?, ?, ?, 'member')");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("sss", $username, $email, $hashedPassword);
       return $stmt->execute();
    }

    //Get user by ID
    function getUserByID($conn, $userID) {
        $user = null;
        $sql = "SELECT username FROM `User` WHERE userID = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }

    // Get user by Username
    function getUserByUsername($conn, $username) {
        $sql = "SELECT * FROM `User` WHERE username = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }


    //Get user by email
    function getUserByEmail($conn, $email) {
        $sql = "SELECT * FROM `User` WHERE email = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }

    //Insert a new post
    function insertPost($conn, $title, $content, $tags) {
        $success = false;
        $userID = intval($_SESSION['userID']);
        // Insert new post into the database
        $stmt = $conn->prepare("INSERT INTO `Post` (userID, title, content) VALUES (?, ?, ?)");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("iss", $userID, $title, $content);
        if($stmt->execute()) {
            $postID = $stmt->insert_id;
            // Insert tags if provided
            $tags = array_map('trim', explode(',', $tags));
            if (!empty($tags)) {
                foreach ($tags as $tagName) {
                    // Check if tag exists, if not create it
                    $tag = getTagByName($conn, $tagName);
                    if (!$tag) {
                        $tagID = createTag($conn, $tagName);
                    } else {
                        $tagID = $tag['tagID'];
                    }
                    // Insert into PostTag table
                    $tagSuccess = createPostTag($conn, $postID, $tagID);
                    }
                }
            $success = true;
        }
        $stmt->close();
        return $success;
    }

    // Get posts given limit and offset
    function getPosts($conn, $limit, $offset) {
        $sql = "SELECT p.*, u.username AS author, GROUP_CONCAT(t.name SEPARATOR ', ') AS tags
        FROM `Post` p
        JOIN `User` u ON p.userID = u.userID
        LEFT JOIN `PostTag` pt ON p.postID = pt.postID
        LEFT JOIN `Tag` t ON pt.tagID = t.tagID
        GROUP BY p.postID
        ORDER BY p.postDate DESC
        LIMIT ? OFFSET ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        $posts = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $posts;
    }
    
    // Create a new tag
    function createTag($conn, $name) {
        $insert_id = null;
        $name = trim($name);
        $stmt = $conn->prepare("INSERT INTO `Tag` (name) VALUES (?)");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("s", $name);
        if ($stmt->execute()) {
            $insert_id = $stmt->insert_id;
        } else {
            die("Execute failed: " . $stmt->error);
        }

        $stmt->close();
        
        return $insert_id;
    }

    function createPostTag($conn, $postID, $tagID) {
        $success = false;
        $stmt = $conn->prepare("INSERT INTO `PostTag` (postID, tagID) VALUES (?, ?)");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("ii", $postID, $tagID);
        if ($stmt->execute()) {
            $success = true;
        }
        $stmt->close();
        return $success;
    }

    function getPostTagsByID($conn, $postID) {
        $sql = "SELECT * FROM `PostTag` WHERE postID = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("i", $postID);
        $stmt->execute();
        $result = $stmt->get_result();
        $tags = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $tags;
    }

    // Get tag by name
    function getTagByName($conn, $name) {
        $name = trim($name);
        $sql = "SELECT * FROM `Tag` WHERE name = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        $tag = $result->fetch_assoc();
        $stmt->close();
        return $tag;
    }

    function getTagByID($conn, $tagID) {
        $sql = "SELECT * FROM `Tag` WHERE tagID = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("i", $tagID);
        $stmt->execute();
        $result = $stmt->get_result();
        $tag = $result->fetch_assoc();
        $stmt->close();
        return $tag;
    }

    // Search posts by title and content 
    function searchPosts($conn, $searchTerm) {
        $likeSearchTerm = '%' . $searchTerm . '%';
        $sql = "SELECT p.*, u.username AS author, GROUP_CONCAT(t.name SEPARATOR ', ') AS tags
                FROM `Post` p
                JOIN `User` u ON p.userID = u.userID
                LEFT JOIN `PostTag` pt ON p.postID = pt.postID
                LEFT JOIN `Tag` t ON pt.tagID = t.tagID
                WHERE p.title LIKE ? OR t.name LIKE ?
                GROUP BY p.postID
                ORDER BY p.postDate DESC";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Failed to prepare statement: " . $conn->error);
        }

        $stmt->bind_param("ss", $likeSearchTerm, $likeSearchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
        $posts = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $posts;
    }

    function insertComment($conn, $userID, $postID, $comment){
        $success = false;
        // Insert comment 
        $stmt = $conn->prepare("INSERT INTO `Comment` (userID, postID, content) VALUES (?, ?, ?)");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("iis", $userID, $postID, $comment);
        if ($stmt->execute()) {
            $success = true;
        }
        $stmt->close();
        return $success;
    }

    function insertRating($conn, $userID, $postID, $rating){
        $success = false;
        // Update post rating
        $existingRating = getRatingByPostIDAndUserID($conn, $postID, $userID);
        if ($existingRating != null){
            return $success; // If user already rated the post
        }
        $stmt = $conn->prepare("INSERT INTO `Rating`(userID, postID, value) VALUES (?, ?, ?)");
        if (!$stmt) {
            die("Prepare Failed: " . $conn->error);
        }
        $stmt->bind_param("iii", $userID, $postID, $rating);
        if ($stmt->execute()) {
            $success = true;
        }
        $stmt->close();
        return $success;
    }

    function getRatingByPostIDAndUserID($conn, $postID, $userID ) {
        $rating = null;
        $sql = "SELECT value FROM `Rating` WHERE postID = ? AND userID = ?";
         $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("ii", $postID, $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $rating = $result->fetch_assoc();
        }
        $stmt->close();
        return $rating;
    }

    function getCommentsAndRatingsByPostID($conn, $postID){
        $sql = "SELECT 
                    u.username AS username,
                    c.commentDate,
                    c.content,
                    r.value
                FROM `Comment` c
                JOIN `User` u ON c.userID = u.userID
                LEFT JOIN `Rating` r ON r.userID = c.userID AND r.postID = c.postID
                WHERE c.postID = ?
                ORDER BY c.commentDate DESC";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("i", $postID);
        $stmt->execute();
        $result = $stmt->get_result();
        $CommentsAndRating = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $CommentsAndRating;
    }
    
    function disconnect($conn) {
        $conn->close();
    }
