<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <title>Library Home Page</title>
    <style>
        /* Custom CSS styles can be added here if needed */
    </style>
</head>
<body>
<?php
// Start the session (if not already started)
session_start();

// Check if the user is logged in (based on your session variables)
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    // Redirect to the login page if not logged in
    header("Location: login.html");
    exit(); // Stop further script execution
}

// Check if the logout link is clicked
if (isset($_GET['logout'])) {
    // Unset and destroy the session
    session_unset();
    session_destroy();
    
    // Redirect to the login page after logout
    header("Location: login.html");
    exit(); // Stop further script execution
}
?>

<!-- Navigation bar (include the Logout link) -->
<div class="navbar bg-gray-800 text-white p-4">
    <div class="logo">
        <img id="logo" src="home_page_logo.png" alt="Library Logo">
    </div>
    <div class="nav-links">
        <a href="#section1">Home</a>
        <a href="#section2">About Us</a>
        <a href="#section3">Resources</a>
        <a href="#section4">Contact</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="?logout=true">Logout</a>
    </div>
</div>

<!-- Section 1: Home -->
<div id="section1" class="section bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 text-white text-center py-20">
    <h1 class="main-heading text-6xl font-bold animate__animated animate__fadeIn animate__delay-1s">
        Welcome to Our Library
    </h1>
    <p>First section content here...</p>
</div>

<!-- Section 2: About Us -->
<div id="section2" class="section">
    <!-- Add your About Us content here -->
</div>

<!-- Section 3: Resources -->
<div id="section3" class="section">
    <!-- Add your Resources content here -->
</div>

<!-- Section 4: Contact -->
<div id="section4" class="section">
    <!-- Add your Contact content here -->
</div>

<!-- Footer -->
<footer class="text-center py-4 bg-gray-800 text-white">
    &copy; 2023 Library Name. All Rights Reserved.
</footer>

<!-- JavaScript for smooth scrolling -->
<script>
    // Function to handle smooth scrolling to sections
    function scrollToSection(targetId) {
        const targetElement = document.getElementById(targetId);
        if (targetElement) {
            window.scrollTo({
                top: targetElement.offsetTop - document.querySelector('.navbar').offsetHeight,
                behavior: 'smooth',
            });
        }
    }

    // Add click event listeners to navbar links
    document.querySelectorAll('.nav-links a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            const targetId = this.getAttribute('href').substring(1);
            scrollToSection(targetId);
        });
    });
</script>

</body>
</html>
