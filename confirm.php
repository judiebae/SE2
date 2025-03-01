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

// Ensure transaction ID exists in session
if (!isset($_SESSION['latest_transaction_id'])) {
    die("<script>alert('No recent transactions found!'); window.location.href='index.php';</script>");
}

$payment_id = $_SESSION['latest_transaction_id']; // Retrieve stored transaction ID

// Fetch the correct transaction
$stmt = $conn->prepare("
    SELECT b.booking_id, p.payment_reference_number 
    FROM booking b
    JOIN payment p ON b.payment_id = p.payment_id
    WHERE p.payment_id = ?
");
$stmt->execute([$payment_id]);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$booking) {
    die("<script>alert('No transaction found!'); window.location.href='index.php';</script>");
}

$showSuccessModal = true; // Ensures the modal is displayed
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Hotel Payment</title>
    <link rel="stylesheet" href="confirm.css">
</head>
<body>

 <!-- ✅ Success Modal (Shows After Payment Submission) -->
 <div class="modal confirmation-modal" id="confirmationModal" style="<?php echo $showSuccessModal ? 'display: flex;' : 'display: none;'; ?>">
      <div class="modal-content">
          <h2>Transaction ID No. <?php echo htmlspecialchars($booking['booking_id'] ?? 'N/A'); ?></h2>
          <p class="confirmation-message">
            Wait for our team's confirmation on your reservation.<br>
            Thank you!
        </p>
        <button class="action-btn" onclick="window.location.href='index.php'">Okay</button>
        <a href="index.php" class="home-link">Go back to Homepage</a>
        <img src="Paws header 2.png" alt="Paw Header" class="top-right">
        <img src="pupcat.png" alt="Happy puppies" class="puppies-image">
      </div>
</div> 

</body>
</html>
