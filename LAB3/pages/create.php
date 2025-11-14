<?php
session_start();
require '../jwt_helper.php';

if (!isset($_SESSION['jwt']) || !decodeJWT($_SESSION['jwt'])) {
    header("Location: ../pages/auth/login.php?msg=" . urlencode("Немате пристап."));
    exit;
}
?>

<form action="../handlers/create_handler.php" method="POST">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" required>
    <br/>
    <label for="location">Location:</label>
    <input type="text" name="location" id="location" required>
    <br/>
    <label for="date">Date:</label>
    <input type="date" name="date" id="date" required>
    <br/>
    <label for="type">Type:</label>
    <select name="type" id="type">
        <option value="public">public</option>
        <option value="private">private</option>
    </select>
    <br/>
    <button type="submit">Add Event</button>
</form>