<?php
session_start();

// Prevent page caching - Ensure these headers are set before any output
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Expire in the past

// If user is not logged in or OTP is not set, redirect to login
if (!isset($_SESSION['username']) || !isset($_SESSION['otp'])) {
    header('Location: login.php');
    exit();
}

// Initialize error message for OTP validation
$otp_error_msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp = $_POST['otp'];

    // Verify if the OTP entered matches the generated one
    if ($otp == $_SESSION['otp']) {
        // OTP is correct, user is successfully logged in
        $user_role = $_SESSION['role'];  // Fetch user's role from the session
        if ($user_role == 'admin' || $user_role == 'employee') {
            header('Location: Dashboard.php');  // Redirect to Admin/Employee Dashboard
            exit();
        } elseif ($user_role == 'student') {
            header('Location: student_portal/index.php');  // Redirect to Student Dashboard
            exit();
        } else {
            header('Location: login.php');  // Default redirect if role is unknown
            exit();
        }
    } else {
        $otp_error_msg = 'Invalid OTP. Please try again.'; // Set error message for invalid OTP
    }
}
?>

<!-- Your existing HTML form for OTP verification -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Verify OTP</title>
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
            </div><!-- End Logo -->

            <div class="card mb-3">
              <div class="card-body">
                <div class="pt-4 pb-2">
                  <h5 class="card-title text-center pb-0 fs-4">Enter Your 2FA Code</h5>
                  <p class="text-center small">Please enter the 6-digit code sent to your email to verify your login</p>
                </div>

                <!-- Error message area: displayed if OTP validation fails -->
                <?php if ($otp_error_msg): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $otp_error_msg; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" id="frmVerifyOtp" class="row g-3 needs-validation" novalidate>
                  <div class="col-12">
                    <label for="otp" class="form-label">2FA Code</label>
                    <input type="text" name="otp" class="form-control" required>
                    <div class="invalid-feedback">Please enter the 2FA code!</div>
                  </div>

                  <div class="col-12">
                    <button class="btn btn-primary w-100" type="submit">Verify Code</button>
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
