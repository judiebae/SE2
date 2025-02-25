<?php
$host = "localhost";
$dbname = "pet_service_db";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch booking details
$sql = "SELECT 
            b.booking_id,
            p.pet_name,
            CONCAT(p.pet_breed, ', ', p.pet_size) AS pet_details,
            CONCAT(c.customer_first_name, ' ', c.customer_last_name) AS owner_name,
            c.customer_contact_number,
            s.service_name,
            pay.payment_status,
            b.booking_check_in,
            b.booking_check_out
        FROM booking b
        JOIN pet p ON b.pet_id = p.pet_id
        JOIN customer c ON p.customer_id = c.customer_id
        JOIN service s ON b.service_id = s.service_id
        JOIN payment pay ON b.payment_id = pay.payment_id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        .panel-container {
            font-family: Arial, sans-serif;
            width: 80%;
            margin: auto;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .booking-frame {
            background: white;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            border-left: 5px solid #007bff;
        }
        .booking-frame.daycare {
            border-left-color: #ffc107;
        }
        .booking-title {
            font-size: 18px;
            font-weight: bold;
        }
        .info {
            margin: 5px 0;
        }
        .highlight {
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>
<body>

<div class="panel-container">
    <h2>Admin Panel</h2>
    <div class="info">Real-time Clock: <span id="real-time-clock">Loading...</span></div>
    <div class="info">Date: <span id="current-date">Loading...</span></div>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $serviceClass = ($row["service_name"] == "Daycare") ? "daycare" : "hotel";
            echo "<div class='booking-frame $serviceClass'>";
            echo "<div class='booking-title'>Booking ID: <span class='highlight'>P" . str_pad($row["booking_id"], 6, "0", STR_PAD_LEFT) . "</span></div>";
            echo "<div class='info'>Pet: <span class='highlight'>" . $row["pet_name"] . "</span></div>";
            echo "<div class='info'>Breed & Size: " . $row["pet_details"] . "</div>";
            echo "<div class='info'>Owner: " . $row["owner_name"] . "</div>";
            echo "<div class='info'>Contact: " . $row["customer_contact_number"] . "</div>";
            echo "<div class='info'>Service: " . $row["service_name"] . "</div>";
            echo "<div class='info'>Payment Status: <span class='highlight'>" . $row["payment_status"] . "</span></div>";
            echo "<div class='info'>Check-in: " . date("m-d-Y", strtotime($row["booking_check_in"])) . "</div>";
            echo "<div class='info'>Check-out: " . date("m-d-Y", strtotime($row["booking_check_out"])) . "</div>";
            echo "</div>";
        }
    } else {
        echo "<p>No bookings found.</p>";
    }
    $conn->close();
    ?>
</div>

<script>
    function updateClock() {
        let now = new Date();
        document.getElementById("real-time-clock").textContent = now.toLocaleTimeString();
        document.getElementById("current-date").textContent = now.toDateString();
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>

</body>
</html>
