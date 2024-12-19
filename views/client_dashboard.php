<?php
session_start();
include('db.php');

// Check if the user is logged in and has the 'client' role
if ($_SESSION['role'] != 'client') {
    header("Location: login.php");
    exit();
}

// Query to get all avocat profiles
$sql = "SELECT * FROM Users WHERE role = 'avocat'";
$avocats = mysqli_query($conn, $sql);

// Get the current user's information
$user_id = $_SESSION['user_id'];
$user_sql = "SELECT * FROM Users WHERE User_ID = '$user_id'";
$user_result = mysqli_query($conn, $user_sql);
$user_info = mysqli_fetch_assoc($user_result);

// Get the user's reservations (if any)
$reservation_sql = "SELECT * FROM Reservations WHERE user_id = '$user_id'";
$reservations = mysqli_query($conn, $reservation_sql);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard - Law Office</title>
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
    <a href="../views/login.php" class="bg-yellow-500 text-gray-900 px-4 py-2 rounded">Login</a>
</nav>

<!-- User Info Section -->
<section class="py-16 bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-yellow-500">Welcome, <?php echo htmlspecialchars($user_info['nom'] . ' ' . $user_info['prenom']); ?>!</h2>
            <p class="mt-4 text-gray-300">Your personal information and reservation history.</p>
        </div>

        <div class="max-w-lg mx-auto bg-gray-700 p-8 rounded-lg">
            <h3 class="text-2xl font-bold text-yellow-500 mb-6">Your Personal Information</h3>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user_info['Email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($user_info['telephone']); ?></p>
            <p><strong>role</strong> <?php echo htmlspecialchars($user_info['role']); ?></p>
            
            <!-- Modify Personal Info -->
            <div class="mt-6">
                <a href="modify_user.php" class="text-yellow-500 hover:text-yellow-400">Modify Your Personal Information</a>
            </div>
        </div>
    </div>
</section>

<!-- Reservations Section -->
<section class="py-16 bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-yellow-500">Your Reservations</h2>
            <p class="mt-4 text-gray-300">Consult your reservation history, modify or cancel any reservation.</p>
        </div>

        <div class="bg-gray-700 p-8 rounded-lg">
            <?php if (mysqli_num_rows($reservations) > 0): ?>
                <h3 class="text-2xl font-bold text-yellow-500 mb-6">Reservation History</h3>
                <ul class="space-y-4">
                    <?php while ($reservation = mysqli_fetch_assoc($reservations)) { ?>
                        <li class="flex justify-between items-center">
                            <div>
                                <p><strong>Date:</strong> <?php echo htmlspecialchars($reservation['reservation_date']); ?></p>
                                <p><strong>Status:</strong> <?php echo htmlspecialchars($reservation['statut']); ?></p>
                            </div>
                            <div class="space-x-4">
                                <a href="modify_reservation.php?id=<?php echo $reservation['reservation_ID']; ?>" class="text-yellow-500 hover:text-yellow-400">Modify</a>
                                <a href="cancel_reservation.php?id=<?php echo $reservation['reservation_ID']; ?>" class="text-red-500 hover:text-red-400">Cancel</a>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            <?php else: ?>
                <p class="text-gray-300">You have no reservations at the moment.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-800 py-6 mt-6">
    <div class="container mx-auto text-center">
        <p class="text-gray-500">&copy; 2024 Law Office. All rights reserved.</p>
        <div class="flex justify-center space-x-4 mt-4">
            <a href="#" class="text-gray-500 hover:text-white"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-gray-500 hover:text-white"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-gray-500 hover:text-white"><i class="fab fa-instagram"></i></a>
        </div>
    </div>
</footer>

</body>
</html>
