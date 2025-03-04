<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_navbar/admin-css/admin_header2.css">
    <link rel="stylesheet" href="admin_navbar/admin-css/admin_customer.css">
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
        <input type="text" id="searchInput" placeholder="Search">
        <span class="icon"><i class="fa-solid fa-magnifying-glass"></i></span>
      </div>
      
      <table class="customer-list">
        <thead class="customer-pet">
          <th class="name">Customer Name</th>
          <th class="pets">Pet/s Name</th>
          <th class="mem-status">Membership Status</th>
          <th class="date"></th>
        </thead>
        
        <tbody class="deets" id="customerTableBody">
          <?php
          // Database connection parameters
          $host = "localhost";
          $dbname = "fur_a_paw_intments"; // Change to your database name
          $username = "root"; // Change to your database username
          $password = ""; // Change to your database password

          try {
              // Create a PDO instance
              $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
              
              // Set the PDO error mode to exception
              $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              
              // Query to fetch customers with GROUP_CONCAT to combine pet names
              $sql = "SELECT 
                        c.customer_id, 
                        CONCAT(c.customer_first_name, ' ', c.customer_last_name) AS owner_name,
                        GROUP_CONCAT(p.pet_name SEPARATOR ', ') AS pet_names,
                        c.customer_membership_status as membership_status
                      FROM 
                        customer c
                      LEFT JOIN 
                        pet p ON c.customer_id = p.customer_id
                      GROUP BY 
                        c.customer_id, c.customer_first_name";
              
              // Prepare and execute the statement
              $stmt = $pdo->prepare($sql);
              $stmt->execute();
              
              // Check if we have results
              if ($stmt->rowCount() > 0) {
                  // Fetch all rows as associative arrays
                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                      echo "<tr class='row1'>";
                      echo "<td class='customer-name'><a href='admin_customers_profile.php?id=" . htmlspecialchars($row["customer_id"]) . "'>" . htmlspecialchars($row["owner_name"]) . "</a></td>";
                      echo "<td class='pets-name'>" . htmlspecialchars($row["pet_names"] ?? 'No pets') . "</td>";
                      echo "<td class='mem-status'>" . htmlspecialchars($row["membership_type"] ?? 'None') . "</td>";
                      echo "<td class='dates'>";
                      echo "<strong>Registered Date:</strong> " . ($row["registration_date"] ? date('m/d/Y', strtotime($row["registration_date"])) : 'N/A') . "<br>";
                      echo "<strong>Expiry Date:</strong> " . ($row["expiry_date"] ? date('m/d/Y', strtotime($row["expiry_date"])) : 'N/A');
                      echo "</td>";
                      echo "</tr>";
                  }
              } else {
                  echo "<tr><td colspan='4'>No customers found</td></tr>";
              }
          } catch (PDOException $e) {
              echo "<tr><td colspan='4'>Database error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
          }
          ?>
        </tbody>
      </table>  
    </div>

    <script>
    // JavaScript for real-time clock
    function updateClock() {
        const now = new Date();
        const options = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        document.getElementById('real-time-clock').textContent = now.toLocaleDateString('en-US', options);
    }
    
    // Update clock immediately and then every second
    updateClock();
    setInterval(updateClock, 1000);
    
    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('#customerTableBody tr');
        
        rows.forEach(row => {
            const customerName = row.querySelector('.customer-name').textContent.toLowerCase();
            const petName = row.querySelector('.pets-name').textContent.toLowerCase();
            
            if (customerName.includes(searchValue) || petName.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
    </script>
</body>
</html>

