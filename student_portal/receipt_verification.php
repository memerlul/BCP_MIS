<!-- receipt_verification.php -->
<?php
session_start();

// Sample receipts data (replace with DB queries)
$receipts = [
    ['id' => 1, 'amount' => 10000.00, 'date' => '2025-05-01', 'status' => 'Pending'],
    ['id' => 2, 'amount' => 5000.00,  'date' => '2025-04-15', 'status' => 'Verified']
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Receipt Verification</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <div class="logo">My University</div>
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
        <h2>Submit Receipt</h2>
        <form action="upload_receipt.php" method="post" enctype="multipart/form-data">
          <label for="receipt_file">Upload Receipt:</label>
          <input type="file" id="receipt_file" name="receipt_file" accept="image/*,application/pdf" required>
          <button type="submit">Upload</button>
        </form>
      </section>

      <section class="card">
        <h2>Receipt Status</h2>
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Amount</th>
              <th>Date</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($receipts as $r): ?>
            <tr>
              <td><?php echo $r['id']; ?></td>
              <td>₱<?php echo number_format($r['amount'], 2); ?></td>
              <td><?php echo htmlspecialchars($r['date']); ?></td>
              <td><?php echo htmlspecialchars($r['status']); ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </section>
    </main>
  </div>

  <footer>
    <p>&copy; 2025 My University. All rights reserved.</p>
  </footer>
</body>
</html>
