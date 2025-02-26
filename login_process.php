<?php
session_start();

// Include the database connection configuration file
include('db_config.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted username and password
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Check if the username exists in the database
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Fetch user data from the database
        $user = mysqli_fetch_assoc($result);

        // Verify the password using password_hash
        if (password_verify($password, $user['password'])) {
            // Store username and other session data in session variables
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['id']; // You can also store user ID for session-based queries

            // Redirect to the dashboard or home page
            header("Location: index.php");
            exit();
        } else {
            // Invalid password
            echo "<script>alert('Invalid username or password'); window.location.href = 'login.html';</script>";
        }
    } else {
        // User does not exist
        echo "<script>alert('Invalid username or password'); window.location.href = 'login.html';</script>";
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
