<?php
session_start();
$host = "localhost";
$dbname = "fur_a_paw_intments";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Redirect if not logged in
if (!isset($_SESSION['customer_id'])) {
    die("<script>alert('Please log in first!'); window.location.href='lag.php';</script>");
}

$customer_id = $_SESSION['customer_id'];

// 🔹 Check if there's an existing unpaid payment
$stmt = $conn->prepare("SELECT payment_id FROM payment WHERE customer_id = ? AND payment_status = 'Pending' LIMIT 1");
$stmt->execute([$customer_id]);
$existing_payment = $stmt->fetch(PDO::FETCH_ASSOC);

if ($existing_payment) {
    $payment_id = $existing_payment['payment_id']; // Use existing payment ID
} else {
    // 🔹 Ensure the user has a registered pet
    $stmt = $conn->prepare("SELECT pet_id FROM pet WHERE customer_id = ? ORDER BY pet_id DESC LIMIT 1");
    $stmt->execute([$customer_id]);
    $pet = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$pet) {
        die("<script>alert('No pet found! Please register a pet first.'); window.location.href='pet.php';</script>");
    }

    $pet_id = $pet['pet_id'];

    // 🔹 Fetch service rate
    $service_id = 1; // Default service (Pet Hotel or Daycare)
    $stmt = $conn->prepare("SELECT service_rate FROM service WHERE service_id = ?");
    $stmt->execute([$service_id]);
    $service = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$service) {
        die("<script>alert('Service not found! Contact support.'); window.location.href='pet.php';</script>");
    }

    $payment_amount = $service['service_rate'];
    $payment_category = 'Full'; // Default to Full payment

    // 🔹 Insert Payment (Set `payment_reference_number` to `NULL`)
    $stmt = $conn->prepare("INSERT INTO payment 
        (payment_reference_number, payment_category, payment_amount, payment_method, payment_status, payment_date, customer_id) 
        VALUES (NULL, ?, ?, 'GCash', 'Pending', NOW(), ?)");

    $stmt->execute([$payment_category, $payment_amount, $customer_id]);
    $payment_id = $conn->lastInsertId(); // Get newly created payment ID

    // 🔹 Create Booking with the Payment ID
    $check_in = date('Y-m-d');
    $check_out = date('Y-m-d', strtotime('+1 day'));

    $stmt = $conn->prepare("INSERT INTO booking (pet_id, service_id, booking_check_in, booking_check_out, payment_id) 
                            VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$pet_id, $service_id, $check_in, $check_out, $payment_id]);
    $booking_id = $conn->lastInsertId(); // Get newly created booking ID

    // Store booking in session
    $_SESSION['latest_booking_id'] = $booking_id;
}

// 🔹 Fetch Booking Details
$stmt = $conn->prepare("
    SELECT b.booking_id, b.payment_id, b.booking_check_in, b.booking_check_out,
           p.pet_name, p.pet_breed, p.pet_gender, p.pet_age,
           c.customer_first_name, c.customer_last_name,
           s.service_name, s.service_rate
    FROM booking b
    JOIN pet p ON b.pet_id = p.pet_id
    JOIN customer c ON p.customer_id = c.customer_id
    JOIN service s ON b.service_id = s.service_id
    WHERE b.payment_id = ?
");
$stmt->execute([$payment_id]);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

// 🔹 Handle Payment Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reference_no = trim($_POST['reference_no']);
    $payment_method = $_POST['payment_method'] ?? 'GCash'; // ✅ Ensure a value is provided

    // ✅ Validate Reference Number
    if (empty($reference_no)) {
        echo "<script>alert('Reference number cannot be empty!'); window.history.back();</script>";
        exit();
    }

    // ✅ Check if Reference Number Already Exists
    $stmt = $conn->prepare("SELECT COUNT(*) FROM payment WHERE payment_reference_number = ?");
    $stmt->execute([$reference_no]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        echo "<script>alert('Reference number already exists! Please enter a unique reference number.'); window.history.back();</script>";
        exit();
    }

    // ✅ Handle proof of payment upload
    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

    $payment_proof = null;
    if (!empty($_FILES['payment_proof']['name'])) {
        $payment_proof = $upload_dir . time() . "_" . basename($_FILES['payment_proof']['name']);
        move_uploaded_file($_FILES['payment_proof']['tmp_name'], $payment_proof);
    }

    // ✅ Update Payment with User-Entered Reference Number
    $stmt = $conn->prepare("UPDATE payment 
        SET payment_reference_number = ?, payment_method = ?, proof_of_payment = ?, payment_status = 'Completed' 
        WHERE payment_id = ?");

    if ($stmt->execute([$reference_no, $payment_method, $payment_proof, $payment_id])) {
        $_SESSION['latest_transaction_id'] = $payment_id; // Store the correct payment ID
        echo "<script>
                alert('Payment submitted successfully! Wait for confirmation.');
                window.location.href='confirm.php';
              </script>";
        exit();
    } else {
        echo "<script>alert('Error processing payment. Try again.');</script>";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Hotel Payment</title>
    <link rel="stylesheet" href="seal.css">
</head>
<body>

<!-- Payment Modal -->
<div class="modal payment-modal" id="paymentModal">
    <div class="modal-content">
        <h1>Let's Seal the Deal!</h1>
        <p class="subtitle">To finalize your pet's stay, please scan the QR code below to securely process your payment.</p>

        <div class="modal-grid">
            <div class="details-section">
                <p class="transaction-no">Transaction No. <?php echo htmlspecialchars($booking['booking_id']); ?></p>
                <h2 class="pet-name"><?php echo htmlspecialchars($booking['pet_name']); ?></h2>
                <p class="dates"><?php echo date("F j", strtotime($booking['booking_check_in'])) . " - " . date("F j, Y", strtotime($booking['booking_check_out'])); ?></p>

                <div class="info-grid">
                    <div class="info-row"><span class="label">Service:</span><span class="value"><?php echo htmlspecialchars($booking['service_name']); ?></span></div>
                    <div class="info-row"><span class="label">Breed:</span><span class="value"><?php echo htmlspecialchars($booking['pet_breed']); ?></span></div>
                    <div class="info-row"><span class="label">Gender:</span><span class="value"><?php echo htmlspecialchars($booking['pet_gender']); ?></span></div>
                    <div class="info-row"><span class="label">Age:</span><span class="value"><?php echo $booking['pet_age']; ?> years old</span></div>
                    <div class="info-row"><span class="label">Owner:</span><span class="value"><?php echo htmlspecialchars($booking['customer_first_name'] . ' ' . $booking['customer_last_name']); ?></span></div>
                    <div class="info-row"><span class="label">Amount to Pay:</span><span class="value">₱ <?php echo number_format($booking['service_rate'], 2); ?></span></div>
                    <div class="info-row"><span class="label">Remaining Balance:</span><span class="value">₱ <?php echo number_format($booking['service_rate'], 2); ?></span></div>
                </div>

                <form method="POST" enctype="multipart/form-data">
                    <div class="payment-section">
                        <p class="section-label">Mode of Payment</p>
                        <div class="radio-group">
                            <label><input type="radio" name="payment_method" value="Maya" checked> <span>Maya</span></label>
                            <label><input type="radio" name="payment_method" value="GCash"> <span>GCash</span></label>
                        </div>

                        <p class="section-label">Reference No. of Your Payment</p>
                        <input type="text" name="reference_no" placeholder="Enter Reference Number" class="reference-input" required>

                        <p class="section-label">Proof of Payment</p>
                        <input type="file" name="payment_proof" accept="image/*" required>
                    </div>

                    <button type="submit" class="action-btn">Complete Booking</button>
                </form>
            </div>

            <div class="qr-section">
                <div class="qr-codes">
                    <img src="temp_gcash.png" alt="GCash QR Code" class="qr-code">
                    <img src="temp_maya.png" alt="Maya QR Code" class="qr-code">
                </div>
                <p class="qr-instruction">We accept bank transfer to our GCash/Maya account or just scan the QR Code!</p>
                <div class="account-info">
                    <p>Account Number: <span>987654321</span></p>
                    <p>Account Name: <span>Veatrice Delos Santos</span></p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
