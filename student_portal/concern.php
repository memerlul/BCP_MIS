<?php 
session_start();

require '../db_config.php'; // Include database connection

// Initialize error message for submitting concern
$concern_error_msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $user_id = $_SESSION['user_id'];  // Get user_id from session
    $username = $_SESSION['username'];  // Get username from session

    // Insert the concern into the database without the timetable
    $stmt = $pdo->prepare('INSERT INTO concerns (user_id, username, concern) VALUES (:user_id, :username, :concern)');
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':concern', $message);
    
    if ($stmt->execute()) {
        header('Location: concern.php?success=true');  // Redirect after successful submission
        exit();
    } else {
        $concern_error_msg = 'Failed to submit the concern.';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Submit Concern</title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* Popup modal styling */
    .popup {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5); /* Black background with transparency */
      justify-content: center;
      align-items: center;
    }

    .popup-content {
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      text-align: center;
      max-width: 400px;
      margin: 0 auto;
    }

    .popup button {
      background-color: #28a745;
      color: white;
      border: none;
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
      border-radius: 5px;
    }

    .popup button:hover {
      background-color: #218838;
    }
  </style>
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
      <!-- Submit a new concern -->
      <section class="card">
        <h2>Submit a Concern</h2>
        <form method="POST">
          <label for="subject">Subject</label>
          <input type="text" id="subject" name="subject" required><br><br>

          <label for="message">Message</label>
          <textarea id="message" name="message" rows="5" required></textarea><br><br>

          <button type="submit">Send</button>
        </form>
        <?php if ($concern_error_msg) { echo "<p>$concern_error_msg</p>"; } ?>
      </section>

      <!-- Success Popup Modal -->
      <?php if (isset($_GET['success'])): ?>
        <div id="popup" class="popup">
          <div class="popup-content">
            <h3>Concern submitted successfully!</h3>
            <button onclick="closePopup()">Close</button>
          </div>
        </div>
      <?php endif; ?>

    </main>
  </div>

  <footer>
    <p>&copy; 2025 All rights reserved.</p>
  </footer>

  <script>
    // Close the popup modal when the 'Close' button is clicked
    function closePopup() {
      document.getElementById('popup').style.display = 'none';
    }

    // Show the popup when the page is loaded with success message
    <?php if (isset($_GET['success'])): ?>
      document.getElementById('popup').style.display = 'flex'; // Display the popup
    <?php endif; ?>
  </script>
</body>
</html>
