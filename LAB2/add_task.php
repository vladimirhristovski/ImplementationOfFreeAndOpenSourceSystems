<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $dueDate = $_POST['due_date'] ?? '';
    $priority = ($_POST['priority'] ?? '');
    $status = ($_POST['status'] ?? '');

    if (empty($title) || empty($dueDate) || empty($priority) || empty($status)) {
        echo "Please fill in all required fields correctly.";
        exit;
    }

    if ($priority == 'Low' || $priority == 'Medium' || $priority == 'High') {

    } else {
        echo "Accepted values are: Low, Medium, High.";
        exit;
    }

    if ($status == 'Pending' || $status == 'Done') {

    } else {
        echo "Accepted values are: Pending, Done.";
        exit;
    }

    $db = connectDatabase();

    $stmt = $db->prepare("INSERT INTO tasks (title, due_date, priority, status) VALUES (:title, :due_date, :priority, :status)");
    $stmt->bindValue(':title', $title, SQLITE3_TEXT);
    $stmt->bindValue(':due_date', $dueDate, SQLITE3_TEXT);
    $stmt->bindValue(':priority', $priority, SQLITE3_TEXT);
    $stmt->bindValue(':status', $status, SQLITE3_TEXT);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Error adding student: " . $db->lastErrorMsg();
    }

    $db->close();
} else {
    echo "Invalid request method. Please submit the form to add a student.";
}