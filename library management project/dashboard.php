<?php
session_start();

// Check if the user is logged in (based on your session variables)
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    // Redirect to the login page if not logged in
    header("Location: login.html");
    exit(); // Stop further script execution
}

// Logout functionality
if (isset($_GET['logout'])) {
    // Destroy the session
    session_destroy();

    // Redirect to the login page
    header("Location: login.html");
    exit(); // Stop further script execution
}

// Database connection parameters
$servername = "localhost"; // Change this to your database server
$dbusername = "root";      // Change this to your database username
$dbpassword = "Qsk_kh@21"; // Change this to your database password
$dbname = "users_db";      // Change this to your database name

// Create a database connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the full name and ID of the user based on their username
$username = $_SESSION['username'];
$sql = "SELECT id, full_name FROM users WHERE username='$username'";
$result = $conn->query($sql);

$full_name = "";
$user_id = -1; // Initialize with an invalid value

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $full_name = $row['full_name'];
    $user_id = $row['id'];
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css" class="css">
    <title>Dashboard</title>
</head>
<body>
<script src="dashboard.js"></script>

    <!-- Left-side Navbar -->
    <div class="navbar">
        <!-- Logo and User Information -->
        <div class="navbar-logo">
            <img src="logo.png" alt="Logo">
        </div>
        <div class="user-info">
            <p>Welcome, <?php echo $full_name; ?></p>
        </div>
        <!-- Navbar Items -->
        <a class="navbar-item" href="student.php">Home</a>
        <a class="navbar-item navbar-logout" href="?logout=true">Logout</a>
    </div>

    <!-- Content Container -->
    <div class="content-container">
        <!-- Button Container -->
        <div class="button-container">
            <button class="dashboard-button" id="availableBooksButton">Show Books</button>
        </div>

        <!-- Available Books Section -->
        <div id="availableBooksSection" class="books-section">
            <?php
            // Database connection parameters (reuse the existing connection)
            $servername = "localhost";
            $dbusername = "root";
            $dbpassword = "Qsk_kh@21";
            $dbname = "users_db";

            // Create a database connection
            $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

            // Check the connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // SQL query to retrieve available books and display the "availability" as "Status"
            $sql = "SELECT b.book_id, b.title, b.author, b.genre, b.publication_year,
                    CASE
                        WHEN b.availability = 1 THEN 'Available'
                        WHEN b.availability = 0 THEN 'Reserved'
                        ELSE 'Unknown'
                    END AS Status
                    FROM books AS b
                    LEFT JOIN reservations AS r ON b.book_id = r.book_id AND r.user_id = $user_id
                    WHERE b.availability IN (0, 1)";

            // Execute the query
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table class='book-table'>";
                echo "<tr><th>Book ID</th><th>Title</th><th>Author</th><th>Genre</th><th>Publication Year</th><th>Status</th><th>Action</th></tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["book_id"] . "</td>";
                    echo "<td>" . $row["title"] . "</td>";
                    echo "<td>" . $row["author"] . "</td>";
                    echo "<td>" . $row["genre"] . "</td>";
                    echo "<td>" . $row["publication_year"] . "</td>";
                    echo "<td>" . $row["Status"] . "</td>";

                    // Add the "Reserve" button for available books
                    if ($row["Status"] == 'Available') {
                        echo "<td><button class='reserve-button' data-bookid='" . $row["book_id"] . "'>Reserve</button></td>";
                    } elseif ($row["Status"] == 'Reserved') {
                        // Add the "Return" button for reserved books
                        echo "<td><button class='return-button' data-bookid='" . $row["book_id"] . "'>Return</button></td>";
                    } else {
                        echo "<td></td>";
                    }

                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "No available books.";
            }

            // Close the database connection
            $conn->close();
            ?>
        </div>

        <!-- My Reserved Books Section -->
        <div id="myReservedBooksSection" class="books-section">
            <?php
            // Connect to the database
            $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

            // Check the connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // SQL query to retrieve user's reserved books
            $sql_reserved_books = "SELECT books.title
                FROM reservations
                INNER JOIN books ON reservations.book_id = books.book_id
                WHERE reservations.user_id = $user_id";

            // Execute the query
            $result_reserved_books = $conn->query($sql_reserved_books);

            if ($result_reserved_books->num_rows > 0) {
                echo "<table class='book-table'>";
                echo "<tr><th>Title</th></tr>";

                while ($row_reserved_books = $result_reserved_books->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row_reserved_books["title"] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "You have not reserved any books.";
            }

            // Close the database connection
            $conn->close();
            ?>
        </div>

        <!-- Other Buttons -->
        <div class="button-container">
            <button class="dashboard-button" id="reservedBooksButton">My Reserved Books</button>
        </div>
    </div>
</body>
</html>
