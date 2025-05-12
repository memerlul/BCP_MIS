<?php
// activate-user.php
require_once 'config.php';
require_once 'auth.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: inactive-accounts.php');
    exit;
}

$id = (int)$_GET['id'];
$stmt = $conn->prepare("UPDATE users SET status = 'active' WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();

header('Location: inactive-accounts.php');
exit;
