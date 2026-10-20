<?php

require_once '../config/constants.php';
require_once '../config/database.php';
require_once '../config/session.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: " . BASE_URL . "auth/login.php");
    exit;
}

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

if (!empty($username)) {
    $_SESSION['login_username'] = $username;
}

if (empty($username) || empty($password)) {
    $_SESSION['error'] = 'Username and password are required.';
    header("Location: " . BASE_URL . "auth/login.php");
    exit;
}

$sql = "SELECT users.user_id, users.username, users.email, users.password, roles.role_name
        FROM users
        JOIN roles ON users.role_id = roles.role_id
        WHERE users.username = ? OR users.email = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    $_SESSION['error'] = 'Database error. Please try again.';
    header("Location: " . BASE_URL . "auth/login.php");
    exit;
}

$stmt->bind_param("ss", $username, $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($user_id, $user_username, $user_email, $db_password, $role_name);
    $stmt->fetch();

    if (password_verify($password, $db_password)) {
        regenerateSession();

        $_SESSION['user_id'] = $user_id;
        $_SESSION['role_name'] = $role_name;
        $_SESSION['username'] = $user_username;
        unset($_SESSION['login_username']);
        $_SESSION['success'] = 'Login successful!';

        $stmt->close();
        header("Location: " . BASE_URL . "index.php");
        exit;
    }

    $_SESSION['error'] = 'Incorrect password. Please try again.';
} else {
    $_SESSION['error'] = 'User not found. Please check your username or email.';
}

$stmt->close();
header("Location: " . BASE_URL . "auth/login.php");
exit;
?>