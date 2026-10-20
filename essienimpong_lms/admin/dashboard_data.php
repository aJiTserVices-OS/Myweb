<?php

require_once '../config/database.php';

/* ===========================
   TOTAL STUDENTS
=========================== */

$sql = "SELECT COUNT(*) AS total_students FROM students";
$result = $conn->query($sql);
$total_students = $result->fetch_assoc()['total_students'];

/* ===========================
   TOTAL TEACHERS
=========================== */

$sql = "SELECT COUNT(*) AS total_teachers FROM teachers";
$result = $conn->query($sql);
$total_teachers = $result->fetch_assoc()['total_teachers'];

/* ===========================
   TOTAL PARENTS
=========================== */

$sql = "SELECT COUNT(*) AS total_parents FROM parents";
$result = $conn->query($sql);
$total_parents = $result->fetch_assoc()['total_parents'];

/* ===========================
   TOTAL CLASSES
=========================== */

$sql = "SELECT COUNT(*) AS total_classes FROM classes";
$result = $conn->query($sql);
$total_classes = $result->fetch_assoc()['total_classes'];

/* ===========================
   TOTAL SUBJECTS
=========================== */

$sql = "SELECT COUNT(*) AS total_subjects FROM subjects";
$result = $conn->query($sql);
$total_subjects = $result->fetch_assoc()['total_subjects'];

/* ===========================
   TOTAL USERS
=========================== */

$sql = "SELECT COUNT(*) AS total_users FROM users";
$result = $conn->query($sql);
$total_users = $result->fetch_assoc()['total_users'];

?>