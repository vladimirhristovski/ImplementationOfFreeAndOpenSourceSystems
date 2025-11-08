<?php
// Include the database connection file
include 'db_connection.php';

// Connect to the SQLite database
$db = connectDatabase();

// Fetch all students from the database
$query = "SELECT * FROM tasks";
$result = $db->query($query);

if (!$result) {
    die("Error fetching students: " . $db->lastErrorMsg());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Tasks</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
            text-align: left;
        }
    </style>
</head>
<body>
<div style="display: flex; align-items: center; justify-content: space-between">
    <h1>Task List</h1>
    <a href="add_task_form.php">
        Add Task
    </a>
</div>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Due Date</th>
        <th>Priority</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($result): ?>
        <?php while ($task = $result->fetchArray(SQLITE3_ASSOC)): ?>
            <tr>
                <td><?php echo htmlspecialchars($task['id']); ?></td>
                <td><?php echo htmlspecialchars($task['title']); ?></td>
                <td><?php echo htmlspecialchars($task['due_date']); ?></td>
                <td><?php echo htmlspecialchars($task['priority']); ?></td>
                <td><?php echo htmlspecialchars($task['status']); ?></td>
                <td>
                    <form action="delete_task.php" method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                        <button type="submit">Delete</button>
                    </form>
                    <form action="update_task_form.php" method="get" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                        <button type="submit">Update</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="5">No tasks found.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
</body>
</html>