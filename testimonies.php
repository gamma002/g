<?php
// Start the session to manage user authentication and admin checks
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimonies - God's Intentions Fellowship</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .testimony-card {
            margin-bottom: 20px;
            border: 1px solid #e1e8ed;
            border-radius: 15px;
            padding: 20px;
            background-color: #f7f7f7;
        }

        .profile-icon {
            font-size: 30px;
            color: #800000;
        }

        .testimony-header {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .testimony-header .username {
            font-weight: bold;
        }

        .testimony-header .date {
            color: #657786;
            font-size: 0.85rem;
        }

        .testimony-content {
            margin-top: 10px;
            font-size: 1rem;
        }

        .testimony-image {
            margin-top: 15px;
            max-width: 100%;
            border-radius: 8px;
        }

        .actions {
            margin-top: 15px;
            font-size: 0.9rem;
        }

        .actions .btn {
            background-color: #1da1f2;
            color: white;
            border: none;
        }

        .actions .btn:hover {
            background-color: #0d8fd6;
        }

        .form-container {
            margin-top: 40px;
            background-color: #f7f7f7;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-container label {
            font-weight: bold;
        }

        .form-container input,
        .form-container textarea {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #800000;">
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

    <!-- Testimonies Content -->
    <div class="container mt-5">
        <h2>Testimonies</h2>
        <p>Read some of the wonderful testimonies from our congregation.</p>
        
        <?php
        include('db_config.php');

        // Query to get all testimonies
        $sql = "SELECT * FROM testimonies ORDER BY created_at DESC"; // Order by most recent first
        $result = mysqli_query($conn, $sql);

        // Check if there are any testimonies
        if (mysqli_num_rows($result) > 0) {
            // Loop through each testimony and display it
            while ($row = mysqli_fetch_assoc($result)) {
                $name = htmlspecialchars($row['name']);
                $testimony = htmlspecialchars($row['testimony']);
                $profile_image = 'fas fa-user'; // FontAwesome icon for profile
                $created_at = date("F j, Y", strtotime($row['created_at']));
                $image_path = $row['image_url'] ? $row['image_url'] : ''; // Get the uploaded image (if any)

                echo '
                <div class="testimony-card">
                    <div class="testimony-header">
                        <i class="' . $profile_image . ' profile-icon"></i>
                        <div>
                            <p class="username">' . $name . '</p>
                            <p class="date">' . $created_at . '</p>
                        </div>
                    </div>
                    <div class="testimony-content">
                        <p>' . nl2br($testimony) . '</p>
                    </div>';

                // If there's an uploaded image, display it like a Facebook post
                if (!empty($image_path)) {
                    echo '<img src="' . $image_path . '" class="testimony-image" alt="Testimony Image">';
                }

                // Admin can reply, others can only like/comment
                if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                    echo '
                    <div class="actions">
                        <button class="btn btn-sm">Reply</button>
                    </div>';
                } else {
                    echo '
                    <div class="actions">
                        <button class="btn btn-sm">Like</button>
                        <button class="btn btn-sm">Comment</button>
                    </div>';
                }

                echo '</div>';
            }
        } else {
            echo '<p>No testimonies found.</p>';
        }

        // Close the database connection
        mysqli_close($conn);
        ?>
    </div>

    <!-- Form to Submit Testimony -->
    <div class="form-container">
        <h3>Share Your Testimony</h3>
        <form action="submit_testimony.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Your Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="testimony" class="form-label">Testimony</label>
                <textarea class="form-control" id="testimony" name="testimony" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="images" class="form-label">Upload Images (Optional)</label>
                <input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple>
            </div>
            <button type="submit" class="btn btn-primary">Submit Testimony</button>
        </form>
    </div>

    <!-- Footer -->
    <footer class="text-center mt-5" style="background-color: #800000; color: white; padding: 20px;">
        <p>&copy; 2025 God's Intentions Fellowship. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
