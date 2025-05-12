<?php
// process-edit-account.php
// Ensure only authenticated users can access
require_once __DIR__ . '/backend/auth.php';
require_once __DIR__ . '/db_config.php';

// Only handle POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: manage-accounts.php');
    exit;
}

// Retrieve and sanitize input
$id    = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$name  = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$role  = trim($_POST['role'] ?? '');

$errors = [];

// Basic validation
if ($id <= 0) {
    $errors[] = 'Invalid user ID.';
}
if ($name === '') {
    $errors[] = 'Full name cannot be empty.';
}
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'A valid email address is required.';
}
if (!in_array($role, ['student', 'employee', 'admin'], true)) {
    $errors[] = 'Invalid role selected.';
}

// If validation fails, store errors and redirect back
if (!empty($errors)) {
    // Assuming auth.php started session
    $_SESSION['flash_errors'] = $errors;
    header('Location: manage-accounts.php');
    exit;
}

// Perform update
try {
    $sql = "UPDATE users
            SET name = :name,
                email = :email,
                role = :role
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name'  => $name,
        ':email' => $email,
        ':role'  => $role,
        ':id'    => $id,
    ]);

    // Optionally log to audit trail here
    // $auditSql = "INSERT INTO audit_logs (user_id, action, timestamp) VALUES (:uid, 'edit_user', NOW())";
    // $auditStmt = $pdo->prepare($auditSql);
    // $auditStmt->execute([':uid'=>$id]);

    $_SESSION['flash_success'] = 'Account updated successfully.';
} catch (PDOException $e) {
    $_SESSION['flash_errors'] = ['Database error: '.$e->getMessage()];
}

// Redirect back to Manage Accounts
header('Location: manage-accounts.php');
exit;
