<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
require 'db_config.php'; // Database connection file
require 'vendor/autoload.php'; // Add this line to load PHPMailer

// Initialize error message variable
$error_msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    // Check if the user exists
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            // Password is correct, generate OTP and store session info
            $otp = rand(100000, 999999);
            $_SESSION['otp'] = $otp;
            $_SESSION['username'] = $username;

            // Generate a unique session ID for this login attempt
            $session_id = session_id();
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            $ip_address = $_SERVER['REMOTE_ADDR'];

            // Check if the session ID already exists in the database
            $stmt = $pdo->prepare('SELECT * FROM sessions WHERE session_id = :session_id');
            $stmt->bindParam(':session_id', $session_id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $session_id = session_create_id(); // Regenerate session ID if it already exists
            }

            // Store the session details in the sessions table
            $stmt = $pdo->prepare('INSERT INTO sessions (session_id, username, user_agent, ip_address) VALUES (:session_id, :username, :user_agent, :ip_address)');
            $stmt->bindParam(':session_id', $session_id);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':user_agent', $user_agent);
            $stmt->bindParam(':ip_address', $ip_address);
            $stmt->execute();

            // Send OTP via email using PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'jiyandelgadogaming@gmail.com';
                $mail->Password = 'hsgqmkgxunjifegq';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('no-reply@example.com', 'MIS System');
                $mail->addAddress($user['email']);

                $mail->isHTML(true);
                $mail->Subject = 'Your 2FA Code';
                $mail->Body    = "Your 2FA code is: $otp";

                $mail->send();
                header('Location: verify_otp.php');
                exit();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $error_msg = 'Username or password is invalid.'; // Set the error message
        }
    } else {
        $error_msg = 'Username or password is invalid.'; // Set the error message if user doesn't exist
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Login - MIS</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
    <main>
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                            <div class="d-flex justify-content-center py-4">
                                <a href="index.html" class="logo d-flex align-items-center w-auto">
                                    <img src="assets/logo.png" alt="">
                                    <span class="d-none d-lg-block">MIS</span>
                                </a>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                                        <p class="text-center small">Enter your username & password to login</p>
                                    </div>
                                    
                                    <!-- Error message area: displayed if login fails -->
                                    <?php if ($error_msg): ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?php echo $error_msg; ?>
                                        </div>
                                    <?php endif; ?>

                                    <form method="POST" id="frmLogin" class="row g-3 needs-validation" novalidate>
                                        <div class="col-12">
                                            <label for="yourUsername" class="form-label">Username</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                <input type="text" id="username" name="username" class="form-control" required>
                                                <div class="invalid-feedback">Please enter your username.</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Password</label>
                                            <input type="password" id="password" name="password" class="form-control" required>
                                            <div class="invalid-feedback">Please enter your password!</div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- End Card -->
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main><!-- End #main -->
</body>

</html>
