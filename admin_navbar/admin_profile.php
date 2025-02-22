<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_navbar1.css">
    <title>Admin Profile</title>
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

          <div class="customer-button">
            <a href="admin_customers.php" class="customers-text">Customers</a>
          </div>

          <div class="profile-button active">
            <a href="admin_profile.php" class="profile-text">Profile</a>
          </div>

      </div>

      <!-- HEADER -->
      <div class="header-img-container">
      </div>

    </nav>

    <!-- PROFILE -->
    <div class="panel-container">
      <div class="admin-panel-text">Profile</div>
      <div class="time-text" id="real-time-clock">Loading...</div>
      <div class="line-1"></div>

      <div class = "profile-body">

        <div class ="name-line">
          <div class="profile-fixed">Name:</div>
          <div class="name-cont">Joanne Margareth Joaquin</div>
          <div class="line-2"></div>
        </div>

        <div class ="contact-line">
          <div class="profile-fixed">Contact No:</div>
          <div class="numb-cont">0995 292 7628</div>
          <div class="line-2"></div>
        </div>

        <div class ="email-add-line">
          <div class="profile-fixed">Email Address:</div>
          <div class="email-add-cont">joannemargareth.joaquin.cics@ust.edu.ph</div>
          <div class="line-2"></div>
        </div>

        <div class="role-line">
          <div class="profile-fixed">Role:</div>
          <div class="role-cont">Staff</div>
        </div>

        </div>

    </div>
    <script src="admin.js"></script>
</body>
</html>
