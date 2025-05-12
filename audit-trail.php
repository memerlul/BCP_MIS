<?php
session_start();
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/backend/auth.php';

// Pagination setup
$page   = max(1, (int)($_GET['page'] ?? 1));
$limit  = 20;
$offset = ($page - 1) * $limit;

// Fetch audit entries with target user info
$sql = "
  SELECT
    at.id AS log_id,
    target.username   AS username,
    at.action         AS action,
    at.created_at     AS timestamp,
    target.role       AS role
  FROM audit_trail AS at
  LEFT JOIN users AS target
    ON target.id = at.target_id
  ORDER BY at.created_at DESC
  LIMIT :lim OFFSET :off
";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':lim', $limit,  PDO::PARAM_INT);
$stmt->bindValue(':off', $offset, PDO::PARAM_INT);
$stmt->execute();
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate total pages
$total = (int)$pdo->query("SELECT COUNT(*) FROM audit_trail")->fetchColumn();
$pages = ceil($total / $limit);

// Layout includes
include __DIR__ . '/backend/components/head.php';
include __DIR__ . '/backend/components/header.php';
include __DIR__ . '/backend/components/sidebar.php';
?>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Audit Trail</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
        <li class="breadcrumb-item active">Audit Trail</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">System Audit Log</h5>

        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="table-light">
              <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Action</th>
                <th>Timestamp</th>
                <th>Role</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($logs)): ?>
                <tr>
                  <td colspan="5" class="text-center py-4">No audit entries found.</td>
                </tr>
              <?php else: ?>
                <?php foreach ($logs as $row): ?>
                  <tr>
                    <td><?= htmlspecialchars($row['log_id']) ?></td>
                    <td><?= htmlspecialchars($row['username']   ?? '—') ?></td>
                    <td><?= htmlspecialchars(str_replace('_',' ', $row['action'])) ?></td>
                    <td><?= htmlspecialchars($row['timestamp']) ?></td>
                    <td><?= htmlspecialchars($row['role']       ?? '—') ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <nav aria-label="Audit pages" class="mt-3">
          <ul class="pagination">
            <?php for ($p = 1; $p <= $pages; $p++): ?>
              <li class="page-item <?= $p === $page ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $p ?>"><?= $p ?></a>
              </li>
            <?php endfor; ?>
          </ul>
        </nav>

      </div>
    </div>
  </section>
</main>

<?php include __DIR__ . '/backend/components/footer.php'; ?>
