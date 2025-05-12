<?php
// deactivate-user.php

session_start();                    // ← make sure you’re using sessions
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/backend/auth.php';

if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
    header('Location: manage-accounts.php');
    exit;
}

$id = (int)$_GET['id'];

// mark as inactive
$stmt = $pdo->prepare("UPDATE users SET status = 'inactive' WHERE id = :id");
$stmt->execute(['id' => $id]);

// set a flash message
$_SESSION['flash_success'] = "User disabled successfully.";

header('Location: manage-accounts.php');
exit;
