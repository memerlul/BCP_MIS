<?php
require_once __DIR__ . '/db_config.php';   // defines $pdo
require_once __DIR__ . '/backend/auth.php';        // admin‐only guard

// grab & sanitize search term
$search = trim($_GET['search'] ?? '');
$like   = "%{$search}%";

// fetch all inactive users matching search
$sql = "
  SELECT id, username, name, email, role
    FROM users
   WHERE status = 'inactive'
     AND (username LIKE :search
       OR name     LIKE :search
       OR email    LIKE :search)
   ORDER BY name
";
$stmt = $pdo->prepare($sql);
$stmt->execute(['search' => $like]);
$allInactive = $stmt->fetchAll(PDO::FETCH_ASSOC);

// group by role
$students  = array_filter($allInactive, fn($u) => $u['role'] === 'student');
$employees = array_filter($allInactive, fn($u) => $u['role'] === 'employee');
$admins    = array_filter($allInactive, fn($u) => $u['role'] === 'admin');
?>

<?php $page_title = "Inactive Account"; ?>
<!DOCTYPE html>
<html lang="en">
    <?php include 'backend/components/head.php'; ?>
    <body>
        <?php include 'backend/components/header.php'; ?>

        <?php include 'backend/components/sidebar.php'; ?>
        
        <main id="main" class="main">
        <div class="pagetitle">
          <h1>Inactive Accounts</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item">Manage Accounts</li>
              <li class="breadcrumb-item active">Inactive Accounts</li>
            </ol>
          </nav>
        </div>

        <section class="section">
          <div class="row">
            <div class="col-12">

            <?php if (!empty($_SESSION['flash_success'])): ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['flash_success']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php unset($_SESSION['flash_success']); ?>
            <?php endif; ?>

            <?php if (!empty($_SESSION['flash_errors'])): ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php foreach ($_SESSION['flash_errors'] as $err): ?>
                  <div><?= htmlspecialchars($err) ?></div>
                <?php endforeach; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php unset($_SESSION['flash_errors']); ?>
            <?php endif; ?>

              <div class="card">
                <div class="card-body">

                  <h5 class="card-title">Inactive User Accounts</h5>

                  <!-- global Search form -->
                  <form method="get" class="mb-3">
                    <div class="input-group">
                      <input type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search inactive users"
                            value="<?= htmlspecialchars($search) ?>">
                      <button class="btn btn-primary">Search</button>
                    </div>
                  </form>

                  <!-- Nav-tabs -->
                  <ul class="nav nav-tabs nav-tabs-bordered mb-3">
                    <li class="nav-item">
                      <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#students">Students</button>
                    </li>
                    <li class="nav-item">
                      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#employees">Employees</button>
                    </li>
                    <li class="nav-item">
                      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#admins">Admins</button>
                    </li>
                  </ul>

                  <div class="tab-content">

                    <!-- Students Tab -->
                    <div class="tab-pane fade show active" id="students">
                      <div class="table-responsive">
                        <table class="table table-hover mb-0">
                          <thead class="table-light">
                            <tr>
                              <th>Username</th>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Role</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if (count($students) > 0): ?>
                              <?php foreach ($students as $u): ?>
                                <tr>
                                  <td><?= htmlspecialchars($u['username']) ?></td>
                                  <td><?= htmlspecialchars($u['name']) ?></td>
                                  <td><?= htmlspecialchars($u['email']) ?></td>
                                  <td><?= htmlspecialchars($u['role']) ?></td>
                                  <td>
                                  <a href="reactivate-account.php?id=<?= $u['id'] ?>"
                                    class="btn btn-success btn-sm"
                                    onclick="return confirm('Reactivate this account?');">
                                    <i class="bi bi-check-circle"></i>
                                  </a>
                                  </td>
                                </tr>
                              <?php endforeach; ?>
                            <?php else: ?>
                              <tr>
                                <td colspan="5" class="text-center py-4">No inactive students found.</td>
                              </tr>
                            <?php endif; ?>
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <!-- Employees Tab -->
                    <div class="tab-pane fade" id="employees">
                      <div class="table-responsive">
                        <table class="table table-hover mb-0">
                          <thead class="table-light">
                            <tr>
                              <th>Username</th>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Role</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if (count($employees) > 0): ?>
                              <?php foreach ($employees as $u): ?>
                                <tr>
                                  <td><?= htmlspecialchars($u['username']) ?></td>
                                  <td><?= htmlspecialchars($u['name']) ?></td>
                                  <td><?= htmlspecialchars($u['email']) ?></td>
                                  <td><?= htmlspecialchars($u['role']) ?></td>
                                  <td>
                                  <a href="reactivate-account.php?id=<?= $u['id'] ?>"
                                    class="btn btn-success btn-sm"
                                    onclick="return confirm('Reactivate this account?');">
                                    <i class="bi bi-check-circle"></i>
                                  </a>
                                  </td>
                                </tr>
                              <?php endforeach; ?>
                            <?php else: ?>
                              <tr>
                                <td colspan="5" class="text-center py-4">No inactive employees found.</td>
                              </tr>
                            <?php endif; ?>
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <!-- Admins Tab -->
                    <div class="tab-pane fade" id="admins">
                      <div class="table-responsive">
                        <table class="table table-hover mb-0">
                          <thead class="table-light">
                            <tr>
                              <th>Username</th>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Role</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if (count($admins) > 0): ?>
                              <?php foreach ($admins as $u): ?>
                                <tr>
                                  <td><?= htmlspecialchars($u['username']) ?></td>
                                  <td><?= htmlspecialchars($u['name']) ?></td>
                                  <td><?= htmlspecialchars($u['email']) ?></td>
                                  <td><?= htmlspecialchars($u['role']) ?></td>
                                  <td>
                                  <a href="reactivate-account.php?id=<?= $u['id'] ?>"
                                    class="btn btn-success btn-sm"
                                    onclick="return confirm('Reactivate this account?');">
                                    <i class="bi bi-check-circle"></i>
                                  </a>
                                  </td>
                                </tr>
                              <?php endforeach; ?>
                            <?php else: ?>
                              <tr>
                                <td colspan="5" class="text-center py-4">No inactive admins found.</td>
                              </tr>
                            <?php endif; ?>
                          </tbody>
                        </table>
                      </div>
                    </div>

                  </div><!-- End .tab-content -->

                </div><!-- End .card-body -->
              </div><!-- End .card -->

            </div>
          </div>
        </section>
      </main>

        <?php include 'backend/components/footer.php'; ?>
    </body>
</html>
