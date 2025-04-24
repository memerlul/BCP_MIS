<?php
session_start();

// Destroy session data and invalidate the session
session_unset();
session_destroy();

// Clear the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], 
        $params["domain"], 
        $params["secure"], 
        $params["httponly"]
    );
}

// Send them to the landing page now that they're logged out
header('Location: index.php');
exit();
?>
