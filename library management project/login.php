<?php
session_start(); // Start the PHP session
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

    // Get login form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL query to fetch user data based on username and password
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, retrieve their role
        $row = $result->fetch_assoc();
        $role = $row['role'];

        // Store user information in the session
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;

        // Create a form with hidden fields
    echo '<form id="hiddenForm" method="post" action="student.php">';
    echo '<input type="hidden" name="username" value="' . $username . '">';
    echo '</form>';

    // Use JavaScript to submit the form automatically
    echo '<script>document.getElementById("hiddenForm").submit();</script>';
    exit();

        // Redirect based on the user's role
        if ($role === "Admin") {
            header("Location: admin.html");
            exit();
        } elseif ($role === "Student") {
            header("Location: student.php");
            exit();
        }
    } else {
        // User not found, display an error message or redirect to an error page
        echo "Login failed. Please check your username and password.";
    }

    // Close the database connection
    $conn->close();
}

?>
