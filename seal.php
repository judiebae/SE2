<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "fur_a_paw_intments");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch booking details from the database
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

// Handle payment form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extracting and sanitizing inputs
    $reference_no = htmlspecialchars($_POST['reference_no']);
    $payment_method = $_POST['payment_method'];
    
    // Handle image upload
    $upload_dir = 'uploads/';
    $upload_file = $upload_dir . basename($_FILES['payment_proof']['name']);
    $upload_ok = 1;
    $image_file_type = strtolower(pathinfo($upload_file, PATHINFO_EXTENSION));
    
    // Check if the uploaded file is an image
    if (isset($_FILES['payment_proof']) && $_FILES['payment_proof']['error'] == 0) {
        $check = getimagesize($_FILES['payment_proof']['tmp_name']);
        if ($check !== false) {
            // Proceed with the upload
            if (move_uploaded_file($_FILES['payment_proof']['tmp_name'], $upload_file)) {
                // File uploaded successfully, now insert into the database
                $stmt = $conn->prepare("INSERT INTO payments (booking_id, reference_no, payment_method, payment_proof) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $booking_id, $reference_no, $payment_method, $upload_file);
                $stmt->execute();
                
                // Redirect or show success message after inserting the data
                echo "<script>
                        const successModal = document.getElementById('successModal');
                        successModal.style.display = 'flex';
                      </script>";
                exit();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "File is not an image.";
        }
    }

    // If no file uploaded, or if error occurs, show an error message
    echo "Please upload a valid payment proof.";
}

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
                <input type="file" accept="image/*" required style="display: none;" id="payment_proof" name="payment_proof">
            </label>
            <div id="file-name"></div>
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
        
        <button class="complete-btn" onclick="handleFormSubmission()">Complete Booking</button>
    </div>
</div>

<!-- Success Modal -->
<div class="success-modal" id="successModal">
    <div class="success-content">
        <div class="paw-prints">🐾 🐾 🐾</div>
        <h2>Transaction ID No. <?php echo $booking['booking_id']; ?></h2>
        <p>Wait for our team's confirmation on your reservation.</p>
        <p>Thank you!</p>
        <button class="okay-btn">Okay</button>
        <a href="index.php">Go back to Homepage</a>
        <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/image-aCDBV3zOmTgQlibaR7BtUA7tqlGqD1.png" alt="Success">
    </div>
</div>

<script>
  // Handle file name display
  const fileInput = document.getElementById('payment_proof');
  const fileNameDisplay = document.getElementById('file-name');

  fileInput.addEventListener('change', () => {
    const file = fileInput.files[0];
    if (file) {
      fileNameDisplay.textContent = `Selected file: ${file.name}`;
    }
  });

  // Function to handle form submission and show success modal
  function handleFormSubmission() {
    const referenceInput = document.querySelector('.reference-input');
    const uploadInput = document.querySelector('input[type="file"]');
    const successModal = document.getElementById("successModal");
    const paymentModal = document.querySelector('.payment-modal');

    // Check if required fields are filled
    if (referenceInput.value && uploadInput.files.length > 0) {
        // Hide the payment modal and show the success modal
        paymentModal.style.display = 'none';
        successModal.style.display = 'flex'; // Show success modal with flexbox centering
    } else {
        alert('Please fill in all required fields before proceeding.');
    }
  }

  // Attach the function to the 'Complete Booking' button
  document.querySelector('.complete-btn').addEventListener('click', handleFormSubmission);

  // Optionally, add a close function for the success modal
  document.querySelector('.okay-btn').addEventListener('click', function() {
    const successModal = document.getElementById("successModal");
    successModal.style.display = 'none';
    window.location.href = 'index.php'; // Redirect to homepage after closing modal
  });
</script>
</body>
</html>
