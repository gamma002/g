<?php
$videosDir = 'deliveranceise/'; // Folder containing the videos

// Check if the directory exists before scanning
$videoFiles = [];
if (is_dir($videosDir)) {
    $videos = array_diff(scandir($videosDir), array('..', '.')); // Exclude '.' and '..'
    
    $allowedExtensions = ['mp4', 'webm', 'ogg'];

    // Filter video files by extension
    foreach ($videos as $video) {
        $fileExtension = strtolower(pathinfo($video, PATHINFO_EXTENSION));
        if (in_array($fileExtension, $allowedExtensions)) {
            $videoFiles[] = $video;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deliverance Videos - God's Intentions Fellowship</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        /* Navbar Styling */
        .navbar {
            background: linear-gradient(to right, #800000, #f2d0a4);
            border-bottom: 2px solid maroon;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
        .navbar .nav-link {
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            transition: all 0.3s ease-in-out;
        }
        .navbar .nav-link:hover {
            color: #f2d0a4;
            text-shadow: 0px 2px 4px rgba(255, 255, 255, 0.6);
        }

        /* Video Feed Styling */
        .feed-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
        }
        .video-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow: hidden;
        }
        .video-container {
            position: relative;
            width: 100%;
        }
        video {
            width: 100%;
            height: auto;
            display: block;
            border-radius: 12px 12px 0 0;
        }
        .video-details {
            padding: 15px;
        }
        .profile-section {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .username {
            font-weight: bold;
            color: #800000;
        }
        .watch-btn {
            width: 100%;
            text-align: center;
            display: block;
            padding: 10px;
            border-radius: 0 0 12px 12px;
            background: #800000;
            color: white;
            font-weight: bold;
            text-decoration: none;
            transition: 0.3s;
        }
        .watch-btn:hover {
            background: #a52a2a;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="#">God's Intentions Fellowship</a>
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
                <li class="nav-item"><a class="nav-link" href="blogs.php"><i class="fas fa-blog"></i> Blogs</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Deliverance Videos Section -->
<div class="feed-container">
    <h2 class="text-center">Deliverance Videos</h2>
    <p class="text-center">Watch the latest deliverance sessions and testimonies.</p>

    <?php
    if (!empty($videoFiles)) {
        foreach ($videoFiles as $videoFile) {
            $videoUrl = $videosDir . $videoFile;
            ?>
            <div class="video-card">
                <div class="video-container">
                    <video controls autoplay muted loop>
                        <source src="<?= htmlspecialchars($videoUrl) ?>" type="video/<?= strtolower(pathinfo($videoFile, PATHINFO_EXTENSION)) ?>">
                        Your browser does not support the video tag.
                    </video>
                </div>
                <div class="video-details">
                    <div class="profile-section">
                        <img src="profile-placeholder.jpg" class="profile-img" alt="Profile">
                        <span class="username">God's Intentions Fellowship</span>
                    </div>
                    <p>Deliverance session featuring powerful prayers and testimonies.</p>
                </div>
                <a href="<?= htmlspecialchars($videoUrl) ?>" class="watch-btn" target="_blank">Watch Full Video</a>
            </div>
            <?php
        }
    } else {
        echo "<p class='text-center'>No videos available at the moment.</p>";
    }
    ?>
</div>

<!-- Footer -->
<footer class="text-center mt-5" style="background-color: #800000; color: white; padding: 20px;">
    <p>&copy; 2025 God's Intentions Fellowship. All rights reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
