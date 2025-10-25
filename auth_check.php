<?php
// auth_check.php - Include this at the top of every protected page

session_start();

// Check if user is logged in
if (!isset($_SESSION['customer_id'])) {
    // Redirect to login page
    header("Location: login.php");
    exit();
}

// Optional: Check session expiration (e.g., 2 hours)
$session_duration = 2 * 60 * 60; // 2 hours in seconds
if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time'] > $session_duration)) {
    // Session expired
    session_destroy();
    header("Location: login.php?session=expired");
    exit();
}

// Optional: Regenerate session ID periodically to prevent fixation
if (!isset($_SESSION['last_regeneration'])) {
    $_SESSION['last_regeneration'] = time();
} elseif (time() - $_SESSION['last_regeneration'] > 1800) { // 30 minutes
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}
?>