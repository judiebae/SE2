<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("connect.php");

// Check if user is logged in
if (!isset($_SESSION['c_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Add this near the top of your profile.php file, after starting the session
if (isset($_SESSION['success_message'])) {
    echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
    unset($_SESSION['success_message']);
} elseif (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
    unset($_SESSION['error_message']);
}

// Get user ID from session
$user_id = $_SESSION['c_id'];

// Fetch customer information
$customer_query = "SELECT c.*, m.membership_status FROM Customer c
                    LEFT JOIN membership_status_Tbl m ON m.membership_id = c.customer_membership_status WHERE c.customer_id = :c_id";

$customer_stmt = $conn->prepare($customer_query);
$customer_stmt->bindParam(':c_id', $user_id);
$customer_stmt->execute();
$fetch_cust_info = $customer_stmt->fetch(PDO::FETCH_ASSOC);

// Fetch pet information
$pet_query = "SELECT * FROM Pet WHERE customer_id = :c_id";
$pet_stmt = $conn->prepare($pet_query);
$pet_stmt->bindParam(':c_id', $user_id);
$pet_stmt->execute();
$pets = $pet_stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch current reservations
$current_reservations_query = "SELECT b.*, p.*, pay.payment_status, s.service_name FROM booking_fact_table b
                                LEFT JOIN Pet p ON p.pet_id = b.pet_id
                                LEFT JOIN Payment pay ON pay.payment_id = b.payment_id
                                LEFT JOIN Service s ON s.service_id = b.service_id
                                WHERE p.customer_id = :c_id AND b.booking_status != 'Completed' AND b.booking_status != 'Cancelled' ORDER BY booking_check_in DESC";

$current_reservations_stmt = $conn->prepare($current_reservations_query);
$current_reservations_stmt->bindParam(':c_id', $user_id);
$current_reservations_stmt->execute();
$current_reservations = $current_reservations_stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch reservation history
$history_query = "SELECT b.*, p.*, pay.payment_status, s.service_name FROM booking_fact_table b
                                LEFT JOIN Pet p ON p.pet_id = b.pet_id
                                LEFT JOIN Payment pay ON pay.payment_id = b.payment_id
                                LEFT JOIN Service s ON s.service_id = b.service_id
                                WHERE p.customer_id = :c_id AND (b.booking_status = 'Completed' OR b.booking_status = 'Cancelled') ORDER BY booking_check_in DESC";
$history_stmt = $conn->prepare($history_query);
$history_stmt->bindParam(':c_id', $user_id);
$history_stmt->execute();
$reservation_history = $history_stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle profile picture path
$profile_picture = isset($fetch_cust_info['customer_profile_picture']) && !empty($fetch_cust_info['customer_profile_picture']) 
    ? $fetch_cust_info['customer_profile_picture'] 
    : "Profile-Pics/profile_icon.png";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="Profile.css">
    <link rel="stylesheet" href="headers.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>

<div class="lHead">
    <img src="Header-Pics/PIC4.png" alt="pic4" class="paws1">
    <img src="Header-Pics/PIC2.png" alt="pic2" class="paw1">
    <img src="Header-Pics/logo.png" alt="LOGO" class="logos">
    <img src="Header-Pics/PIC3.png" alt="pic3" class="paw2">
    <img src="Header-Pics/PIC5.png" alt="pic5" class="paws2">
</div>

<?php include 'login.php'?>
<nav class="navbar navbar-expand-lg navbar-dark ">
    <div class="container">
        <button class="navbar-toggler shadow-none border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="sidebar offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            
            <div class="offcanvas-header text-white border-bottom">
                <img src="logo.png" alt="LOGO" class="log">
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-between flex-grow-1 pe-3">
                    
                    <!-- about us  -->
                    <li class="nav-item dropdown ">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        ABOUT US </a>
                        <ul class="dropdown-menu ">
                            <li><a class="dropdown-item" href="aboutus.php">House Rules</a></li>
                            <li><a class="dropdown-item" href="#ourstory">Our Story</a></li>
                            <li><a class="dropdown-item" href="#time">Opening Hours</a></li>
                        </ul>
                    </li>

                    <!-- book  -->
                    <li class="nav-item dropdown ">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        BOOK </a>
                        <ul class="dropdown-menu ">
                            <li><a class="dropdown-item" href="#second-scroll">Book</a></li>
                            <li><a class="dropdown-item" href="#inclusions">Inclusion and Perks</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="home.php">HOME</a>
                    </li>

                    <li class="nav-item dropdown ">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        CONTACT US
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="Contact_Us.php">Contact Us</a></li>
                            <li><a class="dropdown-item" href="#faqs">FAQs</a></li>  
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="profile.php" class="btn btn-primary">PROFILE</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="profile">
    <section>
        <div class="col-left">
            <div class="user-header">
                <!-- User Info -->
                <div class="user-info">
                    <h6 class="personalinfo">USER INFORMATION</h6>
                    
                    <!-- Button trigger modal -->
                    <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="fa-regular fa-pen-to-square edit-icon"></i>
                    </button>
                </div>
                <!-- Notification Bell -->
                <div class="notifBell">
                    <i class="fa-regular fa-bell notif-icon"></i>
                </div>      
            </div>

            <div class="user-deets">
                <div class="pfp">
                    <img src="<?php echo $profile_picture; ?>" alt="Profile Picture" class="profile-icon">
                    <h6 class="cusID">CUSTOMER ID</h6>
                    <h6 class="cusNum">NO. <?php echo $fetch_cust_info['customer_id']; ?></h6>
                    <h6 class="cusMem"><?php echo $fetch_cust_info['membership_status']; ?> Member</h6>
                </div>

                <div class="deets">
                    <div class="name">
                        <div class="deet1">
                            <p class="deet">FIRST NAME <strong><?php echo $fetch_cust_info['customer_first_name']; ?></strong></p>                    
                            <hr class="hline">
                            <p class="deet">CONTACT NUMBER <strong><?php echo $fetch_cust_info['customer_contact_number']; ?></strong></p>                    
                            <hr class="hline">
                        </div>
                        <div class="deet2">
                            <p class="deet">LAST NAME <strong><?php echo $fetch_cust_info['customer_last_name']; ?></strong></p>                                            
                            <hr class="hline">
                            <p class="deet">EMAIL <strong><?php echo $fetch_cust_info['customer_email']; ?></strong></p>  
                            <hr class="hline">
                        </div>
                    </div>
                    
                    <div class="deet3">
                        <p class="deet">ADDRESS <strong><?php echo isset($fetch_cust_info['c_address']) ? htmlspecialchars($fetch_cust_info['c_address']) : 'N/A'; ?></strong></p>                        
                        <hr class="hline">
                        <p class="deet">SOCIAL LINK <strong><?php echo isset($fetch_cust_info['customer_mode_of_communication']) ? htmlspecialchars($fetch_cust_info['customer_mode_of_communication']) : 'N/A'; ?></strong></p>
                        <hr class="hline">
                    </div>
                </div>
            </div>

            <div class="user-transactions">
                <div class="user-current">
                    <table class="curr">
                        <thead class="cRev">
                            <th class="currRev">CURRENT RESERVATIONS</th>
                        </thead>
                        <tbody>
                            <?php if (empty($current_reservations)): ?>
                                <tr>
                                    <td class="crBody">
                                        <div class="tDeets">
                                            <p>No current reservations found.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($current_reservations as $reservation): ?>
                                    <tr>
                                        <td class="crBody">
                                            <div class="tDeets">
                                                <h6 class="tStatus"><?php echo $reservation['booking_status']; ?></h6>

                                                <div class="tDeets1">
                                                    <div class="tDeets1-1">
                                                        <p class="tpetname"><?php echo $reservation['pet_name']; ?></p>
                                                    </div>

                                                    <div class="tDeets1-2">
                                                        <p class="price"><?php echo $reservation['payment_amount']; ?></p>
                                                    </div>
                                                </div>

                                                <div class="tDeets2">
                                                    <div class="tDeets2-1">
                                                        <p class="tservice"><?php echo $reservation['service_name']; ?></p>
                                                        <p class="tId">Transaction ID NO <?php echo $reservation['booking_id']; ?></p>
                                                        <p class="tDate"><?php echo $reservation['booking_check_in']; ?></p>
                                                    </div>

                                                    <div class="tDeets2-2">
                                                        <button class="btn" data-bs-target="#req-to-cancel-modal" data-bs-toggle="modal" id="reqtoCancel-but" data-booking-id="<?php echo $reservation['booking_id']; ?>">Request to Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="user-history">
                    <table class="hist">
                        <thead class="hRev">
                            <th class="currRev">RESERVATIONS HISTORY</th>
                        </thead>

                        <tbody>
                            <?php if (empty($reservation_history)): ?>
                                <tr>
                                    <td class="crBody">
                                        <div class="tDeets">
                                            <p>No reservation history found.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($reservation_history as $history): ?>
                                    <tr>
                                        <td class="crBody">
                                            <div class="tDeets">
                                                <h6 class="tStatus"><?php echo $history['booking_status']; ?></h6>

                                                <div class="tDeets1">
                                                    <div class="tDeets1-1">
                                                        <p class="tpetname"><?php echo $history['pet_name']; ?></p>
                                                    </div>

                                                    <div class="tDeets1-2">
                                                        <p class="price"><?php echo $history['payment_amount']; ?></p>
                                                    </div>
                                                </div>

                                                <div class="tDeets2">
                                                    <div class="tDeets2-1">
                                                        <p class="tservice"><?php echo $history['service_name']; ?></p>
                                                        <p class="tId">Transaction ID NO <?php echo $history['booking_id']; ?></p>
                                                        <p class="tDate"><?php echo $history['booking_check_in']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>  
            </div>
        </div>

        <div class="col-right">
            <table>
                <thead>
                    <tr>
                        <th class="pbi">PET INFORMATION</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (empty($pets)): ?>
                        <tr>
                            <td class="petDeets">
                                <p>No pets registered yet.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($pets as $pet): ?>
                            <tr>
                                <td class="petDeets">
                                    <div class="petImg">
                                        <img src="<?php echo !empty($pet['pet_picture']) ? $pet['pet_picture'] : 'Profile-Pics/pet_icon.png'; ?>" alt="Pet Icon" class="pet-icon">
                                    </div>
                                    <div class="petInfo">
                                        <p class="petname"><?php echo htmlspecialchars($pet['pet_name']); ?></p>
                                        <p class="petdesc"><?php echo htmlspecialchars($pet['pet_gender']); ?>, <?php echo htmlspecialchars($pet['pet_breed']); ?>, <?php echo htmlspecialchars($pet['pet_age']); ?></p>
                                        <div class="actions">
                                            <!-- View & Edit Button -->
                                            <button type="button" class="btn view-edit-pet" id="ve" data-bs-toggle="modal" data-bs-target="#veModal" data-pet-id="<?php echo $pet['pet_id']; ?>">
                                                <p class="view-and-edit">View & Edit</p>
                                            </button>

                                            <!-- Delete Button -->
                                            <button type="button" class="btn" id="delbut" data-bs-toggle="modal" data-bs-target="#delModal" data-pet-id="<?php echo $pet['pet_id']; ?>">
                                                <p class="del">Delete</p>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="rPet">
                <button type="button" class="btn" id="regPet" data-bs-toggle="modal" data-bs-target="#regPetModal">
                    <h6 class="regPet">Need to register new pet?</h6>
                </button>
            </div>
        </div>
    </section>
</div>

<!-- VIEW AND EDIT MODAL -->
<div class="modal fade" id="veModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content" id="view-and-edit">
            <div class="modal-header" id="mheader">
                <h5 class="modal-title" id="petModalLabel">VIEW & EDIT PET INFORMATION</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="petForm" method="POST" action="update_pet.php" enctype="multipart/form-data">
                    <input type="hidden" name="pet_id" id="edit_pet_id">
                                            
                    <div class="row">
                        <div class="col-md-3">
                            <div class="image-upload-container">
                                <img id="pet-image-preview" src="Profile-Pics/pet_icon.png" class="img-fluid">
                                <input type="file" name="pet_image" id="pet_image" class="form-control mt-2">
                            </div>
                        </div>
                                                
                        <div class="col-md-9">
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">NAME</label>
                                    <input type="text" class="form-control" name="name" id="edit_pet_name" >
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">BREED</label>
                                    <input type="text" class="form-control" name="breed" id="edit_pet_breed" >
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">PET SIZE</label>
                                    <input type="text" class="form-control" name="pet_size" id="edit_pet_size" >
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">AGE</label>
                                    <input type="text" class="form-control" name="age" id="edit_pet_age" >
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">GENDER</label>
                                <select class="form-select" name="gender" id="gender-dropdown">
                                    <option value="Male" <?php echo ($pet['pet_gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female" <?php echo ($pet['pet_gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">DESCRIPTION</label>
                                <textarea class="form-control" name="description" rows="2" id="petDescription" ></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">SPECIAL INSTRUCTIONS</label>
                                <textarea class="form-control" name="special_instructions" rows="2" id="petInstruction" ></textarea>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">VACCINATION STATUS</label>
                                    <select class="form-select" name="vaccination_status" id="vaccination_status">
                                        <option value="Vaccinated">Vaccinated</option>
                                        <option value="Not Vaccinated">Not Vaccinated</option>
                                    </select>
                                </div>
                            
                                <div class="col-md-4">
                                    <label class="form-label">DATE ADMINISTERED</label>
                                    <input type="date" class="form-control" name="date_administered" id="date_administered">
                                </div>
                            
                                <div class="col-md-4">
                                    <label class="form-label">EXPIRY DATE</label>
                                    <input type="date" class="form-control" name="expiry_date" id="expiry_date"> 
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="text mt-3" id="ccbuttons">
                        <button type="button" id="cancel-but" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" id="confirm-but">SAVE CHANGES</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- DELETE MODAL -->
<div class="modal fade" id="delModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" id="del-modal">
            <div class="modal-header d-flex justify-content-center align-items-center" id="mheader">
                <h1 class="modal-title text-center" id="mod-header">Are you sure?</h1>
            </div>
            
            <div class="modal-body d-flex justify-content-center align-items-center" id="mbody">
                <h6 class="modal-title text-center" id="mod-body">
                    <p>Deleting this file will remove all records of your pet from our system permanently.</p>
                </h6>
            </div>
            
            <form action="delete_pet.php" method="POST">
                <input type="hidden" name="pet_id" id="delete_pet_id">
                <div class="modal-footer d-flex justify-content-center align-items-center" id="mfooter">
                    <button type="submit" class="btn" id="confirm-but">Confirm</button>
                    <button type="button" class="btn" data-bs-dismiss="modal" id="cancel-but">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- REGISTER NEW PET MODAL -->
<div class="modal fade" id="regPetModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content" id="reg-pet">
            <div class="modal-header d-flex justify-content-center align-items-center" id="mheader">
                <h1 class="modal-title" id="saveModal">PET/s</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body" id="mbody">
                <div class="pet-modal">
                    
                    <form class="pet-form" method="post" action="add_pet.php" enctype="multipart/form-data">
                        <div class="container-fluid p-0">
                            <div class="row">
                                
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">NAME</label>
                                        <input type="text" name="pet_name" class="form-control" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">PET SIZE</label>
                                        <div class="radio-group">
                                            <div>
                                                <input type="radio" name="pet_size" id="small_dog" value="small_dog" required>
                                                <label for="small_dog" id="pet-size">Small Dog</label>
                                            </div>
                                            <div>
                                                <input type="radio" name="pet_size" id="large_dog" value="large_dog">
                                                <label for="large_dog" id="pet-size">Large Dog</label>
                                            </div>
                                            <div>
                                                <input type="radio" name="pet_size" id="regular_dog" value="regular_dog">
                                                <label for="regular_dog" id="pet-size">Regular Dog</label>
                                            </div>
                                            <div>
                                                <input type="radio" name="pet_size" id="regular_cat" value="regular_cat">
                                                <label for="regular_cat" id="pet-size">Regular Cat</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">BREED</label>
                                        <input type="text" name="breed" class="form-control" placeholder="Type Breed Here" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">AGE</label>
                                        <input type="text" name="age" class="form-control" placeholder="Type Age Here" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">GENDER</label>
                                        <div class="radio-group">
                                            <div>
                                                <input type="radio" name="gender" id="male" value="male" required>
                                                <label for="male" id="pet-gender">Male</label>
                                            </div>
                                            <div>
                                                <input type="radio" name="gender" id="female" value="female">
                                                <label for="female" id="pet-gender">Female</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">DESCRIPTION</label>
                                        <textarea name="description" class="form-control" placeholder="e.x. White Spots" rows="3" id="petDescription" required></textarea>
                                    </div>
                                </div>
                                
                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">PET PROFILE PHOTO</label>
                                        <input type="file" name="pet_photo" class="form-control" accept="image/*,application/pdf">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">VACCINATION STATUS</label>
                                        <input type="file" name="vaccination_file" class="form-control mb-2" accept="image/*,application/pdf" required>
                                        
                                        <div class="radio-group">
                                            <div>
                                                <input type="radio" name="vaccination_status" id="vaccinated" value="vaccinated" required>
                                                <label for="vaccinated">Vaccinated</label>
                                            </div>
                                            <div>
                                                <input type="radio" name="vaccination_status" id="not_vaccinated" value="not_vaccinated">
                                                <label for="not_vaccinated">Not Vaccinated</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">DATE ADMINISTERED</label>
                                        <input type="date" name="date_administered" class="form-control" required >
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">EXPIRY DATE</label>
                                        <input type="date" name="expiry_date" class="form-control" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">SPECIAL INSTRUCTIONS</label>
                                        <textarea name="special_instructions" class="form-control" placeholder="e.x. Medications" rows="3" id="petInstruction" required></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn" id="confirm-but">Save and Go Back</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- REQUEST TO CANCEL MODAL -->
<div class="modal fade" id="req-to-cancel-modal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" id="req-to-cancel">
            
            <form action="cancel_booking.php" method="POST">
                <input type="hidden" name="booking_id" id="cancel_booking_id">
                
                <div class="modal-header" id="mheader">
                    <h1 class="modal-title fs-5" id="req-to-cancel-title">Are you sure you want to cancel?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body" id="mbody-req-to-cancel">
                    <div class="mbody-text">
                        <p id="req-to-cancel-mbody-text">
                            We're sorry to see you go! Please confirm if you'd like to cancel your booking.
                            If you need assistance, feel free to reach out to us.
                        </p>
                        
                        <div class="d-flex flex-wrap gap-3">
                            <div>
                                <input type="radio" name="reason" value="Change of Plans" id="ChangeOfPlans" required>
                                <label for="ChangeOfPlans">Change of Plans</label>
                            </div>

                            <div>
                                <input type="radio" name="reason" value="Personal Emergency" id="PersonalEmergency">
                                <label for="PersonalEmergency">Personal Emergency</label>
                            </div>

                            <div>
                                <input type="radio" name="reason" value="Scheduling Conflict" id="SchedulingConflict">
                                <label for="SchedulingConflict">Scheduling Conflict</label>
                            </div>

                            <div>
                                <input type="radio" name="reason" value="Dissatisfaction with Services" id="DissatisfactionWithServices">
                                <label for="DissatisfactionWithServices">Dissatisfaction with Services</label>
                            </div>

                            <div class="d-flex align-items-center">
                                <input type="radio" name="reason" value="Other" id="Others">
                                <label for="Others" class="me-2">Other Specify:</label>
                                <textarea class="form-control" id="message-text" name="other_reason"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer d-flex justify-content-center align-items-center" id="mfooter">
                    <button class="btn" id="confirm-but" data-bs-target="#process-cancellation" data-bs-toggle="modal" type="button">
                        Proceed to Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="process-cancellation" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="process-cancel">
            <div class="modal-header" id="mheader">
                <h1 class="modal-title fs-5" id="process-cancellation-title">Your Cancellation is Being Processed</h1>
            </div>

            <div class="modal-body" id="mbody-process-cancellation">
                We're processing your refund now. Kindly wait a moment, and we'll notify you once it's complete.
                Thank you for your patience!
            </div>
            
            <div class="modal-footer d-flex justify-content-center align-items-center" id="mfooter">
                <button type="button" class="btn" data-bs-dismiss="modal" id="confirm-but">Confirm</button>
                <button type="button" class="btn" data-bs-dismiss="modal" id="cancel-but">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- EDIT USER INFORMATION -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" id="editProfile">
            <div class="modal-header border-0 pb-0" id="mheader">
                <div class="paw-prints">
                    <img src="Profile-Pics.png" alt="">
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                
            <div class="modal-body" id="mbody">
                <div class="text-center mb-4">
                    <h5 class="modal-title" id="editProfileModalLabel">EDIT PROFILE</h5>
                </div>

                <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3 text-center">
                        <img src="<?php echo $profile_picture; ?>" alt="Profile Picture" class="profile-icon mb-2" style="width: 100px; height: 100px; border-radius: 50%;">
                        <input type="file" name="profile_picture" class="form-control" accept="image/*">
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">FIRST NAME</label>
                            <input type="text" class="form-control" name="first_name" value="<?php echo $fetch_cust_info['customer_first_name']; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">LAST NAME</label>
                            <input type="text" class="form-control" name="last_name" value="<?php echo $fetch_cust_info['customer_last_name']; ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">CONTACT NO.</label>
                            <input type="tel" class="form-control" name="contact" value="<?php echo $fetch_cust_info['customer_contact_number']; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">EMAIL</label>
                            <input type="email" class="form-control" name="email" value="<?php echo $fetch_cust_info['customer_email']; ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ADDRESS</label>
                        <input type="text" class="form-control" name="address" value="<?php echo isset($fetch_cust_info['c_address']) ? htmlspecialchars($fetch_cust_info['c_address']) : ''; ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">SOCIALS</label>
                        <input type="url" class="form-control" name="socials" value="<?php echo isset($fetch_cust_info['customer_mode_of_communication']) ? htmlspecialchars($fetch_cust_info['customer_mode_of_communication']) : ''; ?>">
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">CURRENT PASSWORD</label>
                            <input type="password" class="form-control" name="current_password">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NEW PASSWORD</label>
                            <input type="password" class="form-control" name="new_password">
                        </div>
                    </div>

                    <div class="modal-footer d-flex justify-content-center align-items-center" id="mfooter">
                        <button type="button" class="btn" data-bs-dismiss="modal" id="cancel-but">Cancel</button>
                        <button type="submit" class="btn" id="confirm-but">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for handling modal data -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle View & Edit Pet Modal
    const veModal = document.getElementById('veModal');
    if (veModal) {
        veModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const petId = button.getAttribute('data-pet-id');
            document.getElementById('edit_pet_id').value = petId;
            
            // Fetch pet data via AJAX
            fetch(`get_pet_data.php?pet_id=${petId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('edit_pet_name').value = data.pet_name || '';
                    document.getElementById('edit_pet_breed').value = data.pet_breed || '';
                    document.getElementById('edit_pet_size').value = data.pet_size || '';
                    document.getElementById('edit_pet_age').value = data.pet_age || '';
                    document.getElementById('gender-dropdown').value = data.pet_gender || '';
                    document.getElementById('petDescription').value = data.pet_description || '';
                    document.getElementById('petInstruction').value = data.pet_special_instructions || '';
                    document.getElementById('vaccination_status').value = data.pet_vaccination_status || '';
                    document.getElementById('date_administered').value = data.pet_vaccination_date_administered || '';
                    document.getElementById('expiry_date').value = data.pet_expiry_date || '';
                    
                    if (data.pet_picture) {
                        document.getElementById('pet-image-preview').src = data.pet_picture;
                    }
                })
                .catch(error => {
                    console.error('Error fetching pet data:', error);
                    alert('Error loading pet data. Please try again.');
                });
        });
    }
    
    // Handle Delete Pet Modal
    const delModal = document.getElementById('delModal');
    if (delModal) {
        delModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const petId = button.getAttribute('data-pet-id');
            document.getElementById('delete_pet_id').value = petId;
        });
    }
    
    // Handle Cancel Booking Modal
    const cancelModal = document.getElementById('req-to-cancel-modal');
    if (cancelModal) {
        cancelModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const bookingId = button.getAttribute('data-booking-id');
            document.getElementById('cancel_booking_id').value = bookingId;
        });
    }
    
    // Preview uploaded images
    const petImageInput = document.getElementById('pet_image');
    if (petImageInput) {
        petImageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('pet-image-preview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>

</body>
</html>