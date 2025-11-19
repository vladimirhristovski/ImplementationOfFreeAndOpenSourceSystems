<?php
include './database/db_connection.php';
include './jwt_helper.php';

session_start();

if (!isset($_SESSION['jwt']) || !decodeJWT($_SESSION['jwt'])) {
    header("Location: ../pages/auth/login.php?msg=");
    exit;
}

$db = connectDatabase();

$query = "SELECT * FROM payments";
$result = $db->query($query);

if (!$result) {
    die("Error fetching events: " . $db->errorCode());
}

$message = $_GET['msg'] ?? '';
?>

<body>
<div>
    <h1>Payments List</h1>
    <?php if ($message): ?>
        <p style="color: red;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <a href="pages/create.php">
        Add Payment
    </a>
    <a href="handlers/auth/logout_handler.php">
        Logout
    </a>
</div>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Date</th>
        <th>Amount</th>
        <th>Type</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($result): ?>
        <?php while ($payment = $result->fetchArray(SQLITE3_ASSOC)): ?>
            <tr>
                <td><?php echo htmlspecialchars($payment['id']); ?></td>
                <td><?php echo htmlspecialchars($payment['name']); ?></td>
                <td><?php echo htmlspecialchars($payment['date']); ?></td>
                <td><?php echo htmlspecialchars($payment['amount']); ?></td>
                <td><?php echo htmlspecialchars($payment['type']); ?></td>
                <td>
                    <?php if ($payment['amount'] <= 100): ?>
                        <form action="handlers/delete_handler.php" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $payment['id']; ?>">
                            <button type="submit">Delete</button>
                        </form>
                    <?php endif ?>
                    <?php if ($payment['amount'] > 100): ?>
                        <p>Не може да се избрише.</p>
                    <?php endif ?>
                    <form action="pages/edit.php" method="get" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $payment['id']; ?>">
                        <button type="submit">Update</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="5">No payments found.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
</body>