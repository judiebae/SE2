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
    <style>
        :root {
            --primary-bg: #F7E2CF;
            --primary-text: #AB643C;
            --button-bg: #55402F;
            --text-color: #545454;
            --coral-text: #D98D62;
        }

        body {
            margin: 0;
            padding: 20px;
            font-family: 'Ballotadmu-Medium', sans-serif;
            background-color: rgba(0, 0, 0, 0.5);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .payment-modal {
            background-color: var(--primary-bg);
            border-radius: 24px;
            padding: 30px;
            width: 1000px;
            position: relative;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .paw-prints {
            position: absolute;
            top: 20px;
            right: 20px;
            opacity: 0.3;
        }

        h1 {
            color: var(--primary-text);
            font-size: 36px;
            margin: 0;
            grid-column: 1 / -1;
            text-align: center;
        }

        .subtitle {
            grid-column: 1 / -1;
            text-align: center;
            color: var(--text-color);
            margin: 0 0 20px 0;
        }

        .booking-details {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .transaction-number {
            color: var(--text-color);
            font-weight: bold;
            margin: 0;
        }

        .pet-name {
            color: var(--coral-text);
            font-size: 24px;
            margin: 5px 0;
        }

        .details-grid {
            display: grid;
            gap: 8px;
        }

        .details-row {
            display: grid;
            grid-template-columns: 120px 1fr;
            color: var(--coral-text);
        }

        .details-row .value {
            color: var(--text-color);
        }

        .payment-section {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .qr-codes {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .qr-code {
            width: 100%;
            max-width: 200px;
            height: auto;
        }

        .payment-form {
            margin-top: 20px;
        }

        .radio-group {
            display: flex;
            gap: 20px;
            margin: 10px 0;
        }

        .radio-group label {
            color: var(--coral-text);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .reference-input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin: 5px 0;
        }

        .upload-btn {
            display: inline-block;
            padding: 8px 16px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            color: var(--text-color);
        }

        .complete-btn {
            background: var(--button-bg);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            float: right;
            margin-top: 20px;
        }

        /* Success Modal Styles */
        .success-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .success-content {
            background: var(--primary-bg);
            width: 800px;
            height: 400px;
            border-radius: 24px;
            padding: 30px;
            text-align: center;
            position: relative;
        }

        .success-content h2 {
            color: var(--primary-text);
            font-size: 42px;
            margin: 20px 0;
        }

        .success-content img {
            width: 300px;
            height: auto;
            margin: 20px 0;
        }

        .success-content .okay-btn {
            background: var(--button-bg);
            color: white;
            border: none;
            padding: 12px 40px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 20px 0;
        }

        .success-content a {
            color: var(--primary-text);
            text-decoration: none;
            display: block;
            margin-top: 10px;
        }

        .account-info {
            color: var(--coral-text);
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
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
                    📎 Upload Here
                    <input type="file" accept="image/*" required style="display: none;">
                </label>
            </div>
        </div>

        <div class="payment-section">
            <div class="qr-codes">
                <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/image-RHu4Y3NL0GrRbDTuKtQBOzBqGV3ib7.png" alt="GCash QR" class="qr-code">
                <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/image-RHu4Y3NL0GrRbDTuKtQBOzBqGV3ib7.png" alt="Maya QR" class="qr-code">
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
            <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/image-aCDBV3zOmTgQlibaR7BtUA7tqlGqD1.png" alt="Success">
            <button class="okay-btn" onclick="window.location.href='index.php'">Okay</button>
            <a href="index.php">Go back to Homepage</a>
        </div>
    </div>

    <script>
        function showSuccessModal() {
            document.getElementById('successModal').style.display = 'flex';
        }
    </script>
</body>
</html>