<?php

include ("../connect.php");

$reservations = mysqli_query($conn, "SELECT 
                                        b.booking_id AS b_id,
                                        p.pet_name AS p_pet,
                                        p.pet_breed AS p_breed,
                                        p.pet_size AS p_size,
                                        CONCAT(c.customer_first_name, ' ', c.customer_last_name) AS owner_name,
                                        c.customer_contact_number AS owner_num,
                                        s.service_name AS s_service,
                                        pay.payment_status AS pay_status,
                                        DATE(b.booking_check_in) AS b_in,
                                        DATE(b.booking_check_out) AS b_out
                                    FROM booking b
                                    JOIN pet p ON b.pet_id = p.pet_id
                                    JOIN customer c ON p.customer_id = c.customer_id
                                    JOIN service s ON b.service_id = s.service_id
                                    JOIN payment pay ON b.payment_id = pay.payment_id
                                    WHERE b.booking_status <> 'Cancelled'
                                    ORDER BY 
                                        CASE 
                                            WHEN b.booking_check_in >= CURDATE() THEN 1  -- Future & today’s bookings first
                                            ELSE 2  -- Past bookings last
                                        END,
                                        b.booking_check_in ASC;");
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_navbarq.css">
    <link rel="stylesheet" href="ad_home.css">

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
        <div class="head">
            <h6  class="admin-panel-text">Admin Panel</h6>
            <!-- Real-time clock -->
            <div class="time-text" id="real-time-clock">Loading...</div>
            
        </div>       
        
        <div class="date-and-day">Loading date...</div>

        <table class="reservations">
            <?php

                if (mysqli_num_rows($reservations)>0) {
                echo '
                <thead class="attributes">
                        <th class="id">ID</th>
                        <th class="pet">Pet</th>
                        <th class="service">Service</th>
                        <th class="name">Name</th>
                        <th class="payment">Payment</th>
                        <th class="date">Date</th>
                </thead>
                <tbody class="deets">
            ';
            while ($fetch_reservations=mysqli_fetch_assoc($reservations)){
            ?>
            
                <tr class ="row" >
                    <td class="deets-id <?php echo strtolower($fetch_reservations['s_service']) === 'pet hotel' ? 'row-hotel' : 'row-daycare'; ?>"><?php echo $fetch_reservations['b_id'] ?></td>
                    <td class="deets-pet">
                        <span class="pet-name"><?php echo $fetch_reservations['p_pet'] . "<br> </span> <span class='pet-breed'>" . 
                                                $fetch_reservations['p_breed'] . ", " .   
                                                $fetch_reservations['p_size'];  ?> </span></td>
                    <td class="deets-service"><?php echo $fetch_reservations['s_service'] ?></td>
                    <td class="deets-name"><span class="owner"><?php echo $fetch_reservations['owner_name'] ."<br> </span> <span class='owner-num'>". 
                                                        $fetch_reservations['owner_num']?> <span> </td>
                    <td class="deets-payment"><span class="payment-dot <?php echo strtolower($fetch_reservations['pay_status']) === 'down payment' ? 'payment-down' : 'payment-full';?>" ></span><?php  echo $fetch_reservations['pay_status'] ?></td>
                    <td class="deets-date">
                       
                            <span class="name-12-span">Check-in:</span>
                            <span class="name-12-span2"><?php echo $fetch_reservations['b_in'] ?></span>
                            <br>
                            <span class="number-12-span">Check-out:</span>
                            <span class="number-12-span2"><?php echo $fetch_reservations['b_out'] ?></span>
                        
                    </td>
                </tr>
            <?php }
            }
            ?>
            </tbody>
        </table>

        
    </div>

    <script src="admin.js"></script>
</body>
</html>
