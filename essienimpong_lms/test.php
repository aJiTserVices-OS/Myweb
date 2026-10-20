<?php

require_once 'config/constants.php';
require_once 'config/session.php';
require_once 'includes/functions.php';

echo "<h2>" . APP_NAME . "</h2>";
echo "<p>Version: " . APP_VERSION . "</p>";
echo "<p>School: " . SCHOOL_NAME . "</p>";
echo "<p>Today's Date: " . formatDate(date('Y-m-d')) . "</p>";
?>