<?php
session_start();

// Destroy session data and invalidate the session
session_unset();  // Remove all session variables
session_destroy();  // Destroy the session completely

// Clear the session cookie to prevent the browser from holding it
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, 
        $params["path"], 
        $params["domain"], 
        $params["secure"], 
        $params["httponly"]
    );
}

// Redirect to the login page after logout
header('Location: login.php');
exit();
?>
