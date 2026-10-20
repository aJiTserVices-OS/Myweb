<?php

if (session_status() === PHP_SESSION_NONE) {

    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax'
    ]);

    session_start();
}

function regenerateSession()
{
    // Regenerate once after successful authentication to mitigate session fixation.
    // Session ID regeneration should not depend on previously set timestamps.
    session_regenerate_id(true);
    $_SESSION['created'] = time();
}
