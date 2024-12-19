<?php
// Include database connection
include('db.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password
    $role = $_POST['role'];

    // Prepare and bind for Users table
    $stmt = $conn->prepare("INSERT INTO Users (nom, prenom, email, telephone, password, role) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nom, $prenom, $email, $telephone, $password, $role);

    if ($stmt->execute()) {
        // Get the last inserted user ID
        $user_id = $stmt->insert_id;

        // If the user is an avocat, insert additional info into the Info table
        if ($role == 'avocat') {
            $photo = ''; // Default value, you can add logic for photo upload
            $biographie = ''; // You can add biographie input field in the form
            $coordonnee = ''; // Add additional input fields if necessary
            $annee_experience = ''; // Add additional input fields if necessary
            $specialite = ''; // Add additional input fields if necessary

            // Prepare and bind for Info table
            $info_stmt = $conn->prepare("INSERT INTO Info (photo, Biographie, coordonnee, annee_experience, specialite, user_id) VALUES (?, ?, ?, ?, ?, ?)");
            $info_stmt->bind_param("sssssi", $photo, $biographie, $coordonnee, $annee_experience, $specialite, $user_id);

            if ($info_stmt->execute()) {
                // Redirect to login page with success message
                header("Location: login.php?success=1");
                exit();
            } else {
                $error = "Error inserting into Info table: " . $info_stmt->error;
            }

            $info_stmt->close();
        } else {
            // If the user is a client, just redirect to login
            header("Location: login.php?success=1");
            exit();
        }
    } else {
        $error = "Error inserting into Users table: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Law Office</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-900 text-white">
    <!-- Navigation -->
    <nav class="flex justify-between items-center py-4 px-8 bg-gray-800">
        <div class="text-lg font-bold">Law Office</div>
        <ul class="flex space-x-4">
            <li><a href="../views/index.php" class="hover:text-gray-400">Home</a></li>
            <li><a href="#about-section" class="hover:text-gray-400">About</a></li>
            <li><a href="../views/client_dashboard.php" class="hover:text-gray-400">Clients</a></li>
            <li><a href="../views/registration.php" class="hover:text-gray-400">Registration</a></li>
            <li><a href="../views/avocat_dashboard.php" class="hover:text-gray-400">Avocats</a></li>
        </ul>
        <a href="../views/login.php" class="bg-yellow-500 text-gray-900 px-4 py-2 rounded">Login</a>
    </nav>

    <!-- Registration form -->
    <div class="min-h-screen flex items-center justify-center py-12 px-4">
        <div class="bg-gray-800 p-8 rounded-lg shadow-xl w-full max-w-md">
            <h2 class="text-[#C4A962] text-2xl text-center">Register</h2>
            <form method="POST" class="space-y-6">
                <input type="text" name="nom" placeholder="First Name" class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:border-[#C4A962]" required>
                <input type="text" name="prenom" placeholder="Last Name" class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:border-[#C4A962]" required>
                <input type="email" name="email" placeholder="Email" class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:border-[#C4A962]" required>
                <input type="tel" name="telephone" placeholder="Phone Number" class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:border-[#C4A962]" required>
                <input type="password" name="password" placeholder="Password" class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:border-[#C4A962]" required>
                <select name="role" class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:border-[#C4A962]" required>
                    <option value="client">Client</option>
                    <option value="avocat">Avocat</option>
                </select>
                <button type="submit" class="w-full bg-[#C4A962] text-white py-2 rounded hover:bg-[#d4b972] transition">
                    Register
                </button>
                <?php if (isset($error)): ?>
                    <div class="text-red-500 text-center mt-4"><?php echo $error; ?></div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</body>
</html>
