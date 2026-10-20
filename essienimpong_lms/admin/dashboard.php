<?php
require_once '../config/session.php';
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once 'dashboard_data.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../includes/admin_header.php';
include '../includes/admin_sidebar.php';
include '../includes/admin_topbar.php';
?>

<div class="main-content">

<h1>Administrator Dashboard</h1>

<div class="dashboard-cards">

<div class="card">
<h2>Total Students</h2>
<p id="student-count">0</p>

</div>

<div class="card">
<h2>Total Teachers</h2>
<p id="teacher-count">0</p>
</div>

<div class="card">
<h2>Total Parents</h2>
<p id="parent-count">0</p>
</div>

<div class="card">
<h2>Total Classes</h2>
<p id="class-count">0</p>
</div>

</div>

<div class="dashboard-cards">

<div class="card">
<h2>Total Students</h2>
<p><?php echo $total_students; ?></p>
</div>

<div class="dashboard-section">

<h2>Latest Announcements</h2>

<table>

<tr>

<th>Title</th>

<th>Audience</th>

<th>Publish Date</th>

</tr>

<?php

$sql = "SELECT
title,
audience,
publish_date
FROM announcements
ORDER BY announcement_id DESC
LIMIT 5";

$result = $conn->query($sql);

while($row = $result->fetch_assoc()){

?>

<tr>

<td><?php echo htmlspecialchars($row['title']); ?></td>

<td><?php echo htmlspecialchars($row['audience']); ?></td>

<td><?php echo htmlspecialchars($row['publish_date']); ?></td>

</tr>

<?php } ?>

</table>

</div>

<div class="card">
<h2>Total Teachers</h2>
<p><?php echo $total_teachers; ?></p>
</div>

<div class="card">
<h2>Total Parents</h2>
<p><?php echo $total_parents; ?></p>
</div>

<div class="card">
<h2>Total Classes</h2>
<p><?php echo $total_classes; ?></p>
</div>

<div class="card">
<h2>Total Subjects</h2>
<p><?php echo $total_subjects; ?></p>
</div>

<div class="card">
<h2>Total Users</h2>
<p><?php echo $total_users; ?></p>
</div>

</div>

</div>

</div>
<div class="dashboard-section">

<h2>Recently Registered Students</h2>

<table>

<tr>

<th>Admission No.</th>

<th>Name</th>

<th>Gender</th>

<th>Admission Date</th>

</tr>

<?php

$sql = "SELECT admission_number,
first_name,
last_name,
gender,
admission_date
FROM students
ORDER BY student_id DESC
LIMIT 5";

$result = $conn->query($sql);

while($row = $result->fetch_assoc()){

?>

<tr>

<td><?php echo htmlspecialchars($row['admission_number']); ?></td>

<td><?php echo htmlspecialchars($row['first_name']." ".$row['last_name']); ?></td>

<td><?php echo htmlspecialchars($row['gender']); ?></td>

<td><?php echo htmlspecialchars($row['admission_date']); ?></td>

</tr>

<?php } ?>

</table>

</div>
<div class="dashboard-section">

<h2>System Information</h2>

<table>

<tr>
<td>Current Academic Year</td>
<td>2026 / 2027</td>
</tr>

<tr>
<td>Current Term</td>
<td>Term 1</td>
</tr>

<tr>
<td>Logged in User</td>
<td><?php echo htmlspecialchars($_SESSION['username']); ?></td>
</tr>

<tr>
<td>User Role</td>
<td><?php echo htmlspecialchars($_SESSION['role_name']); ?></td>
</tr>

<tr>
<td>Server Time</td>
<td><?php echo date("d M Y h:i A"); ?></td>
</tr>

<tr>
<td>Application Version</td>
<td>1.0</td>
</tr>

</table>

</div>

<?php
include '../includes/admin_footer.php';
?>