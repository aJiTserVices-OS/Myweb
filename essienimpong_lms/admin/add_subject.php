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
?>

<div class="main-content">

<h1>Add Subject</h1>

<form action="save_subject.php" method="POST">

<div class="form-grid">

<div class="form-group">
    <label>Subject Name</label>
    <input type="text" name="subject_name" required>
</div>

<div class="form-group">
    <label>Subject Code</label>
    <input type="text" name="subject_code" required>
</div>

<div class="form-group" style="grid-column:1 / -1;">
    <label>Description</label>
    <textarea name="description"></textarea>
</div>

</div>

<button type="submit">Save Subject</button>
<a href="subjects.php" class="action-btn" style="background:#555;">Cancel</a>

</form>

</div>

<?php
include '../includes/admin_footer.php';
?>