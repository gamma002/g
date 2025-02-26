<?php
session_start();
session_unset(); // Clear the session
session_destroy(); // Destroy the session

header("Location: index.html"); // Redirect to the login page
exit();
?>
