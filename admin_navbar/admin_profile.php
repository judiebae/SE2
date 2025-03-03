<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin-css/admin_header.css">
    <link rel="stylesheet" href="admin-css/admin_profile.css">
    <script src="admin.js"></script>

    <title>Admin Profile</title>
</head> 

<body>
    <!-- NAVIGATION BAR -->
    <nav class="nav-bar">
    <img class="adorafur-logo" src="admin-pics/adorafur-logo.png" alt="Adorafur Logo" />
      <div class="nav-container">

          <div class="home-button">
            <a href="admin_home.php" class="home-text">Home</a>
          </div>

          <div class="book-button">
            <a href="admin_bookings.php" class="booking-text">Bookings</a>
          </div>

          <div class="customer-button">
            <a href="admin_customers.php" class="customers-text">Customers</a>
          </div>

          <div class="profile-button active">
            <a href="admin_profile.php" class="profile-text">Profile</a>
          </div>

      </div>

      <!-- HEADER -->
      <div class="header-img-container">
            <button id="notificationButton">
                <img class="notifications" src="admin-pics/notification-bell.png" alt="Notifications" />
            </button>
        </div>

    </nav>

    <!-- PROFILE -->
    <div class="panel-container">
      <div class="head">
        <div class="head-text">Profile</div>
        <div class="time-text" id="real-time-clock">Loading...</div>
      </div>
      
      <div class="date-and-day">Loading date...</div>

      <div class="profile-content">
        <div class="profile-field">
          <div class="field-label">Name:</div>
          <div class="field-value">Joanne</div>
        </div>
        
        <div class="profile-field">
          <div class="field-label">Contact No:</div>
          <div class="field-value">Joanne</div>
        </div>
        
        <div class="profile-field">
          <div class="field-label">Email Address:</div>
          <div class="field-value">Joanne</div>
        </div>
        
        <div class="profile-field">
          <div class="field-label">Role:</div>
          <div class="field-value">Joanne</div>
        </div>
        
        <div class="logout-container">
          <a href="logout.php" class="logout-btn">Logout</a>
        </div>
      </div>
    </div>
    
</body>
</html>
