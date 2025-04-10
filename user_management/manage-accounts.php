<?php 
$page_title = "Manage Accounts"; 
include 'backend/components/head.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'backend/components/header.php'; ?>

<?php include 'backend/components/sidebar.php'; ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Manage Accounts</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="Dashboard.php">Home</a></li>
                <li class="breadcrumb-item active">Manage Accounts</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <!-- Button to trigger the modal -->
            <div class="col-lg-12">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAccountModal">
                    Add New Account
                </button>
            </div>

            <!-- Accounts List Section -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Account List</h5>

                        <!-- Tabs for filtering by Student, Employee, Admin -->
                        <ul class="nav nav-tabs" id="userTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="student-tab" data-bs-toggle="tab" href="#student" role="tab" aria-controls="student" aria-selected="true">Students</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="employee-tab" data-bs-toggle="tab" href="#employee" role="tab" aria-controls="employee" aria-selected="false">Employees</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="admin-tab" data-bs-toggle="tab" href="#admin" role="tab" aria-controls="admin" aria-selected="false">Admins</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="userTabsContent">
                            <!-- Student Tab -->
                            <div class="tab-pane fade show active" id="student" role="tabpanel" aria-labelledby="student-tab">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Username ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Add the PHP logic to display users here -->
                                        <?php echo getUsersList('student'); ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Employee Tab -->
                            <div class="tab-pane fade" id="employee" role="tabpanel" aria-labelledby="employee-tab">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Username ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php echo getUsersList('employee'); ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Admin Tab -->
                            <div class="tab-pane fade" id="admin" role="tabpanel" aria-labelledby="admin-tab">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Username ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php echo getUsersList('admin'); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Modal for adding new account -->
<div class="modal fade" id="addAccountModal" tabindex="-1" aria-labelledby="addAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAccountModalLabel">Add New Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="process-account.php">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="student">Student</option>
                            <option value="employee">Employee</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username ID (Generated)</label>
                        <input type="text" id="username" name="username" class="form-control" value="<?php echo generateUsername(); ?>" readonly>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Account</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'backend/components/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

<?php
// Function to generate a unique username ID
function generateUsername() {
    return "USR" . strtoupper(uniqid()); // Generates a unique username ID based on the current time
}

// Function to get user list based on role
function getUsersList($role) {
    // Connect to your database
    include 'backend/components/db.php';

    // Query for getting users based on role
    $query = "SELECT * FROM users WHERE role = '$role' LIMIT 10";
    $result = $conn->query($query);

    // Output the users
    $output = '';
    while ($row = $result->fetch_assoc()) {
        $output .= "<tr>
                        <td>{$row['username']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['role']}</td>
                        <td>
                            <a href='edit-account.php?id={$row['id']}'>Edit</a> | 
                            <a href='delete-account.php?id={$row['id']}'>Delete</a>
                        </td>
                    </tr>";
    }

    return $output;
}
?>
