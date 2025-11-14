<?php
include '../database/db_connection.php';
session_start();
require '../jwt_helper.php';

if (!isset($_SESSION['jwt']) || !decodeJWT($_SESSION['jwt'])) {
    header("Location: ../pages/auth/login.php?msg=" . urlencode("Немате пристап."));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $location = $_POST['location'] ?? '';
    $date = $_POST['date'] ?? date('d-m-Y');
    $type = $_POST['type'] ?? '';


    $db = connectDatabase();

    $stmt = $db->prepare("INSERT INTO events (name, location, date, type) VALUES (:name, :location, :date, :type)");
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':location', $location);
    $stmt->bindValue(':date', $date);
    $stmt->bindValue(':type', $type);

    if ($stmt->execute()) {
        header("Location: ../index.php");
    } else {
        echo "Error adding expense: " . $db->errorCode();
    }
    $db = null;
} else {
    echo "Invalid request method.";
}
?>