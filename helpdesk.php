<?php
require __DIR__ . '/backend/auth.php';
?>

<?php $page_title = "Help Desk"; ?>
<!DOCTYPE html>
<html lang="en">
    <?php include 'backend/components/head.php'; ?>
    <body>
        <?php include 'backend/components/header.php'; ?>

        <?php include 'backend/components/sidebar.php'; ?>
        
        <main id="main" class="main">

            <div class="pagetitle">
            <h1>Help Desk</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="Dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active">Help Desk</li>
                </ol>
            </nav>
            </div><!-- End Page Title -->

            <section class="section">
                <div class="row">
                    <div class="col-lg-6">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Example Card</h5>
                                <p>This is an examle page with no contrnt. You can use it as a starter for your custom pages.</p>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-6">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Example Card</h5>
                                <p>This is an examle page with no contrnt. You can use it as a starter for your custom pages.</p>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

        </main><!-- End #main -->

        <?php include 'backend/components/footer.php'; ?>
    </body>
</html>
