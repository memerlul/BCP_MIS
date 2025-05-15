<?php
require __DIR__ . '/backend/auth.php';
require 'db_config.php';  // Ensure the database connection is included

$page_title = "Student Ledger"; 

// Fetch student balances and join with students table to get student names
$query_balance = "
    SELECT sb.student_id, s.student_name, sb.balance
    FROM student_balance sb
    LEFT JOIN students s ON sb.student_id = s.student_id
";
$stmt_balance = $pdo->query($query_balance);
$student_balance_data = $stmt_balance->fetchAll(PDO::FETCH_ASSOC);

// Ensure that the student_id is set (for example, from the URL or session)
$student_id = 'USR680F7858ABF0C';  // Replace this with dynamic student_id retrieval, if needed

// Fetch payment history and join with students table to get student names, receipt numbers, and amounts
$query_payment = "
    SELECT p.student_id, p.payment_date, p.payment_method, p.payment_type, p.receipt_number, p.amount
    FROM payment_history p
    WHERE p.student_id = :student_id
";
$stmt_payment = $pdo->prepare($query_payment);
$stmt_payment->bindParam(':student_id', $student_id);
$stmt_payment->execute();
$payment_history_data = $stmt_payment->fetchAll(PDO::FETCH_ASSOC);

// Function to generate a random receipt number
function generateReceiptNo() {
    return 'REC' . strtoupper(uniqid());  // Generates a unique random receipt number
}

// Handle form submission for payment records with generated receipt numbers and amounts
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Example data (this should come from your form or dynamic data)
    $student_id = 'USR680F7858ABF0C';  // Replace with dynamic data
    $payment_date = date('Y-m-d H:i:s');
    $payment_method = 'Bank Transfer'; // Example, replace with actual data
    $payment_type = 'Tuition';  // Example, replace with actual data
    $amount = 1000.00;  // Example payment amount (can be dynamic)
    $receipt_number = generateReceiptNo();  // Generate random receipt number

    // 1. Insert payment record into the payment_history table
    $query_insert_payment = "
        INSERT INTO payment_history (student_id, payment_date, payment_method, payment_type, receipt_number, amount)
        VALUES (:student_id, :payment_date, :payment_method, :payment_type, :receipt_number, :amount)
    ";
    $stmt_insert = $pdo->prepare($query_insert_payment);
    $stmt_insert->bindParam(':student_id', $student_id);
    $stmt_insert->bindParam(':payment_date', $payment_date);
    $stmt_insert->bindParam(':payment_method', $payment_method);
    $stmt_insert->bindParam(':payment_type', $payment_type);
    $stmt_insert->bindParam(':receipt_number', $receipt_number);
    $stmt_insert->bindParam(':amount', $amount);

    if ($stmt_insert->execute()) {
        echo "Payment inserted successfully.";  // Debugging message to check if the payment is inserted
    } else {
        echo "Error inserting payment.";  // If insertion fails
    }

    // 2. Check if the student already has a balance
    $query_get_balance = "
        SELECT balance FROM student_balance WHERE student_id = :student_id
    ";
    $stmt_balance = $pdo->prepare($query_get_balance);
    $stmt_balance->bindParam(':student_id', $student_id);
    $stmt_balance->execute();
    $current_balance = $stmt_balance->fetchColumn();  // Get the current balance

    // Debugging the current balance
    echo "Current Balance: " . $current_balance;  // Debug the current balance

    // 3. If no balance exists, initialize it with a default value (15,000)
    if ($current_balance === false) {
        // Set a default balance of 15,000.00 if no balance exists
        $default_balance = 15000.00;
        $query_init_balance = "
            INSERT INTO student_balance (student_id, balance)
            VALUES (:student_id, :balance)
        ";
        $stmt_init_balance = $pdo->prepare($query_init_balance);
        $stmt_init_balance->bindParam(':student_id', $student_id);
        $stmt_init_balance->bindParam(':balance', $default_balance);
        $stmt_init_balance->execute();
        $current_balance = $default_balance;  // Use the default balance
    }

    // Calculate the new balance
    $new_balance = $current_balance - $amount;  // Subtract payment amount from current balance

    // Debugging the new balance
    echo "New Balance: " . $new_balance;  // Debug the new balance

    // 5. Update the student's balance in the student_balance table
    $query_update_balance = "
        UPDATE student_balance
        SET balance = :new_balance
        WHERE student_id = :student_id
    ";
    $stmt_update_balance = $pdo->prepare($query_update_balance);
    $stmt_update_balance->bindParam(':new_balance', $new_balance);
    $stmt_update_balance->bindParam(':student_id', $student_id);

    if ($stmt_update_balance->execute()) {
        echo "Balance updated successfully.";
    } else {
        echo "Error updating balance.";  // If it fails
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
                <h1>Student Ledger</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="Dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Student Ledger</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->

            <section class="section">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- Student Balance Title -->
                                <h5 class="card-title">Student Balance</h5>
                                
                                <!-- Tabs for Student Balance and Payment History -->
                                <ul class="nav nav-tabs" id="studentLedgerTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="studentBalanceTab" data-bs-toggle="tab" href="#studentBalance">Student Balance</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="paymentHistoryTab" data-bs-toggle="tab" href="#paymentHistory">Payment History</a>
                                    </li>
                                </ul>

                                <!-- Tab Content -->
                                <div class="tab-content mt-3">
                                    <!-- Student Balance Tab Content -->
                                    <div class="tab-pane fade show active" id="studentBalance">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Student ID</th>
                                                    <th>Name</th>
                                                    <th>Balance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($student_balance_data as $student): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($student['student_id']) ?></td>
                                                        <td><?= htmlspecialchars($student['student_name']) ?></td>
                                                        <td>₱<?= number_format($student['balance'], 2) ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Payment History Tab Content -->
                                    <div class="tab-pane fade" id="paymentHistory">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Student ID</th>
                                                    <th>Date</th>
                                                    <th>Payment Method</th>
                                                    <th>Payment Type</th>
                                                    <th>Receipt Number</th>
                                                    <th>Amount Paid</th>  <!-- Add Amount Paid column -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($payment_history_data)) {
                                                    foreach ($payment_history_data as $payment): ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($payment['student_id']) ?></td>
                                                            <td><?= htmlspecialchars($payment['payment_date']) ?></td>
                                                            <td><?= htmlspecialchars($payment['payment_method']) ?></td>
                                                            <td><?= htmlspecialchars($payment['payment_type']) ?></td>
                                                            <td><?= htmlspecialchars($payment['receipt_number']) ?></td>
                                                            <td>₱<?= number_format($payment['amount'], 2) ?></td>  <!-- Display Amount -->
                                                        </tr>
                                                    <?php endforeach; 
                                                } else { ?>
                                                    <tr><td colspan="6">No payment history found for this student.</td></tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div> <!-- End of tab-content -->
                            </div><!-- End of card-body -->
                        </div><!-- End of card -->
                    </div><!-- End of col-lg-12 -->
                </div><!-- Enda of row -->
            </section><!-- End section -->
        </main><!-- End #main -->

        <?php include 'backend/components/footer.php'; ?>

    </body>
</html>
