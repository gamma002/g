<?php
include('db_config.php'); // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $testimony = mysqli_real_escape_string($conn, $_POST['testimony']);
    
    // Handle image upload
    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = $_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imagePath = 'uploads/' . basename($imageName);

        // Move the uploaded image to the 'uploads' directory
        if (!move_uploaded_file($imageTmpName, $imagePath)) {
            echo "Failed to upload image.";
            exit();
        }
    }

    // Insert testimony into database
    $sql = "INSERT INTO testimonies (name, testimony, profile_image) 
            VALUES ('$name', '$testimony', '$imagePath')";

    if (mysqli_query($conn, $sql)) {
        header("Location: testimonies.html"); // Redirect to testimonies page after submission
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close database connection
    mysqli_close($conn);
}
?>
