<?php
// Start the session (if not already started)
session_start();

// Check if the user is not logged in (based on your session variables)
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="1.css">
    <title>Library Home Page</title>
</head>
<body>

<!-- Navigation bar (include the Logout link) -->
<div class="navbar">
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
<div id="section1" class="section">
    <h1 class="main-heading">Welcome to Our Library</h1>
    <p>Nestled within the vibrant K.J. Somaiya Institute of Technology (KJSIT) campus, we welcome you to a world of boundless knowledge and innovation. Established in 2001 by the visionary Somaiya Trust, KJSIT is a symbol of excellence in modern Information Technology, Engineering, and Technology education. Our G+8 storey building stands as a testament to our commitment to providing world-class facilities for academic growth.
    </p>
</div>

<!-- Section 2: About Us -->
<div id="section2" class="section">
    <h2>About Us</h2>
    <p>At the heart of academic exploration, the KJSIT Library stands as a beacon of wisdom. With a collection of 23,677 print books encompassing textbooks, reference materials, encyclopedias, general reading, and competitive exam resources, we are your gateway to a wealth of knowledge. Our library is digitally empowered, offering access to over 16,000 ebooks in engineering, along with membership to the National Digital Library of India.
    </p>
</div>

<!-- Section 3: Resources -->
<div id="section3" class="section">
    <h2>Resources</h2>
    <p>Our library is not just a repository of books; it's a treasure trove of resources. Dive into the depths of 500+ e-journals, including prestigious publications like IEEE, ASME, Wiley Springer, ACM Digital Library, and the National Digital Library. We proudly maintain a collection of 40 print journals, ensuring you stay updated with the latest research.
    </p>
</div>

<!-- Section 4: Contact -->
<div id="section4" class="section">
    <h2>Contact</h2>
    <p>Located conveniently near the Eastern Express Highway, with Chunabhatti and Sion railway stations as our neighbors, we're easily accessible. Visit us at Everard Nagar, Chunabhatti, on the Eastern Express Highway. Our dedicated team is always here to assist you on your academic journey.
    </p>
</div>

<!-- Footer -->
<footer>
    &copy; 2023 KJSIT Library. All Rights Reserved.
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