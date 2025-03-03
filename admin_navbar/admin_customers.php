<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin-css/admin_header2.css">
    <link rel="stylesheet" href="admin-css/admin_customer.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
      
    <title>Admin Customers</title>
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

          <div class="customer-button active">
            <a href="admin_customers.php" class="customers-text">Customers</a>
          </div>

          <div class="profile-button">
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

    <!-- CUSTOMERS -->

    <div class="panel-container">
      <div class="head">
        <div class="head-text"> Customers</div>
        <div class="time-text" id="real-time-clock">Loading...</div>
      </div>

      <div class="search-box">
        <input type="text" placeholder="Search">
        <span class="icon"><i class="fa-solid fa-magnifying-glass"></i></i></span>
      </div>
      
      <table class="customer-list">
        <thead class="customer-pet">
          <th class="name">Customer Name</th>
          <th class="pets">Pet/s Name</th>
          <th class="mem-status">Membership Status</th>
          <th class="date"></th>
        </thead>
        
        <tbody class="deets">
          <tr class="row1">
            <td class="customer-name ">  
              <a href="admin_customers_profile.php">kIko</a></td>
            <td class="pets-name ">ellie</td>
            <td class="mem-status">gold</td>
            <td class="dates">
              <strong>Registered Date:</strong> 06/05/2024<br>
              <strong>Expiry Date:</strong> 06/05/2026
            </td>
          </tr>
        </tbody>
      </table>  

    </div>


  </div>

    <script src="admin.js"></script>
</body>
</html>
