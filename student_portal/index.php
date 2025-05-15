<!-- index.php (Dashboard) -->
<?php
session_start();

// Prevent page caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Expire in the past

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
  // If not logged in, redirect to login page
  header('Location: /../login.php');
  exit();
}

// Check if the user is a student (redirect if not)
if ($_SESSION['role'] !== 'student') {
  // Redirect users who are not students
  header('Location: login.php');  // Or redirect to an appropriate page for other roles
  exit();
}

// Load student info (replace with real DB query)
$student = [
    'name'       => 'Juan Dela Cruz',
    'student_id' => '2021001',
    'address'    => '123 Main St, City, Country',
    'course'     => 'BS Computer Science',
    'year'       => '3',
    'email'      => 'juan.delacruz@example.com',
    'contact'    => '09171234567'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Dashboard</title>
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
      <section class="card profile-card">
        <h2>Student Information</h2>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($student['name']); ?></p>
        <p><strong>Student ID:</strong> <?php echo htmlspecialchars($student['student_id']); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($student['address']); ?></p>
        <p><strong>Course:</strong> <?php echo htmlspecialchars($student['course']); ?></p>
        <p><strong>Year Level:</strong> <?php echo htmlspecialchars($student['year']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($student['email']); ?></p>
        <p><strong>Contact:</strong> <?php echo htmlspecialchars($student['contact']); ?></p>
      </section>
    </main>
  </div>

  <footer>
    <p>&copy; 2025 All rights reserved.</p>
  </footer>
</body>
</html>