<?php
session_start();
include('db.php');

// Check if the user is logged in and has the 'client' role
if ($_SESSION['role'] != 'client') {
    header("Location: login.php");
    exit();
}

// Get avocat details based on the avocat ID passed in the query string
if (isset($_GET['avocat_id'])) {
    $avocat_id = $_GET['avocat_id'];

    // Fetch avocat's details
    $sql = "SELECT Users.User_ID, Users.nom, Users.prenom, Users.Email, info.photo, info.specialite, info.annee_experience, info.coordonnee, info.Biographie
            FROM Users
            JOIN info ON Users.User_ID = info.user_id
            WHERE Users.User_ID = '$avocat_id' AND Users.role = 'avocat'";

    $avocat_result = mysqli_query($conn, $sql);
    $avocat = mysqli_fetch_assoc($avocat_result);

    // Get avocat's available time slots (only where statut is 'disponible')
    $availability_sql = "SELECT disponibilite_ID, disponibilite_date FROM Disponibilites WHERE user_ID = '$avocat_id' AND statut = 'disponible'";
    $availability_result = mysqli_query($conn, $availability_sql);
    $availability = mysqli_fetch_all($availability_result, MYSQLI_ASSOC);
} else {
    header("Location: client_dashboard.php");
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation de Consultation - <?php echo htmlspecialchars($avocat['nom'] . ' ' . $avocat['prenom']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">

<!-- Navigation -->
<nav class="flex justify-between items-center py-4 px-8 bg-gray-800">
    <div class="text-lg font-bold">Law Office</div>
    <ul class="flex space-x-4">
        <li><a href="../views/index.php" class="hover:text-gray-400">Home</a></li>
        <li><a href="../views/client_dashboard.php" class="hover:text-gray-400">Clients</a></li>
        <li><a href="../views/avocat_dashboard.php" class="hover:text-gray-400">Avocats</a></li>
        <li><a href="../views/logout.php" class="bg-yellow-500 text-gray-900 px-4 py-2 rounded">Logout</a></li>
    </ul>
</nav>

<!-- Avocat Information -->
<section class="py-16 bg-gray-800">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl font-bold text-yellow-500">Réserver une Consultation avec <?php echo htmlspecialchars($avocat['nom'] . ' ' . $avocat['prenom']); ?></h2>

        <div class="max-w-lg mx-auto bg-gray-700 p-8 rounded-lg shadow-lg mt-8">
            <img src="<?php echo htmlspecialchars($avocat['photo']); ?>" alt="Profile Photo" class="rounded-full w-40 h-40 mx-auto mb-6">
            <h3 class="text-2xl font-semibold text-yellow-500"><?php echo htmlspecialchars($avocat['specialite']); ?></h3>
            <p class="text-gray-300"><?php echo htmlspecialchars($avocat['Biographie']); ?></p>
            <p class="text-gray-300"><strong>Années d'expérience:</strong> <?php echo htmlspecialchars($avocat['annee_experience']); ?></p>
            <p class="text-gray-300"><strong>Coordonnées:</strong> <?php echo htmlspecialchars($avocat['coordonnee']); ?></p>
        </div>

        <h3 class="text-2xl font-semibold text-yellow-500 mt-8">Disponibilités</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mt-6">
            <?php if (count($availability) > 0): ?>
                <?php foreach ($availability as $slot): ?>
                    <div class="bg-gray-700 p-6 rounded-lg">
                        <p class="text-gray-300"><strong>Date:</strong> <?php echo htmlspecialchars($slot['disponibilite_date']); ?></p>
                        <a href="process_reservation.php?avocat_id=<?php echo $avocat['User_ID']; ?>&disponibilite_id=<?php echo $slot['disponibilite_ID']; ?>"
                           class="text-yellow-500 hover:text-yellow-400 mt-4 inline-block">Réserver ce créneau</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-300">Aucune disponibilité actuellement.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

</body>
</html>
