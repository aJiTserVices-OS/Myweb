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

$sql = "SELECT a.*, 
        s.first_name AS student_first_name,
        s.last_name AS student_last_name,
        c.class_name,
        c.class_level,
        c.class_section
        FROM attendance a
        LEFT JOIN students s ON a.student_id = s.student_id
        LEFT JOIN classes c ON a.class_id = c.class_id
        ORDER BY a.attendance_date DESC, c.class_level, c.class_name, s.last_name";
$result = $conn->query($sql);
?>

<div class="main-content">

<h1>Attendance</h1>

<div style="margin-bottom:20px; display:flex; justify-content:flex-end; align-items:center; gap:15px;">
    <a href="add_attendance.php" class="action-btn">+ Add Attendance</a>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="error"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
<?php endif; ?>

<table>
    <tr>
        <th>Date</th>
        <th>Student</th>
        <th>Class</th>
        <th>Status</th>
        <th>Remarks</th>
    </tr>

    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['attendance_date']); ?></td>
                <td><?php echo htmlspecialchars($row['student_first_name'] . ' ' . $row['student_last_name']); ?></td>
                <td><?php echo htmlspecialchars($row['class_name'] . ' ' . $row['class_level'] . ' ' . ($row['class_section'] ?: '')); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td><?php echo htmlspecialchars($row['remarks'] ?: ''); ?></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="5" style="text-align:center; padding:30px;">No attendance records found.</td>
        </tr>
    <?php endif; ?>
</table>

</div>

<?php
include '../includes/admin_footer.php';
?>