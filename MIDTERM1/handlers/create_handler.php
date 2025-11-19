<?php
// Include the database connection file
include '../database/db_connection.php';
include '../jwt_helper.php';
session_start();

if (!isset($_SESSION['jwt']) || !decodeJWT($_SESSION['jwt'])) {
    header("Location: ../pages/auth/login.php");
    exit;
}

// Check if the request method is POST to handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form values from the POST request, with basic validation
    $name = $_POST['name'] ?? '';
    $date = $_POST['date'] ?? '';
    $amount = (int)($_POST['amount'] ?? 0);
    $type = $_POST['type'] ?? 'Cash';

    // Validate required fields
    if (empty($name) || empty($date) || empty($amount) || empty($type)) {
        echo "Please fill in all required fields correctly.";
        exit;
    }

    // Connect to the SQLite database
    $db = connectDatabase();

    // Prepare and execute the insert statement
    $stmt = $db->prepare("INSERT INTO payments (name, date, amount, type) VALUES (:name, :date, :amount, :type)");
    $stmt->bindValue(':name', $name, SQLITE3_TEXT);
    $stmt->bindValue(':date', $date, SQLITE3_TEXT);
    $stmt->bindValue(':amount', $amount, SQLITE3_INTEGER);
    $stmt->bindValue(':type', $type, SQLITE3_TEXT);


    // Execute the statement and check for success
    if ($stmt->execute()) {
        // Redirect back to the view page
        header("Location: ../index.php");
    } else {
        echo "Error adding payment: " . $db->lastErrorMsg();
    }

    // Close the database connection
    $db->close();
} else {
    // If not a POST request, display an error message
    echo "Invalid request method. Please submit the form to add a payment.";
}
?>