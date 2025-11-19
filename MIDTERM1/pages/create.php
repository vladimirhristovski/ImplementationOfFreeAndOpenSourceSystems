<?php

require '../jwt_helper.php';
session_start();

// Проверка дали JWT токенот постои и е валиден
if (!isset($_SESSION['jwt']) || !decodeJWT($_SESSION['jwt'])) {
    header("Location: ../pages/auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Payment</title>
</head>
<body>
<form action="../handlers/create_handler.php" method="POST">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" required>
    <br/>
    <label for="date">Date:</label>
    <input type="date" name="date" id="date" required>
    <br/>
    <label for="amount">Amount:</label>
    <input type="number" name="amount" id="amount" required>
    <br/>
    <label for="type">Type:</label>
    <select name="type" id="type" required>
        <option value="cash">Cash</option>
        <option value="card">Card</option>
    </select>
    <br/>
    <button type="submit">Add Payment</button>
</form>
</body>