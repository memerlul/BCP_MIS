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
?>

<?php $page_title = "Dashboard"; ?>
<!DOCTYPE html>
<html lang="en">
    <?php include 'backend/components/head.php'; ?>
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
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Example Card</h5>
                                <p>This is an example page with no content. You can use it as a starter for your custom pages.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Example Card</h5>
                                <p>This is an example page with no content. You can use it as a starter for your custom pages.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main><!-- End #main -->

        <?php include 'backend/components/footer.php'; ?>
    </body>
    <script>
        // This will force a reload of the page, preventing the user from going back to it
        if (performance.navigation.type == 2) {
            location.reload(true);
        }
    </script>
</html>
