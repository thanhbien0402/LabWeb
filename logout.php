<?php
session_start(); // Start the session.

// Check if the user is logged in
if (isset($_SESSION['userID'])) {
    // Unset and destroy the session to log the user out
    session_unset();
    session_destroy();
}

// Redirect the user to the homepage or any other desired location
header('Location: index.php?page=login');
exit();
?>
