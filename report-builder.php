<?php
require __DIR__ . '/backend/auth.php';   // only admins
require_once 'vendor/autoload.php';      // TCPDF
require 'db_config.php';                 // DB connection

$page_title = "Report Builder";

// ───────────────────────────────────────────────────────────────
// Internal System Report Generation
// ───────────────────────────────────────────────────────────────
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['report_type'])) {
    $report_type = $_POST['report_type'];
    $start_date  = $_POST['start_date']  ?? '';
    $end_date    = $_POST['end_date']    ?? '';

    if ($report_type === 'user_management') {
        $sql    = 'SELECT id, username, email, role, created_at FROM users';
        $conds  = [];
        if ($start_date && $end_date) {
            $conds[] = 'created_at BETWEEN :start_date AND :end_date';
        }
        if ($conds) {
            $sql .= ' WHERE ' . implode(' AND ', $conds);
        }
        $stmt = $pdo->prepare($sql);
        if ($start_date && $end_date) {
            $stmt->bindParam(':start_date', $start_date);
            $stmt->bindParam(':end_date',   $end_date);
        }
        $stmt->execute();
        $report_data  = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $report_title = "User Management Report";

    } elseif ($report_type === 'audit_trail') {
        $sql = <<<SQL
SELECT a.id,
       u.username,
       a.action,
       a.created_at AS timestamp
  FROM audit_trail a
  JOIN users u ON a.actor_id = u.id
SQL;
        $conds = [];
        if ($start_date && $end_date) {
            $conds[] = 'a.created_at BETWEEN :start_date AND :end_date';
        }
        if ($conds) {
            $sql .= ' WHERE ' . implode(' AND ', $conds);
        }
        $stmt = $pdo->prepare($sql);
        if ($start_date && $end_date) {
            $stmt->bindParam(':start_date', $start_date);
            $stmt->bindParam(':end_date',   $end_date);
        }
        $stmt->execute();
        $report_data  = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $report_title = "Audit Trail Report";

    } elseif ($report_type === 'help_desk') {
        $sql    = 'SELECT id, student_id, concern, status, created_at FROM concerns';
        $conds  = [];
        if ($start_date && $end_date) {
            $conds[] = 'created_at BETWEEN :start_date AND :end_date';
        }
        if ($conds) {
            $sql .= ' WHERE ' . implode(' AND ', $conds);
        }
        $stmt = $pdo->prepare($sql);
        if ($start_date && $end_date) {
            $stmt->bindParam(':start_date', $start_date);
            $stmt->bindParam(':end_date',   $end_date);
        }
        $stmt->execute();
        $report_data  = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $report_title = "Help Desk Report";

    } else {
        die("Invalid internal report type.");
    }

    // ───────────────────────────────────────────────────────────────
    // Generate PDF for internal system
    // ───────────────────────────────────────────────────────────────
    if (!empty($report_data)) {
        $pdf = new TCPDF('P','mm','A4',true,'UTF-8',false);
        $pdf->SetMargins(15,25,15);
        $pdf->SetAutoPageBreak(true,15);
        $pdf->AddPage();

        // Logos & Title
        $logoW = 20; $yLogo = 15;
        $pdf->Image('./backend/pdf_bcp_logo.png',15,$yLogo,$logoW);
        $pdf->Image('./backend/pdf_bcp_logo.png',$pdf->getPageWidth()-15-$logoW,$yLogo,$logoW);
        $pdf->Ln($logoW+5);
        $pdf->SetFont('helvetica','B',16);
        $pdf->Cell(0,0,'BESTLINK COLLEGE OF THE PHILIPPINES',0,1,'C');
        $pdf->Ln(8);
        $pdf->SetFont('helvetica','B',14);
        $pdf->Cell(0,10,$report_title,0,1,'C');
        $pdf->Ln(5);

        // Header row
        $pdf->SetFont('helvetica','B',10);
        if ($report_type==='user_management') {
            $pdf->Cell(15,8,'ID',1,0,'C');
            $pdf->Cell(40,8,'Username',1,0,'C');
            $pdf->Cell(55,8,'Email',1,0,'C');
            $pdf->Cell(30,8,'Role',1,0,'C');
            $pdf->Cell(40,8,'Created At',1,1,'C');
        } elseif ($report_type==='audit_trail') {
            $pdf->Cell(15,8,'ID',1,0,'C');
            $pdf->Cell(45,8,'Username',1,0,'C');
            $pdf->Cell(60,8,'Action',1,0,'C');
            $pdf->Cell(60,8,'When',1,1,'C');
        } else { // help_desk
            $pdf->Cell(15,8,'ID',1,0,'C');
            $pdf->Cell(45,8,'Student ID',1,0,'C');
            $pdf->Cell(85,8,'Concern',1,0,'C');
            $pdf->Cell(35,8,'Status',1,1,'C');
        }

        // Data rows
        $pdf->SetFont('helvetica','',10);
        foreach ($report_data as $row) {
            if ($report_type==='user_management') {
                $pdf->Cell(15,8,$row['id'],1,0,'C');
                $pdf->Cell(40,8,$row['username'],1,0,'C');
                $pdf->Cell(55,8,$row['email'],1,0,'L');
                $pdf->Cell(30,8,$row['role'],1,0,'C');
                $pdf->Cell(40,8,$row['created_at'],1,1,'C');
            } elseif ($report_type==='audit_trail') {
                $pdf->Cell(15,8,$row['id'],1,0,'C');
                $pdf->Cell(45,8,$row['username'],1,0,'C');
                $pdf->Cell(60,8,$row['action'],1,0,'L');
                $pdf->Cell(60,8,$row['timestamp'],1,1,'C');
            } else {
                $pdf->Cell(15,8,$row['id'],1,0,'C');
                $pdf->Cell(45,8,$row['student_id'],1,0,'C');
                $pdf->Cell(85,8,$row['concern'],1,0,'L');
                $pdf->Cell(35,8,$row['status'],1,1,'C');
            }
        }

        $pdf->Output('report.pdf','I');
        exit;
    }
} 
?> 
<!DOCTYPE html>
<html lang="en">
    <?php include 'backend/components/head.php'; ?>
    <body>
        <?php include 'backend/components/header.php'; ?> 
        <?php include 'backend/components/sidebar.php'; ?>

        <main id="main" class="main"> 
            <div class="pagetitle">
                <h1>Report Builder</h1>
                <nav><ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="Dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active">Report Builder</li>
                </ol></nav>
            </div>

            <section class="section">
                <div class="row"> 

                    <!-- Internal System -->
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Select Report Type</h5>
                                <form method="POST">
                                    <div class="row gy-3">
                                        <div class="col-md-4">
                                            <label for="report_type">Report Type</label>
                                            <select id="report_type" name="report_type" class="form-select" required>
                                                <option value="user_management">User Management</option>
                                                <option value="audit_trail">Audit Trail</option>
                                                <option value="help_desk">Help Desk</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="start_date">Start Date</label>
                                            <input type="date" id="start_date" name="start_date" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="end_date">End Date</label>
                                            <input type="date" id="end_date" name="end_date" class="form-control">
                                        </div>
                                    </div>
                                    <button class="btn btn-primary mt-3">Generate Report</button>
                                </form>
                            </div>
                        </div>
                    </div> 

                    <!-- External System -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">External System Report Builder</h5>
                                <form method="POST">
                                    <div class="row gy-3">
                                        <div class="col-md-3">
                                            <label for="external_system">System</label>
                                            <select id="external_system" name="external_system" class="form-select" required>
                                                <option value="admission">Admission System</option>
                                                <option value="sis">Student Info System</option>
                                                <option value="finance">Finance System</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="external_report_type">Report Type</label>
                                            <select id="external_report_type" name="external_report_type" class="form-select" required>
                                                <option value="user_management">User Management</option>
                                                <option value="audit_trail">Audit Trail</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="external_start_date">Start Date</label>
                                            <input type="date" id="external_start_date" name="external_start_date" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="external_end_date">End Date</label>
                                            <input type="date" id="external_end_date" name="external_end_date" class="form-control">
                                        </div>
                                    </div>
                                    <button type="submit" name="external_generate" class="btn btn-secondary mt-3">
                                        Generate External Report
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div><!-- /.row -->
            </section>
        </main><!-- End #main --> 

        <?php include 'backend/components/footer.php'; ?>
    </body>
</html>
