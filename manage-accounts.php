<?php
// Ensure only authenticated users can access
require_once __DIR__ . '/backend/auth.php';

// Load database connection
require_once __DIR__ . '/db_config.php';

// Set page title (used in head.php)
$page_title = "Manage Accounts";

// Get search term, current page, and limit from query parameters
$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10; // Entries per page, default is 10
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once __DIR__ . '/backend/components/head.php'; ?>
</head>
<body>
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
            <div class="row mb-3">
                <div class="col-6">
                    <form method="GET" action="manage-accounts.php">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search users" value="<?php echo htmlspecialchars($search); ?>">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </form>
                </div>
                <div class="col-6 text-end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAccountModal">
                        Add New Account
                    </button>
                </div>
            </div>

            <?php if (!empty($_SESSION['flash_success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['flash_success']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['flash_success']); ?>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Account List</h5>
                    <ul class="nav nav-tabs" id="userTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="student-tab" data-bs-toggle="tab" data-bs-target="#student" type="button" role="tab" aria-controls="student" aria-selected="true">Students</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="employee-tab" data-bs-toggle="tab" data-bs-target="#employee" type="button" role="tab" aria-controls="employee" aria-selected="false">Employees</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="admin-tab" data-bs-toggle="tab" data-bs-target="#admin" type="button" role="tab" aria-controls="admin" aria-selected="false">Admins</button>
                        </li>
                    </ul>

                    <div class="tab-content pt-3" id="userTabsContent">
                        <div class="tab-pane fade show active" id="student" role="tabpanel" aria-labelledby="student-tab">
                            <table class="table table-striped">
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
                                    <?php echo getUsersList('student', $search, $page, $limit); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="employee" role="tabpanel" aria-labelledby="employee-tab">
                            <table class="table table-striped">
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
                                    <?php echo getUsersList('employee', $search, $page, $limit); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="admin" role="tabpanel" aria-labelledby="admin-tab">
                            <table class="table table-striped">
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
                                    <?php echo getUsersList('admin', $search, $page, $limit); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <nav>
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo ($page - 1); ?>&search=<?php echo htmlspecialchars($search); ?>&limit=<?php echo $limit; ?>">Previous</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo ($page + 1); ?>&search=<?php echo htmlspecialchars($search); ?>&limit=<?php echo $limit; ?>">Next</a>
                            </li>
                        </ul>
                    </nav>

                    <!-- Entries Per Page Dropdown -->
                    <form method="GET" action="manage-accounts.php">
                        <label for="limit">Entries per page: </label>
                        <select name="limit" onchange="this.form.submit()" class="form-select" id="limit">
                            <option value="10" <?php echo ($limit == 10) ? 'selected' : ''; ?>>10</option>
                            <option value="20" <?php echo ($limit == 20) ? 'selected' : ''; ?>>20</option>
                            <option value="50" <?php echo ($limit == 50) ? 'selected' : ''; ?>>50</option>
                        </select>
                        <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                        <input type="hidden" name="page" value="<?php echo $page; ?>">
                    </form>
                </div>
            </div>
        </section>
    </main>

    <!-- Add Account Modal -->
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

    <!-- Edit Account Modal -->
    <div class="modal fade" id="editAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form method="POST" action="process-edit-account.php">
            <div class="modal-header"><h5 class="modal-title">Edit Account</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
            <input type="hidden" name="id" id="edit-id">
            <div class="mb-3"><label class="form-label">Username</label><input id="edit-username" name="username" class="form-control" readonly></div>
            <div class="mb-3"><label class="form-label">Full Name</label><input id="edit-name" name="name" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Email</label><input type="email" id="edit-email" name="email" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Role</label><select id="edit-role" name="role" class="form-select" required><option>student</option><option>employee</option><option>admin</option></select></div>
            </div>
            <div class="modal-footer"><button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button><button class="btn btn-primary btn-sm">Save Changes</button></div>
        </form>
        </div>
    </div>
    </div>

    <!-- Confirm Delete Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-body text-center">Are you sure you want to delete this account?</div>
        <div class="modal-footer justify-content-center">
            <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
            <a id="confirmDeleteButton" class="btn btn-danger btn-sm">Delete</a>
        </div>
        </div>
    </div>
    </div>

    <?php require_once __DIR__ . '/backend/components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Populate Edit Modal
    var editModal = document.getElementById('editAccountModal');
    editModal.addEventListener('show.bs.modal', function(e) {
        var btn = e.relatedTarget;
        document.getElementById('edit-id').value = btn.dataset.userId;
        document.getElementById('edit-username').value = btn.dataset.username;
        document.getElementById('edit-name').value = btn.dataset.name;
        document.getElementById('edit-email').value = btn.dataset.email;
        document.getElementById('edit-role').value = btn.dataset.role;
    });
    // Delete Modal
    var delModal = document.getElementById('confirmDeleteModal');
    delModal.addEventListener('show.bs.modal', function(e) {
        var btn = e.relatedTarget;
        document.getElementById('confirmDeleteButton').href = 'delete-account.php?id=' + btn.dataset.userId;
    });
    </script>

    <?php if (!empty($_SESSION['flash_success'])): ?>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="successToast"
            class="toast align-items-center text-white bg-success border-0"
            role="alert"
            aria-live="assertive"
            aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
            <?= htmlspecialchars($_SESSION['flash_success']) ?>
            </div>
            <button type="button"
                    class="btn-close btn-close-white me-2 m-auto"
                    data-bs-dismiss="toast"
                    aria-label="Close"></button>
        </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
        var toastEl = document.getElementById('successToast');
        var toast   = new bootstrap.Toast(toastEl, { delay: 3000 });
        toast.show();
        });
    </script>
    <?php 
    unset($_SESSION['flash_success']); 
    endif; ?>

</body>
</html>

<?php
function generateUsername() {
    return 'USR' . strtoupper(uniqid());
}

// Function to fetch users based on role, search term, and pagination
function getUsersList($role, $search = '', $page = 1, $limit = 10) {
    global $pdo;

    // Calculate the offset for pagination
    $offset = ($page - 1) * $limit;

    // Build the query with optional search
    $sql = "
      SELECT id, username, name, email, role
        FROM users
       WHERE role   = :role
         AND status = 'active'          -- only active accounts
         AND (username LIKE :search
           OR name     LIKE :search
           OR email    LIKE :search)
       LIMIT :limit
      OFFSET :offset
    ";

    $stmt = $pdo->prepare($sql);
    $searchTerm = '%' . $search . '%';
    $stmt->bindParam(':role',   $role,       PDO::PARAM_STR);
    $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
    $stmt->bindParam(':limit',  $limit,      PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset,     PDO::PARAM_INT);

    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $output = '';
    foreach ($users as $row) {
        $output .= sprintf(
          "<tr>
             <td>%s</td>
             <td>%s</td>
             <td>%s</td>
             <td>%s</td>
             <td>
               <button
                 class='btn btn-sm btn-outline-primary me-1'
                 data-bs-toggle='modal'
                 data-bs-target='#editAccountModal'
                 data-user-id='%d'
                 data-username='%s'
                 data-name='%s'
                 data-email='%s'
                 data-role='%s'
                 title='Edit'
               >
                 <i class='bi bi-pencil-square'></i>
               </button>
               <button
                 class='btn btn-sm btn-outline-danger'
                 data-bs-toggle='modal'
                 data-bs-target='#confirmDeleteModal'
                 data-user-id='%d'
                 title='Delete'
               >
                 <i class='bi bi-trash'></i>
               </button>
             </td>
           </tr>",
           // 1–4: row columns
           htmlspecialchars($row['username']),
           htmlspecialchars($row['name']),
           htmlspecialchars($row['email']),
           htmlspecialchars($row['role']),
           // 5–9: for edit modal data-*
           $row['id'],
           htmlspecialchars($row['username']),
           htmlspecialchars($row['name']),
           htmlspecialchars($row['email']),
           htmlspecialchars($row['role']),
           // 10: for delete modal data-user-id
           $row['id']
        );
    }

    return $output;
}


