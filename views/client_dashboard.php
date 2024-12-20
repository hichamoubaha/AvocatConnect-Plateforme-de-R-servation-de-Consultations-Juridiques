<?php
session_start();
include('db.php');

// Check if the user is logged in and has the 'client' role
if ($_SESSION['role'] != 'client') {
    header("Location: login.php");
    exit();
}

// Query to get all avocat profiles with their details from the 'info' table
$sql = "SELECT Users.User_ID, Users.nom, Users.prenom, Users.Email, info.photo, info.Biographie, info.coordonnee, info.annee_experience, info.specialite 
        FROM Users 
        JOIN info ON Users.User_ID = info.user_id 
        WHERE Users.role = 'avocat'";
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
            <h2 class="text-4xl font-bold text-yellow-500">Bienvenue, <?php echo htmlspecialchars($user_info['nom'] . ' ' . $user_info['prenom']); ?>!</h2>
            <p class="mt-4 text-gray-300">Vos informations personnelles et l'historique de vos réservations.</p>
        </div>

        <div class="max-w-lg mx-auto bg-gray-700 p-8 rounded-lg">
            <h3 class="text-2xl font-bold text-yellow-500 mb-6">Vos Informations Personnelles</h3>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user_info['Email']); ?></p>
            <p><strong>Téléphone:</strong> <?php echo htmlspecialchars($user_info['telephone']); ?></p>
            <p><strong>Role:</strong> <?php echo htmlspecialchars($user_info['role']); ?></p>
            
            <!-- Modify Personal Info -->
            <div class="mt-6">
                <a href="modify_user.php" class="text-yellow-500 hover:text-yellow-400">Modifier vos Informations Personnelles</a>
            </div>
        </div>
    </div>
</section>

<!-- Avocat Profiles Section -->
<section class="py-16 bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-yellow-500">Consultation des Profils des Avocats</h2>
            <p class="mt-4 text-gray-300">Consultez les profils des avocats du cabinet et choisissez celui qui vous convient.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php while ($avocat = mysqli_fetch_assoc($avocats)) { ?>
                <div class="bg-gray-700 p-6 rounded-lg">
                    <img src="<?php echo htmlspecialchars($avocat['photo']); ?>" alt="Photo of <?php echo htmlspecialchars($avocat['nom']); ?>" class="w-full h-64 object-cover rounded-lg mb-4">
                    <h3 class="text-2xl font-bold text-yellow-500"><?php echo htmlspecialchars($avocat['nom'] . ' ' . $avocat['prenom']); ?></h3>
                    <p class="text-gray-300"><?php echo htmlspecialchars($avocat['specialite']); ?></p>
                    <p class="text-gray-300">Années d'expérience: <?php echo htmlspecialchars($avocat['annee_experience']); ?></p>
                    <p class="text-gray-300">Coordonnées: <?php echo htmlspecialchars($avocat['coordonnee']); ?></p>
                    <p class="text-gray-300"><?php echo nl2br(htmlspecialchars($avocat['Biographie'])); ?></p>
                    <a href="reservation_form.php?avocat_id=<?php echo $avocat['User_ID']; ?>" class="text-yellow-500 hover:text-yellow-400 mt-4 inline-block">Réserver une consultation</a>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<!-- Reservations Section -->
<section class="py-16 bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-yellow-500">Gestion de vos Réservations</h2>
            <p class="mt-4 text-gray-300">Consultez votre historique, modifiez ou annulez vos réservations.</p>
        </div>

        <div class="bg-gray-700 p-8 rounded-lg">
            <?php if (mysqli_num_rows($reservations) > 0): ?>
                <h3 class="text-2xl font-bold text-yellow-500 mb-6">Historique de vos Réservations</h3>
                <ul class="space-y-4">
                    <?php while ($reservation = mysqli_fetch_assoc($reservations)) { ?>
                        <li class="flex justify-between items-center">
                            <div>
                                <p><strong>Date:</strong> <?php echo htmlspecialchars($reservation['reservation_date']); ?></p>
                                <p><strong>Status:</strong> <?php echo htmlspecialchars($reservation['statut']); ?></p>
                            </div>
                            <div class="space-x-4">
                                <a href="modify_reservation.php?id=<?php echo $reservation['reservation_ID']; ?>" class="text-yellow-500 hover:text-yellow-400">Modifier</a>
                                <a href="cancel_reservation.php?id=<?php echo $reservation['reservation_ID']; ?>" class="text-red-500 hover:text-red-400">Annuler</a>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            <?php else: ?>
                <p class="text-gray-300">Vous n'avez aucune réservation pour le moment.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-800 py-6 mt-6">
    <div class="container mx-auto text-center">
        <p class="text-gray-500">&copy; 2024 Law Office. Tous droits réservés.</p>
        <div class="flex justify-center space-x-4 mt-4">
            <a href="#" class="text-gray-500 hover:text-white"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-gray-500 hover:text-white"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-gray-500 hover:text-white"><i class="fab fa-instagram"></i></a>
        </div>
    </div>
</footer>

</body>
</html>
