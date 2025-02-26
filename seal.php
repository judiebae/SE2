<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "fur_a_paw_intments");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch booking details from database
$booking_id = $_GET['booking_id'] ?? 'B001';
$query = "SELECT 
    b.booking_id,
    b.booking_check_in,
    b.booking_check_out,
    p.pet_name,
    p.pet_breed,
    p.pet_gender,
    p.pet_age,
    c.customer_first_name,
    c.customer_last_name,
    s.service_name,
    s.service_rate
FROM booking b
JOIN pet p ON b.pet_id = p.pet_id
JOIN customer c ON p.customer_id = c.customer_id
JOIN service s ON b.service_id = s.service_id
WHERE b.booking_id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Let's Seal the Deal! - Payment Confirmation</title>
    <link rel="stylesheet" href="seal.css">

</head>
<body>
    <div class="payment-modal">
        <div class="paw-prints">🐾 🐾 🐾</div>
        <h1>Let's Seal the Deal!</h1>
        <p class="subtitle">To finalize your pet's stay, please scan the QR code below to securely process your payment.</p>

        <div class="booking-details">
            <p class="transaction-number">Transaction No. <?php echo $booking['booking_id']; ?></p>
            <h2 class="pet-name"><?php echo htmlspecialchars($booking['pet_name']); ?></h2>
            
            <div class="details-grid">
                <div class="details-row">
                    <span class="label">Service:</span>
                    <span class="value"><?php echo htmlspecialchars($booking['service_name']); ?></span>
                </div>
                <div class="details-row">
                    <span class="label">Breed:</span>
                    <span class="value"><?php echo htmlspecialchars($booking['pet_breed']); ?></span>
                </div>
                <div class="details-row">
                    <span class="label">Gender:</span>
                    <span class="value"><?php echo htmlspecialchars($booking['pet_gender']); ?></span>
                </div>
                <div class="details-row">
                    <span class="label">Age:</span>
                    <span class="value"><?php echo $booking['pet_age']; ?> years old</span>
                </div>
                <div class="details-row">
                    <span class="label">Owner:</span>
                    <span class="value"><?php echo htmlspecialchars($booking['customer_first_name'] . ' ' . $booking['customer_last_name']); ?></span>
                </div>
                <div class="details-row">
                    <span class="label">Amount:</span>
                    <span class="value">₱ <?php echo number_format($booking['service_rate'], 2); ?></span>
                </div>
            </div>

            <div class="payment-form">
                <div class="radio-group">
                    <label><input type="radio" name="payment" value="maya" checked> Maya</label>
                    <label><input type="radio" name="payment" value="gcash"> GCash</label>
                </div>
                
                <label style="color: var(--coral-text);">Reference No. of Your Payment</label>
                <input type="text" class="reference-input" placeholder="Enter Reference Number" required>
                
                <label class="upload-btn">
                Upload Here
                    <input type="file" accept="image/*" required style="display: none;">
                </label>
            </div>
        </div>

        <div class="payment-section">
            <div class="qr-codes">
                <img src="temp_gcash.png" alt="GCash QR" class="qr-code1">
                <img src="temp_maya.png" alt="Maya QR" class="qr-code2">
            </div>
            
            <div class="account-info">
                <p>We accept bank transfer to our GCash/Maya account or just scan the QR Code!</p>
                <p>Account Number: 987654321</p>
                <p>Account Name: Veatrice Delos Santos</p>
            </div>
            
            <button class="complete-btn" onclick="showSuccessModal()">Complete Booking</button>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="success-modal" id="successModal">
        <div class="success-content">
            <div class="paw-prints">🐾 🐾 🐾</div>
            <h2>Transaction ID No. <?php echo $booking['booking_id']; ?></h2>
            <p>Wait for our team's confirmation on your reservation.</p>
            <p>Thank you!</p>
            <button class="okay-btn" onclick="window.location.href='index.php'">Okay</button>
            <a href="index.php">Go back to Homepage</a>
            <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/image-aCDBV3zOmTgQlibaR7BtUA7tqlGqD1.png" alt="Success">
        </div>
    </div>

    <script>
        function showSuccessModal() {
            document.getElementById('successModal').style.display = 'flex';
        }
    </script>
</body>
</html>