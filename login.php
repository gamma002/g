<?php
session_start();

// Check if the user is already logged in and redirect to the dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard1.php"); // Redirect to dashboard if already logged in
    exit();
}

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    include('db_config.php');

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter your username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // If there are no errors, proceed with login validation
    if (empty($username_err) && empty($password_err)) {
        // Prepare a SQL query to fetch user details based on the username
        $sql = "SELECT user_id, username, password, role FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind the username to the prepared statement
            mysqli_stmt_bind_param($stmt, "s", $username);

            // Execute the statement
            if (mysqli_stmt_execute($stmt)) {
                // Store the result so we can check if the username exists
                mysqli_stmt_store_result($stmt);

                // Check if the username exists, then verify the password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $user_id, $username, $hashed_password, $role);
                    if (mysqli_stmt_fetch($stmt)) {
                        // Verify the password
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, start a new session
                            session_start();

                            // Store user data in session variables
                            $_SESSION['user_id'] = $user_id;
                            $_SESSION['username'] = $username;
                            $_SESSION['role'] = $role;

                            // Redirect to dashboard
                            header("Location: dashboard1.php");
                            exit();
                        } else {
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    $username_err = "No account found with that username.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close the prepared statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - God's Intentions Fellowship</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles for login page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 400px;
            padding: 30px;
            background-color: white;
            margin-top: 100px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .btn-primary {
            background-color: #800000;
            border: none;
            width: 100%;
            padding: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Login</h2>
    <p class="text-center">Welcome back! Please login to continue.</p>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
            <span class="invalid-feedback"><?php echo $username_err; ?></span>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
            <span class="invalid-feedback"><?php echo $password_err; ?></span>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>

        <div class="form-group text-center">
            <p>Don't have an account? <a href="signup.php">Sign up</a></p>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
