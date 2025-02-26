<?php
session_start();
include('db_config.php');

// Ensure user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $reply_content = mysqli_real_escape_string($conn, $_POST['reply_content']);
        $user_id = $_SESSION['user_id'];
        $query = "INSERT INTO replies (post_id, user_id, content) VALUES ('$post_id', '$user_id', '$reply_content')";
        
        if (mysqli_query($conn, $query)) {
            header("Location: view_post.php?id=$post_id");
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
} else {
    echo "No post ID specified.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reply to Post</title>
</head>
<body>
    <h2>Reply to Post</h2>
    <form method="POST" action="reply_post.php?id=<?php echo $_GET['id']; ?>">
        <label>Reply:</label><br>
        <textarea name="reply_content" rows="4" required></textarea><br><br>
        <button type="submit">Reply</button>
    </form>
</body>
</html>
