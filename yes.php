<?php
// Database connection details
$host = "localhost";
$dbname = "fur_a_paw_intments";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming booking_id is passed via query parameter, e.g., edit_booking.php?booking_id=B001
$booking_id = $_GET['booking_id'];

// Query to fetch booking data along with related pet, service, and payment details
$sql = "
    SELECT 
        b.booking_id, 
        b.booking_check_in, 
        b.booking_check_out,
        b.booking_status,
        p.pet_name,
        p.pet_breed,
        p.pet_size,
        s.service_name,
        pay.payment_method,
        pay.payment_status AS pay_status,
        pay.payment_amount,
        pay.payment_reference_number,
        c.customer_first_name,
        c.customer_last_name,
        c.customer_contact_number,
        c.customer_email
    FROM booking b
    JOIN pet p ON b.pet_id = p.pet_id
    JOIN service s ON b.service_id = s.service_id
    JOIN payment pay ON b.payment_id = pay.payment_id
    JOIN customer c ON p.customer_id = c.customer_id
    WHERE b.booking_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$bookingData = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Hotel Management</title>
    <link rel="stylesheet" href="yes1.css">
</head>
<body>
    <div class="modal-overlay">
        <div class="modal">
            <header class="header">
                <div class="header-id"><?php echo $bookingData['booking_id']; ?></div>
                <div class="header-controls">
                    <div class="staff-section">
                        <label class="staff-label">Staff:</label>
                        <select class="staff-select" id="staffSelect">
                            <option value="Veronica">Veronica</option>
                            <option value="John">John</option>
                            <option value="Sarah">Sarah</option>
                        </select>
                    </div>
                    <div class="button-group">
                        <button class="button" id="saveButton">Save</button>
                        <button class="button" onclick="document.querySelector('.modal-overlay').style.display='none'">Cancel</button>
                    </div>
                </div>
            </header>

            <main class="main-content">
                <form class="form-grid" id="updateBookingForm">
                    <!-- Left Column -->
                    <div class="form-section">
                        <div class="form-group">
                            <label class="form-label">Owner Name:</label>
                            <input type="text" class="form-input" name="ownerName" value="<?php echo $bookingData['customer_first_name'] . ' ' . $bookingData['customer_last_name']; ?>" id="ownerName">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Contact:</label>
                            <input type="text" class="form-input" name="contact" value="<?php echo $bookingData['customer_contact_number']; ?>" id="contact">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Comm Plat:</label>
                            <input type="text" class="form-input" name="commPlat" value="Viber" id="commPlat">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Pet Name:</label>
                            <input type="text" class="form-input" name="petName" value="<?php echo $bookingData['pet_name']; ?>" id="petName">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Pet Type:</label>
                            <input type="text" class="form-input" name="petType" value="<?php echo $bookingData['pet_size']; ?>" id="petType">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Pet Breed:</label>
                            <input type="text" class="form-input" name="petBreed" value="<?php echo $bookingData['pet_breed']; ?>" id="petBreed">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Service:</label>
                            <input type="text" class="form-input" name="service" value="<?php echo $bookingData['service_name']; ?>" id="service">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Check-in:</label>
                            <input type="text" class="form-input" name="checkIn" value="<?php echo $bookingData['booking_check_in']; ?>" id="checkIn">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Check-out:</label>
                            <input type="text" class="form-input" name="checkOut" value="<?php echo $bookingData['booking_check_out']; ?>" id="checkOut">
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="form-section">
                        <div class="form-group">
                            <label class="form-label">Balance:</label>
                            <input type="text" class="form-input" name="balance" value="<?php echo $bookingData['payment_amount']; ?>" id="balance">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Amount:</label>
                            <input type="text" class="form-input" name="amount" value="<?php echo $bookingData['payment_amount']; ?>" id="amount">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Mode of Payment:</label>
                            <input type="text" class="form-input" name="paymentMode" value="<?php echo $bookingData['payment_method']; ?>" id="paymentMode">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Reference No:</label>
                            <input type="text" class="form-input" name="referenceNo" value="<?php echo $bookingData['payment_reference_number']; ?>" id="referenceNo">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Payment Status:</label>
                            <input type="text" class="form-input" name="paymentStatus" value="<?php echo $bookingData['pay_status']; ?>" id="paymentStatus">
                        </div>

                        <div class="payment-section" data-expanded="false" onclick="this.setAttribute('data-expanded', this.getAttribute('data-expanded') === 'true' ? 'false' : 'true')">
                            <div class="payment-header">Add Payment?</div>
                            <div class="payment-form">
                                <div class="form-group">
                                    <label class="form-label">Amount Paid:</label>
                                    <input type="text" class="form-input" name="amountPaid" value="PHP 200.00" id="amountPaid">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Mode of Payment:</label>
                                    <input type="text" class="form-input" name="paymentModeAdd" value="Gcash" id="paymentModeAdd">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Balance:</label>
                                    <input type="text" class="form-input" name="balanceAdd" value="PHP 200.00" id="balanceAdd">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Payment Status:</label>
                                    <input type="text" class="form-input" name="paymentStatusAdd" value="Downpayment" id="paymentStatusAdd">
                                </div>
                                <button class="save-payment" onclick="event.stopPropagation()">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </main>
        </div>
    </div>

    <script>
        // Save Button Click Handler
        document.getElementById('saveButton').addEventListener('click', function (e) {
            e.preventDefault();

            // Create the data to send via POST
            const formData = new FormData(document.getElementById('updateBookingForm'));
            const data = {
                ownerName: formData.get('ownerName'),
                contact: formData.get('contact'),
                commPlat: formData.get('commPlat'),
                petName: formData.get('petName'),
                petType: formData.get('petType'),
                petBreed: formData.get('petBreed'),
                service: formData.get('service'),
                checkIn: formData.get('checkIn'),
                checkOut: formData.get('checkOut'),
                balance: formData.get('balance'),
                amount: formData.get('amount'),
                paymentMode: formData.get('paymentMode'),
                referenceNo: formData.get('referenceNo'),
                paymentStatus: formData.get('paymentStatus'),
                booking_id: "<?php echo $booking_id; ?>"
            };

            fetch('update_booking.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    alert('Booking updated successfully!');
                } else {
                    alert('Error updating booking.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating the booking!');
            });
        });
    </script>
</body>
</html>
