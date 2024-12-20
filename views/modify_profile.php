<?php
session_start();
include('db.php');

// Check if the user is logged in and has the 'avocat' role
if ($_SESSION['role'] != 'avocat') {
    header("Location: login.php");
    exit();
}

// Get the avocat's current information
$user_id = $_SESSION['user_id'];
$user_sql = "SELECT * FROM Users WHERE User_ID = '$user_id'";
$user_result = mysqli_query($conn, $user_sql);
$user_info = mysqli_fetch_assoc($user_result);

$info_sql = "SELECT * FROM Info WHERE user_id = '$user_id'";
$info_result = mysqli_query($conn, $info_sql);
$info = mysqli_fetch_assoc($info_result);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $photo = $_POST['photo'];
    $biography = $_POST['biography'];
    $coordinates = $_POST['coordinates'];
    $experience = $_POST['experience'];
    $specialty = $_POST['specialty'];

    // Update Users table
    $update_user_sql = "UPDATE Users SET Email = '$email', telephone = '$phone' WHERE User_ID = '$user_id'";
    mysqli_query($conn, $update_user_sql);

    // Update Info table
    if ($info) {
        $update_info_sql = "UPDATE Info SET photo = '$photo', Biographie = '$biography', coordonnee = '$coordinates', annee_experience = '$experience', specialite = '$specialty' WHERE user_id = '$user_id'";
        mysqli_query($conn, $update_info_sql);
    } else {
        $insert_info_sql = "INSERT INTO Info (user_id, photo, Biographie, coordonnee, annee_experience, specialite) VALUES ('$user_id', '$photo', '$biography', '$coordinates', '$experience', '$specialty')";
        mysqli_query($conn, $insert_info_sql);
    }

    header("Location: avocat_dashboard.php");
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Profile - Law Office</title>
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

<!-- Modify Profile Form -->
<section class="py-16 bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-yellow-500">Modify Your Profile</h2>
            <p class="mt-4 text-gray-300">Update your personal and professional information.</p>
        </div>

        <div class="max-w-lg mx-auto bg-gray-700 p-8 rounded-lg">
            <form method="POST" action="">
                <div class="mb-4">
                    <label for="email" class="block text-gray-300">Email</label>
                    <input type="email" name="email" id="email" class="w-full px-4 py-2 rounded bg-gray-800 text-white" value="<?php echo htmlspecialchars($user_info['Email']); ?>" required>
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-gray-300">Phone</label>
                    <input type="text" name="phone" id="phone" class="w-full px-4 py-2 rounded bg-gray-800 text-white" value="<?php echo htmlspecialchars($user_info['telephone']); ?>" required>
                </div>
                <div class="mb-4">
                    <label for="photo" class="block text-gray-300">Photo URL</label>
                    <input type="text" name="photo" id="photo" class="w-full px-4 py-2 rounded bg-gray-800 text-white" value="<?php echo htmlspecialchars($info['photo']); ?>">
                </div>
                <div class="mb-4">
                    <label for="biography" class="block text-gray-300">Biography</label>
                    <textarea name="biography" id="biography" class="w-full px-4 py-2 rounded bg-gray-800 text-white"><?php echo htmlspecialchars($info['Biographie']); ?></textarea>
                </div>
                <div class="mb-4">
                    <label for="coordinates" class="block text-gray-300">Coordinates</label>
                    <input type="text" name="coordinates" id="coordinates" class="w-full px-4 py-2 rounded bg-gray-800 text-white" value="<?php echo htmlspecialchars($info['coordonnee']); ?>">
                </div>
                <div class="mb-4">
                    <label for="experience" class="block text-gray-300">Years of Experience</label>
                    <input type="text" name="experience" id="experience" class="w-full px-4 py-2 rounded bg-gray-800 text-white" value="<?php echo htmlspecialchars($info['annee_experience']); ?>">
                </div>
                <div class="mb-4">
                    <label for="specialty" class="block text-gray-300">Specialty</label>
                    <input type="text" name="specialty" id="specialty" class="w-full px-4 py-2 rounded bg-gray-800 text-white" value="<?php echo htmlspecialchars($info['specialite']); ?>">
                </div>
                <div class="mt-6">
                    <button type="submit" class="bg-yellow-500 text-gray-900 px-4 py-2 rounded">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="py-4 bg-gray-800 text-center">
    <p class="text-gray-500">&copy; 2024 Law Office. All rights reserved.</p>
</footer>

</body>
</html>