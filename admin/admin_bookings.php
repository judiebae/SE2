<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin-css/admin_header2.css">
    <link rel="stylesheet" href="admin-css/admin_bookings.css">
    <title>Admin Bookings</title>
</head> 

<body>
    <!-- NAVIGATION BAR -->
    <nav class="nav-bar">
    <img class="adorafur-logo" src="admin-pics/adorafur-logo.png" alt="Adorafur Logo" />
      <div class="nav-container">

          <div class="home-button">
            <a href="admin_home.php" class="home-text">Home</a>
          </div>

          <div class="book-button active">
            <a href="admin_bookings1.php" class="booking-text">Bookings</a>
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
      <button id="notificationButton">
                <img class="notifications" src="admin-pics/notification-bell.png" alt="Notifications" />
            </button>
      </div>

    </nav>

    <!-- BOOKINGS PANEL-->
    <div class="panel-container">

      <div class="head">
        <div class="head-text">Bookings</div>
        <div class="time-text" id="real-time-clock">Loading...</div>
      </div>
      
      <div class="content">


      

    <!-- CALENDAR -->
      <div class="bookings-weekly">
          <div class="controls">
            <button onclick="changeWeek(-1)">⬅️ Previous Week</button>
            <span id="week-range"></span>
            <button onclick="changeWeek(1)">Next Week ➡️</button>
        </div>

        <div class="calendar" id="calendar"></div>
        </div>


    <!-- SIDE BAR-->
      <div class="side-bar">
      <div class="reminders-section">
    <div class="sidebar-title">REMINDERS</div>

    <div class="sidebar-textbox reminder-item">
        <div class="sidebar-subtitle">Vet Visit</div>
        <div class="sidebar-desc">October 5, 2024</div>
        <div class="sidebar-line"></div>
    </div>

    <div class="sidebar-textbox reminder-item">
        <div class="sidebar-subtitle">Water Interruption</div>
        <div class="sidebar-desc">October 9, 2024</div>
        <div class="sidebar-line"></div>
    </div>

    <div class="sidebar-textbox reminder-item">
        <div class="sidebar-subtitle">Electric Bills Deadline</div>
        <div class="sidebar-desc">October 15, 2024</div>
        <div class="sidebar-line"></div>
    </div>

    <div class="sidebar-textbox reminder-item">
        <div class="sidebar-subtitle">Dog Food Restock</div>
        <div class="sidebar-desc">October 15, 2024</div>
        <div class="sidebar-line"></div>
    </div>

    <div class="sidebar-textbox reminder-item">
        <div class="sidebar-subtitle">Halfday Operations</div>
        <div class="sidebar-desc">October 15, 2024</div>
        <div class="sidebar-line"></div>
    </div>

    <div class="sidebar-textbox">
        <div class="add-sidebar">Add Reminder</div>
        <div class="sidebar-line"></div>
    </div>

    <div class="view-rem" id="viewRemindersBtn">View Reminders</div>
</div>


        <div class="tasks-section">
        <div class="sidebar-title">TASKS</div>

        <div class="sidebar-textbox">
          <div class="sidebar-subtitle">Follow Up Payment</div>
          <div class="sidebar-bdesc">Transaction ID: SHSD78F6</div>
          <div class="sidebar-desc">Han Bascao, GCash</div>
          <div class="sidebar-line"></div>
        </div>

        <div class="sidebar-textbox">
          <div class="sidebar-subtitle">Send Confirmation Msg</div>
          <div class="sidebar-bdesc">Phone Number: 0993 452 1387</div>
          <div class="sidebar-desc">Joanne Margareth</div>
          <div class="sidebar-line"></div>
        </div>

        <div class="sidebar-textbox">
          <div class="sidebar-subtitle">Follow Up Payment</div>
          <div class="sidebar-bdesc">Transaction ID: H3JK4H5J</div>
          <div class="sidebar-desc">Jude Flores, Paymaya</div>
          <div class="sidebar-line"></div>
        </div>

        <div class="sidebar-textbox">
          <div class="sidebar-subtitle">Send Confirmation Msg</div>
          <div class="sidebar-bdesc">Phone Number: 0932 763 1111</div>
          <div class="sidebar-desc">Vince Delos Santos</div>
          <div class="sidebar-line"></div>
        </div>

        <div class="sidebar-textbox">
          <div class="add-sidebar">Add Task</div>
          <div class="sidebar-line"></div>
          </div>
          <div class="view-task" id="viewTasksBtn">View Tasks</div>
        </div>
      </div>
      </div>
    </div>
    <script src="admin.js"></script>
</body>
</html>
