<?php

require_once 'config/session.php';

if(!isset($_SESSION['user_id'])){

header("Location: auth/login.php");

exit;

}

switch($_SESSION['role_name']){

case 'Administrator':

header("Location: admin/dashboard.php");

break;

case 'Teacher':

header("Location: admin/dashboard.php");

break;

case 'Student':

header("Location: admin/dashboard.php");

break;

case 'Parent':

header("Location: admin/dashboard.php");

break;

case 'Headmaster':

header("Location: admin/dashboard.php");

break;

case 'Accountant':

header("Location: admin/dashboard.php");

break;

case 'Librarian':

header("Location: admin/dashboard.php");

break;

default:

session_destroy();

header("Location: auth/login.php");

}

exit;