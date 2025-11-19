<?php
include '../database/db_connection.php';
include '../jwt_helper.php';

session_start();

if (!isset($_SESSION['jwt']) || !decodeJWT($_SESSION['jwt'])) {
    header("Location: ../pages/auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $db = connectDatabase();

    // Delete student by ID
    $stmt = $db->prepare("SELECT * FROM payments WHERE id = :id");
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $result = $stmt->execute();
    $payment = $result->fetchArray(SQLITE3_ASSOC);

    if ($payment['amount'] > 100) {
        exit;
    } else {
        $stmt = $db->prepare("DELETE FROM payments WHERE id = :id");
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        $stmt->execute();
    }

    // Close the database connection
    $db->close();

    // Redirect back to the view page
    header("Location: ../index.php");
    exit();
} else {
    echo "Invalid request.";
}
?>