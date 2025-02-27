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

// Fetch the latest pet added by the logged-in user
$stmt = $conn->prepare("
    SELECT 
        p.pet_id, p.pet_name, p.pet_breed, p.pet_gender, p.pet_age,
        c.customer_first_name, c.customer_last_name
    FROM pet p
    JOIN customer c ON p.customer_id = c.customer_id
    WHERE c.customer_id = ? 
    ORDER BY p.pet_id DESC LIMIT 1
");
$stmt->execute([$customer_id]);
$pet = $stmt->fetch(PDO::FETCH_ASSOC);

// If no pet found
if (!$pet) {
    die("<script>alert('No registered pet found! Please add a pet first.'); window.location.href='pet.php';</script>");
}

// Handle Payment Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reference_no = htmlspecialchars($_POST['reference_no']);
    $payment_method = $_POST['payment_method'];

    // Handle proof of payment upload
    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

    $payment_proof = null;
    if (!empty($_FILES['payment_proof']['name'])) {
        $payment_proof = $upload_dir . time() . "_" . basename($_FILES['payment_proof']['name']);
        move_uploaded_file($_FILES['payment_proof']['tmp_name'], $payment_proof);
    }

    // Store payment in database
    $stmt = $conn->prepare("INSERT INTO payment (customer_id, pet_id, reference_no, payment_method, payment_proof, payment_status) VALUES (?, ?, ?, ?, ?, 'Pending')");
    if ($stmt->execute([$customer_id, $pet['pet_id'], $reference_no, $payment_method, $payment_proof])) {
        echo "<script>
                alert('Payment submitted successfully! Wait for confirmation.');
                window.location.href='index.php';
              </script>";
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
                    <div class="info-row"><span class="label">Remaining Balance:</span><span class="value">₱ 0.00</span></div>
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

<!-- Success Modal -->
<div class="modal confirmation-modal" id="confirmationModal" style="display: none;">
    <div class="modal-content">
        <h2>Transaction ID No. <?php echo htmlspecialchars($booking['booking_id']); ?></h2>
        <p class="confirmation-message">Wait for our team's confirmation on your reservation.<br>Thank you!</p>
        <button class="action-btn" onclick="window.location.href='index.php'">Okay</button>
    </div>
</div>

</body>
</html>
