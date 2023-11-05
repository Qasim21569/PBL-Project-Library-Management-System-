<?php
session_start();

if (!isset($_SESSION['username'])) {
    // Handle the case when the user is not logged in
    $response = array("success" => false);
} else {
    // Database connection parameters
    $servername = "localhost";
    $dbusername = "root";
    $dbpassword = "Qsk_kh@21";
    $dbname = "users_db";

    // Create a database connection
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        // Handle the case when the database connection fails
        $response = array("success" => false);
    } else {
        // Get user_id using the session username
        $username = $_SESSION['username'];
        $sql = "SELECT id FROM users WHERE username='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $user_id = $row['id'];

            // Retrieve book_id from the POST request
            $book_id = $_POST['bookId'];

            // Delete the reservation record
            $sql = "DELETE FROM reservations WHERE user_id = $user_id AND book_id = $book_id";

            if ($conn->query($sql) === TRUE) {
                // Update the book's availability status
                $sql = "UPDATE books SET availability = 1 WHERE book_id = $book_id";

                if ($conn->query($sql) === TRUE) {
                    // Reservation record deleted and book status updated successfully
                    $response = array("success" => true);
                } else {
                    // Failed to update the book's availability status
                    $response = array("success" => false);
                }
            } else {
                // Failed to delete the reservation record
                $response = array("success" => false);
            }
        } else {
            // Failed to retrieve user_id
            $response = array("success" => false);
        }

        // Close the database connection
        $conn->close();
    }
}

// Send JSON response
echo json_encode($response);
?>
