<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_navbar.css">
    <title>Admin Customers</title>
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

    <!-- CUSTOMERS -->

    <div class="panel-container">
      <div class="admin-panel-text"> Customers</div>
      <div class="time-text" id="real-time-clock">Loading...</div>
      <div class="line-1"></div>

      <div class="customer-line">
      <div class="cust-header">Customer Name</div>
      <div class="pet-header">Pet/s Name</div>
      <div class="memb-header">Membership Status</div>
      <div class="date-header">Date</div>
    </div>

    <div class="search-bar">
  <div class="search">Search</div>
  <img class="search-img" src="search-icon.png" />
</div>

  <div class="profile-frame">
  <div class="profile-name1">
  <a href="admin_customers_profile.php" class="profile-name-info">  
  Han Isaac Bascao
</a>
  </div>
  <div class="pet-name1">Eddie, Ebi</div>
  <div class="memb-status1">Gold</div>
  <div class="profile-date-container">
    <span>
      <span class="registered-date">
        Registered Date:
      </span>
      <span class="registered-date-holder">
        06/05/2024
        <br />
      </span>
      <span class="expired-date">
        Expiry Date:
      </span>
      <span class="expired-date-holder">
        06/05/2026
      </span>
    </span>
  </div>
  </div>


  </div>

    <script src="admin.js"></script>
</body>
</html>
