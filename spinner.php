<?php
// spinner.php
// A reusable full-page spinner overlay
// Usage: spinner.php?redirect=URL&message=Text&delay=ms

// Prevent caching
header('Cache-Control: no-cache, no-store, must-revalidate');

// Capture parameters with defaults
$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php';
$message  = isset($_GET['message'])  ? htmlspecialchars($_GET['message']) : 'Please wait...';
$delay    = isset($_GET['delay'])    ? (int)$_GET['delay'] : 800;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once __DIR__ . '/backend/components/head.php'; ?>
  <style>
    /* Full-screen overlay */
    .spinner-overlay {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(255,255,255,0.8);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 9999;
    }
  </style>
</head>
<body>
  <div class="spinner-overlay">
    <div class="text-center">
      <div class="spinner-border" role="status" style="width: 3rem; height: 3rem;">
        <span class="visually-hidden">Loading...</span>
      </div>
      <div class="mt-2"><?= $message ?></div>
    </div>
  </div>

  <script>
    // Redirect after delay
    setTimeout(function() {
      window.location = <?= json_encode($redirect) ?>;
    }, <?= $delay ?>);
  </script>
</body>
</html>
