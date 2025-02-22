<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_navbar1.css">
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
        <div class="admin-panel-text">Admin Panel</div>
        <div class="id-text">ID</div>
        <div class="pet-text">Pet</div>
        <div class="service-text">Service</div>
        <div class="name-text">Name</div>
        <div class="payment-text">Payment</div>
        
        <!-- Real-time clock -->
        <div class="time-text" id="real-time-clock">Loading...</div>
        <div class="date-and-day">Loading date...</div>
        <div class="date-text">Date</div>
        <div class="line-1"></div>

        <!-- Pet Hotel Booking -->
        <div class="pet-hotel-frame">
            <div class="pet-hotel-color"></div>
            <div class="id-1">P045849</div>
            <div class="pet-name-1">Eddie</div>
            <div class="pet-breed-1">Dog, Shih tzu</div>
            <div class="name-1">Han Bascao</div>
            <div class="number-1">Viber 0994 234 2413</div>
            <div class="hotel">Pet Hotel</div>
            <div class="dp-1">Down Payment</div>
            <div class="ellipse-1"></div>
            <div class="name-12">
                <span>
                    <span class="name-12-span">Check-in:</span>
                    <span class="name-12-span2">09-05-24</span>
                </span>
            </div>
            <div class="number-12">
                <span>
                    <span class="number-12-span">Check-out:</span>
                    <span class="number-12-span2">09-10-24</span>
                </span>
            </div>
        </div>

        <!-- Daycare Booking -->
        <div class="daycare-frame">
            <div class="daycare-color"></div>
            <div class="id-1">P045813</div>
            <div class="pet-name-1">K.C.</div>
            <div class="pet-breed-1">Dog, Shih tzu</div>
            <div class="name-1">Jude Flores</div>
            <div class="number-13">Instagram 0994 234 2413</div>
            <div class="hotel">Daycare</div>
            <div class="dp-1">Full Payment</div>
            <div class="ellipse-12"></div>
            <div class="name-13">
                <span class="daycare-check-in">
                    <span class="name-13-span">Check-in:</span>
                    <span class="name-13-span2">09-05-24</span>
                </span>
            </div>
            <div class="number-14">
                <span>
                    <span class="number-14-span">Check-out:</span>
                    <span class="number-14-span2">09-10-24</span>
                </span>
            </div>
        </div>
    </div>

    <script src="admin.js"></script>
</body>
</html>
