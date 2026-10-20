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

<h1>Teacher Management</h1>

<div style="margin-bottom:20px; display:flex; justify-content:flex-end; align-items:center; flex-wrap:wrap; gap:15px;">
    <a href="add_teacher.php" class="action-btn">+ Add Teacher</a>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="error"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
<?php endif; ?>

<?php
$sql = "SELECT
    t.teacher_id,
    t.staff_number,
    t.first_name,
    t.last_name,
    t.gender,
    t.date_of_birth,
    t.phone AS teacher_phone,
    t.email AS teacher_email,
    t.address,
    t.qualification,
    t.EMIS_code,
    t.Lincese_Number,
    t.SSNIT_Number,
    t.TIN_Number,
    t.GH_Card_Number,
    t.Fisrt_Appointment_Date,
    t.Last_Promotion_Date,
    t.Current_Rank,
    t.Marital_status,
    t.Bank_Name,
    t.Account_Number,
    t.Bank_Branch,
    t.Number_of_Children,
    t.photo,
    t.created_at,
    d.department_name,
    u.email AS user_email,
    u.phone AS user_phone
FROM teachers t
LEFT JOIN departments d ON t.department_id = d.department_id
LEFT JOIN users u ON t.user_id = u.user_id
ORDER BY t.last_name, t.first_name";

$result = $conn->query($sql);
?>

<table>
    <tr>
        <th>Photo</th>
        <th>Staff No.</th>
        <th>Name</th>
        <th>Department</th>
        <th>Gender</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Rank</th>
        <th>Joined</th>
        <th>Bank</th>
    </tr>

    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td>
                    <img
                        src="<?php echo !empty($row['photo']) ? '../assets/uploads/' . htmlspecialchars($row['photo']) : '../assets/images/default-user.png'; ?>"
                        class="profile-img"
                        alt="Teacher Photo">
                </td>
                <td><?php echo htmlspecialchars($row['staff_number']); ?></td>
                <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                <td><?php echo htmlspecialchars($row['department_name'] ?: 'N/A'); ?></td>
                <td><?php echo htmlspecialchars($row['gender'] ?: 'N/A'); ?></td>
                <td><?php echo htmlspecialchars($row['user_phone'] ?: $row['teacher_phone'] ?: 'N/A'); ?></td>
                <td><?php echo htmlspecialchars($row['user_email'] ?: $row['teacher_email'] ?: 'N/A'); ?></td>
                <td><?php echo htmlspecialchars($row['Current_Rank'] ?: 'N/A'); ?></td>
                <td><?php echo !empty($row['Fisrt_Appointment_Date']) ? htmlspecialchars($row['Fisrt_Appointment_Date']) : 'N/A'; ?></td>
                <td><?php echo htmlspecialchars($row['Bank_Name'] ?: 'N/A'); ?></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="10" style="text-align:center; padding:30px;">No teachers found.</td>
        </tr>
    <?php endif; ?>
</table>

</div>

<?php
include '../includes/admin_footer.php';
?>