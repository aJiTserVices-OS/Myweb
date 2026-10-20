<?php
// Compatibility route for legacy or direct /login.php access.
header('Location: auth/login.php');
exit;
