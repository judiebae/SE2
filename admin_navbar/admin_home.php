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
        <button id="notificationButton">
            <img class="notifications" src="notification-bell.png" alt="Notifications" />
        </button>
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

        <!-- Notification Modal -->
        <div id="notificationModal" class="modal-home">
        <div class="modal-content-home">
            <div class="modal-header">
                <img src="adorafur-logo.png" alt="Adorafur Logo" class="modal-logo">
                <div class="notifications-header">
                    Notifications
                </div>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <div class="notif-today">TODAY</div>
                <div class="notification-card">
                    <div class="notif-service">Pet Hotel</div>
                    <div class="notif-sec">
                    <div class="notif-sub">Transaction No:</div>
                    <div class="notif-info">7S89F7A</div>
                </div>

                <div class="notif-sec">
                    <div class="notif-sub">Customer: </div>
                    <div class="notif-info">Han Bascao</div>
                </div>
                    <div class="notification-footer">
                        <div class="date-sec">
                        <div class="notif-sub">Date: </div>
                        <div class="notif-info">Today</div>
                        </div>
                        <div class="notif-confirmed">CONFIRMED</div>
                    </div>
                </div>


                <div class="notification-card">
                <div class="notif-circle"></div>
                <div class="notif-service">Daycare</div>

                <div class="notif-sec">
                    <div class="notif-sub">Transaction No:</div>
                    <div class="notif-info">ASF9S8F9</div>
                </div>

                <div class="notif-sec">
                    <div class="notif-sub">Customer: </div>
                    <div class="notif-info">Jude Flores</div>
                </div>
                    <div class="notification-footer">
                        <div class="date-sec">
                        <div class="notif-sub">Date: </div>
                        <div class="notif-info">October 5, 2025</div>
                        </div>
                        <button id="confirm-btn" class="confirm-btn">Confirm</button>
                    </div>
                </div>
                <div class="notif-date">Oct 2</div>
                <div class="notification-card">
                    <div class="notif-text">Fully Booked on October 6, 2024</div>
                </div>
            </div>
        </div>
    </div>

    <script>
    const modal = document.getElementById("notificationModal");
    const btn = document.getElementById("notificationButton");
    const modalOverlay = document.createElement("div"); // Create overlay dynamically
    modalOverlay.classList.add("modal-overlay");
    document.body.appendChild(modalOverlay); // Append overlay to body

    const closeButtons = document.querySelectorAll(".close");

    // Open modal and overlay on button click
    if (btn && modal) {
        btn.addEventListener("click", () => {
            modal.style.display = "block";
            modalOverlay.style.display = "block"; // Show overlay
        });
    }

    // Close modal and overlay on (x) button click
    closeButtons.forEach((btn) => {
        btn.addEventListener("click", () => {
            if (modal) {
                modal.style.display = "none";
                modalOverlay.style.display = "none"; // Hide overlay
            }
        });
    });

    // Close modal and overlay when clicking outside the content
    modalOverlay.addEventListener("click", () => {
        modal.style.display = "none";
        modalOverlay.style.display = "none";
    });
</script>

        <script src="admin.js"></script>
</body>
</html>
