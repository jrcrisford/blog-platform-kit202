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

    //Get user by ID
    function getUserByID($userID) {
        $conn = connect();
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
        disconnect($conn);
        return $user;
    }

    // Get user by Username
    function getUserByUsername($username) {
        $conn = connect();
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
        disconnect($conn);
        return $user;
    }

    //Get user by email
    function getUserByEmail($email) {
        $conn = connect();
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
        disconnect($conn);
        return $user;
    }

    // Get posts
    function getPosts($limit) {
        $conn = connect();
        $sql = "SELECT * FROM `Post` ORDER BY `postDate` DESC LIMIT ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $posts = $result->fetch_all(MYSQLI_ASSOC);

        // Get the author name for each post
        foreach ($posts as &$post) {
        // Check if userID exists and is not empty
        if (isset($post['userID']) && !empty($post['userID'])) {
            $authorID = $post['userID'];
            $author = getUserByID($authorID);
            // Check if author was found
            if ($author && isset($author['username'])) {
                $post['author'] = $author['username'];
            } else {
                $post['author'] = 'Unknown Author';
            }
        } else {
            $post['author'] = 'Unknown Author';
        }
    }

        // Get the tags for each post
        foreach ($posts as &$post) {
        if (isset($post['postID']) && !empty($post['postID'])) {
            $tags = getPostTagsByID($post['postID']);
            $tagNames = [];
            foreach ($tags as $tag) {
                if (isset($tag['tagID']) && !empty($tag['tagID'])) {
                    $tagDetails = getTagByID($tag['tagID']);
                    if ($tagDetails && isset($tagDetails['name'])) {
                        $tagNames[] = $tagDetails['name'];
                    }
                }
            }
            $post['tags'] = implode(', ', $tagNames);
        } else {
            $post['tags'] = '';
        }
    }

        $stmt->close();
        disconnect($conn);
        return $posts;
    }

    function getPostTagsByID($postID) {
        $conn = connect();
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
        disconnect($conn);
        return $tags;
    }

    function getTagByID($tagID) {
        $conn = connect();
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
        disconnect($conn);
        return $tag;
    }

    function disconnect($conn) {
        $conn->close();
    }