<?php
session_start();
include('db.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM Users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['User_ID'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] == 'client') {
                header("Location: client_dashboard.php");
            } else {
                header("Location: avocat_dashboard.php");
            }
        } else {
            $error = "Invalid credentials";
        }
    } else {
        $error = "No user found with that email";
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
    <title>Login - Law Office</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white"> <!-- Navigation -->
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
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-gray-800 p-8 rounded-lg shadow-xl w-full max-w-md">
            <h2 class="text-[#C4A962] text-2xl text-center">Login</h2>
            <form method="POST" class="space-y-6">
                <input type="email" name="email" placeholder="Email" class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:border-[#C4A962]" required>
                <input type="password" name="password" placeholder="Password" class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:border-[#C4A962]" required>
                <button type="submit" class="w-full bg-[#C4A962] text-white py-2 rounded hover:bg-[#d4b972] transition">
                    Login
                </button>
                <?php if (isset($error)): ?>
                    <div class="text-red-500 text-center mt-4"><?php echo $error; ?></div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</body>
</html>
