<?php
require_once '../config/database.php';
require_once '../config/session.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../includes/admin_header.php';
include '../includes/admin_sidebar.php';
include '../includes/admin_topbar.php';
?>

<div class="main-content">

<h1>Parent Management</h1>

<div style="margin-bottom:20px; display:flex; justify-content:flex-end; align-items:center; gap:15px;">
    <a href="add_parrents.php" class="action-btn">+ Add Parent</a>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="error"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
<?php endif; ?>

<?php
$sql = "SELECT p.*, u.email AS user_email, u.phone AS user_phone FROM parents p LEFT JOIN users u ON p.user_id = u.user_id ORDER BY p.last_name, p.first_name";
$result = $conn->query($sql);
?>

<table>
    <tr>
        <th>Name</th>
        <th>Relationship</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Occupation</th>
        <th>Marital Status</th>
        <th>Joined</th>
    </tr>
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                <td><?php echo htmlspecialchars($row['relationship'] ?: 'N/A'); ?></td>
                <td><?php echo htmlspecialchars($row['user_phone'] ?: $row['phone'] ?: 'N/A'); ?></td>
                <td><?php echo htmlspecialchars($row['user_email'] ?: $row['email'] ?: 'N/A'); ?></td>
                <td><?php echo htmlspecialchars($row['occupation'] ?: 'N/A'); ?></td>
                <td><?php echo htmlspecialchars($row['Marital_Status'] ?: 'N/A'); ?></td>
                <td><?php echo !empty($row['Date_of_Birth']) ? htmlspecialchars($row['Date_of_Birth']) : 'N/A'; ?></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="7" style="text-align:center; padding:30px;">No parents found.</td>
        </tr>
    <?php endif; ?>
</table>

</div>

<?php
include '../includes/admin_footer.php';
?>
