<?php
session_start();
include('db_config.php');

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $testimony_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Insert the like into the database (you may want a table for likes to store user_id and post_id)
    $query = "INSERT INTO likes (user_id, testimony_id) VALUES ('$user_id', '$testimony_id')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: dashboard1.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
