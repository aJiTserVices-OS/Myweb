<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "essienimpong_lms_fix";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

?>