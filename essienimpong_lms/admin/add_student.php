<?php
require_once '../config/database.php';
require_once '../config/session.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

/* Generate Admission Number */
$year = date('Y');

$result = $conn->query("SELECT MAX(student_id) AS last_id FROM students");
$row = $result->fetch_assoc();

$next = ($row['last_id'] ?? 0) + 1;

$admission_no = "ESS-" . $year . "-" . str_pad($next,4,"0",STR_PAD_LEFT);

include '../includes/admin_header.php';
include '../includes/admin_sidebar.php';
include '../includes/admin_topbar.php';
?>

<div class="main-content">

<h1>Student Admission Form</h1>

<form action="save_student.php"
      method="POST"
      enctype="multipart/form-data">

<div class="form-grid">

<div class="form-group">

<label>Student Photo</label>

<input
type="file"
name="photo"
accept=".jpg,.jpeg,.png"
onchange="previewImage(event)">

<img
id="preview"
src="../assets/images/default-user.png"
style="width:120px;height:120px;border-radius:50%;margin-top:10px;object-fit:cover;">

</div>

<div class="form-group">

<label>Admission Number</label>

<input
type="text"
name="admission_number"
value="<?php echo $admission_no;?>"
readonly>

</div>

<div class="form-group">

<label>First Name</label>

<input
type="text"
name="first_name"
required>

</div>

<div class="form-group">

<label>Last Name</label>

<input
type="text"
name="last_name"
required>

</div>

<div class="form-group">

<label>Other Name</label>

<input
type="text"
name="other_name">

</div>

<div class="form-group">

<label>Gender</label>

<select
name="gender"
required>

<option value="">Select</option>

<option>Male</option>

<option>Female</option>

</select>

</div>

<div class="form-group">

<label>Date of Birth</label>

<input
type="date"
name="date_of_birth"
required>

</div>

<div class="form-group">

<label>Place of Birth</label>

<input
type="text"
name="place_of_birth">

</div>

<div class="form-group">

<label>Nationality</label>

<input
type="text"
name="nationality"
value="Ghanaian">

</div>

<div class="form-group">

<label>Religion</label>

<input
type="text"
name="religion">

</div>

<div class="form-group">

<label>Address</label>

<textarea
name="address"></textarea>

</div>

<div class="form-group">

<label>Phone Number</label>

<input
type="text"
name="phone">

</div>

<div class="form-group">

<label>Email Address</label>

<input
type="email"
name="email">

</div>

<div class="form-group">

<label>Parent / Guardian</label>

<input
type="text"
name="parent_name"
required>

</div>

<div class="form-group">

<label>Parent Phone</label>

<input
type="text"
name="parent_phone"
required>

</div>

<div class="form-group">

<label>Emergency Contact</label>

<input
type="text"
name="emergency_contact">

</div>

<div class="form-group">

<label>Class</label>

<select
name="class_id"
required>

<option value="">Select Class</option>

<?php

$classes = $conn->query("SELECT * FROM classes ORDER BY class_level");

while($class = $classes->fetch_assoc()){

?>

<option value="<?php echo $class['class_id'];?>">

<?php echo htmlspecialchars($class['class_name']);?>

</option>

<?php } ?>

</select>

</div>

<div class="form-group">

<label>Admission Date</label>

<input
type="date"
name="admission_date"
value="<?php echo date('Y-m-d');?>">

</div>

<div class="form-group">

<label>Username</label>

<input
type="text"
name="username"
required>

</div>

<div class="form-group">

<label>Password</label>

<input
type="password"
name="password"
required>

</div>

<div class="form-group">

<label>Status</label>

<select
name="status">

<option>Active</option>

<option>Inactive</option>

</select>

</div>

</div>

<br>

<button type="submit">

Register Student

</button>

<a href="students.php" class="action-btn">

Cancel

</a>

</form>

</div>

<script>

function previewImage(event){

let reader=new FileReader();

reader.onload=function(){

document.getElementById('preview').src=reader.result;

};

reader.readAsDataURL(event.target.files[0]);

}

</script>

<?php
include '../includes/admin_footer.php';
?>