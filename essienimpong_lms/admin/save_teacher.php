<?php
require_once '../config/database.php';
require_once '../config/session.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: add_teacher.php');
    exit;
}

function redirectToAdd($message, $isSuccess = false)
{
    $_SESSION[$isSuccess ? 'success' : 'error'] = $message;
    header('Location: add_teacher.php');
    exit;
}

$staff_number = trim($_POST['staff_number'] ?? '');
$first_name = trim($_POST['first_name'] ?? '');
$last_name = trim($_POST['last_name'] ?? '');
$gender = trim($_POST['gender'] ?? '');
$date_of_birth = trim($_POST['date_of_birth'] ?? null);
$phone = trim($_POST['phone'] ?? '');
$email = trim($_POST['email'] ?? '');
$address = trim($_POST['address'] ?? '');
$qualification = trim($_POST['qualification'] ?? '');
$EMIS_code = trim($_POST['EMIS_code'] ?? '');
$Lincese_Number = trim($_POST['Lincese_Number'] ?? '');
$SSNIT_Number = trim($_POST['SSNIT_Number'] ?? '');
$TIN_Number = trim($_POST['TIN_Number'] ?? '');
$GH_Card_Number = trim($_POST['GH_Card_Number'] ?? '');
$Fisrt_Appointment_Date = trim($_POST['Fisrt_Appointment_Date'] ?? null);
$Last_Promotion_Date = trim($_POST['Last_Promotion_Date'] ?? null);
$Current_Rank = trim($_POST['Current_Rank'] ?? '');
$Marital_status = trim($_POST['Marital_status'] ?? 'Single');
$Bank_Name = trim($_POST['Bank_Name'] ?? '');
$Account_Number = trim($_POST['Account_Number'] ?? '');
$Bank_Branch = trim($_POST['Bank_Branch'] ?? '');
$Number_of_Children = trim($_POST['Number_of_Children'] ?? '0');
$department_id = trim($_POST['department_id'] ?? '');
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');
$status = trim($_POST['status'] ?? 'Active');

if (empty($staff_number) || empty($first_name) || empty($last_name) || empty($gender) || empty($department_id) || empty($username) || empty($password)) {
    redirectToAdd('Please fill in all required fields.');
}

$photo = '';
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
    $photo = uniqid('teacher_', true) . '.' . $extension;
    $targetPath = $uploadDir . $photo;
    if (!move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
        redirectToAdd('Failed to upload teacher photo.');
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
$role_id = 3; // Teacher role
$user_status = $status === 'Inactive' ? 'Inactive' : 'Active';

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

$teacherStmt = $conn->prepare('INSERT INTO teachers (user_id, department_id, staff_number, first_name, last_name, gender, date_of_birth, phone, email, address, qualification, EMIS_code, Lincese_Number, SSNIT_Number, TIN_Number, GH_Card_Number, Fisrt_Appointment_Date, Last_Promotion_Date, Current_Rank, Marital_status, Bank_Name, Account_Number, Bank_Branch, Number_of_Children, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
if (!$teacherStmt) {
    $conn->rollback();
    redirectToAdd('Failed to create teacher record.');
}
$teacherStmt->bind_param(
    'iisssssssssssssssssssssss',
    $user_id,
    $department_id,
    $staff_number,
    $first_name,
    $last_name,
    $gender,
    $date_of_birth,
    $phone,
    $email,
    $address,
    $qualification,
    $EMIS_code,
    $Lincese_Number,
    $SSNIT_Number,
    $TIN_Number,
    $GH_Card_Number,
    $Fisrt_Appointment_Date,
    $Last_Promotion_Date,
    $Current_Rank,
    $Marital_status,
    $Bank_Name,
    $Account_Number,
    $Bank_Branch,
    $Number_of_Children,
    $photo
);

if (!$teacherStmt->execute()) {
    $teacherStmt->close();
    $conn->rollback();
    redirectToAdd('Failed to save teacher information.');
}

$teacherStmt->close();
$conn->commit();

redirectToAdd('Teacher added successfully.', true);
