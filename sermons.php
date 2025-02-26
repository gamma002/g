<?php  
// Define the path to the uploaded videos folder
$videosDir = 'uploaded_videos/';

// Get all video files
$videos = array_diff(scandir($videosDir), array('..', '.'));

// Allowed video formats
$allowedExtensions = ['mp4', 'webm', 'ogg','MOV'];
$videoFiles = [];

// Filter valid video files
foreach ($videos as $video) {
    $fileExtension = strtolower(pathinfo($video, PATHINFO_EXTENSION));
    if (in_array($fileExtension, $allowedExtensions)) {
        $videoFiles[] = $video;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sermons - God's Intentions Fellowship</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: white;
            color: maroon;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        .navbar {
            background: linear-gradient(to right, #800000, #f2d0a4);
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
            color: #f2d0a4;
            text-shadow: 0px 2px 4px rgba(255, 255, 255, 0.6);
            transform: scale(1.1);
        }
        .container h2 {
            border-bottom: 2px solid maroon;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .video-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .video-card {
            width: 100%;
            max-width: 350px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }
        video {
            width: 100%;
            height: auto;
        }
        .card-body {
            padding: 10px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">God's Intentions Fellowship</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about_us.html">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="sermons.html">Sermons</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="testimonies.php">Testimonies</a></li>
                    <li class="nav-item"><a class="nav-link" href="prophecies.html">Prophecies</a></li>
                    <li class="nav-item"><a class="nav-link" href="blogs.html">Blogs</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Sermons</h2>
        <p>Explore our powerful sermons and grow in your faith.</p>

        <div class="video-container">
            <?php if (!empty($videoFiles)) {
                foreach ($videoFiles as $videoFile) {
                    $videoUrl = $videosDir . htmlspecialchars($videoFile);
            ?>
            <div class="video-card">
                <video controls preload="metadata">
                    <source src="<?= $videoUrl ?>" type="video/<?= strtolower(pathinfo($videoFile, PATHINFO_EXTENSION)) ?>">
                    Your browser does not support the video tag.
                </video>
                <div class="card-body">
                    <h5 class="card-title"> <?= htmlspecialchars(pathinfo($videoFile, PATHINFO_FILENAME)) ?> </h5>
                    <p class="card-text">Click below to watch the sermon.</p>
                    <a href="<?= $videoUrl ?>" class="btn btn-primary" target="_blank">Watch Now</a>
                </div>
            </div>
            <?php } 
            } else {
                echo "<p>No sermons available at the moment.</p>";
            } ?>
        </div>
    </div>

    <footer class="text-center mt-5" style="background-color: #800000; color: white; padding: 20px;">
        <p>&copy; 2025 God's Intentions Fellowship. All rights reserved.</p>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
