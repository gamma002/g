<?php 
include('db_config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $testimony = mysqli_real_escape_string($conn, $_POST['testimony']);
    $image_paths = [];

    // Ensure the 'images' column exists in the database
    $check_column = mysqli_query($conn, "SHOW COLUMNS FROM testimonies LIKE 'images'");
    if (mysqli_num_rows($check_column) == 0) {
        mysqli_query($conn, "ALTER TABLE testimonies ADD COLUMN images TEXT");
    }

    // Check if files are uploaded and process them
    if (!empty($_FILES['images']['name'][0])) {
        $target_dir = "uploads/";
        
        // Loop through each file and upload
        for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
            if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                $target_file = $target_dir . basename($_FILES["images"]["name"][$i]);
                move_uploaded_file($_FILES["images"]["tmp_name"][$i], $target_file);
                $image_paths[] = $target_file; // Store the image path
            }
        }
    }

    // Convert the image paths array to a comma-separated string or set it to NULL if empty
    $image_paths_str = !empty($image_paths) ? implode(',', $image_paths) : NULL;

    // Insert testimony into the database
    $sql = "INSERT INTO testimonies (name, testimony, images) VALUES ('$name', '$testimony', " . ($image_paths_str ? "'$image_paths_str'" : "NULL") . ")";
    if (mysqli_query($conn, $sql)) {
        header('Location: testimonies.php');
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
