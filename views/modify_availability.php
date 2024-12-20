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

    // Fetch the current availability details from the database
    $sql = "SELECT * FROM Disponibilites WHERE disponibilite_ID = '$availability_id' AND user_ID = " . $_SESSION['user_id'];
    $result = mysqli_query($conn, $sql);
    $availability = mysqli_fetch_assoc($result);

    // If no availability is found, redirect back to the dashboard
    if (!$availability) {
        header("Location: avocat_dashboard.php");
        exit();
    }
}

// Handle form submission for updating availability
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_date = $_POST['disponibilite_date'];
    $new_status = $_POST['statut'];

    // Update the availability in the database
    $update_sql = "UPDATE Disponibilites SET disponibilite_date = '$new_date', statut = '$new_status' WHERE disponibilite_ID = '$availability_id' AND user_ID = " . $_SESSION['user_id'];
    if (mysqli_query($conn, $update_sql)) {
        header("Location: avocat_dashboard.php");  // Redirect back to the dashboard after successful update
        exit();
    } else {
        echo "Error updating availability: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Availability - Law Office</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">

<!-- Navigation -->
<nav class="flex justify-between items-center py-4 px-8 bg-gray-800">
    <div class="text-lg font-bold">Law Office</div>
    <ul class="flex space-x-4">
        <li><a href="../views/index.php" class="hover:text-gray-400">Home</a></li>
        <li><a href="#about-section" class="hover:text-gray-400">About</a></li>
        <li><a href="../views/client_dashboard.php" class="hover:text-gray-400">Clients</a></li>
        <li><a href="../views/regestration.php" class="hover:text-gray-400">Registration</a></li>
        <li><a href="../views/avocat_dashboard.php" class="hover:text-gray-400">Avocats</a></li>
    </ul>
    <a href="../views/logout.php" class="bg-yellow-500 text-gray-900 px-4 py-2 rounded">Logout</a>
</nav>

<!-- Modify Availability Form -->
<section class="py-16 bg-gray-800">
    <div class="container mx-auto px-4 text-center">
        <div class="mb-12">
            <h2 class="text-4xl font-bold text-yellow-500">Modify Your Availability</h2>
        </div>

        <div class="max-w-lg mx-auto bg-gray-700 p-8 rounded-lg shadow-lg">
            <form method="POST">
                <div class="mb-6">
                    <label for="disponibilite_date" class="text-yellow-500">Availability Date</label>
                    <input type="date" id="disponibilite_date" name="disponibilite_date" value="<?php echo htmlspecialchars($availability['disponibilite_date']); ?>" class="w-full px-4 py-2 bg-gray-600 text-white rounded" required>
                </div>

                <div class="mb-6">
                    <label for="statut" class="text-yellow-500">Status</label>
                    <select id="statut" name="statut" class="w-full px-4 py-2 bg-gray-600 text-white rounded" required>
                        <option value="disponible" <?php echo $availability['statut'] === 'disponible' ? 'selected' : ''; ?>>Available</option>
                        <option value="indisponible" <?php echo $availability['statut'] === 'indisponible' ? 'selected' : ''; ?>>Unavailable</option>
                    </select>
                </div>

                <div>
                    <button type="submit" class="bg-yellow-500 text-gray-900 px-4 py-2 rounded">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</section>

</body>
</html>
