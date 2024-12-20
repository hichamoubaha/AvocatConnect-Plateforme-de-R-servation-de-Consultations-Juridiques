<?php
session_start();
include('db.php');

// Check if the user is logged in and has the 'avocat' role
if ($_SESSION['role'] != 'avocat') {
    header("Location: login.php");
    exit();
}

// Get avocat reservations
$sql = "SELECT * FROM Reservations WHERE user_ID = " . $_SESSION['user_id'];
$reservations = mysqli_query($conn, $sql);

// Get avocat availability
$sql_availability = "SELECT * FROM Disponibilites WHERE user_ID = " . $_SESSION['user_id'];
$availability = mysqli_query($conn, $sql_availability);

// Get the avocat's information
$user_id = $_SESSION['user_id'];
$user_sql = "SELECT * FROM Users WHERE User_ID = '$user_id'";
$user_result = mysqli_query($conn, $user_sql);
$user_info = mysqli_fetch_assoc($user_result);

// Get avocat's profile info from Info table
$info_sql = "SELECT * FROM Info WHERE user_id = '$user_id'";
$info_result = mysqli_query($conn, $info_sql);
$info = mysqli_fetch_assoc($info_result);

// Calculate statistics
$pending_reservations_sql = "SELECT COUNT(*) AS count FROM Reservations WHERE user_ID = '$user_id' AND statut = 'en attente'";
$pending_reservations_result = mysqli_query($conn, $pending_reservations_sql);
$pending_reservations_count = mysqli_fetch_assoc($pending_reservations_result)['count'];

$approved_today_sql = "SELECT COUNT(*) AS count FROM Reservations WHERE user_ID = '$user_id' AND statut = 'confirmee' AND DATE(reservation_date) = CURDATE()";
$approved_today_result = mysqli_query($conn, $approved_today_sql);
$approved_today_count = mysqli_fetch_assoc($approved_today_result)['count'];

$approved_tomorrow_sql = "SELECT COUNT(*) AS count FROM Reservations WHERE user_ID = '$user_id' AND statut = 'confirmee' AND DATE(reservation_date) = CURDATE() + INTERVAL 1 DAY";
$approved_tomorrow_result = mysqli_query($conn, $approved_tomorrow_sql);
$approved_tomorrow_count = mysqli_fetch_assoc($approved_tomorrow_result)['count'];

$next_client_sql = "SELECT * FROM Reservations WHERE user_ID = '$user_id' AND statut = 'confirmee' ORDER BY reservation_date ASC LIMIT 1";
$next_client_result = mysqli_query($conn, $next_client_sql);
$next_client = mysqli_fetch_assoc($next_client_result);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avocat Dashboard - Law Office</title>
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

<!-- User Info Section -->
<section class="py-16 bg-gray-800">
    <div class="container mx-auto px-4 text-center">
        <div class="mb-12">
            <h2 class="text-4xl font-bold text-yellow-500">Welcome, <?php echo htmlspecialchars($user_info['nom'] . ' ' . $user_info['prenom']); ?>!</h2>
            <p class="mt-4 text-gray-300">Your personal information and reservation history.</p>
        </div>

        <div class="max-w-lg mx-auto bg-gray-700 p-8 rounded-lg shadow-lg">
            <h3 class="text-2xl font-semibold text-yellow-500 mb-6">Your Personal Information</h3>

            <!-- Display profile info from Info table -->
            <?php if ($info): ?>
                <div class="mb-6">
                    <img src="<?php echo htmlspecialchars($info['photo']); ?>" alt="Profile Photo" class="rounded-full w-40 h-40 mx-auto mb-6">
                </div>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user_info['Email']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($user_info['telephone']); ?></p>
                <p><strong>Role:</strong> <?php echo htmlspecialchars($user_info['role']); ?></p>

                <div class="mt-4">
                    <p><strong>Biography:</strong> <?php echo htmlspecialchars($info['Biographie']); ?></p>
                    <p><strong>Coordinates:</strong> <?php echo htmlspecialchars($info['coordonnee']); ?></p>
                    <p><strong>Experience:</strong> <?php echo htmlspecialchars($info['annee_experience']); ?> years</p>
                    <p><strong>Specialty:</strong> <?php echo htmlspecialchars($info['specialite']); ?></p>
                </div>
            <?php endif; ?>

            <!-- Modify Personal Info -->
            <div class="mt-6">
                <a href="../views/modify_profile.php" class="text-yellow-500 hover:text-yellow-400 transition-colors">Modify Your Personal Information</a>
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
                                <a href="accept_reservation.php?id=<?php echo $reservation['reservation_ID']; ?>" class="text-green-500 hover:text-green-400">Accept</a>
                                <a href="reject_reservation.php?id=<?php echo $reservation['reservation_ID']; ?>" class="text-red-500 hover:text-red-400">Reject</a>
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

<!-- Availability Section -->
<section class="py-16 bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-yellow-500">Your Availability</h2>
            <p class="mt-4 text-gray-300">Set or update your availability to meet with clients.</p>
        </div>

        <div class="bg-gray-700 p-8 rounded-lg">
            <?php if (mysqli_num_rows($availability) > 0): ?>
                <h3 class="text-2xl font-bold text-yellow-500 mb-6">Availability History</h3>
                <ul class="space-y-4">
                    <?php while ($avail = mysqli_fetch_assoc($availability)) { ?>
                        <li class="flex justify-between items-center">
                            <div>
                                <p><strong>Date:</strong> <?php echo htmlspecialchars($avail['disponibilite_date']); ?></p>
                                <p><strong>Status:</strong> <?php echo htmlspecialchars($avail['statut']); ?></p>
                            </div>
                            <div class="space-x-4">
                                <a href="modify_availability.php?id=<?php echo $avail['disponibilite_ID']; ?>" class="text-yellow-500 hover:text-yellow-400">Modify</a>
                                <a href="cancel_availability.php?id=<?php echo $avail['disponibilite_ID']; ?>" class="text-red-500 hover:text-red-400">Cancel</a>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            <?php else: ?>
                <p class="text-gray-300">You have not set any availability yet.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-16 bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-yellow-500">Your Statistics</h2>
            <p class="mt-4 text-gray-300">Here are some key statistics about your activity.</p>
        </div>

        <div class="bg-gray-700 p-8 rounded-lg">
            <div class="flex justify-between mb-4">
                <div class="text-center">
                    <h3 class="text-2xl font-semibold text-yellow-500">Pending Reservations</h3>
                    <p class="text-3xl"><?php echo $pending_reservations_count; ?></p>
                </div>
                <div class="text-center">
                    <h3 class="text-2xl font-semibold text-yellow-500">Approved Today</h3>
                    <p class="text-3xl"><?php echo $approved_today_count; ?></p>
                </div>
                <div class="text-center">
                    <h3 class="text-2xl font-semibold text-yellow-500">Approved Tomorrow</h3>
                    <p class="text-3xl"><?php echo $approved_tomorrow_count; ?></p>
                </div>
            </div>

            <div class="mt-6 text-center">
                <h3 class="text-2xl font-semibold text-yellow-500">Next Client</h3>
                <?php if ($next_client): ?>
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($next_client['reservation_date']); ?></p>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($next_client['statut']); ?></p>
                <?php else: ?>
                    <p>No upcoming clients.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

</body>
</html>
