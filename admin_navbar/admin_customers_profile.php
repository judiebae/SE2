<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_navbar1.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Admin Bookings</title>
    <style>body {background: #e8e8e8;}</style>
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

    <!-- BOOKINGS -->
    <div class="panel-container">
        <div class="admin-panel-text">Customers</div>
        <div class="time-text" id="real-time-clock">Loading...</div>
        <div class="line-1"></div>

        <div class="profile-box">
        <!-- User Section -->
          <div class="user-section">
          <a href="admin_customers.php">
            <img src="back-icon.png" class="back-icon" alt="Back">
          </a>

          <img src="crown.png" class="crown-img">
          <div class="user-name">Han Isaac Bascao</div>

          <div class="gd-status"> 
            Gold Member 
          <img src="edit-icon.png" class="edit-img">
          </div>

        <div class="pet-card">
            <div class="pet-profile1">Eddie</div>
            <div class="pet-profile2">Shih Tzu, Dog</div>
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
          <div class ="amount-paid-text">Amount Paid</div>
          <div class="ref-num-text">Ref. Number</div>
          <div class="date-paid-text">Date Paid</div>
        </div>

        <div class="trans-record">
          <div class="trans-record-id">12346</div>
          <div class="trans-record-service">Pet Hotel</div>
          <div class="trans-record-pet-name">Eddie</div>
          <div class="trans-record-amount-paid">
            <div class="trans-record-amount">$2,500</div>
            <div class="trans-record-status">Final Payment</div>
          </div>
          <div class="trans-record-ref-number">
            <div class="trans-record-ref">SA2384HJ</div>
            <div class="trans-record-source">GCash</div>
          </div>
          <div class="trans-record-date">09-21-24</div>
        </div>
    </div>
    
  </div>
  <script src="admin.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
