<?php

include("../connect.php");

$sql = "SELECT 
            b.booking_id AS b_id,
            p.pet_name AS p_pet,
            p.pet_breed AS p_breed,
            p.pet_size AS p_size,
            CONCAT(c.customer_first_name, ' ', c.customer_last_name) AS owner_name,
            c.customer_contact_number AS owner_num,
            s.service_name AS s_service,
            pay.payment_status AS pay_status,
            DATE(b.booking_check_in) AS b_in,
            DATE(b.booking_check_out) AS b_out
        FROM booking b
        JOIN pet p ON b.pet_id = p.pet_id
        JOIN customer c ON p.customer_id = c.customer_id
        JOIN service s ON b.service_id = s.service_id
        JOIN payment pay ON b.payment_id = pay.payment_id
        WHERE b.booking_status <> 'Cancelled'
        ORDER BY 
            CASE 
                WHEN b.booking_check_in >= CURDATE() THEN 1  -- Future & today’s bookings first
                ELSE 2  -- Past bookings last
            END,
            b.booking_check_in ASC;";

try {
    $stmt = $conn->prepare($sql);  // Prepare the query
    $stmt->execute();  // Execute the query
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Fetch results as an associative array
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Remove this part as we'll fetch booking data dynamically
// $booking_id = $_GET['booking_id'];
// $sql1 = "...";
// $stmt = $conn->prepare($sql1);
// $stmt->bind_param('s', $booking_id);
// $stmt->execute();
// $result = $stmt->get_result();
// $bookingData = $result->fetch_assoc();
// $stmt->close();

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_navbars.css">
    <link rel="stylesheet" href="ad_home.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <title>Admin Homepage</title>
   
</head> 

<body>
    <!-- NAVIGATION BAR -->
    <nav class="nav-bar">
        <img class="adorafur-logo" src="adorafur-logo.png" alt="Adorafur Logo" />
        <div class="nav-container">
            <div class="home-button active">
                <a href="admin_home.php" class="home-text">Home</a>
            </div>
            <div class="book-button">
                <a href="admin_bookings.php" class="booking-text">Bookings</a>
            </div>
            <div class="customer-button">
                <a href="admin_customers.php" class="customers-text">Customers</a>
            </div>
            <div class="profile-button">
                <a href="admin_profile.php" class="profile-text">Profile</a>
            </div>
        </div>
        <!-- HEADER -->
        <div class="header-img-container">
        <img class="notifications" src="notification-bell.png" />
        </div>

    </nav>

    
    <!-- HOME PAGE -->
    <div class="panel-container">
        <div class="head">
            <h6  class="admin-panel-text">Admin Panel</h6>
            <!-- Real-time clock -->
            <div class="time-text" id="real-time-clock">Loading...</div>
            
        </div>       
        
        <div class="date-and-day">Loading date...</div>

        <table class="reservations">
            <?php
            if (!empty($reservations)) { // Check if there are results
                echo '
                <thead class="attributes">
                    <th class="id">ID</th>
                    <th class="pet">Pet</th>
                    <th class="service">Service</th>
                    <th class="name">Name</th>
                    <th class="payment">Payment</th>
                    <th class="date">Date</th>
                </thead>
                <tbody class="deets">
                ';

                foreach ($reservations as $fetch_reservations) {
            ?>
            
                <tr class="row1">
                    
                    <td class="deets-id <?php echo strtolower($fetch_reservations['s_service']) === 'pet hotel' ? 'row-hotel' : 'row-daycare'; ?>">
                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#bookingModal" 
                        data-booking-id="<?php echo htmlspecialchars($fetch_reservations['b_id']); ?>"
                        data-owner-name="<?php echo htmlspecialchars($fetch_reservations['owner_name']); ?>"
                        data-owner-num="<?php echo htmlspecialchars($fetch_reservations['owner_num']); ?>"
                        data-pet-name="<?php echo htmlspecialchars($fetch_reservations['p_pet']); ?>"
                        data-pet-breed="<?php echo htmlspecialchars($fetch_reservations['p_breed']); ?>"
                        data-pet-size="<?php echo htmlspecialchars($fetch_reservations['p_size']); ?>"
                        data-service="<?php echo htmlspecialchars($fetch_reservations['s_service']); ?>"
                        data-check-in="<?php echo htmlspecialchars($fetch_reservations['b_in']); ?>"
                        data-check-out="<?php echo htmlspecialchars($fetch_reservations['b_out']); ?>"
                        data-payment-status="<?php echo htmlspecialchars($fetch_reservations['pay_status']); ?>">
                            <?php echo htmlspecialchars($fetch_reservations['b_id']); ?>
                        </button>
                    </td>
                    
                    <td class="deets-pet">
                        <span class="pet-name">
                            <?php echo htmlspecialchars($fetch_reservations['p_pet']); ?>
                        </span><br>
                        <span class="pet-breed">
                            <?php echo htmlspecialchars($fetch_reservations['p_breed'] . ", " . $fetch_reservations['p_size']); ?>
                        </span>
                    </td>
                    <td class="deets-service"><?php echo htmlspecialchars($fetch_reservations['s_service']); ?></td>
                    <td class="deets-name">
                        <span class="owner"><?php echo htmlspecialchars($fetch_reservations['owner_name']); ?></span><br>
                        <span class='owner-num'><?php echo htmlspecialchars($fetch_reservations['owner_num']); ?></span>
                    </td>
                    <td class="deets-payment">
                        <span class="payment-dot <?php echo strtolower($fetch_reservations['pay_status']) === 'down payment' ? 'payment-down' : 'payment-full'; ?>">
                        </span>
                        <?php echo htmlspecialchars($fetch_reservations['pay_status']); ?>
                    </td>
                    <td class="deets-date">
                        <span class="name-12-span">Check-in:</span>
                        <span class="name-12-span2"><?php echo htmlspecialchars($fetch_reservations['b_in']); ?></span>
                        <br>
                        <span class="number-12-span">Check-out:</span>
                        <span class="number-12-span2"><?php echo htmlspecialchars($fetch_reservations['b_out']); ?></span>
                    </td>
                </tr>
            <?php 
                }
            }
            ?>
            </tbody>
        </table>   
    </div>

    <!-- Bootstrap Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-center">
        <div class="modal-content" id="book-modal">
            <div class="modal-header" id="modalHeader">
                <div class="header-id" id="modalBookingId"></div>
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
                        <button class="button" id="cancelButton" onclick="document.querySelector('.modal-overlay').style.display='none'">Cancel</button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form id="updateBookingForm">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Owner Name:</label>
                                <input type="text" class="form-control" name="ownerName" id="ownerName">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Contact:</label>
                                <input type="text" class="form-control" name="contact" id="contact">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pet Name:</label>
                                <input type="text" class="form-control" name="petName" id="petName">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pet Type:</label>
                                <input type="text" class="form-control" name="petType" id="petType">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pet Breed:</label>
                                <input type="text" class="form-control" name="petBreed" id="petBreed">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Service:</label>
                                <input type="text" class="form-control" name="service" id="service">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Check-in:</label>
                                <input type="text" class="form-control" name="checkIn" id="checkIn">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Check-out:</label>
                                <input type="text" class="form-control" name="checkOut" id="checkOut">
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Balance:</label>
                                <input type="text" class="form-control" name="balance" id="balance">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mode of Payment:</label>
                                <input type="text" class="form-control" name="paymentMode" id="paymentMode">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Reference No:</label>
                                <input type="text" class="form-control" name="referenceNo" id="referenceNo">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Payment Status:</label>
                                <input type="text" class="form-control" name="paymentStatus" id="paymentStatus">
                            </div>
                             <!-- Add Payment Section -->
                             <div class="card mt-4">
                                    <div class="card-header payment-header" data-bs-toggle="collapse" data-bs-target="#paymentForm">
                                        Add Payment?
                                    </div>
                                    <div id="paymentForm" class="collapse">
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label fw-bold text-brown mb-2">Amount Paid:</label>
                                                        <input type="text" class="form-control" name="amountPaid" value="PHP 200.00" id="amountPaid">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label fw-bold text-brown mb-2">Mode of Payment:</label>
                                                        <input type="text" class="form-control" name="paymentModeAdd" value="Gcash" id="paymentModeAdd">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label fw-bold text-brown mb-2">Balance:</label>
                                                        <input type="text" class="form-control" name="balanceAdd" value="PHP 200.00" id="balanceAdd">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label fw-bold text-brown mb-2">Payment Status:</label>
                                                        <input type="text" class="form-control" name="paymentStatusAdd" value="Downpayment" id="paymentStatusAdd">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <button type="button" class="btn btn-secondary w-100" onclick="document.getElementById('addPayment').value='yes'; document.getElementById('updateBookingForm').submit();">Save Payment</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>

                   

                </form>
            </div>
        </div>
    </div>
</div>
    <script src="admin.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var bookingModal = document.getElementById('bookingModal');
    bookingModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var bookingId = button.getAttribute('data-booking-id');
        var modalBookingId = document.getElementById('modalBookingId');
        modalBookingId.textContent = bookingId;

        // Set the modal header class based on the service type
        var service = button.getAttribute('data-service');
        var modalHeader = document.getElementById('modalHeader');
        modalHeader.className = 'modal-header ' + (service.toLowerCase() === 'pet hotel' ? 'modal-hotel' : 'modal-daycare');

        // Populate form fields with data from button attributes
        document.getElementById('ownerName').value = button.getAttribute('data-owner-name');
        document.getElementById('contact').value = button.getAttribute('data-owner-num');
        document.getElementById('petName').value = button.getAttribute('data-pet-name');
        document.getElementById('petBreed').value = button.getAttribute('data-pet-breed');
        document.getElementById('petType').value = button.getAttribute('data-pet-size');
        document.getElementById('service').value = button.getAttribute('data-service');
        document.getElementById('checkIn').value = button.getAttribute('data-check-in');
        document.getElementById('checkOut').value = button.getAttribute('data-check-out');
        document.getElementById('paymentStatus').value = button.getAttribute('data-payment-status');

        // Fetch additional booking data
        fetch('get_booking_data.php?booking_id=' + bookingId)
            .then(response => response.json())
            .then(data => {
                // Populate additional fields that weren't available in the table
                document.getElementById('balance').value = data.payment_amount;
                document.getElementById('paymentMode').value = data.payment_method;
                document.getElementById('referenceNo').value = data.payment_reference_number;
                // ... populate other fields as needed
            })
            .catch(error => console.error('Error:', error));
    });

    document.getElementById('saveButton').addEventListener('click', function (e) {
        e.preventDefault();

        var formData = new FormData(document.getElementById('updateBookingForm'));
        formData.append('booking_id', document.getElementById('modalBookingId').textContent);

        fetch('update_booking.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert('Booking updated successfully!');
                // Optionally, refresh the page or update the table
                location.reload();
            } else {
                alert('Error updating booking.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating the booking!');
        });
    });
});
</script>
</body>
</html>

