<?php 
session_start();
include('db_config.php');

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Get user role
$user_role = $_SESSION['role']; // 'admin' or 'member'

// Fetch posts from multiple tables (testimonies, blogs, events)
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
    FROM testimonies)
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
    FROM blogs)
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
    FROM events)
    ORDER BY created_at DESC
";

// Check for query errors
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Error in query: " . mysqli_error($conn));
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
                    <li class="nav-item"><a class="nav-link" href="index.html"><i class="fas fa-home"></i> Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about_us.html"><i class="fas fa-info-circle"></i> About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="sermons.php"><i class="fas fa-bible"></i> Sermons</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.html"><i class="fas fa-envelope"></i> Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="testimonies.php"><i class="fas fa-quote-left"></i> Testimonies</a></li>
                    <li class="nav-item"><a class="nav-link" href="prophecies.html"><i class="fas fa-lightbulb"></i> Prophecies</a></li>
                    <li class="nav-item"><a class="nav-link" href="blogs.html"><i class="fas fa-blog"></i> Blogs</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="container mt-5">
    <h2><i class="fas fa-pen-square"></i> Posts</h2>
    
    <?php if ($user_role == 'admin') { ?>
        <div class="mb-4">
            <a href="create_post.php" class="btn btn-primary">Create New Post</a>
            <a href="go_live.php" class="btn btn-success">Go Live</a>
        </div>
    <?php } ?>
    
    <div class="list-group">
        <?php while ($post = mysqli_fetch_assoc($result)) { ?>
            <div class="list-group-item">
                <h5 class="mb-2"><?php echo htmlspecialchars($post['title']); ?></h5>
                <p class="mb-2">
                    <?php 
                    if ($post['post_type'] == 'testimony') {
                        echo htmlspecialchars($post['content']);
                    } elseif ($post['post_type'] == 'blog') {
                        echo htmlspecialchars($post['content']);
                    } else {
                        echo htmlspecialchars($post['content']);
                    }
                    ?>
                </p>
                <p><small>Posted on <?php echo $post['created_at']; ?> by <?php echo htmlspecialchars($post['author']); ?></small></p>

                <!-- For users -->
                <?php if ($user_role == 'member') { ?>
                    <a href="like_post.php?id=<?php echo $post['post_id']; ?>" class="btn btn-outline-primary btn-sm">Like</a>
                <?php } ?>

                <!-- Admin actions -->
                <?php if ($user_role == 'admin') { ?>
                    <a href="reply_post.php?id=<?php echo $post['post_id']; ?>" class="btn btn-outline-warning btn-sm">Reply</a>
                <?php } ?>

                <a href="view_post.php?id=<?php echo $post['post_id']; ?>" class="btn btn-outline-secondary btn-sm">View</a>
            </div>
        <?php } ?>
    </div>
</div>

<footer>
    <p>&copy; 2025 God's Intentions Fellowship. All rights reserved.</p>
    <p>
        Follow us:
        <a href="https://facebook.com"><i class="fab fa-facebook"></i> Facebook</a> |
        <a href="https://twitter.com"><i class="fab fa-twitter"></i> Twitter</a> |
        <a href="https://instagram.com"><i class="fab fa-instagram"></i> Instagram</a>
    </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
