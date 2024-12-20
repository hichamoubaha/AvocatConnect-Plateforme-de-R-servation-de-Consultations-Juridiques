<?php
session_start();
include('db.php');

// Check if the user is logged in and has the 'client' role
if ($_SESSION['role'] != 'client') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['avocat_id']) && isset($_GET['disponibilite_id'])) {
    $client_id = $_SESSION['user_id']; // Assuming the client's user ID is stored in the session
    $avocat_id = $_GET['avocat_id'];
    $disponibilite_id = $_GET['disponibilite_id'];
    $reservation_date = date('Y-m-d H:i:s');
    $statut = 'en attente';

    // Insert reservation into the Reservations table
    $insert_sql = "INSERT INTO Reservations (user_ID, disponibilite_ID, reservation_date, statut)
                   VALUES ('$client_id', '$disponibilite_id', '$reservation_date', '$statut')";

    if (mysqli_query($conn, $insert_sql)) {
        // Update the availability status to 'reserve'
        $update_sql = "UPDATE Disponibilites SET statut = 'reserve' WHERE disponibilite_ID = '$disponibilite_id'";
        mysqli_query($conn, $update_sql);

        header("Location: client_dashboard.php?message=Reservation successful");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: client_dashboard.php?message=Invalid request");
}

mysqli_close($conn);
?>
