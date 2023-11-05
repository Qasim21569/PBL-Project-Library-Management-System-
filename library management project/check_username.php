<?php
// Database connection parameters
$servername = "localhost";  // Change this to your database server
$dbusername = "root"; // Change this to your database username
$dbpassword = "Qsk_kh@21"; // Change this to your database password
$dbname = "users_db"; // Change this to your database name

// Create a database connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the username from the AJAX request
if (isset($_POST['username'])) {
    $username = $_POST['username'];

    // Query the database to check if the username exists
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo 'exists';
    } else {
        echo 'available';
    }
} else {
    echo 'invalid';
}

// Close the database connection
$conn->close();
?>
