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

<h1>Add Parent</h1>

<form action="save_parents.php" method="POST">
    <div class="form-grid">
        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="first_name" required>
        </div>

        <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="last_name" required>
        </div>

        <div class="form-group">
            <label>Date of Birth</label>
            <input type="date" name="Date_of_Birth">
        </div>

        <div class="form-group">
            <label>Relationship</label>
            <input type="text" name="relationship">
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
            <label>Occupation</label>
            <input type="text" name="occupation">
        </div>

        <div class="form-group">
            <label>GH Card Number</label>
            <input type="text" name="GH_Card_Number">
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
            <label>Marital Status</label>
            <select name="Marital_Status">
                <option value="Single">Single</option>
                <option value="Married">Married</option>
                <option value="Widow">Widow</option>
                <option value="Divorce">Divorce</option>
            </select>
        </div>

        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
    </div>

    <button type="submit">Save Parent</button>
    <a href="parents.php" class="action-btn" style="background:#555;">Cancel</a>
</form>

</div>

<?php
include '../includes/admin_footer.php';
?>
