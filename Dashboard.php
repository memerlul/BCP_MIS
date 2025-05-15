<?php
session_start();

// Prevent page caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Expire in the past

// If the user is not logged in, redirect them to the login page
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Database connection (for widget queries)
require 'db_config.php';  // provides $pdo

// Dashboard data queries
// 1) User Accounts Overview
$totalUsers    = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$activeUsers   = $pdo->query("SELECT COUNT(*) FROM users WHERE status='active'")->fetchColumn();
$inactiveUsers = $totalUsers - $activeUsers;

// 2) New Sign-ups Over Time (last 30 days)
$stmt = $pdo->query(
    "SELECT DATE(created_at) AS d, COUNT(*) AS c
     FROM users
     WHERE created_at >= CURDATE() - INTERVAL 29 DAY
     GROUP BY DATE(created_at)"
);
$dates   = [];
$signups = [];
foreach ($stmt as $r) {
    $dates[]   = $r['d'];
    $signups[] = $r['c'];
}

// 3) Audit Trail Activity (last 7 days)
$stmt = $pdo->query(
    "SELECT action, COUNT(*) AS cnt
     FROM audit_trail
     WHERE created_at >= CURDATE() - INTERVAL 7 DAY
     GROUP BY action"
);
$actions      = [];
$actionCounts = [];
foreach ($stmt as $r) {
    $actions[]      = $r['action'];
    $actionCounts[] = $r['cnt'];
}

// 4) Help Desk Ticket Status
$openCount   = $pdo->query("SELECT COUNT(*) FROM concerns WHERE status='Open'")->fetchColumn();
$closedCount = $pdo->query("SELECT COUNT(*) FROM concerns WHERE status='Closed'")->fetchColumn();

// 5) Report Builder Usage (as proxy: counts this week)
$umCount = $pdo->query("SELECT COUNT(*) FROM users WHERE created_at >= CURDATE() - INTERVAL 7 DAY")->fetchColumn();
$atCount = $pdo->query("SELECT COUNT(*) FROM audit_trail WHERE created_at >= CURDATE() - INTERVAL 7 DAY")->fetchColumn();
// concerns has no created_at column, so just count all records
$hdCount = $pdo->query("SELECT COUNT(*) FROM concerns")->fetchColumn();

?>

<?php $page_title = "Dashboard"; ?>
<!DOCTYPE html>
<html lang="en">
    <?php include 'backend/components/head.php'; ?>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <body>
        <?php include 'backend/components/header.php'; ?> 
        <?php include 'backend/components/sidebar.php'; ?>

        <main id="main" class="main">
            <div class="pagetitle">
                <h1>Dashboard</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="Dashboard.php">Home</a></li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->

            <section class="section">
  <!-- KPI Row -->
  <div class="row gy-4">
    <!-- Accounts KPI -->
    <div class="col-lg-4">
      <div class="card p-3">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h3 class="mb-1"><?= number_format($totalUsers) ?></h3>
            <small class="text-muted">Total Users</small>
          </div>
          <div style="width:120px; height:50px;">
            <canvas id="sparkUsers"></canvas>
          </div>
        </div>
      </div>
    </div>
    <!-- Sign-ups KPI -->
    <div class="col-lg-4">
      <div class="card p-3">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h3 class="mb-1"><?= array_sum($signups) ?></h3>
            <small class="text-muted">Sign-ups (30d)</small>
          </div>
          <div style="width:120px; height:50px;">
            <canvas id="sparkSignups"></canvas>
          </div>
        </div>
      </div>
    </div>
    <!-- Tickets KPI -->
    <div class="col-lg-4">
      <div class="card p-3">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h3 class="mb-1"><?= $openCount ?></h3>
            <small class="text-muted">Open Tickets</small>
          </div>
          <div style="width:120px; height:50px;">
            <canvas id="sparkTickets"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Larger Charts Row -->
  <div class="row gy-4 mt-4">
    <div class="col-lg-6">
      <div class="card h-100 p-3">
        <h5 class="card-title">Monthly Sign-ups</h5>
        <canvas id="signupsLine"></canvas>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card h-100 p-3">
        <h5 class="card-title">Audit Actions (7d)</h5>
        <canvas id="auditBar"></canvas>
      </div>
    </div>
  </div>

  <div class="row gy-4 mt-4">
    <div class="col-lg-6">
      <div class="card h-100 p-3">
        <h5 class="card-title">Tickets: Open vs Closed</h5>
        <canvas id="ticketsDonut"></canvas>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card h-100 p-3">
        <h5 class="card-title">Reports Generated (7d)</h5>
        <canvas id="reportsStacked"></canvas>
      </div>
    </div>
  </div>

            </section>
        </main><!-- End #main -->

        <?php include 'backend/components/footer.php'; ?>

        <script>
        document.addEventListener('DOMContentLoaded', function(){
          // common sparkline
          const sparkOpts = {
            type: 'line', options: { responsive: true, maintainAspectRatio: false,
              elements:{ line:{ tension:0.4,borderWidth:2 }, point:{ radius:0} },
              plugins:{ legend:{ display:false }, tooltip:{ enabled:false } },
              scales:{ x:{ display:false }, y:{ display:false } }
            }
          };

          // spark: users
          new Chart(document.getElementById('sparkUsers'), Object.assign({}, sparkOpts, { data:{ labels:<?= json_encode($dates) ?>, datasets:[{ data:<?= json_encode($signups) ?>, borderColor:'#3b82f6', backgroundColor:'rgba(59,130,246,0.2)', fill:true }] } }));
          // spark: signups
          new Chart(document.getElementById('sparkSignups'), Object.assign({}, sparkOpts, { data:{ labels:<?= json_encode($dates) ?>, datasets:[{ data:<?= json_encode($signups) ?>, borderColor:'#10b981', backgroundColor:'rgba(16,185,129,0.2)', fill:true }] } }));
          // spark: tickets
          new Chart(document.getElementById('sparkTickets'), Object.assign({}, sparkOpts, { data:{ labels:<?= json_encode($actions) ?>, datasets:[{ data:<?= json_encode([$openCount]) ?>, borderColor:'#ef4444', backgroundColor:'rgba(239,68,68,0.2)', fill:true }] } }));

          // larger: signups line (reuse id signupsLine)
          new Chart(document.getElementById('signupsLine'), { type:'line', data:{ labels:<?= json_encode($dates) ?>, datasets:[{ label:'Sign-ups', data:<?= json_encode($signups) ?>, fill:false }] }, options:{ scales:{ x:{ display:true }, y:{ beginAtZero:true } } } });

          // audit bar
          new Chart(document.getElementById('auditBar'), { type:'bar', data:{ labels:<?= json_encode($actions) ?>, datasets:[{ label:'Events', data:<?= json_encode($actionCounts) ?> }] } });

          // tickets donut
          new Chart(document.getElementById('ticketsDonut'), { type:'doughnut', data:{ labels:['Open','Closed'], datasets:[{ data:[<?= $openCount ?>,<?= $closedCount ?>] }] } });

          // reports stacked
          new Chart(document.getElementById('reportsStacked'), { type:'bar', data:{ labels:['This Week'], datasets:[{ label:'User Mgmt', data:[<?= $umCount ?>] },{ label:'Audit Trail', data:[<?= $atCount ?>] },{ label:'Help Desk', data:[<?= $hdCount ?>] }] }, options:{ scales:{ x:{ stacked:true }, y:{ stacked:true } } } });
        });
        </script>
    </body>
</html>