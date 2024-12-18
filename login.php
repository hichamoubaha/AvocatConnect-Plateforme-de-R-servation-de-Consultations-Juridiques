<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Law Office</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-900 text-white">
    <!-- Navigation -->
    <nav class="flex justify-between items-center py-4 px-8 bg-gray-800">
        <div class="text-lg font-bold">Law Office</div>
        <ul class="flex space-x-4">
            <li><a href="index.html" class="hover:text-gray-400">Home</a></li>
            <li><a href="#" class="hover:text-gray-400">About</a></li>
            <li><a href="reservation.html" class="hover:text-gray-400">reservation</a></li>
            <li><a href="regestration.html" class="hover:text-gray-400">regestration</a></li>
        </ul>
        <a href="login.html" class="bg-yellow-500 text-gray-900 px-4 py-2 rounded">Login</a>
    </nav>
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-gray-800 p-8 rounded-lg shadow-xl w-full max-w-md">
            <div class="text-center mb-8">
                <a href="index.html" class="text-white text-2xl font-bold flex items-center justify-center">
                    <i class="fas fa-balance-scale mr-2"></i>
                    Law Office
                </a>
            </div>
            <form class="space-y-6">
                <div>
                    <label class="block text-[#C4A962] mb-2">Email Address</label>
                    <input type="email" class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:border-[#C4A962] focus:outline-none" required>
                </div>
                <div>
                    <label class="block text-[#C4A962] mb-2">Password</label>
                    <input type="password" class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:border-[#C4A962] focus:outline-none" required>
                </div>
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" class="mr-2">
                        <span class="text-gray-300">Remember me</span>
                    </label>
                    <a href="#" class="text-[#C4A962] hover:text-[#d4b972]">Forgot Password?</a>
                </div>
                <button type="submit" class="w-full bg-[#C4A962] text-white py-2 rounded hover:bg-[#d4b972] transition">
                    Login
                </button>
                <p class="text-center text-gray-300">
                    Don't have an account? 
                    <a href="register.html" class="text-[#C4A962] hover:text-[#d4b972]">Register</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>