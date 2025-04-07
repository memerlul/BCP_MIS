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
            <a class="nav-link <?= ($current_page == 'usermanagement.php') ? 'active' : '' ?>" href="usermanagement.php">
                <i class="bi bi-person-fill"></i>
                <span>User Management</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'audit.php') ? 'active' : '' ?>" href="audit.php">
                <i class="bi bi-journal-text"></i>
                <span>Audit</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'helpdesk.php') ? 'active' : '' ?>" href="helpdesk.php">
                <i class="bi bi-telephone-inbound-fill"></i>
                <span>Help Desk</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'report-builder.php') ? 'active' : '' ?>" href="report-builder.php">
                <i class="bi bi-folder"></i>
                <span>Report Builder</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'student-ledger.php') ? 'active' : '' ?>" href="student-ledger.php">
                <i class="bi bi-journal-bookmark-fill"></i>
                <span>Student Ledger</span>
            </a>
        </li>

    </ul>
</aside>
