<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Get registration form data
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $department = $_POST['department'];

    // Default role for new users
    $role = "Student";

    // SQL query to insert data into the 'users' table
    $sql = "INSERT INTO users (full_name, email, username, password, role, department)
            VALUES ('$full_name', '$email', '$username', '$password', '$role','$department')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to the login page after successful registration
        header("Location: successful.html");
        exit(); // Stop further execution
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>