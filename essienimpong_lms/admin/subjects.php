<?php
require_once '../config/database.php';
require_once '../config/session.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

include '../includes/admin_header.php';
include '../includes/admin_sidebar.php';
include '../includes/admin_topbar.php';

$sql = "SELECT * FROM subjects ORDER BY subject_name";
$result = $conn->query($sql);
?>

<div class="main-content">

<h1>Subjects</h1>

<div style="margin-bottom:20px; display:flex; justify-content:flex-end; align-items:center; gap:15px;">
    <a href="add_subject.php" class="action-btn">+ Add Subject</a>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="error"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
<?php endif; ?>

<table>
    <tr>
        <th>Subject Name</th>
        <th>Subject Code</th>
        <th>Description</th>
        <th>Created At</th>
    </tr>

    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['subject_name']); ?></td>
                <td><?php echo htmlspecialchars($row['subject_code']); ?></td>
                <td><?php echo nl2br(htmlspecialchars($row['description'] ?: 'N/A')); ?></td>
                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="4" style="text-align:center; padding:30px;">No subjects found.</td>
        </tr>
    <?php endif; ?>
</table>

</div>

<?php
include '../includes/admin_footer.php';
?>