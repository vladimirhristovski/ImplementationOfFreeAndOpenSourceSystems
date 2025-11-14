<?php
include '../database/db_connection.php';
require '../jwt_helper.php';

session_start();
if (!isset($_SESSION['jwt']) || !decodeJWT($_SESSION['jwt'])) {
    header("Location: ../pages/auth/login.php?msg=" . urlencode("Немате пристап."));
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $db = connectDatabase();

    $stmt = $db->prepare("SELECT * FROM events WHERE id = :id");
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $stmt->execute();
    $event = $stmt->fetch();

    $db = null;
} else {
    die("Invalid expense ID.");
}
?>

    <h1>Update Event</h1>

<?php if ($event): ?>
    <form action="../handlers/edit_handler.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($event['id']); ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($event['name']); ?>" required>
        <br>
        <label for="location">Location:</label>
        <input type="text" name="location" id="location" value="<?php echo htmlspecialchars($event['location']); ?>"
               required>
        <br>
        <label for="date">Date:</label>
        <input type="date" name="date" id="date" value="<?php echo htmlspecialchars($event['date']); ?>" required>
        <br>
        <label for="type">Type:</label>
        <select name="type" id="type">
            <option <?php echo htmlspecialchars($event['type']) === 'public' ? 'selected=true' : ''; ?> value="public">
                public
            </option>
            <option <?php echo htmlspecialchars($event['type']) === 'private' ? 'selected=true' : ''; ?>
                    value="private">private
            </option>
        </select>
        <br/>
        <button type="submit">Update Event</button>
    </form>
<?php else: ?>
    <p>Event not found.</p>
<?php endif; ?>