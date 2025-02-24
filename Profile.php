<?php

session_start();
include("connect.php");

// After including connect.php
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User is not logged in.");
}

$user_id = $_SESSION['user_id'];
echo "User ID: " . $user_id . "<br>";

// Execute the query
$customer_info = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
if (!$customer_info) {
    die("Query failed: " . mysqli_error($conn));
}

// Fetch the results
$fetch_cust_info = mysqli_fetch_assoc($customer_info);
if (!$fetch_cust_info) {
    die("No user found with ID: " . $user_id);
}

// Display the fetched data
echo "<pre>";
print_r($fetch_cust_info);
echo "</pre>";

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Profilers.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>
<body>
<?php 
    include 'header.php';
    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0) {
        $user_id = $_SESSION['user_id'];
        $customer_info = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
        if ($customer_info) {
            $fetch_cust_info = mysqli_fetch_assoc($customer_info);
            if (!$fetch_cust_info) {
                echo "No user found with ID: " . $user_id;
            }
        } else {
            echo "Query failed: " . mysqli_error($conn);
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
                        <button type="button" class="btn" id="ve-but" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                            <i class="fa-regular fa-pen-to-square edit-icon"></i>
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered">
                            <div class="modal-content">
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
                                        <input type="text" class="form-control" name="address" value="<?php echo $address; ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">SOCIALS</label>
                                        <input type="url" class="form-control" name="socials" value="<?php echo $socials; ?>">
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
                    <!-- Notification Bell -->
                    <div class="notifBell">
                        <i class="fa-regular fa-bell notif-icon"></i>
                    </div>      
                </div>

                <div class="user-deets">
                    <div class="pfp">
                        <img src="Profile-Pics/profile_icon.png" alt="" class="profile-icon">
                        <h6 class="cusID">CUSTOMER ID</h6>
                        <h6 class="cusNum">NO. ######</h6>
                        <h6 class="cusMem">Regular</h6>
                    </div>

                    <div class="deets">
                        <div class="name">
                            <div class="deet1">
                                <p class="deet">FIRST NAME <strong><?php echo $fetch_cust_info['first_name']?> </strong> </p>                     
                                <hr class="hline">
                                <p class="deet">CONTACT NUMBER <strong><?php echo $fetch_cust_info['contact_number']?> </strong> </p>                     
                                <hr class="hline">
                            </div>
                            <div class="deet2">
                                <p class="deet">LAST NAME <strong><?php echo $fetch_cust_info['last_name']?> </strong> </p>                                            
                                <hr class="hline">
                                <p class="deet">EMAIL <strong><?php echo $fetch_cust_info['email']?></strong> </p>  
                                <hr class="hline">
                            </div>
                        </div>
                        
                        <div class="deet3">
                            <p class="deet">ADDRESS <strong><?php echo isset($fetch_cust_info['address']) ? htmlspecialchars($fetch_cust_info['address']) : 'N/A'; ?> </strong> </p>                         
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
                                            <h6 class="tStatus">Ongoing</h6>

                                            <div class="tDeets1">
                                                <div class="tDeets1-1">
                                                    <p class="tpetname">DOG NAME</p>
                                                </div>

                                                <div class="tDeets1-2">
                                                    <p class="price">Php 0000.00</p>
                                                </div>
                                            </div>

                                            <div class="tDeets2">
                                            <div class="tDeets2-1">
                                                    <p class="tservice">Pet Hotel</p>
                                                    <p class="tId">Transaction ID NO </p>
                                                    <p class="tDate">October </p>

                                                </div>

                                                <div class="tDeets2-2">
                                                        <button class="btn" data-bs-target="#req-to-cancel-modal" data-bs-toggle="modal" id="reqtoCancel-but">Request to Cancel</button>
                                                            <div class="modal fade" id="req-to-cancel-modal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                                <div class="modal-content">
                                                                <div class="modal-header" id="mheader">
                                                                    <h1 class="modal-title fs-5" id="req-to-cancel-title">Are you sure you want to cancel?</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body" id="mbody-req-to-cancel">
                                                                    <div class="mbody-text">
                                                                        <p id="req-to-cancel-mbody-text"> We're sorry to see you go! Please confirm if you'd like to cancel your booking. 
                                                                        If you need assistance, feel free to reach out to us. </p>
                                                                        
                                                                            <input type="radio" name="reason" id="ChangeOfPlans"> Change of Plans
                                                                            <input type="radio" name="reason" id="PersonalEmergency"> Personal Emergecy
                                                                            <input type="radio" name="reason" id="SchedulingConflict"> Scheduling Conflict
                                                                            <input type="radio" name="reason" id="DissatisfactionWithServices"> Dissatisfaction with Services
                                                                            <div class="reason4">
                                                                                <input type="radio" name="reason" id="Others"> Other Specify: 
                                                                                    <textarea class="form-control" id="message-text"></textarea>
                                                                            </div>
                                                                        <!-- </ul> -->
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer d-flex justify-content-center align-items-center" id="mfooter">
                                                                    <button class="btn" data-bs-target="#process-cancellation" data-bs-toggle="modal" id="confirm-but">Proceed to Cancel</button>
                                                                </div>
                                                                </div>
                                                            </div>
                                                            </div>
                                                            <div class="modal fade" id="process-cancellation" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                <div class="modal-header" id="mheader">
                                                                    <h1 class="modal-title fs-5" id="process-cancellation-title">Your Cancellation is Being Processed</h1>
                                                                </div>
                                                                <div class="modal-body" id="mbody-process-cancellation">
                                                                    We’re processing your refund now. Kindly wait a moment, and we’ll notify you once it's complete. 
                                                                    Thank you for your patience!</div>
                                                                <div class="modal-footer d-flex justify-content-center align-items-center" id="mfooter">
                                                                    <button type="button" class="btn" data-bs-dismiss="modal" id="confirm-but">Confirm</button>
                                                                    <button type="button" class="btn" data-bs-dismiss="modal" id="cancel-but">Cancel</button>
                                                                </div>
                                                                </div>
                                                            </div>
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

                            <tbody>
                                <tr>
                                    <td class="rhBody">
                                    <h6 class="tStatus">Ongoing</h6>
                                    <p class="tpetname">DOG NAME</p> 
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>   
                </div>
            </div>

            <div class="col-right">
                <h6 class="pbi"> PET INFORMATION</h6>
                

                <div class="petDeets">
                    <div class="petImg">
                        <img src="Profile-Pics/pet_icon.png" alt="" class="pet-icon">
                    </div>
                    <div class="petInfo">
                        <p class="petname">DOG NAME</p> 
                        <p class="petdesc">Sex, Breed, Age</p>
                        <div class="actions">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn" id="ve" data-bs-toggle="modal" data-bs-target="#veModal">
                                <p class="view-and-edit">View & Edit</p>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="veModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-xl">
                                    <div class="modal-content">
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

                                <!-- Button trigger modal -->
                                <button type="button" class="btn" id="delbut"  data-bs-toggle="modal" data-bs-target="#delModal">
                                <p class="del">Delete</p>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="delModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
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
                        </div>

                    </div>
                </div>


                <div class="rPet">
                    <button type="button" class="btn" id="regPet" data-bs-toggle="modal" data-bs-target="#regPetModal">
                        <h6 class="regPet">Need to register new pet?</h6>
                    </button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="regPetModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-xl">
                                    <div class="modal-content">
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
                                                                <input type="radio" name="pet_size" id="regular_cat" value="regular_cat">
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
                                </div>

            </div>
        </section>
    </div>
</body>
</html>