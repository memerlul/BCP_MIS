<!-- balance.php -->
<?php
session_start();

// Load balance (replace with real DB query)
$student_id = $_SESSION['student_id'] ?? '2021001';
$balance = 15000.00; // sample balance in PHP variable
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Account Balance</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <div class="logo">University</div>
    <nav>
      <ul>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <div class="container">
    <?php include 'sidebar.php'; ?>

    <main>
      <section class="card">
        <h2>Your Current Balance</h2>
        <p>₱<span id="balance"><?php echo number_format($balance, 2); ?></span></p>
      </section>
    </main>
  </div>

  <footer>
    <p>&copy; 2025 All rights reserved.</p>
  </footer>
</body>
</html>