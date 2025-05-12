<!-- concern.php -->
<?php
session_start();

// Sample concerns (replace with DB queries)
$concerns = [
    ['id' => 1, 'subject' => 'Schedule Inquiry', 'message' => 'When is the next exam?', 'date' => '2025-05-02', 'status' => 'Open'],
    ['id' => 2, 'subject' => 'Fee Payment', 'message' => 'Need clarification on payment options.', 'date' => '2025-04-20', 'status' => 'Closed']
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Submit Concern</title>
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
        <h2>Submit a Concern</h2>
        <form action="submit_concern.php" method="post">
          <label for="subject">Subject</label>
          <input type="text" id="subject" name="subject" required>

          <label for="message">Message</label>
          <textarea id="message" name="message" rows="5" required></textarea>

          <button type="submit">Send</button>
        </form>
      </section>

      <section class="card">
        <h2>Your Concerns</h2>
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Subject</th>
              <th>Date</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($concerns as $c): ?>
            <tr>
              <td><?php echo $c['id']; ?></td>
              <td><?php echo htmlspecialchars($c['subject']); ?></td>
              <td><?php echo htmlspecialchars($c['date']); ?></td>
              <td><?php echo htmlspecialchars($c['status']); ?></td>
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
