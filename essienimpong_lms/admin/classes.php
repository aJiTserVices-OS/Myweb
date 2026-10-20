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

$sql = "SELECT c.*, 
        CONCAT(t.first_name, ' ', t.last_name) AS teacher_name,
        SUM(CASE WHEN LOWER(s.gender) = 'male' THEN 1 ELSE 0 END) AS total_boys,
        SUM(CASE WHEN LOWER(s.gender) = 'female' THEN 1 ELSE 0 END) AS total_girls,
        COUNT(s.student_id) AS total_enrollment
        FROM classes c
        LEFT JOIN teachers t ON c.class_teacher = t.teacher_id
        LEFT JOIN students s ON s.class_id = c.class_id
        GROUP BY c.class_id
        ORDER BY c.class_level, c.class_name";

$result = $conn->query($sql);
?>

<div class="main-content">

<h1>Classes</h1>

<div style="margin-bottom:20px; display:flex; justify-content:flex-end; align-items:center; gap:15px;">
    <a href="add_class.php" class="action-btn">+ Add Class</a>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="error"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
<?php endif; ?>

<table>
    <tr>
        <th>Class Name</th>
        <th>Level</th>
        <th>Section</th>
        <th>Class Teacher</th>
        <th>Total Boys</th>
        <th>Total Girls</th>
        <th>Total Enrollment</th>
        <th>Created At</th>
    </tr>

    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['class_name']); ?></td>
                <td><?php echo htmlspecialchars($row['class_level']); ?></td>
                <td><?php echo htmlspecialchars($row['class_section'] ?: 'N/A'); ?></td>
                <td><?php echo htmlspecialchars($row['teacher_name'] ?: 'N/A'); ?></td>
                <td><?php echo intval($row['total_boys']); ?></td>
                <td><?php echo intval($row['total_girls']); ?></td>
                <td><?php echo intval($row['total_enrollment']); ?></td>
                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="8" style="text-align:center; padding:30px;">No classes found.</td>
        </tr>
    <?php endif; ?>
</table>

</div>

<?php
include '../includes/admin_footer.php';
?>