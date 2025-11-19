<?php
include '../database/db_connection.php';


require '../jwt_helper.php';
session_start();

// Проверка дали JWT токенот постои и е валиден
if (!isset($_SESSION['jwt']) || !decodeJWT($_SESSION['jwt'])) {
    header("Location: ../pages/auth/login.php");
    exit;
}


if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $db = connectDatabase();

    // Fetch the current details of the student
    $stmt = $db->prepare("SELECT * FROM payments WHERE id = :id");
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $result = $stmt->execute();
    $payment = $result->fetchArray(SQLITE3_ASSOC);

    $db->close();
} else {
    die("Invalid payment ID.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Payment</title>
</head>
<body>
<h1>Update Payment</h1>

<?php if ($payment): ?>
    <form action="../handlers/edit_handler.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($payment['id']); ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($payment['name']); ?>" required><br><br>
        <label for="date">Date:</label>
        <input type="date" name="date" value="<?php echo htmlspecialchars($payment['date']); ?>" required><br><br>
        <label for="amount">Amount:</label>
        <input type="number" name="amount" value="<?php echo htmlspecialchars($payment['amount']); ?>" required><br><br>
        <label for="type">Type:</label>
        <select name="type" id="type" required>
            <option <?php echo htmlspecialchars($payment['type']) === 'cash' ? 'selected=true' : '' ?> value="cash">
                Cash
            </option>
            <option <?php echo htmlspecialchars($payment['type']) === 'card' ? 'selected=true' : '' ?> value="card">
                Card
            </option>
        </select>
        <button type="submit">Update Payment</button>
    </form>
<?php else: ?>
    <p>Payment not found.</p>
<?php endif; ?>
</body>
</html>