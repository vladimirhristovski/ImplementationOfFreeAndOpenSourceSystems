<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $title = $_POST['title'];
    $dueDate = $_POST['due_date'];
    $priority = ($_POST['priority']);
    $status = ($_POST['status']);

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

    $stmt = $db->prepare("UPDATE tasks SET title = :title, due_date = :due_date, priority = :priority, status = :status WHERE id = :id");
    $stmt->bindValue(':title', $title, SQLITE3_TEXT);
    $stmt->bindValue(':due_date', $dueDate, SQLITE3_TEXT);
    $stmt->bindValue(':priority', $priority, SQLITE3_TEXT);
    $stmt->bindValue(':status', $status, SQLITE3_TEXT);
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $stmt->execute();

    $db->close();

    header("Location: index.php");
    exit();
} else {
    echo "Invalid request.";
}
?>