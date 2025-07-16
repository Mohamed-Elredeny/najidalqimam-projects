<?php
// logout.php
session_start();
// Unset all of the session variables
$_SESSION = [];
// Destroy the session cookie
if (ini_get("session.use_cookies")) {
    setcookie(
        session_name(),
        '',
        time() - 42000,
        ini_get("session.cookie_path"),
        ini_get("session.cookie_domain"),
        ini_get("session.cookie_secure"),
        ini_get("session.cookie_httponly")
    );
}
// Finally destroy the session
session_destroy();
// Redirect back to login
header('Location: login.php');
exit;
