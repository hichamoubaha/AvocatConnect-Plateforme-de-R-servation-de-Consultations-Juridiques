<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Law Office</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-gray-900 text-white">

    <!-- Navigation -->
    <nav class="flex justify-between items-center py-4 px-8 bg-gray-800">
        <div class="text-lg font-bold">Law Office</div>
        <ul class="flex space-x-4">
            <li><a href="index.html" class="hover:text-gray-400">Home</a></li>
            <li><a href="#about-section" class="hover:text-gray-400">About</a></li>
            <li><a href="reservation.html" class="hover:text-gray-400">reservation</a></li>
            <li><a href="regestration.html" class="hover:text-gray-400">regestration</a></li>
        </ul>
        <a href="login.html" class="bg-yellow-500 text-gray-900 px-4 py-2 rounded">Login</a>
    </nav>

    <!-- Hero Section -->
    <section class="hero-background h-screen flex items-center justify-center relative">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 items-center">
                <div class="md:text-left text-center">
                    <h1 class="text-6xl font-bold text-yellow-500">The Law Protects</h1>
                    <h2 class="text-2xl mt-4">The Law Protects Every Human</h2>
                    <p class="mt-6 text-gray-300">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>
                <div class="flex justify-center md:justify-end mt-6 md:mt-0">
                    <img src="justice-blance.png" alt="Lawyer" class="w-3/4 rounded-lg shadow-lg">
                </div>
            </div>
        </div>
    </section>
     <!-- about hero Section -->
     <section id="about-section" class="hero-background h-screen flex items-center justify-center relative bg-cover bg-center" style="background-image: url('hero-image.jpg');">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <h1 class="text-6xl font-bold text-yellow-500">About Us</h1>
            <p class="mt-4 text-2xl text-gray-300">Learn more about our mission, values, and team</p>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-16 bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-yellow-500">Our Mission</h2>
                <p class="mt-4 text-gray-300">At Law Office, we are dedicated to providing exceptional legal services to our clients. Our mission is to protect your rights and ensure justice is served.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-2xl font-bold text-yellow-500">Our Values</h3>
                    <p class="mt-4 text-gray-300">Integrity, professionalism, and dedication are at the core of everything we do. We strive to maintain the highest standards in all our legal practices.</p>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-yellow-500">Our Vision</h3>
                    <p class="mt-4 text-gray-300">Our vision is to be the leading law firm known for its unwavering commitment to justice and client satisfaction. We aim to make a positive impact on our community and beyond.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-16 bg-gray-900">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-yellow-500">Meet Our Team</h2>
                <p class="mt-4 text-gray-300">Our team of experienced attorneys is here to support you every step of the way.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Team Member 1 -->
                <div class="text-center">
                    <img src="platt-mike-02156-web.jpg" alt="Team Member 1" class="w-48 h-48 rounded-full mx-auto shadow-lg">
                    <h3 class="mt-4 text-2xl font-bold text-yellow-500">John Doe</h3>
                    <p class="mt-2 text-gray-300">Senior Attorney</p>
                </div>
                <!-- Team Member 2 -->
                <div class="text-center">
                    <img src="Sam-Sprangers-720x934.jpg" alt="Team Member 2" class="w-48 h-48 rounded-full mx-auto shadow-lg">
                    <h3 class="mt-4 text-2xl font-bold text-yellow-500">Jane Smith</h3>
                    <p class="mt-2 text-gray-300">Partner</p>
                </div>
                <!-- Team Member 3 -->
                <div class="text-center">
                    <img src="flawyer.avif" alt="Team Member 3" class="w-48 h-48 rounded-full mx-auto shadow-lg">
                    <h3 class="mt-4 text-2xl font-bold text-yellow-500">Michael Johnson</h3>
                    <p class="mt-2 text-gray-300">Associate Attorney</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 py-6 mt-6">
        <div class="container mx-auto text-center">
            <p class="text-gray-500">&copy; 2024 Law Office. All rights reserved.</p>
            <div class="flex justify-center space-x-4 mt-4">
                <a href="#" class="text-gray-500 hover:text-white"><img src="facebook (1).png" alt="icon1" class="w-6 h-6"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="text-gray-500 hover:text-white"><img src="twitter (1).png" alt="icon2" class="w-6 h-6"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-gray-500 hover:text-white"><img src="instagram.png" alt="icon3" class="w-6 h-6"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </footer>

</body>
</html>
