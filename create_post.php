<?php
session_start();
include('db_config.php');

// Ensure user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_type = $_POST['post_type'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $author = $_SESSION['user_id'];
    $image_url = $_POST['image_url'] ?? NULL; // Optional field
    $additional_content = isset($_POST['additional_content']) ? mysqli_real_escape_string($conn, $_POST['additional_content']) : NULL;

    if ($post_type == 'testimony') {
        $profile_image = $_POST['profile_image'] ?? NULL; // Optional field
        $query = "INSERT INTO testimonies (user_id, title, content, image_url, name, profile_image, testimony) 
                  VALUES ('$author', '$title', '$content', '$image_url', 'Admin', '$profile_image', '$additional_content')";
    } elseif ($post_type == 'blog') {
        $query = "INSERT INTO blogs (title, content, image_url, author_id) 
                  VALUES ('$title', '$content', '$image_url', '$author')";
    } elseif ($post_type == 'event') {
        $event_date = $_POST['event_date'];
        $location = mysqli_real_escape_string($conn, $_POST['location']);
        $query = "INSERT INTO events (title, description, event_date, location) 
                  VALUES ('$title', '$content', '$event_date', '$location')";
    }

    if (mysqli_query($conn, $query)) {
        header("Location: dashboard1.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Post</title>
</head>
<body>
    <h2>Create a New Post</h2>
    <form method="POST" action="create_post.php">
        <label>Post Type:</label>
        <select name="post_type" required>
            <option value="testimony">Testimony</option>
            <option value="blog">Blog</option>
            <option value="event">Event</option>
        </select><br><br>

        <label>Title:</label>
        <input type="text" name="title" required><br><br>

        <label>Content:</label>
        <textarea name="content" rows="4" required></textarea><br><br>

        <div id="additional_fields"></div>

        <label>Image URL:</label>
        <input type="text" name="image_url"><br><br>

        <button type="submit">Create Post</button>
    </form>

    <script>
        document.querySelector('select[name="post_type"]').addEventListener('change', function() {
            var additionalFields = document.getElementById('additional_fields');
            additionalFields.innerHTML = '';

            if (this.value === 'testimony') {
                additionalFields.innerHTML = '<label>Profile Image URL:</label><input type="text" name="profile_image"><br><br>' +
                                             '<label>Testimony:</label><textarea name="additional_content" rows="4"></textarea><br><br>';
            } else if (this.value === 'event') {
                additionalFields.innerHTML = '<label>Event Date:</label><input type="datetime-local" name="event_date" required><br><br>' +
                                             '<label>Location:</label><input type="text" name="location" required><br><br>';
            }
        });
    </script>
</body>
</html>
