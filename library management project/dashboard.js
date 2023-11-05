// Wait for the DOM to be fully loaded
document.addEventListener("DOMContentLoaded", function () {
    // Get references to the button elements
    const availableBooksButton = document.getElementById("availableBooksButton");
    const reservedBooksButton = document.getElementById("reservedBooksButton");

    // Get references to the content sections
    const availableBooksSection = document.getElementById("availableBooksSection");
    const myReservedBooksSection = document.getElementById("myReservedBooksSection");

    // Initialize a flag to track the visibility of the available books table
    let isAvailableBooksVisible = false;

    // Event listener for the "Available Books" button
    availableBooksButton.addEventListener("click", function () {
        // Toggle the visibility of the available books section
        if (isAvailableBooksVisible) {
            availableBooksSection.style.display = "none";
            isAvailableBooksVisible = false;
        } else {
            availableBooksSection.style.display = "block";
            isAvailableBooksVisible = true;
        }
    });

    reservedBooksButton.addEventListener("click", function () {
        if (myReservedBooksSection.style.display === "none" || myReservedBooksSection.style.display === "") {
            myReservedBooksSection.style.display = "block";
        } else {
            myReservedBooksSection.style.display = "none";
        }
    });

    const reserveButtons = document.querySelectorAll(".reserve-button");

    reserveButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const bookId = button.getAttribute("data-bookid");

            // Send an AJAX request to reserve the book
            reserveBook(bookId);
        });
    });

    function reserveBook(bookId) {
        // Send an AJAX request to reserve the book
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "reserve_book.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onload = function () {
            if (xhr.status === 200) {
                // Handle the response (you can display a success message, update the page, etc.)
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    alert("Book reserved successfully!");
                    // Reload the page or update the book status as needed
                    location.reload();
                } else {
                    alert("Failed to reserve the book.");
                }
            } else {
                alert("Error occurred while reserving the book.");
            }
        };

        // Send user and book IDs to the PHP script for reservation
        const data = `bookId=${bookId}`;
        xhr.send(data);
    }

    const returnButtons = document.querySelectorAll(".return-button");

    returnButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const bookId = button.getAttribute("data-bookid");

            // Send an AJAX request to return the book
            returnBook(bookId);
        });
    });

    function returnBook(bookId) {
        // Send an AJAX request to return the book
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "return_book.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onload = function () {
            if (xhr.status === 200) {
                // Handle the response (you can display a success message, update the page, etc.)
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    alert("Book returned successfully!");
                    // Reload the page or update the book status as needed
                    location.reload();
                } else {
                    alert("Failed to return the book.");
                }
            } else {
                alert("Error occurred while returning the book.");
            }
        };

        // Send user and book IDs to the PHP script for return
        const data = `bookId=${bookId}`;
        xhr.send(data);
    }
    
});
