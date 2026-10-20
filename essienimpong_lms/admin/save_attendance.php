<?php
require_once '../config/database.php';
require_once '../config/session.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: add_attendance.php');
    exit;
}

$attendance_date = trim($_POST['attendance_date'] ?? '');
$class_id = trim($_POST['class_id'] ?? '');
$student_id = trim($_POST['student_id'] ?? '');
$status = trim($_POST['status'] ?? '');
$remarks = trim($_POST['remarks'] ?? '');

if (empty($attendance_date) || empty($class_id) || empty($student_id) || empty($status)) {
    $_SESSION['error'] = 'Please fill in all required fields.';
    header('Location: add_attendance.php');
    exit;
}

$validStatuses = ['Present', 'Absent', 'Late', 'Excused'];
if (!in_array($status, $validStatuses, true)) {
    $_SESSION['error'] = 'Invalid attendance status.';
    header('Location: add_attendance.php');
    exit;
}

$stmt = $conn->prepare('SELECT attendance_id FROM attendance WHERE attendance_date = ? AND student_id = ?');
if (!$stmt) {
    $_SESSION['error'] = 'Database error. Please try again.';
    header('Location: add_attendance.php');
    exit;
}
$stmt->bind_param('si', $attendance_date, $student_id);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $stmt->close();
    $_SESSION['error'] = 'Attendance already recorded for this student and date.';
    header('Location: add_attendance.php');
    exit;
}
$stmt->close();

$insert = $conn->prepare('INSERT INTO attendance (student_id, class_id, attendance_date, status, remarks) VALUES (?, ?, ?, ?, ?)');
if (!$insert) {
    $_SESSION['error'] = 'Database error. Please try again.';
    header('Location: add_attendance.php');
    exit;
}
$insert->bind_param('iisss', $student_id, $class_id, $attendance_date, $status, $remarks);
if (!$insert->execute()) {
    $insert->close();
    $_SESSION['error'] = 'Failed to save attendance.';
    header('Location: add_attendance.php');
    exit;
}
$insert->close();

$_SESSION['success'] = 'Attendance saved successfully.';
header('Location: attendance.php');
exit;
?>