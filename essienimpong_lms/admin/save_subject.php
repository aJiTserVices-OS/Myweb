<?php
require_once '../config/database.php';
require_once '../config/session.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: add_subject.php');
    exit;
}

$subject_name = trim($_POST['subject_name'] ?? '');
$subject_code = trim($_POST['subject_code'] ?? '');
$description = trim($_POST['description'] ?? '');

if (empty($subject_name) || empty($subject_code)) {
    $_SESSION['error'] = 'Subject name and code are required.';
    header('Location: add_subject.php');
    exit;
}

$stmt = $conn->prepare('SELECT subject_id FROM subjects WHERE subject_name = ? OR subject_code = ?');
if (!$stmt) {
    $_SESSION['error'] = 'Database error. Please try again.';
    header('Location: add_subject.php');
    exit;
}
$stmt->bind_param('ss', $subject_name, $subject_code);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $stmt->close();
    $_SESSION['error'] = 'Subject name or code already exists.';
    header('Location: add_subject.php');
    exit;
}
$stmt->close();

$insert = $conn->prepare('INSERT INTO subjects (subject_name, subject_code, description) VALUES (?, ?, ?)');
if (!$insert) {
    $_SESSION['error'] = 'Database error. Please try again.';
    header('Location: add_subject.php');
    exit;
}
$insert->bind_param('sss', $subject_name, $subject_code, $description);
if (!$insert->execute()) {
    $insert->close();
    $_SESSION['error'] = 'Failed to save subject.';
    header('Location: add_subject.php');
    exit;
}
$insert->close();

$_SESSION['success'] = 'Subject added successfully.';
header('Location: subjects.php');
exit;
?>