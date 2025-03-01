<?php
// Assume we have a function to get customer data
// In a real application, you'd fetch this from a database
function getCustomerData() {
    return [
        'name' => 'Han Isaac Bascao',
        'status' => 'Gold',
        'pet' => [
            'name' => 'Eddie',
            'breed' => 'Shih Tzu, Dog'
        ]
    ];
}

// Assume we have a function to get transaction data
function getTransactions() {
    return [
        [
            'id' => '12346',
            'service' => 'Pet Hotel',
            'petName' => 'Eddie',
            'amount' => '$2,500',
            'status' => 'Final Payment',
            'refNumber' => 'SA2384HJ',
            'source' => 'GCash',
            'date' => '09-21-24'
        ]
        // Add more transactions as needed
    ];
}

$customer = getCustomerData();
$transactions = getTransactions();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Customer Profile</title>
    <link rel="stylesheet" href="admin_navbar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #e8e8e8; }
    </style>
</head>
<body>
    <!-- NAVIGATION BAR -->
    <nav class="nav-bar">
    <img class="adorafur-logo" src="adorafur-logo.png" alt="Adorafur Logo" />
      <div class="nav-container">

          <div class="home-button">
            <a href="admin_home.php" class="home-text">Home</a>
          </div>

          <div class="book-button">
            <a href="admin_bookings.php" class="booking-text">Bookings</a>
          </div>

          <div class="customer-button active">
            <a href="admin_customers.php" class="customers-text">Customers</a>
          </div>

          <div class="profile-button">
            <a href="admin_profile.php" class="profile-text">Profile</a>
          </div>

      </div>

      <!-- HEADER -->
      <div class="header-img-container">
      </div>

    </nav>

    <!-- Main Content -->
    <div class="panel-container">
        <div class="admin-panel-text">Customers</div>
        <!-- Real-time clock -->
        <div class="time-text" id="real-time-clock">Loading...</div>
        <div class="line-1"></div>

        <div class="profile-box">
            <!-- User Section -->
            <div class="user-section">
                <a href="admin_customers.php">
                    <img src="back-icon.png" class="back-icon" alt="Back">
                </a>
                <img src="crown.png" class="crown-img">
                <div class="user-name"><?php echo $customer['name']; ?></div>
                <div class="gd-status">
                    <?php echo $customer['status']; ?> Member
                    <button id="openModalBtn" class="open-btn">
                        <img src="edit-icon.png" class="edit-img" alt="Edit">
                    </button>
                </div>
                <div class="pet-card">
                    <div class="pet-profile1"><?php echo $customer['pet']['name']; ?></div>
                    <div class="pet-profile2"><?php echo $customer['pet']['breed']; ?></div>
                </div>
            </div>

            <div class="divider-line"></div>

            <!-- Transactions Section -->
            <div class="transactions-box">
                <div class="transac-header">Transactions</div>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" 
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Sort
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="#">Oldest</a></li>
                        <li><a class="dropdown-item" href="#">Newest</a></li>
                    </ul>
                </div>
                <div class="transac-line">
                    <div class="transac-id-text">Transaction ID</div>
                    <div class="service-text1">Service</div>
                    <div class="pet-name-text">Pet Name</div>
                    <div class="amount-paid-text">Amount Paid</div>
                    <div class="ref-num-text">Ref. Number</div>
                    <div class="date-paid-text">Date Paid</div>
                </div>
                <?php foreach ($transactions as $transaction): ?>
                    <div class="trans-record">
                        <div class="trans-record-id"><?php echo $transaction['id']; ?></div>
                        <div class="trans-record-service"><?php echo $transaction['service']; ?></div>
                        <div class="trans-record-pet-name"><?php echo $transaction['petName']; ?></div>
                        <div class="trans-record-amount-paid">
                            <div class="trans-record-amount"><?php echo $transaction['amount']; ?></div>
                            <div class="trans-record-status"><?php echo $transaction['status']; ?></div>
                        </div>
                        <div class="trans-record-ref-number">
                            <div class="trans-record-ref"><?php echo $transaction['refNumber']; ?></div>
                            <div class="trans-record-source"><?php echo $transaction['source']; ?></div>
                        </div>
                        <div class="trans-record-date"><?php echo $transaction['date']; ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="membershipModal" class="modal">
        <div class="modal-content">

            <img src="memb-modal-header.png" class="status-header">
            <h2 class="memb-status-header">Membership Status Update</h2>
            <form id="membershipForm">
                <div style="display: flex;">
                    <div style="width: 50%; padding-right: 10px;">
                    <label for="paymentMethod">Payment Method:</label>
                    <input type="text" id="paymentMethod" name="paymentMethod" placeholder="Enter payment method">
                        
                    <br>
                    <label for="membershipStatus">Membership Status:</label>
                    <br>
                        <input type="radio" id="status-reg" name="memb-status" value="REGULAR">
                        <label for="status-reg">Regular</label><br>
                        <input type="radio" id="status-silver" name="memb-status" value="SILVER">
                        <label for="status-silver">Silver</label><br>
                        <input type="radio" id="status-gold" name="memb-status" value="GOLD" checked>
                        <label for="status-gold">Gold</label><br>
                        <input type="radio" id="status-platinum" name="memb-status" value="PLATINUM">
                        <label for="status-platinum">Platinum</label><br>
                    </div>
                    <div style="width: 50%; padding-left: 10px;">

                    <div class="input-group">
                        <label for="membershipAmount">Amount</label>
                        <input type="text" name="membershipAmount" placeholder="Enter amount">
                    </div>

                    <div class="input-group">
                        <label for="refNumber">Reference No.</label>
                        <input type="text" name="refNumber" placeholder="Enter reference number">
                    </div>

                        
                        <label for="proofofPayment">Proof of Payment.</label>
                        <input type="file" name="proofOfPayment">

                    </div>
                </div>
                <div class="cancel-save-btns">
                <button type="submit" class="modal-button">Cancel</button>
                <button type="submit" class="modal-button">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JavaScript for modal functionality
        var modal = document.getElementById("membershipModal");
        var btn = document.getElementById("openModalBtn");
        var cancelBtn = document.getElementById("cancelBtn");

        btn.onclick = function() {
            modal.style.display = "block";
        }

        cancelBtn.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
        <script src="admin.js"></script>
</body>
</html>