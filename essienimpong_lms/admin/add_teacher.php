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

$departments = $conn->query('SELECT department_id, department_name FROM departments ORDER BY department_name');
?>

<div class="main-content">

<h1>Add New Teacher</h1>

<form action="save_teacher.php" method="POST" enctype="multipart/form-data">

<div class="form-grid">

<div class="form-group">
    <label>Staff Number</label>
    <input type="text" name="staff_number" required>
</div>

<div class="form-group">
    <label>First Name</label>
    <input type="text" name="first_name" required>
</div>

<div class="form-group">
    <label>Last Name</label>
    <input type="text" name="last_name" required>
</div>

<div class="form-group">
    <label>Department</label>
    <select name="department_id" required>
        <option value="">Select Department</option>
        <?php while ($department = $departments->fetch_assoc()): ?>
            <option value="<?php echo $department['department_id']; ?>"><?php echo htmlspecialchars($department['department_name']); ?></option>
        <?php endwhile; ?>
    </select>
</div>

<div class="form-group">
    <label>Gender</label>
    <select name="gender" required>
        <option value="">Select Gender</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
    </select>
</div>

<div class="form-group">
    <label>Date of Birth</label>
    <input type="date" name="date_of_birth">
</div>

<div class="form-group">
    <label>Phone</label>
    <input type="text" name="phone">
</div>

<div class="form-group">
    <label>Email</label>
    <input type="email" name="email">
</div>

<div class="form-group">
    <label>Address</label>
    <textarea name="address"></textarea>
</div>

<div class="form-group">
    <label>Qualification</label>
    <input type="text" name="qualification">
</div>

<div class="form-group">
    <label>EMIS Code</label>
    <input type="text" name="EMIS_code">
</div>

<div class="form-group">
    <label>License Number</label>
    <input type="text" name="Lincese_Number">
</div>

<div class="form-group">
    <label>SSNIT Number</label>
    <input type="text" name="SSNIT_Number">
</div>

<div class="form-group">
    <label>TIN Number</label>
    <input type="text" name="TIN_Number">
</div>

<div class="form-group">
    <label>GH Card Number</label>
    <input type="text" name="GH_Card_Number">
</div>

<div class="form-group">
    <label>First Appointment Date</label>
    <input type="date" name="Fisrt_Appointment_Date">
</div>

<div class="form-group">
    <label>Last Promotion Date</label>
    <input type="date" name="Last_Promotion_Date">
</div>

<div class="form-group">
    <label>Current Rank</label>
    <input type="text" name="Current_Rank">
</div>

<div class="form-group">
    <label>Marital Status</label>
    <select name="Marital_status">
        <option value="Single">Single</option>
        <option value="Married">Married</option>
        <option value="Widow">Widow</option>
        <option value="Divorce">Divorce</option>
    </select>
</div>

<div class="form-group">
    <label>Bank Name</label>
    <input type="text" name="Bank_Name">
</div>

<div class="form-group">
    <label>Account Number</label>
    <input type="text" name="Account_Number">
</div>

<div class="form-group">
    <label>Bank Branch</label>
    <input type="text" name="Bank_Branch">
</div>

<div class="form-group">
    <label>Number of Children</label>
    <input type="text" name="Number_of_Children" value="0">
</div>

<div class="form-group">
    <label>Photo</label>
    <input type="file" name="photo" accept=".jpg,.jpeg,.png">
</div>

<div class="form-group">
    <label>Username</label>
    <input type="text" name="username" required>
</div>

<div class="form-group">
    <label>Password</label>
    <input type="password" name="password" required>
</div>

<div class="form-group">
    <label>Status</label>
    <select name="status">
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
    </select>
</div>

</div>

<button type="submit">Save Teacher</button>
<a href="teachers.php" class="action-btn" style="background:#555;">Cancel</a>

</form>

</div>

<?php
include '../includes/admin_footer.php';
?>