<?php
// Start session to manage user state
session_start();

// Database connection using PDO
try {
    $host = 'localhost';
    $dbname = 'fur_a_paw_intments';
    $username = 'root';
    $password = '';
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// For demonstration, let's assume we have a logged-in user with ID 9
// In a real application, you would get this from the session after login
$customerId = 9;

// Fetch customer data
$stmt = $pdo->prepare("
    SELECT c.*, m.membership_status 
    FROM customer c 
    LEFT JOIN membership_status m ON c.c_membership_status = m.membership_id 
    WHERE c.c_id = ?
");
$stmt->execute([$customerId]);
$customer = $stmt->fetch();

// Fetch customer's pets
$stmt = $pdo->prepare("SELECT * FROM pet WHERE customer_id = ?");
$stmt->execute([$customerId]);
$pets = $stmt->fetchAll();

// Fetch customer's bookings (current and history)
$stmt = $pdo->prepare("
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
        $stmt = $pdo->prepare("
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
        
        $stmt = $pdo->prepare("UPDATE bookings SET booking_status = 'Cancelled' WHERE booking_id = ?");
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
        $stmt = $pdo->prepare("
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
        
        $stmt = $pdo->prepare("DELETE FROM pet WHERE pet_id = ? AND customer_id = ?");
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
        $stmt = $pdo->prepare("
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
    <title>User Profile - Fur-A-Paw-Intments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="Profile.css">
    <link rel="stylesheet" href="headers.css">
</head>
<body>
    <div class="profile">
        <section>
            <div class="col-left">
                <div class="user-header">
                    <div class="user-info">
                        <h1 class="personalinfo">Personal Information</h1>
                        <i class="fa-solid fa-pen-to-square edit-icon" data-bs-toggle="modal" data-bs-target="#editProfile"></i>
                    </div>
                    <div class="notif-icon">
                        <i class="fa-solid fa-bell"></i>
                    </div>
                </div>
                
                <div class="user-deets">
                    <div class="pfp">
                        <img src="<?php echo getProfilePicture($customer['c_profile_picture']); ?>" alt="Profile Picture" class="profile-icon">
                        <p class="cusID">Customer ID: <span class="cusNum"><?php echo $customer['c_id']; ?></span></p>
                        <p class="cusMem"><?php echo $customer['membership_status']; ?></p>
                    </div>
                    
                    <div class="deets">
                        <div class="name">
                            <div class="deet1">
                                <p class="deet">First Name</p>
                                <hr class="hline">
                                <p class="deet"><?php echo $customer['c_first_name']; ?></p>
                            </div>
                            <div class="deet2">
                                <p class="deet">Last Name</p>
                                <hr class="hline">
                                <p class="deet"><?php echo $customer['c_last_name']; ?></p>
                            </div>
                        </div>
                        
                        <div class="deet3">
                            <p class="deet">Email</p>
                            <hr class="hline">
                            <p class="deet"><?php echo $customer['c_email']; ?></p>
                        </div>
                        
                        <div class="deet3">
                            <p class="deet">Contact Number</p>
                            <hr class="hline">
                            <p class="deet"><?php echo $customer['c_contact_number']; ?></p>
                        </div>
                        
                        <div class="deet3">
                            <p class="deet">Mode of Communication</p>
                            <hr class="hline">
                            <p class="deet"><?php echo $customer['c_mode_of_communication']; ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="user-transactions">
                    <div class="user-current">
                        <div class="curr">
                            <div class="cRev">
                                <h2 class="currRev">Current Reservations</h2>
                            </div>
                            
                            <div class="crBody">
                                <?php 
                                $currentBookings = array_filter($bookings, function($booking) {
                                    return $booking['booking_status'] == 'Confirmed' || $booking['booking_status'] == 'Pending';
                                });
                                
                                if (empty($currentBookings)) {
                                    echo "<p>No current reservations.</p>";
                                } else {
                                    foreach ($currentBookings as $booking) {
                                ?>
                                <div class="transaction-card mb-3">
                                    <div class="tDeets1">
                                        <div class="tDeets1-1">
                                            <h3 class="tpetname"><?php echo $booking['pet_name']; ?></h3>
                                            <p class="tservice"><?php echo $booking['service_name'] . ' - ' . $booking['service_variant']; ?></p>
                                        </div>
                                        <div class="tDeets1-2">
                                            <p class="price">₱<?php echo number_format($booking['service_rate'], 2); ?></p>
                                            <span class="tStatus"><?php echo $booking['booking_status']; ?></span>
                                        </div>
                                    </div>
                                    
                                    <div class="tDeets2">
                                        <div class="tDeets2-1">
                                            <p class="tId">Booking ID: <?php echo $booking['booking_id']; ?></p>
                                            <p class="tDate">
                                                <?php echo formatDateTime($booking['booking_check_in']); ?> - 
                                                <?php echo formatDateTime($booking['booking_check_out']); ?>
                                            </p>
                                        </div>
                                        <div class="tDeets2-2">
                                            <button id="reqtoCancel-but" class="btn" data-bs-toggle="modal" data-bs-target="#req-to-cancel" data-booking-id="<?php echo $booking['booking_id']; ?>">
                                                Request to Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <?php 
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="user-history">
                        <div class="hist">
                            <div class="hRev">
                                <h2 class="hisRev">Reservation History</h2>
                            </div>
                            
                            <div class="rhBody">
                                <?php 
                                $historyBookings = array_filter($bookings, function($booking) {
                                    return $booking['booking_status'] == 'Completed' || $booking['booking_status'] == 'Cancelled';
                                });
                                
                                if (empty($historyBookings)) {
                                    echo "<p>No reservation history.</p>";
                                } else {
                                    foreach ($historyBookings as $booking) {
                                ?>
                                <div class="transaction-card mb-3">
                                    <div class="tDeets1">
                                        <div class="tDeets1-1">
                                            <h3 class="tpetname"><?php echo $booking['pet_name']; ?></h3>
                                            <p class="tservice"><?php echo $booking['service_name'] . ' - ' . $booking['service_variant']; ?></p>
                                        </div>
                                        <div class="tDeets1-2">
                                            <p class="price">₱<?php echo number_format($booking['service_rate'], 2); ?></p>
                                            <span class="tStatus"><?php echo $booking['booking_status']; ?></span>
                                        </div>
                                    </div>
                                    
                                    <div class="tDeets2">
                                        <div class="tDeets2-1">
                                            <p class="tId">Booking ID: <?php echo $booking['booking_id']; ?></p>
                                            <p class="tDate">
                                                <?php echo formatDateTime($booking['booking_check_in']); ?> - 
                                                <?php echo formatDateTime($booking['booking_check_out']); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <?php 
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-right">
                <div class="pbi">
                    <h2>Pet Information</h2>
                </div>
                
                <div class="rPet">
                    <p class="regPet" id="regPet" data-bs-toggle="modal" data-bs-target="#reg-pet">Register Pet</p>
                </div>
                
                <?php foreach ($pets as $pet): ?>
                <div class="petDeets">
                    <div class="petImg">
                        <img src="<?php echo getPetPicture($pet['pet_picture']); ?>" alt="Pet Picture" class="pet-icon">
                    </div>
                    
                    <div class="petInfo">
                        <h3 class="petname"><?php echo $pet['pet_name']; ?></h3>
                        <p class="petdesc"><?php echo $pet['pet_breed']; ?>, <?php echo $pet['pet_age']; ?> years old</p>
                        <div class="actions">
                            <p id="ve" class="view-and-edit" data-bs-toggle="modal" data-bs-target="#view-and-edit" data-pet-id="<?php echo $pet['pet_id']; ?>">View and Edit Pet Information</p>
                            <p id="delbut" class="del" data-bs-toggle="modal" data-bs-target="#del-modal" data-pet-id="<?php echo $pet['pet_id']; ?>">Delete Pet Information</p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
    
    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfile" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" id="mheader">
                    <h1 class="modal-title" id="editProfileModalLabel">Edit Profile</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $customer['c_first_name']; ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $customer['c_last_name']; ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $customer['c_email']; ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="contactNumber" class="form-label">Contact Number</label>
                                <input type="tel" class="form-control" id="contactNumber" name="contactNumber" value="<?php echo $customer['c_contact_number']; ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="modeOfCommunication" class="form-label">Mode of Communication</label>
                                <select class="form-control" id="modeOfCommunication" name="modeOfCommunication" required>
                                    <option value="Email" <?php echo $customer['c_mode_of_communication'] == 'Email' ? 'selected' : ''; ?>>Email</option>
                                    <option value="Phone" <?php echo $customer['c_mode_of_communication'] == 'Phone' ? 'selected' : ''; ?>>Phone</option>
                                    <option value="SMS" <?php echo $customer['c_mode_of_communication'] == 'SMS' ? 'selected' : ''; ?>>SMS</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="profilePicture" class="form-label">Profile Picture</label>
                                <input type="file" class="form-control" id="profilePicture" name="profilePicture" accept="image/*">
                                <?php if ($customer['c_profile_picture']): ?>
                                <div class="mt-2">
                                    <img src="<?php echo getProfilePicture($customer['c_profile_picture']); ?>" alt="Current Profile Picture" style="max-width: 100px; max-height: 100px;">
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer" id="mfooter">
                        <div class="form-actions">
                            <button type="button" class="btn" id="cancel-but" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn" id="confirm-but" name="update_profile">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Request to Cancel Modal -->
    <div class="modal fade" id="req-to-cancel" tabindex="-1" aria-labelledby="req-to-cancel-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" id="mheader">
                    <h1 class="modal-title" id="req-to-cancel-title">Request to Cancel</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form method="POST">
                    <div class="modal-body" id="mbody-req-to-cancel">
                        <input type="hidden" id="booking_id" name="booking_id">
                        <p>Please select a reason for cancellation:</p>
                        
                        <div class="radio-group">
                            <input type="radio" id="reason1" name="cancellation_reason" value="Change of plans" required>
                            <label for="reason1">Change of plans</label>
                        </div>
                        
                        <div class="radio-group">
                            <input type="radio" id="reason2" name="cancellation_reason" value="Found another service">
                            <label for="reason2">Found another service</label>
                        </div>
                        
                        <div class="radio-group">
                            <input type="radio" id="reason3" name="cancellation_reason" value="Pet is not available">
                            <label for="reason3">Pet is not available</label>
                        </div>
                        
                        <div class="radio-group reason4">
                            <input type="radio" id="reason4" name="cancellation_reason" value="Other">
                            <label for="reason4">Other:</label>
                            <textarea id="otherReason" name="other_reason" placeholder="Please specify"></textarea>
                        </div>
                    </div>
                    
                    <div class="modal-footer" id="mfooter">
                        <div id="ccbuttons">
                            <button type="button" class="btn" id="cancel-but" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn" id="confirm-but" name="cancel_booking" data-bs-toggle="modal" data-bs-target="#process-cancel">Confirm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Process Cancellation Modal -->
    <div class="modal fade" id="process-cancel" tabindex="-1" aria-labelledby="process-cancellation-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" id="mheader">
                    <h1 class="modal-title" id="process-cancellation-title">Cancellation Request</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body" id="mbody-process-cancellation">
                    <p>Your cancellation request has been submitted.</p>
                    <p>We will process your request shortly.</p>
                </div>
                
                <div class="modal-footer" id="mfooter">
                    <div id="ccbuttons">
                        <button type="button" class="btn" id="confirm-but" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- View and Edit Pet Modal -->
    <div class="modal fade" id="view-and-edit" tabindex="-1" aria-labelledby="petModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" id="mheader">
                    <h1 class="modal-title" id="petModalLabel">Pet Information</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form method="POST" enctype="multipart/form-data" id="edit-pet-form">
                    <div class="modal-body">
                        <input type="hidden" id="edit_pet_id" name="pet_id">
                        <input type="hidden" id="current_pet_picture" name="current_pet_picture">
                        <input type="hidden" id="current_vaccination_card" name="current_vaccination_card">
                        
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="petName" class="form-label">Pet Name</label>
                                <input type="text" class="form-control" id="petName" name="petName" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="petSize" class="form-label">Pet Size</label>
                                <select class="form-control" id="petSize" name="petSize" required>
                                    <option value="Cat">Cat</option>
                                    <option value="Small">Small Dog</option>
                                    <option value="Medium">Medium Dog</option>
                                    <option value="Large">Large Dog</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="petBreed" class="form-label">Pet Breed</label>
                                <input type="text" class="form-control" id="petBreed" name="petBreed" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="petAge" class="form-label">Pet Age</label>
                                <input type="number" class="form-control" id="petAge" name="petAge" min="0" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="petGender" class="form-label">Pet Gender</label>
                                <select class="form-control" id="petGender" name="petGender" required>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="petPicture" class="form-label">Pet Picture</label>
                                <input type="file" class="form-control" id="petPicture" name="petPicture" accept="image/*">
                                <div class="mt-2">
                                    <img id="pet-image-preview" src="/placeholder.svg" alt="Pet Picture" style="max-width: 100px; max-height: 100px;">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="petDescription" class="form-label">Pet Description</label>
                                <textarea class="form-control" id="petDescription" name="petDescription" rows="3"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="petVaccinationDate" class="form-label">Vaccination Date</label>
                                <input type="date" class="form-control" id="petVaccinationDate" name="petVaccinationDate">
                            </div>
                            
                            <div class="form-group">
                                <label for="petVaccinationExpiry" class="form-label">Vaccination Expiry</label>
                                <input type="date" class="form-control" id="petVaccinationExpiry" name="petVaccinationExpiry">
                            </div>
                            
                            <div class="form-group">
                                <label for="petVaccinationCard" class="form-label">Vaccination Card</label>
                                <input type="file" class="form-control" id="petVaccinationCard" name="petVaccinationCard" accept="image/*">
                                <div class="mt-2">
                                    <img id="vaccination-card-preview" src="/placeholder.svg" alt="Vaccination Card" style="max-width: 100px; max-height: 100px; display: none;">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="petVaccinationStatus" class="form-label">Vaccination Status</label>
                                <select class="form-control" id="petVaccinationStatus" name="petVaccinationStatus" required>
                                    <option value="Up to date">Up to date</option>
                                    <option value="Expired">Expired</option>
                                    <option value="Not vaccinated">Not vaccinated</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="petSpecialInstruction" class="form-label">Special Instructions</label>
                                <textarea class="form-control" id="petSpecialInstruction" name="petSpecialInstruction" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer" id="mfooter">
                        <div class="form-actions">
                            <button type="button" class="btn" id="cancel-but" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn" id="confirm-but" name="update_pet">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Delete Pet Modal -->
    <div class="modal fade" id="del-modal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" id="mheader">
                    <h1 class="modal-title" id="deleteModalLabel">Delete Pet</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" id="delete_pet_id" name="pet_id">
                        <p>Are you sure you want to delete this pet's information?</p>
                        <p>This action cannot be undone.</p>
                    </div>
                    
                    <div class="modal-footer" id="mfooter">
                        <div id="ccbuttons">
                            <button type="button" class="btn" id="cancel-but" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn" id="confirm-but" name="delete_pet">Delete</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Register Pet Modal -->
    <div class="modal fade" id="reg-pet" tabindex="-1" aria-labelledby="registerPetModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" id="mheader">
                    <h1 class="modal-title" id="registerPetModalLabel">Register Pet</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="regPetName" class="form-label">Pet Name</label>
                                <input type="text" class="form-control" id="regPetName" name="petName" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="regPetSize" class="form-label">Pet Size</label>
                                <select class="form-control" id="regPetSize" name="petSize" required>
                                    <option value="Cat">Cat</option>
                                    <option value="Small">Small Dog</option>
                                    <option value="Medium">Medium Dog</option>
                                    <option value="Large">Large Dog</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="regPetBreed" class="form-label">Pet Breed</label>
                                <input type="text" class="form-control" id="regPetBreed" name="petBreed" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="regPetAge" class="form-label">Pet Age</label>
                                <input type="number" class="form-control" id="regPetAge" name="petAge" min="0" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="regPetGender" class="form-label">Pet Gender</label>
                                <select class="form-control" id="regPetGender" name="petGender" required>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="regPetPicture" class="form-label">Pet Picture</label>
                                <input type="file" class="form-control" id="regPetPicture" name="petPicture" accept="image/*">
                            </div>
                            
                            <div class="form-group">
                                <label for="regPetDescription" class="form-label">Pet Description</label>
                                <textarea class="form-control" id="regPetDescription" name="petDescription" rows="3"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="regPetVaccinationDate" class="form-label">Vaccination Date</label>
                                <input type="date" class="form-control" id="regPetVaccinationDate" name="petVaccinationDate">
                            </div>
                            
                            <div class="form-group">
                                <label for="regPetVaccinationExpiry" class="form-label">Vaccination Expiry</label>
                                <input type="date" class="form-control" id="regPetVaccinationExpiry" name="petVaccinationExpiry">
                            </div>
                            
                            <div class="form-group">
                                <label for="regPetVaccinationCard" class="form-label">Vaccination Card</label>
                                <input type="file" class="form-control" id="regPetVaccinationCard" name="petVaccinationCard" accept="image/*">
                            </div>
                            
                            <div class="form-group">
                                <label for="regPetVaccinationStatus" class="form-label">Vaccination Status</label>
                                <select class="form-control" id="regPetVaccinationStatus" name="petVaccinationStatus" required>
                                    <option value="Up to date">Up to date</option>
                                    <option value="Expired">Expired</option>
                                    <option value="Not vaccinated">Not vaccinated</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="regPetSpecialInstruction" class="form-label">Special Instructions</label>
                                <textarea class="form-control" id="regPetSpecialInstruction" name="petSpecialInstruction" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer" id="mfooter">
                        <div class="form-actions">
                            <button type="button" class="btn" id="cancel-but" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn" id="confirm-but" name="register_pet">Register</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Handle Request to Cancel modal
        document.querySelectorAll('#reqtoCancel-but').forEach(button => {
            button.addEventListener('click', function() {
                const bookingId = this.getAttribute('data-booking-id');
                document.getElementById('booking_id').value = bookingId;
            });
        });
        
        // Handle View and Edit Pet modal
        document.querySelectorAll('.view-and-edit').forEach(link => {
            link.addEventListener('click', function() {
                const petId = this.getAttribute('data-pet-id');
                
                // Fetch pet data using AJAX
                fetch(`get_pet_data.php?pet_id=${petId}`)
                    .then(response => response.json())
                    .then(pet => {
                        document.getElementById('edit_pet_id').value = pet.pet_id;
                        document.getElementById('petName').value = pet.pet_name;
                        document.getElementById('petSize').value = pet.pet_size;
                        document.getElementById('petBreed').value = pet.pet_breed;
                        document.getElementById('petAge').value = pet.pet_age;
                        document.getElementById('petGender').value = pet.pet_gender;
                        document.getElementById('petDescription').value = pet.pet_description;
                        document.getElementById('petVaccinationDate').value = pet.pet_vaccination_date_administered;
                        document.getElementById('petVaccinationExpiry').value = pet.pet_vaccination_date_expiry;
                        document.getElementById('petVaccinationStatus').value = pet.pet_vaccination_status;
                        document.getElementById('petSpecialInstruction').value = pet.pet_special_instruction;
                        
                        // Set hidden fields for current images
                        document.getElementById('current_pet_picture').value = pet.pet_picture;
                        document.getElementById('current_vaccination_card').value = pet.pet_vaccination_card;
                        
                        // Show current images
                        const petImagePreview = document.getElementById('pet-image-preview');
                        if (pet.pet_picture) {
                            petImagePreview.src = `uploads/pets/${pet.pet_picture}`;
                            petImagePreview.style.display = 'block';
                        } else {
                            petImagePreview.src = 'assets/default-pet.jpg';
                            petImagePreview.style.display = 'block';
                        }
                        
                        const vaccinationCardPreview = document.getElementById('vaccination-card-preview');
                        if (pet.pet_vaccination_card) {
                            vaccinationCardPreview.src = `uploads/vaccination/${pet.pet_vaccination_card}`;
                            vaccinationCardPreview.style.display = 'block';
                        } else {
                            vaccinationCardPreview.style.display = 'none';
                        }
                    })
                    .catch(error => console.error('Error fetching pet data:', error));
            });
        });
        
        // Handle Delete Pet modal
        document.querySelectorAll('.del').forEach(link => {
            link.addEventListener('click', function() {
                const petId = this.getAttribute('data-pet-id');
                document.getElementById('delete_pet_id').value = petId;
            });
        });
        
        // Preview uploaded images
        document.getElementById('petPicture').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('pet-image-preview').src = e.target.result;
                    document.getElementById('pet-image-preview').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
        
        document.getElementById('petVaccinationCard').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('vaccination-card-preview').src = e.target.result;
                    document.getElementById('vaccination-card-preview').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>