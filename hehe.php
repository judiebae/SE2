<?php

// Start session at the very beginning
session_start();

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['customer_id']) && !isset($_SESSION['c_id'])) {
    header("Location: home.php");
    exit;
}

// Get the logged-in customer's ID from session
$customerId = isset($_SESSION['c_id']) ? $_SESSION['c_id'] : $_SESSION['customer_id'];

include("connect.php");

// After including connect.php
if (!$conn) {
    die("Connection failed: PDO connection not established");
}

// For debugging (optional - you can remove this later)
// echo "<pre>Session data: ";
// print_r($_SESSION);
// echo "<br>Customer ID: $customerId</pre>";

$stmt = $conn->prepare("
    SELECT c.*, m.membership_status 
    FROM customer c 
    LEFT JOIN membership_status m ON c.c_membership_status = m.membership_id 
    WHERE c.c_id = ?
");
$stmt->execute([$customerId]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

// if (!$customer) {
//     // Clear invalid session
//     session_unset();
//     session_destroy();
//     header("Location: home.php");
//     exit;
// }

// Fetch customer's pets
$stmt = $conn->prepare("SELECT * FROM pet WHERE customer_id = ?");
$stmt->execute([$customerId]);
$pets = $stmt->fetchAll();

$stmt = $conn->prepare("
    SELECT b.*, p.pet_name, p.pet_picture, s.service_name, s.service_variant, s.service_rate 
    FROM bookings b
    JOIN pet p ON b.pet_id = p.pet_id
    JOIN service s ON b.service_id = s.service_id
    WHERE p.customer_id = ?
    ORDER BY b.booking_check_in DESC
");


$stmt->execute([$customerId]);
$bookings = $stmt->fetchAll();


// Process form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update user profile
    if (isset($_POST['update_profile'])) {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $contactNumber = $_POST['contactNumber'];
        $modeOfCommunication = $_POST['modeOfCommunication'];
        
        // Handle profile picture upload
        $profilePicture = $customer['c_profile_picture']; // Default to current picture
        
        if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] === 0) {
            $uploadDir = 'uploads/profiles/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $fileName = uniqid() . '_' . basename($_FILES['profilePicture']['name']);
            $uploadFile = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], $uploadFile)) {
                $profilePicture = $fileName;
            }
        }
        
        // Update customer in database
        $stmt = $conn->prepare("
            UPDATE customer 
            SET c_first_name = ?, c_last_name = ?, c_email = ?, 
                c_contact_number = ?, c_mode_of_communication = ?, c_profile_picture = ?
            WHERE c_id = ?
        ");
        $stmt->execute([$firstName, $lastName, $email, $contactNumber, $modeOfCommunication, $profilePicture, $customerId]);
        
        // Redirect to refresh the page
        header("Location: profile.php");
        exit;
    }
    
    // Cancel booking
    if (isset($_POST['cancel_booking'])) {
        $bookingId = $_POST['booking_id'];
        $reason = $_POST['cancellation_reason'];
        
        $stmt = $conn->prepare("UPDATE bookings SET booking_status = 'Cancelled' WHERE booking_id = ?");
        $stmt->execute([$bookingId]);
        
        // Redirect to refresh the page
        header("Location: profile.php");
        exit;
    }

    // Update pet information
    if (isset($_POST['update_pet'])) {
        $petId = $_POST['pet_id'];
        $petName = $_POST['petName'];
        $petSize = $_POST['petSize'];
        $petBreed = $_POST['petBreed'];
        $petAge = $_POST['petAge'];
        $petGender = $_POST['petGender'];
        $petDescription = $_POST['petDescription'];
        $petVaccinationDate = $_POST['petVaccinationDate'];
        $petVaccinationExpiry = $_POST['petVaccinationExpiry'];
        $petVaccinationStatus = $_POST['petVaccinationStatus'];
        $petSpecialInstruction = $_POST['petSpecialInstruction'];
        
        // Handle pet picture upload
        $petPicture = null;
        if (isset($_POST['current_pet_picture'])) {
            $petPicture = $_POST['current_pet_picture'];
        }
        
        if (isset($_FILES['petPicture']) && $_FILES['petPicture']['error'] === 0) {
            $uploadDir = 'uploads/pets/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $fileName = uniqid() . '_' . basename($_FILES['petPicture']['name']);
            $uploadFile = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['petPicture']['tmp_name'], $uploadFile)) {
                $petPicture = $fileName;
            }
        }
        
        // Handle vaccination card upload
        $petVaccinationCard = null;
        if (isset($_POST['current_vaccination_card'])) {
            $petVaccinationCard = $_POST['current_vaccination_card'];
        }
        
        if (isset($_FILES['petVaccinationCard']) && $_FILES['petVaccinationCard']['error'] === 0) {
            $uploadDir = 'uploads/vaccination/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $fileName = uniqid() . '_' . basename($_FILES['petVaccinationCard']['name']);
            $uploadFile = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['petVaccinationCard']['tmp_name'], $uploadFile)) {
                $petVaccinationCard = $fileName;
            }
        }
        
        // Update pet in database
        $stmt = $conn->prepare("
            UPDATE pet 
            SET pet_name = ?, pet_size = ?, pet_breed = ?, pet_age = ?, pet_gender = ?, 
                pet_description = ?, pet_vaccination_date_administered = ?, 
                pet_vaccination_date_expiry = ?, pet_vaccination_status = ?, 
                pet_special_instruction = ?, pet_picture = ?, pet_vaccination_card = ?
            WHERE pet_id = ? AND customer_id = ?
        ");
        $stmt->execute([
            $petName, $petSize, $petBreed, $petAge, $petGender, $petDescription,
            $petVaccinationDate, $petVaccinationExpiry, $petVaccinationStatus,
            $petSpecialInstruction, $petPicture, $petVaccinationCard, $petId, $customerId
        ]);
        
        // Redirect to refresh the page
        header("Location: profile.php");
        exit;
    }
    
    // Delete pet
    if (isset($_POST['delete_pet'])) {
        $petId = $_POST['pet_id'];
        
        $stmt = $conn->prepare("DELETE FROM pet WHERE pet_id = ? AND customer_id = ?");
        $stmt->execute([$petId, $customerId]);
        
        // Redirect to refresh the page
        header("Location: profile.php");
        exit;
    }
    
    // Register new pet
    if (isset($_POST['register_pet'])) {
        $petName = $_POST['petName'];
        $petSize = $_POST['petSize'];
        $petBreed = $_POST['petBreed'];
        $petAge = $_POST['petAge'];
        $petGender = $_POST['petGender'];
        $petDescription = $_POST['petDescription'];
        $petVaccinationDate = $_POST['petVaccinationDate'] ?: null;
        $petVaccinationExpiry = $_POST['petVaccinationExpiry'] ?: null;
        $petVaccinationStatus = $_POST['petVaccinationStatus'];
        $petSpecialInstruction = $_POST['petSpecialInstruction'];
        
        // Handle pet picture upload
        $petPicture = null;
        if (isset($_FILES['petPicture']) && $_FILES['petPicture']['error'] === 0) {
            $uploadDir = 'uploads/pets/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $fileName = uniqid() . '_' . basename($_FILES['petPicture']['name']);
            $uploadFile = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['petPicture']['tmp_name'], $uploadFile)) {
                $petPicture = $fileName;
            }
        }
        
        // Handle vaccination card upload
        $petVaccinationCard = null;
        if (isset($_FILES['petVaccinationCard']) && $_FILES['petVaccinationCard']['error'] === 0) {
            $uploadDir = 'uploads/vaccination/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $fileName = uniqid() . '_' . basename($_FILES['petVaccinationCard']['name']);
            $uploadFile = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['petVaccinationCard']['tmp_name'], $uploadFile)) {
                $petVaccinationCard = $fileName;
            }
        }
        
        // Insert new pet into database
        $stmt = $conn->prepare("
            INSERT INTO pet (
                customer_id, pet_name, pet_size, pet_breed, pet_age, pet_gender, 
                pet_description, pet_vaccination_date_administered, pet_vaccination_date_expiry, 
                pet_vaccination_status, pet_special_instruction, pet_picture, pet_vaccination_card
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $customerId, $petName, $petSize, $petBreed, $petAge, $petGender, 
            $petDescription, $petVaccinationDate, $petVaccinationExpiry, 
            $petVaccinationStatus, $petSpecialInstruction, $petPicture, $petVaccinationCard
        ]);
        
        // Redirect to refresh the page
        header("Location: profile.php");
        exit;
    }
}

// Helper function to display profile picture
function getProfilePicture($picture) {
    if ($picture && file_exists('uploads/profiles/' . $picture)) {
        return 'uploads/profiles/' . $picture;
    }
    return 'assets/default-profile.jpg';
}

// Helper function to display pet picture
function getPetPicture($picture) {
    if ($picture && file_exists('uploads/pets/' . $picture)) {
        return 'uploads/pets/' . $picture;
    }
    return 'assets/default-pet.jpg';
}

// Format date for display
function formatDate($date) {
    return date('M d, Y', strtotime($date));
}

// Format datetime for display
function formatDateTime($datetime) {
    return date('M d, Y h:i A', strtotime($datetime));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="headers.css">
    <link rel="stylesheet" href="Profile.css">
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
        <!-- <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Offcanvas</h5> -->
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
            <a class="nav-link" aria-current="page" href="home.php">HOME</a>
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
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal" data-backdrop="false">LOGIN</button>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>

<?php
    if ((isset($_SESSION['c_id']) && $_SESSION['c_id'] > 0) || (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] > 0)) {
        $customer_id = isset($_SESSION['c_id']) ? $_SESSION['c_id'] : $_SESSION['customer_id'];
        
        try {
            $stmt = $conn->prepare("SELECT * FROM customer WHERE c_id = :customer_id");
            $stmt->bindParam(':customer_id', $customer_id);
            $stmt->execute();
            $fetch_cust_info = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$fetch_cust_info) {
                echo "No user found with ID: " . $customer_id;
            }
        } catch(PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
    } else {
        echo "User is not logged in.";
    }
?>

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

                    <!-- Notification Bell -->
                    <div class="notifBell">
                        <i class="fa-regular fa-bell notif-icon"></i>
                    </div>      
                </div>


                <div class="user-deets">
                    <div class="pfp">
                        <img src="Profile-Pics/profile_icon.png" alt="" class="profile-icon">
                        <h6 class="cusID">CUSTOMER ID</h6>
                        <h6 class="cusNum">NO. <?php echo $fetch_cust_info['customer_id'] ?></h6>
                        <h6 class="cusMem"><?php echo $fetch_cust_info['customer_membership_status'] ?></h6>
                    </div>


                    <div class="deets">
                        <div class="name">
                            <div class="deet1">
                                <p class="deet">FIRST NAME <strong><?php echo $fetch_cust_info['customer_first_name']?> </strong> </p>                    
                                <hr class="hline">
                                <p class="deet">CONTACT NUMBER <strong><?php echo $fetch_cust_info['customer_contact_number']?> </strong> </p>                    
                                <hr class="hline">
                            </div>
                            <div class="deet2">
                                <p class="deet">LAST NAME <strong><?php echo $fetch_cust_info['customer_last_name']?> </strong> </p>                                            
                                <hr class="hline">
                                <p class="deet">EMAIL <strong><?php echo $fetch_cust_info['customer_email']?></strong> </p>  
                                <hr class="hline">
                            </div>
                        </div>
                       
                        <div class="deet3">
                            <p class="deet">ADDRESS <strong><?php echo isset($fetch_cust_info['customer_address']) ? htmlspecialchars($fetch_cust_info['customer_address']) : 'N/A'; ?> </strong> </p>                        
                            <hr class="hline">
                            <p class="deet">SOCIAL LINK</p>
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
                            <tbody >
                                <tr>
                                    <td class="crBody">
                                        <div class="tDeets">
                                            <h6 class="tStatus"><?php echo $fetch_service_info['b_status'] ?></h6>


                                            <div class="tDeets1">
                                                <div class="tDeets1-1">
                                                    <p class="tpetname"><?php echo $fetch_service_info['b_pet'] ?></p>
                                                </div>


                                                <div class="tDeets1-2">
                                                    <p class="price"><?php echo $fetch_service_info['b_payment'] ?></p>
                                                </div>
                                            </div>


                                            <div class="tDeets2">
                                            <div class="tDeets2-1">
                                                    <p class="tservice"><?php echo $fetch_service_info['b_service'] ?></p>
                                                    <p class="tId">Transaction ID NO <?php echo $fetch_service_info['b_id'] ?></p>
                                                    <p class="tDate"><?php echo $fetch_service_info['b_date'] ?></p>


                                                </div>


                                                <div class="tDeets2-2">
                                                        <button class="btn" data-bs-target="#req-to-cancel-modal" data-bs-toggle="modal" id="reqtoCancel-but">Request to Cancel</button>
                                                           
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                   <div class="user-history">
                        <table class="hist">


                            <thead class="hRev">
                                <th class="currRev">RESERVATIONS HISTORY</th>
                            </thead>


                            <tbody >
                                <tr>
                                    <td class="crBody">
                                        <div class="tDeets">
                                            <h6 class="tStatus"><?php echo $fetch_service_info['b_status'] ?></h6>


                                            <div class="tDeets1">
                                                <div class="tDeets1-1">
                                                    <p class="tpetname"><?php echo $fetch_service_info['b_pet'] ?></p>
                                                </div>


                                                <div class="tDeets1-2">
                                                    <p class="price"><?php echo $fetch_service_info['b_payment'] ?></p>
                                                </div>
                                            </div>


                                            <div class="tDeets2">
                                            <div class="tDeets2-1">
                                                    <p class="tservice"><?php echo $fetch_service_info['b_service'] ?></p>
                                                    <p class="tId">Transaction ID NO <?php echo $fetch_service_info['b_id'] ?></p>
                                                    <p class="tDate"><?php echo $fetch_service_info['b_date'] ?></p>


                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
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


                    <tbody >
                        <tr>
                            <td class="petDeets">
                                <div class="petImg">
                                    <img src="Profile-Pics/pet_icon.png" alt="Pet Icon" class="pet-icon">
                                </div>
                                <div class="petInfo">
                                    <p class="petname">DOG NAME</p>
                                    <p class="petdesc">Sex, Breed, Age</p>
                                    <div class="actions">
                                        <!-- View & Edit Button -->
                                        <button type="button" class="btn" id="ve" data-bs-toggle="modal" data-bs-target="#veModal">
                                            <p class="view-and-edit">View & Edit</p>
                                        </button>


                                        <!-- Delete Button -->
                                        <button type="button" class="btn" id="delbut" data-bs-toggle="modal" data-bs-target="#delModal">
                                            <p class="del">Delete</p>
                                        </button>
                                </div>
                                </div>
                            </td>
                        </tr>
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
        <div class="modal-header" id= "mheader">
            <h5 class="modal-title" id="petModalLabel">VIEW & EDIT PET INFORMATION</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="petForm" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="pet_id" value="<?php echo $pet['id']; ?>">
                                           
                <div class="row">
                    <div class="col-md-3">
                        <div class="image-upload-container">
                            <img id="pet-image" src="<?php echo $pet['image_path'] ?? 'placeholder.jpg'; ?>" class="img-fluid">
                            <input type="file" name="pet_image" id="pet_image" class="form-control mt-2">
                        </div>
                    </div>
                                               
                    <div class="col-md-9">
                       
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">NAME</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $pet['name']; ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">BREED</label>
                                <input type="text" class="form-control" name="breed" value="<?php echo $pet['breed']; ?>">
                            </div>
                        </div>
                       
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">PET SIZE</label>
                                <input type="text" class="form-control" name="pet_size" value="<?php echo $pet['pet_size']; ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">AGE</label>
                                <input type="text" class="form-control" name="age" value="<?php echo $pet['age']; ?>">
                            </div>
                        </div>
                       
                        <div class="mb-3">
                             <label class="form-label">GENDER</label>
                             <select class="form-select" name="gender" id="gender-dropdown">
                                <option value="Male" <?php echo $pet['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?php echo $pet['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                            </select>
                        </div>
                       
                        <div class="mb-3">
                            <label class="form-label">DESCRIPTION</label>
                            <textarea class="form-control" name="description" rows="2" id="petDescription"><?php echo $pet['description']; ?></textarea>
                        </div>
                       
                        <div class="mb-3">
                            <label class="form-label">SPECIAL INSTRUCTIONS</label>
                            <textarea class="form-control" name="special_instructions" rows="2" id="petInstruction"><?php echo $pet['special_instructions']; ?></textarea>
                        </div>
                       
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">VACCINATION STATUS</label>
                                <input type="text" class="form-control" name="vaccination_status" value="<?php echo $pet['vaccination_status']; ?>">
                        </div>
                       
                        <div class="col-md-4">
                            <label class="form-label">DATE ADMINISTERED</label>
                            <input type="date" class="form-control" name="date_administered" value="<?php echo $pet['date_administered']; ?>">
                        </div>
                       
                        <div class="col-md-4">
                            <label class="form-label">EXPIRY DATE</label>
                            <input type="date" class="form-control" name="expiry_date" value="<?php echo $pet['expiry_date']; ?>">
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
           
            <div class="modal-footer d-flex justify-content-center align-items-center" id="mfooter">
                <button type="button" class="btn" data-bs-dismiss="modal" id="confirm-but">Confirm</button>
                <button type="button" class="btn" data-bs-dismiss="modal" id="cancel-but">Cancel</button>
            </div>
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
                   
                    <form class="pet-form" method="post" enctype="multipart/form-data">
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
                                            <input type="radio" name="pet_size" id="small_dog" value="small_dog">
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
                                            <input type="radio" name="pet_size"                                            <input type="radio" name="pet_size" id="regular_cat" value="regular_cat">
                                            <label for="regular_cat" id="pet-size">Regular Cat</label>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="mb-3">
                                    <label class="form-label">BREED</label>
                                    <input type="text" name="breed" class="form-control" placeholder="Type Breed Here">
                                </div>
                               
                                <div class="mb-3">
                                    <label class="form-label">AGE</label>
                                    <input type="text" name="age" class="form-control" placeholder="Type Age Here">
                                </div>


                                <div class="mb-3">
                                    <label class="form-label">GENDER</label>
                                    <div class="radio-group">
                                        <div>
                                            <input type="radio" name="gender" id="male" value="male">
                                            <label for="male"id="pet-gender">Male</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="gender" id="female" value="female">
                                            <label for="female" id="pet-gender">Female</label>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="mb-3">
                                    <label class="form-label">DESCRIPTION</label>
                                    <textarea name="description" class="form-control" placeholder="e.x. White Spots" rows="3" id="petDescription"></textarea>
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
                                    <input type="file" name="vaccination_file" class="form-control mb-2" accept="image/*,application/pdf">
                                   
                                    <div class="radio-group">
                                        <div>
                                            <input type="radio" name="vaccination_status" id="vaccinated" value="vaccinated">
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
                                    <input type="date" name="date_administered" class="form-control">
                                </div>
                               
                                <div class="mb-3">
                                    <label class="form-label">EXPIRY DATE</label>
                                    <input type="date" name="expiry_date" class="form-control">
                                </div>
                               
                                <div class="mb-3">
                                    <label class="form-label">SPECIAL INSTRUCTIONS</label>
                                    <textarea name="special_instructions" class="form-control" placeholder="e.x. Medications" rows="3" id="petInstruction"></textarea>
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


<!-- REQUEST TO CANCEL MODAL -->
<div class="modal fade" id="req-to-cancel-modal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" id="req-to-cancel">
           
            <form action="cancel_booking.php" method="POST"> <!-- Form starts here -->
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
                    <!-- This button will open the next modal while keeping form data -->
                    <button class="btn" id="confirm-but" data-bs-target="#process-cancellation" data-bs-toggle="modal" type="button">
                        Proceed to Cancel
                    </button>
                </div>
            </form> <!-- Form ends here -->


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
                We’re processing your refund now. Kindly wait a moment, and we’ll notify you once it's complete.
                Thank you for your patience!
            </div>
           
            <div class="modal-footer d-flex justify-content-center align-items-center" id="mfooter">
                <button type="button" class="btn" data-bs-dismiss="modal" id="confirm-but">Confirm</button>
                <button type="button" class="btn" data-bs-dismiss="modal" id="cancel-but">Cancel</button>
            </div>


        </div>
    </div>
</div>



<!-- EDIT USER PROFILE -->



                        <!-- Modal -->
                        <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered">
                            <div class="modal-content"  id="editProfile">
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


                                    <form action="update_profile.php" method="POST">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">FIRST NAME</label>
                                            <input type="text" class="form-control" name="first_name" value="<?php echo $fetch_cust_info['first_name'] ?>" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">LAST NAME</label>
                                            <input type="text" class="form-control" name="last_name" value="<?php echo $fetch_cust_info['last_name']?>" required>
                                        </div>
                                    </div>


                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">CONTACT NO.</label>
                                            <input type="tel" class="form-control" name="contact" value="<?php echo $fetch_cust_info['contact_number']?>" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">EMAIL</label>
                                            <input type="email" class="form-control" name="email" value="<?php echo $fetch_cust_info['email']?>" required>
                                        </div>
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label">ADDRESS</label>
                                        <input type="text" class="form-control" name="address" value="<?php echo isset($fetch_cust_info['address']) ? htmlspecialchars($fetch_cust_info['address']) : 'N/A'; ?>" required>
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label">SOCIALS</label>
                                        <input type="url" class="form-control" name="socials" value="<?php echo isset($fetch_cust_info['socials']) ? htmlspecialchars($fetch_cust_info['address']) : 'N/A'; ?>">
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
                                        <button type="button" class="btn" data-bs-dismiss="modal" id="confirm-but">Save Changes</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>

</body>
</html>

