<?php
require_once '../config/constants.php';
require_once '../config/session.php';

if (isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "index.php");
    exit;
}

$loginUsername = $_SESSION['login_username'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login | Essienimpong M/A Primary LMS</title>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/login.css">

</head>

<body>

<div class="login-container">

<div class="glass-card">

<img src="<?php echo BASE_URL; ?>assets/images/logo.png" class="logo">

<h2>Essienimpong M/A Primary School</h2>

<p>Learning Management System</p>

<?php
if (isset($_SESSION['error'])) {
    echo '<div class="error-message">' . htmlspecialchars($_SESSION['error']) . '</div>';
    unset($_SESSION['error']);
}

if (isset($_SESSION['success'])) {
    echo '<div class="success-message">' . htmlspecialchars($_SESSION['success']) . '</div>';
    unset($_SESSION['success']);
}
?>

<form action="<?php echo BASE_URL; ?>auth/login_process.php" method="POST">

<input
    type="text"
    name="username"
    placeholder="Username or Email"
    value="<?php echo htmlspecialchars($loginUsername); ?>"
    required
    autofocus>

<input
    type="password"
    name="password"
    placeholder="Password"
    required>
<div class="remember">

<label>

<input type="checkbox" name="remember">

Remember Me

</label>

</div>

<button type="submit">

LOGIN

</button>

</form>

</div>

</div>

</body>

</html>