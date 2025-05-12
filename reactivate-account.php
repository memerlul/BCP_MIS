<?php
// reactivate-account.php
// Reactivate a soft-deleted user account
require_once __DIR__ . '/backend/auth.php';
require_once __DIR__ . '/db_config.php';

// Validate incoming 'id'
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['flash_errors'] = ['Invalid user ID for reactivation.'];
    header('Location: inactive-accounts.php');
    exit;
}

$id = (int) $_GET['id'];

try {
    // Set status back to 'active'
    $stmt = $pdo->prepare("UPDATE users SET status = 'active' WHERE id = :id");
    $stmt->execute([':id' => $id]);

    // Optional: log audit trail
    // $audit = $pdo->prepare("INSERT INTO audit_logs (user_id, action, timestamp) VALUES (:uid, 'reactivate_user', NOW())");
    // $audit->execute([':uid' => $id]);

    $_SESSION['flash_success'] = 'User account reactivated successfully.';
} catch (Exception $e) {
    $_SESSION['flash_errors'] = ['Error reactivating user: ' . $e->getMessage()];
}

// Redirect back to Inactive Accounts list
header('Location: inactive-accounts.php');
exit;
