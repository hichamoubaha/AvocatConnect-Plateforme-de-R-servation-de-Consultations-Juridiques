<?php
session_start();
include('db.php');

// Check if the user is logged in and has the 'avocat' role
if ($_SESSION['role'] != 'avocat') {
    header("Location: login.php");
    exit();
}

// Get the availability ID from the URL
if (isset($_GET['id'])) {
    $availability_id = $_GET['id'];

    // Delete the availability from the database
    $delete_sql = "DELETE FROM Disponibilites WHERE disponibilite_ID = '$availability_id' AND user_ID = " . $_SESSION['user_id'];
    if (mysqli_query($conn, $delete_sql)) {
        header("Location: avocat_dashboard.php");  // Redirect back to the dashboard after successful deletion
        exit();
    } else {
        echo "Error deleting availability: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
