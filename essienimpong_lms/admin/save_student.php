<?php
require_once '../config/database.php';
require_once '../config/session.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: add_student.php');
    exit;
}

function redirectToAdd($message, $isSuccess = false)
{
    $_SESSION[$isSuccess ? 'success' : 'error'] = $message;
    header('Location: add_student.php');
    exit;
}

$admission_number = trim($_POST['admission_number'] ?? '');
$first_name = trim($_POST['first_name'] ?? '');
$last_name = trim($_POST['last_name'] ?? '');
$other_name = trim($_POST['other_name'] ?? '');
$gender = trim($_POST['gender'] ?? '');
$date_of_birth = trim($_POST['date_of_birth'] ?? null);
$place_of_birth = trim($_POST['place_of_birth'] ?? '');
$nationality = trim($_POST['nationality'] ?? 'Ghanaian');
$religion = trim($_POST['religion'] ?? '');
$address = trim($_POST['address'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$email = trim($_POST['email'] ?? '');
$parent_name = trim($_POST['parent_name'] ?? '');
$parent_phone = trim($_POST['parent_phone'] ?? '');
$emergency_contact = trim($_POST['emergency_contact'] ?? '');
$class_id = trim($_POST['class_id'] ?? '');
$admission_date = trim($_POST['admission_date'] ?? date('Y-m-d'));
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');
$status = trim($_POST['status'] ?? 'Active');

if (empty($admission_number) || empty($first_name) || empty($last_name) || empty($gender) || empty($class_id) || empty($username) || empty($password) || empty($parent_name) || empty($parent_phone)) {
    redirectToAdd('Please fill in all required fields.');
}

if (!in_array($status, ['Active', 'Inactive'], true)) {
    $status = 'Active';
}

$student_photo = '';
if (!empty($_FILES['photo']['name']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = __DIR__ . '/../assets/uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $fileInfo = pathinfo($_FILES['photo']['name']);
    $allowed = ['jpg', 'jpeg', 'png'];
    $extension = strtolower($fileInfo['extension'] ?? '');

    if (!in_array($extension, $allowed, true)) {
        redirectToAdd('Only JPG, JPEG, and PNG image uploads are allowed.');
    }

    $student_photo = uniqid('student_', true) . '.' . $extension;
    $targetPath = $uploadDir . $student_photo;

    if (!move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
        redirectToAdd('Failed to upload student photo.');
    }
}

$stmt = $conn->prepare('SELECT user_id FROM users WHERE username = ? OR email = ?');
if (!$stmt) {
    redirectToAdd('Database error. Please try again.');
}
$stmt->bind_param('ss', $username, $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $stmt->close();
    redirectToAdd('Username or email is already in use.');
}
$stmt->close();

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$role_id = 4; // Student role
$user_status = 'Active';

$conn->begin_transaction();

$userStmt = $conn->prepare('INSERT INTO users (role_id, username, password, email, phone, status) VALUES (?, ?, ?, ?, ?, ?)');
if (!$userStmt) {
    $conn->rollback();
    redirectToAdd('Failed to create user account.');
}
$userStmt->bind_param('isssss', $role_id, $username, $hashedPassword, $email, $phone, $user_status);
if (!$userStmt->execute()) {
    $userStmt->close();
    $conn->rollback();
    redirectToAdd('Failed to create user account.');
}
$user_id = $conn->insert_id;
$userStmt->close();

$nhis_number = '';
$gh_card_number = '';

$studentStmt = $conn->prepare(
    'INSERT INTO students (user_id, class_id, admission_number, NHIS_Number, GH_Card_Number, first_name, last_name, other_name, gender, date_of_birth, place_of_birth, nationality, religion, admission_date, photo, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
);
if (!$studentStmt) {
    $conn->rollback();
    redirectToAdd('Failed to create student record.');
}
$studentStmt->bind_param(
    'iissssssssssssss',
    $user_id,
    $class_id,
    $admission_number,
    $nhis_number,
    $gh_card_number,
    $first_name,
    $last_name,
    $other_name,
    $gender,
    $date_of_birth,
    $place_of_birth,
    $nationality,
    $religion,
    $admission_date,
    $student_photo,
    $status
);

if (!$studentStmt->execute()) {
    $studentStmt->close();
    $conn->rollback();
    redirectToAdd('Failed to save student information.');
}

$studentStmt->close();
$conn->commit();

redirectToAdd('Student registered successfully.', true);
