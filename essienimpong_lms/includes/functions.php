<?php

function clean($data)
{
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

function redirect($url)
{
    header("Location: $url");
    exit;
}

function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function getRole()
{
    return $_SESSION['role_name'] ?? '';
}

function formatDate($date)
{
    return date("d M Y", strtotime($date));
}

function currentDateTime()
{
    return date("Y-m-d H:i:s");
}

function generateAdmissionNumber()
{
    return "ADM" . date("Y") . rand(1000,9999);
}

function generateStaffNumber()
{
    return "STF" . date("Y") . rand(1000,9999);
}

function generateReceiptNumber()
{
    return "RCP" . time();
}