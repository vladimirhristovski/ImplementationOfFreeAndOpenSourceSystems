<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $db = connectDatabase();

    $stmt = $db->prepare("SELECT * FROM tasks WHERE id = :id");
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $result = $stmt->execute();
    $student = $result->fetchArray(SQLITE3_ASSOC);

    $db->close();
} else {
    die("Invalid task ID.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Task</title>
</head>
<body>
<h1>Update Task</h1>

<?php if ($student): ?>
    <form action="update_task.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($student['id']); ?>">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($student['title']); ?>" required><br><br>
        <label for="due_date">Due Date:</label>
        <input type="date" name="due_date" value="<?php echo htmlspecialchars($student['due_date']); ?>"
               required><br><br>
        <label for="priority">Priority:</label>
        <input type="text" name="priority" value="<?php echo htmlspecialchars($student['priority']); ?>"
               required><br><br>
        <label for="status">Status:</label>
        <input type="text" name="status" value="<?php echo htmlspecialchars($student['status']); ?>" required><br><br>
        <button type="submit">Update Task</button>
    </form>
<?php else: ?>
    <p>Task not found.</p>
<?php endif; ?>
</body>
</html>