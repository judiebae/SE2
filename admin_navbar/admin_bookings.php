<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_navbar1.css">
    <title>Admin Bookings</title>
</head> 

<body>
    <!-- NAVIGATION BAR -->
    <nav class="nav-bar">
    <img class="adorafur-logo" src="adorafur-logo.png" alt="Adorafur Logo" />
      <div class="nav-container">

          <div class="home-button">
            <a href="admin_home.php" class="home-text">Home</a>
          </div>

          <div class="book-button active">
            <a href="admin_bookings.php" class="booking-text">Bookings</a>
          </div>

            <div class="by-service-frame">
                <div class="by-service">By Service</div>
            </div>

            <div class="pet-hotel-cont">
            <input type="checkbox" id="hotel-check" class="pet-hotel-checkbox">
            <label for="hotel-check" class="pet-hotel-text">Pet Hotel</label>
            </div>

            <div class="pet-daycare-cont">
            <input type="checkbox" id="daycare-check" class="daycare-checkbox">
            <label for="daycare-check" class="pet-daycare-text">Pet Daycare</label>
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
      </div>

    </nav>

    <!-- BOOKINGS -->
    <div class="panel-container">
      <div class="admin-panel-text">Bookings</div>
      <div class="time-text" id="real-time-clock">Loading...</div>
      <div class="line-1"></div>

    </div>
    <script src="admin.js"></script>
</body>
</html>
