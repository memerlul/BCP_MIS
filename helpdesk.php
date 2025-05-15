<?php
// Start the session and include the authentication file for admin verification
session_start();
require __DIR__ . '/backend/auth.php'; // Ensures only admins can access this page

// Database connection
require 'db_config.php';

// Fetch concerns from the database (fetch all concerns for the admin)
$stmt = $pdo->prepare('SELECT * FROM concerns ORDER BY id DESC'); // No need to filter by user_id for admin
$stmt->execute();
$concerns = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">User Concerns</h5>
                                
                                <!-- Table to display concerns -->
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Username</th>
                                            <th>Concern</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($concerns as $concern): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($concern['id']); ?></td>
                                                <td><?php echo htmlspecialchars($concern['username']); ?></td>
                                                <td><?php echo htmlspecialchars($concern['concern']); ?></td>
                                                <td><?php echo htmlspecialchars($concern['status']); ?></td>
                                                <td>
                                                    <?php if ($concern['status'] == 'Open'): ?>
                                                        <!-- Action button to mark concern as closed -->
                                                        <form method="POST" action="close_concern.php">
                                                            <input type="hidden" name="concern_id" value="<?php echo $concern['id']; ?>">
                                                            <button type="submit" class="btn btn-danger">Close</button>
                                                        </form>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main><!-- End #main -->

        <?php include 'backend/components/footer.php'; ?>
    </body>
</html>
