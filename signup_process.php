<?php
// Include the database connection configuration
include('db_config.php');

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Retrieve the form data and sanitize inputs to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    
    // Validate the data
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        echo "All fields are required.";
        exit();
    }
    
    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        exit();
    }
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit();
    }

    // Hash the password for secure storage
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if the username or email already exists in the database
    $check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        echo "Username or email already taken.";
        exit();
    }

    // Insert the new user into the database
    $insert_query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
    
    if (mysqli_query($conn, $insert_query)) {
        // Redirect to the login page upon successful registration
        header('Location: login.html');
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    
    // Close the database connection
    mysqli_close($conn);
}
?>
