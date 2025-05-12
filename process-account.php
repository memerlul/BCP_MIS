<?php

// Include the database configuration file to get the PDO connection
require_once __DIR__ . '/db_config.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and get form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $role = htmlspecialchars($_POST['role']);
    $password = htmlspecialchars($_POST['password']);
    $username = htmlspecialchars($_POST['username']);
    
    // Check if the username already exists
    $check_username = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($check_username);
    $stmt->execute(['username' => $username]);

    if ($stmt->rowCount() > 0) {
        echo "<script>alert('Username already exists!'); window.history.back();</script>";
        exit();
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new account into the database
    $query = "INSERT INTO users (username, name, email, password, role) 
              VALUES (:username, :name, :email, :password, :role)";
    $stmt = $pdo->prepare($query);
    
    $stmt->execute([
        'username' => $username,
        'name' => $name,
        'email' => $email,
        'password' => $hashed_password,
        'role' => $role
    ]);

    if ($stmt) {
        echo "<script>alert('Account added successfully!'); window.location.href = 'manage-accounts.php';</script>";
    } else {
        echo "<script>alert('Error: Unable to add the account.'); window.history.back();</script>";
    }
}

// ... after successful insert ...

// Build the spinner URL
$spinnerUrl = 'spinner.php'
    . '?redirect=' . urlencode('manage-accounts.php?flash=added')
    . '&message=' . urlencode('Account added successfully!')
    . '&delay=1000';

// Redirect to spinner
header('Location: ' . $spinnerUrl);
exit;

?>
