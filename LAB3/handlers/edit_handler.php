<?php
include '../database/db_connection.php';
session_start();
require '../jwt_helper.php';

if (!isset($_SESSION['jwt']) || !decodeJWT($_SESSION['jwt'])) {
    header("Location: ../pages/auth/login.php?msg=" . urlencode("Немате пристап."));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $name = $_POST['name'];
    $location = $_POST['location'];
    $date = $_POST['date'];
    $type = $_POST['type'];

    $db = connectDatabase();

    $stmt = $db->prepare("UPDATE events SET name = :name, location = :location, date = :date, type = :type WHERE id = :id");
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':location', $location);
    $stmt->bindValue(':date', $date);
    $stmt->bindValue(':type', $type);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $db = null;

    header("Location: ../index.php");
    exit();
} else {
    echo "Invalid request.";
}
?>