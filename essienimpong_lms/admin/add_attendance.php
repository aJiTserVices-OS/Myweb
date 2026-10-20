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

$students = $conn->query('SELECT student_id, first_name, last_name FROM students ORDER BY last_name, first_name');
$classes = $conn->query('SELECT class_id, class_name, class_level, class_section FROM classes ORDER BY class_level, class_name');
?>

<div class="main-content">

<h1>Add Attendance</h1>

<form action="save_attendance.php" method="POST">

<div class="form-grid">

<div class="form-group">
    <label>Attendance Date</label>
    <input type="date" name="attendance_date" value="<?php echo date('Y-m-d'); ?>" required>
</div>

<div class="form-group">
    <label>Class</label>
    <select name="class_id" required>
        <option value="">Select Class</option>
        <?php while ($class = $classes->fetch_assoc()): ?>
            <option value="<?php echo $class['class_id']; ?>"><?php echo htmlspecialchars($class['class_name'] . ' ' . $class['class_level'] . ' ' . $class['class_section']); ?></option>
        <?php endwhile; ?>
    </select>
</div>

<div class="form-group">
    <label>Student</label>
    <select name="student_id" required>
        <option value="">Select Student</option>
        <?php while ($student = $students->fetch_assoc()): ?>
            <option value="<?php echo $student['student_id']; ?>"><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></option>
        <?php endwhile; ?>
    </select>
</div>

<div class="form-group">
    <label>Status</label>
    <select name="status" required>
        <option value="">Select Status</option>
        <option value="Present">Present</option>
        <option value="Absent">Absent</option>
        <option value="Late">Late</option>
        <option value="Excused">Excused</option>
    </select>
</div>

<div class="form-group" style="grid-column:1 / -1;">
    <label>Remarks</label>
    <textarea name="remarks"></textarea>
</div>

</div>

<button type="submit">Save Attendance</button>
<a href="attendance.php" class="action-btn" style="background:#555;">Cancel</a>

</form>

</div>

<?php
include '../includes/admin_footer.php';
?>