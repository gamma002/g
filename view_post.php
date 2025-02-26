<?php
// Start the session at the very beginning of the file
session_start();
include('db_config.php');

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>God's Intentions Fellowship - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: white; /* White background */
            color: maroon; /* Maroon text color */
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        /* Navbar Custom Styles */
        .navbar {
            background: linear-gradient(to right, #800000, #f2d0a4); /* Maroon to light beige gradient */
            border-bottom: 2px solid maroon;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
        .navbar .navbar-nav .nav-link {
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease-in-out;
        }
        .navbar .navbar-nav .nav-link:hover {
            color: #f2d0a4; /* Light beige color on hover */
            text-shadow: 0px 2px 4px rgba(255, 255, 255, 0.6);
            transform: scale(1.1);
        }
        .navbar .navbar-nav .nav-link i {
            margin-right: 5px; /* Add spacing between icons and text */
        }
        .navbar-toggler {
            border: none;
            background-color: #800000; /* Maroon background for toggle button */
            color: white;
        }
        .navbar-toggler-icon {
            color: white;
        }

        /* Header Styles */
        header {
            background: linear-gradient(to right, #800000, #f2d0a4); /* Maroon to light beige gradient */
            color: white;
            padding: 40px 20px;
            text-align: center;
            animation: fadeInDown 1.5s ease-in-out;
        }

        header h1 {
            font-size: 3rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.6);
            animation: fadeInDown 2s ease-in-out;
        }

        header p {
            font-size: 1.2rem;
            margin-top: 10px;
            font-style: italic;
            animation: fadeInDown 2.5s ease-in-out;
        }

        /* Hero Section Styling */
        .hero {
            background: url('main_1.jpg') no-repeat center center/cover;
            color: maroon;
            text-align: center;
            padding: 100px 20px;
            position: relative;
            overflow: hidden;
            height: 100vh; /* Make the height 100% of the viewport height */
            background-size: cover;
            background-position: center;
            animation: fadeInUp 2s ease-in-out;
        }
        
        .hero h1, .hero p, .hero a {
            animation: fadeInUp 1.5s ease-in-out;
            position: relative;
            left: 110px; /* Move the text 20px to the right */
        }

        .hero a {
            animation: bounce 2s infinite;
            background-color: maroon;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            font-size: 1.2rem;
            transition: all 0.3s ease-in-out;
        }

        .hero a:hover {
            background-color: white;
            color: maroon;
            border: 2px solid maroon;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
        }

        /* Media Queries for Responsive Design */
        @media (max-width: 768px) {
            header h1 {
                font-size: 2.5rem;
            }
            header p {
                font-size: 1rem;
            }
            .hero h1 {
                font-size: 2rem;
            }
            .hero p {
                font-size: 1rem;
            }
            .hero a {
                padding: 12px 25px;
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            header h1 {
                font-size: 1.8rem;
            }
            header p {
                font-size: 1rem;
            }
            .hero {
                padding: 60px 20px;
                height: 60vh; /* Decrease height on smaller screens */
            }
            .hero h1 {
                font-size: 1.5rem;
            }
            .hero p {
                font-size: 1rem;
            }
            .hero a {
                padding: 10px 20px;
                font-size: 1rem;
            }
        }

        /* Container Section */
        .container h2 {
            border-bottom: 2px solid maroon;
            padding-bottom: 10px;
            animation: slideIn 1.5s ease-in-out;
        }

        .container p {
            line-height: 1.6;
            margin-top: 10px;
            animation: fadeInUp 1.5s ease-in-out;
        }

        /* Footer Styles */
        footer {
            background: maroon;
            color: white;
            text-align: center;
            padding: 20px;
            animation: fadeIn 2s ease-in-out;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li::before {
            content: "• ";
            color: maroon;
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-15px);
            }
            60% {
                transform: translateY(-8px);
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
<header>
    <img src="logo.jpg" alt="Logo">
    <h1>Welcome to God's Intentions Fellowship</h1>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: #800000;">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="dashboard1.php"><i class="fas fa-home"></i> Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about_us.html"><i class="fas fa-info-circle"></i> About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="sermons.html"><i class="fas fa-bible"></i> Sermons</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.html"><i class="fas fa-envelope"></i> Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="testimonies.php"><i class="fas fa-quote-left"></i> Testimonies</a></li>
                    <li class="nav-item"><a class="nav-link" href="prophecies.html"><i class="fas fa-lightbulb"></i> Prophecies</a></li>
                    <li class="nav-item"><a class="nav-link" href="blogs.html"><i class="fas fa-blog"></i> Blogs</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<?php
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    // Fetch post details from multiple tables (testimonies, blogs, events)
    $query = "
        (SELECT 
            'testimony' AS post_type, 
            testimony_id AS post_id, 
            title, 
            content, 
            created_at, 
            name AS author, 
            image_url, 
            profile_image, 
            testimony AS additional_content 
        FROM testimonies
        WHERE testimony_id = '$post_id')
        UNION
        (SELECT 
            'blog' AS post_type, 
            blog_id AS post_id, 
            title, 
            content, 
            created_at, 
            'Admin' AS author, 
            image_url, 
            NULL AS profile_image, 
            NULL AS additional_content 
        FROM blogs
        WHERE blog_id = '$post_id')
        UNION
        (SELECT 
            'event' AS post_type, 
            event_id AS post_id, 
            title, 
            description AS content, 
            created_at, 
            'Event Organizer' AS author, 
            NULL AS image_url, 
            NULL AS profile_image, 
            NULL AS additional_content 
        FROM events
        WHERE event_id = '$post_id')
        ORDER BY created_at DESC
    ";

    $result = mysqli_query($conn, $query);
    
    if ($post = mysqli_fetch_assoc($result)) {
        // Display post details
        echo "<h2>" . htmlspecialchars($post['title']) . "</h2>";
        echo "<p><strong>By: </strong>" . htmlspecialchars($post['author']) . " <strong>Created At:</strong> " . $post['created_at'] . "</p>";
        echo "<p>" . nl2br(htmlspecialchars($post['content'])) . "</p>";

        // If the post is a testimony, show the additional content (testimony)
        if ($post['post_type'] == 'testimony') {
            echo "<p><strong>Testimony:</strong> " . nl2br(htmlspecialchars($post['additional_content'])) . "</p>";
        }

        // If there's an image URL, display it
        if ($post['image_url']) {
            echo "<img src='" . htmlspecialchars($post['image_url']) . "' alt='Post Image'><br><br>";
        }

        // If the post is a testimony, display the profile image
        if ($post['post_type'] == 'testimony' && $post['profile_image']) {
            echo "<img src='" . htmlspecialchars($post['profile_image']) . "' alt='Profile Image'><br><br>";
        }
        
        // Display replies if any
        $reply_query = "SELECT r.*, u.username FROM replies r LEFT JOIN users u ON r.user_id = u.user_id WHERE r.post_id = '$post_id' ORDER BY r.created_at DESC";
        $replies_result = mysqli_query($conn, $reply_query);

        if (mysqli_num_rows($replies_result) > 0) {
            echo "<h3>Replies:</h3>";
            while ($reply = mysqli_fetch_assoc($replies_result)) {
                echo "<p><strong>" . htmlspecialchars($reply['username']) . ":</strong> " . nl2br(htmlspecialchars($reply['content'])) . " <strong>Posted on:</strong> " . $reply['created_at'] . "</p>";
            }
        } else {
            echo "<p>No replies yet.</p>";
        }
    } else {
        echo "Post not found.";
    }
}
?>

<footer>
    <p>&copy; 2025 God's Intentions Fellowship. All rights reserved.</p>
    <p>
        Follow us:
        <a href="https://facebook.com"><i class="fab fa-facebook"></i> Facebook</a> |
        <a href="https://twitter.com"><i class="fab fa-twitter"></i> Twitter</a> |
        <a href="https
