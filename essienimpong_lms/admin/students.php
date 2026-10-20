<?php
require_once '../config/database.php';
require_once '../config/session.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../includes/admin_header.php';
include '../includes/admin_sidebar.php';
include '../includes/admin_topbar.php';
?>

<div class="main-content">

<h1>Student Management</h1>

<div style="margin-bottom:20px;">

<a href="add_student.php" class="action-btn">
+ Add New Student
</a>

</div>

<table>

<tr>

<th>Photo</th>

<th>Admission No.</th>

<th>Full Name</th>

<th>Gender</th>

<th>Class</th>

<th>Actions</th>

</tr>

<?php

$sql = "SELECT
students.*,
classes.class_name
FROM students
LEFT JOIN classes
ON students.class_id = classes.class_id
ORDER BY first_name";

$result = $conn->query($sql);

while($row = $result->fetch_assoc()){

?>

<tr>

<td>

<img
src="../assets/uploads/<?php echo $row['photo']; ?>"
class="profile-img">

</td>

<td><?php echo htmlspecialchars($row['admission_number']); ?></td>

<td>

<?php

echo htmlspecialchars(
$row['first_name']." ".$row['last_name']
);

?>

</td>

<td><?php echo htmlspecialchars($row['gender']); ?></td>

<td><?php echo htmlspecialchars($row['class_name']); ?></td>

<td>

<a href="view_student.php?id=<?php echo $row['student_id']; ?>">View</a> |

<a href="edit_student.php?id=<?php echo $row['student_id']; ?>">Edit</a> |

<a href="delete_student.php?id=<?php echo $row['student_id']; ?>"
onclick="return confirm('Delete this student?');">

Delete

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

<?php
include '../includes/admin_footer.php';
?>