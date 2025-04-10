<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <?php 
        $current_page = basename($_SERVER['PHP_SELF']); // Get current page filename
        ?>

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'Dashboard.php') ? 'active' : '' ?>" href="Dashboard.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>User management</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                <a class="nav-link <?= ($current_page == 'user_management/manage-accounts.php') ? 'active' : '' ?>" href="user_management/manage-accounts.php">
                        <i class="bi bi-circle"></i><span>Manage Accounts</span>
                    </a>
                </li>
                <li>
                <a class="nav-link <?= ($current_page == 'user_management/inactive-accounts.php') ? 'active' : '' ?>" href="user_management/inactive-accounts.php">
                        <i class="bi bi-circle"></i><span>Inactive Accounts</span>
                    </a>
                </li>
                <li>
                <a class="nav-link <?= ($current_page == 'user_management/roles-&-permissions.php') ? 'active' : '' ?>" href="user_management/roles-&-permissions.php">
                        <i class="bi bi-circle"></i><span>Roles & Permissions</span>
                    </a>
                </li>
                <>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'audit.php') ? 'active' : '' ?>" href="audit.php">
                <i class="bi bi-grid"></i>
                <span>Audit logs</span>
            </a>
        </li><!-- End Audit logs Nav -->

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'helpdesk.php') ? 'active' : '' ?>" href="helpdesk.php">
                <i class="bi bi-grid"></i>
                <span>Help Desk</span>
            </a>
        </li><!-- End Help Desk Nav -->

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'report-builder.php') ? 'active' : '' ?>" href="report-builder.php">
                <i class="bi bi-grid"></i>
                <span>Report Builder</span>
            </a>
        </li><!-- End Report Builder Nav -->

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'student-ledger.php') ? 'active' : '' ?>" href="student-ledger.php">
                <i class="bi bi-grid"></i>
                <span>Student Ledger</span>
            </a>
        </li><!-- End Student Ledger Nav -->
    </ul>
</aside>
