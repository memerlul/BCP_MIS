<?php
// api_mis.php

header('Content-Type: application/json; charset=utf-8');

// Simple token check (optional, but recommended)
// Admission system must send ?token=YOUR_SHARED_SECRET
if (!isset($_GET['token']) || $_GET['token'] !== 'YOUR_SHARED_SECRET') {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

require __DIR__ . '/db_config.php';  // provides $pdo

$report    = $_GET['report']     ?? '';
$startDate = $_GET['start_date'] ?? null;
$endDate   = $_GET['end_date']   ?? null;

// Build date filter if supplied
$dateClause = '';
$params     = [];
if ($startDate && $endDate) {
    $dateClause = ' WHERE created_at BETWEEN :start AND :end';
    $params = [
        ':start' => $startDate . ' 00:00:00',
        ':end'   => $endDate   . ' 23:59:59',
    ];
}

try {
    switch ($report) {
        case 'user_management':
            $sql = "
                SELECT id, username, email, role, created_at
                FROM users
                $dateClause
                ORDER BY created_at DESC
            ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            break;

        case 'audit_trail':
            $sql = "
                SELECT a.id,
                       u.username,
                       a.action,
                       a.created_at AS timestamp,
                       a.target_role
                FROM audit_trail a
                JOIN users u ON a.actor_id = u.id
                $dateClause
                ORDER BY a.created_at DESC
            ";
            // override dateClause parameter keys since audit_trail.created_at
            if ($dateClause) {
                $params = [
                    ':start' => $startDate . ' 00:00:00',
                    ':end'   => $endDate   . ' 23:59:59',
                ];
            }
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            break;

        default:
            http_response_code(400);
            echo json_encode(['error' => 'Invalid report type']);
            exit;
    }

    echo json_encode([
        'report' => $report,
        'generated_at' => date('c'),
        'data'   => $data,
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
