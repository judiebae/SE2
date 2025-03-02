<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adorafu Happy Stay/Book/Pet Hotel</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">

    <!-- Your custom CSS -->
    <link rel="stylesheet" href="book-pet-hotel.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Your custom JavaScript -->
    <script src="booking.js" defer></script>


</head>

<body>

    <?php include 'header.php'; ?>

    <div class="main">
        <div class="main-container">
            <div class="pet-hotel-title" id="flex">PET HOTEL</div>
            <hr class="hr" id="flex">
            <div class="content-wrapper">
                <div class="calendar" id="flex">
                    <div class="calendar-header">
                        <button id="prevMonth" class="nav-arrow">&lt;</button>
                        <div class="month-year">
                            <span id="month"></span>
                            <span id="year"></span>
                        </div>
                        <button id="nextMonth" class="nav-arrow">&gt;</button>
                    </div>
                    <div class="line"></div>
                    <div class="calendar-body">
                        <div class="weekdays">
                            <div>Sun</div>
                            <div>Mon</div>
                            <div>Tue</div>
                            <div>Wed</div>
                            <div>Thu</div>
                            <div>Fri</div>
                            <div>Sat</div>
                        </div>
                        <div id="days" class="days-grid"></div>
                    </div>
                </div>

                <!-- Booking Section -->
                <div class="main-schedule-options">
                    <div class="schedule-options">
                        <div class="available-slot" id="align-1">Available Slots</div>
                        <!-- Bootstrap Dropdown -->
                        <div class="selection-dropdown" id="align-1">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="petSelectionMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Choose Pet
                            </button>
                            <div class="dropdown-menu" aria-labelledby="petSelectionMenu">
                                <button class="dropdown-item pet-type" id="dd-item-dog" type="button">Dog</button>
                                <button class="dropdown-item pet-type" id="dd-item-cat" type="button">Cat</button>

                            </div>
                        </div>
                    </div>
                    <div class="pet-selection">
                        <div class="pet-information-dog">
                            <div class="pet-info dog-info">
                                <img src="Booking/small_dog.png" alt="Small Dog" class="small-dog" data-selected-src="Booking/small_dog(selected).png">
                                <h3>Small Dog</h3>
                                <h6>Weight: 10kg<br>
                                    ₱ 700</h6>
                            </div>

                            <div class="pet-info dog-info">
                                <img src="Booking/reg_dog.png" alt="Regular Dog" class="reg-dog" data-selected-src="Booking/reg_dog(selected).png">
                                <h3>Regular Dog</h3>
                                <h6>Weight: 26 - 40 lbs<br>
                                    ₱ 800</h6>
                            </div>

                            <div class="pet-info dog-info">
                                <img src="Booking/large_dog.png" alt="Large Dog" class="large-dog" data-selected-src="Booking/large_dog(selected).png">
                                <h3>Large Dog</h3>
                                <h6>Weight: 40 lbs and above<br>
                                    ₱ 900</h6>
                            </div>
                        </div>

                        <div class="pet-information-cat">
                            <div class="pet-info cat-info">
                                <img src="Booking/reg_cat.png" alt="Cat" class="cat" data-selected-src="Booking/reg_cat(selected).png">
                                <h3>Cat</h3>
                                <h6>Weight: 4 - 5kg<br>
                                    ₱ 500</h6>
                            </div>
                        </div>
                    </div>
                    <div class="checkin-out">
                        <div class="check-in" id="check">
                            <h3>Check In: </h3>
                            <div class="selection-dropdown-check" id="align-1">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="checkInMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Choose Time
                                </button>
                                <div class="dropdown-menu" aria-labelledby="checkInMenu">
                                    <button class="dropdown-item check-in-time" type="button">10:00 AM</button>
                                    <button class="dropdown-item check-in-time" type="button">11:00 AM</button>
                                    <button class="dropdown-item check-in-time" type="button">12:00 PM</button>
                                    <button class="dropdown-item check-in-time" type="button">1:00 PM</button>
                                    <button class="dropdown-item check-in-time" type="button">2:00 PM</button>
                                    <button class="dropdown-item check-in-time" type="button">3:00 PM</button>
                                    <button class="dropdown-item check-in-time" type="button">4:00 PM</button>
                                    <button class="dropdown-item check-in-time" type="button">5:00 PM</button>
                                    <button class="dropdown-item check-in-time" type="button">6:00 PM</button>
                                    <button class="dropdown-item check-in-time" type="button">7:00 PM</button>
                                </div>
                            </div>
                        </div>


                        <div class="check-in" id="check">
                            <h3>Check Out: </h3>
                            <div class="selection-dropdown-check" id="align-1">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="checkOutMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Choose Time
                                </button>
                                <div class="dropdown-menu" aria-labelledby="checkOutMenu">
                                    <button class="dropdown-item check-out-time" type="button">10:00 AM</button>
                                    <button class="dropdown-item check-out-time" type="button">11:00 AM</button>
                                    <button class="dropdown-item check-out-time" type="button">12:00 PM</button>
                                    <button class="dropdown-item check-out-time" type="button">1:00 PM</button>
                                    <button class="dropdown-item check-out-time" type="button">2:00 PM</button>
                                    <button class="dropdown-item check-out-time" type="button">3:00 PM</button>
                                    <button class="dropdown-item check-out-time" type="button">4:00 PM</button>
                                    <button class="dropdown-item check-out-time" type="button">5:00 PM</button>
                                    <button class="dropdown-item check-out-time" type="button">6:00 PM</button>
                                    <button class="dropdown-item check-out-time" type="button">7:00 PM</button>
                                </div>
                            </div>
                        </div>

                        <div class="book">BOOK</div>

                    </div>
                </div>
                <div class="book-1">
                    <div class="book-label">
                        <div class="client">
                            <b>Client name</b><br>
                            <span class="client-email">Client Email</span>
                        </div>
                        <div class="pet-1">
                            <div class="pets"><b>Pet/s</b></div>

                            <table class="table">
                                <thead>
                                    <tr>

                                        <th>NAME</th>
                                        <th>BREED</th>
                                        <th>AGE</th>
                                        <th>GENDER</th>
                                        <th>SIZE</th>
                                        <th>PRICE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Sample pet data array
                                    $pets = [
                                        ['name' => 'Max', 'breed' => 'Golden Retriever', 'age' => '4 years', 'gender' => 'Male', 'size' => 'Large', 'price' => '₱3500.00'],
                                        ['name' => 'Luna', 'breed' => 'Poodle', 'age' => '1.5 years', 'gender' => 'Female', 'size' => 'Medium', 'price' => '₱2500.00'],
                                        ['name' => 'Buddy', 'breed' => 'Labrador', 'age' => '3 years', 'gender' => 'Male', 'size' => 'Large', 'price' => '₱3000.00'],
                                        ['name' => 'Daisy', 'breed' => 'Beagle', 'age' => '2 years', 'gender' => 'Female', 'size' => 'Small', 'price' => '₱2000.00'],
                                        ['name' => 'Rocky', 'breed' => 'Bulldog', 'age' => '5 years', 'gender' => 'Male', 'size' => 'Medium', 'price' => '₱4000.00'],
                                    ];

                                    // Generate table rows
                                    foreach ($pets as $pet) {
                                        echo "<tr>";

                                        echo "<td data-label='Name'>{$pet['name']}</td>";
                                        echo "<td data-label='Breed'>{$pet['breed']}</td>";
                                        echo "<td data-label='Age'>{$pet['age']}</td>";
                                        echo "<td data-label='Gender'>{$pet['gender']}</td>";
                                        echo "<td data-label='Size'>{$pet['size']}</td>";
                                        echo "<td data-label='Price'>{$pet['price']}</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <div class="lower-section">
                                <button type="button" class="btn" id="regPet" data-bs-toggle="modal" data-bs-target="#petRegistrationModal">
                                    <h6 class="regnewpet" style="font-weight: 600;">Need to register new pet?</h6>
                                </button>

                                <div class="modal fade" id="petRegistrationModal" data-backdrop="static" data-keyboard="false" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex justify-content-center align-items-center" id="modalHeader">
                                                <h1 class="modal-title" id="modalTitle">Register Your Pet</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" id="modalBody">
                                                <div class="pet-registration-form">
                                                    <form class="pet-form" method="post" enctype="multipart/form-data">
                                                        <div class="container-fluid p-0">
                                                            <div class="row">
                                                                <!-- Left Column -->
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="petName" class="form-label">Pet Name</label>
                                                                        <input type="text" id="petName" name="pet_name" class="form-control" required>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label class="form-label">Pet Size</label>
                                                                        <div class="radio-group">
                                                                            <div>
                                                                                <input type="radio" name="pet_size" id="sizeSmallDog" value="small_dog">
                                                                                <label for="sizeSmallDog">Small Dog</label>
                                                                            </div>
                                                                            <div>
                                                                                <input type="radio" name="pet_size" id="sizeLargeDog" value="large_dog">
                                                                                <label for="sizeLargeDog">Large Dog</label>
                                                                            </div>
                                                                            <div>
                                                                                <input type="radio" name="pet_size" id="sizeRegularDog" value="regular_dog">
                                                                                <label for="sizeRegularDog">Regular Dog</label>
                                                                            </div>
                                                                            <div>
                                                                                <input type="radio" name="pet_size" id="sizeRegularCat" value="regular_cat">
                                                                                <label for="sizeRegularCat">Regular Cat</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="petBreed" class="form-label">Breed</label>
                                                                        <input type="text" id="petBreed" name="breed" class="form-control" placeholder="Type Breed Here">
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="petAge" class="form-label">Age</label>
                                                                        <input type="text" id="petAge" name="age" class="form-control" placeholder="Type Age Here">
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label class="form-label">Gender</label>
                                                                        <div class="radio-group">
                                                                            <div>
                                                                                <input type="radio" name="gender" id="genderMale" value="male">
                                                                                <label for="genderMale">Male</label>
                                                                            </div>
                                                                            <div>
                                                                                <input type="radio" name="gender" id="genderFemale" value="female">
                                                                                <label for="genderFemale">Female</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="petDescription" class="form-label">Description</label>
                                                                        <textarea id="petDescription" name="description" class="form-control" placeholder="e.g., White Spots" rows="3"></textarea>
                                                                    </div>
                                                                </div>

                                                                <!-- Right Column -->
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="petProfilePhoto" class="form-label">Pet Profile Photo</label>
                                                                        <input type="file" id="petProfilePhoto" name="pet_photo" class="form-control" accept="image/*,application/pdf">
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label class="form-label">Vaccination Status</label>
                                                                        <input type="file" name="vaccination_file" class="form-control mb-2" accept="image/*,application/pdf">
                                                                        <div class="radio-group">
                                                                            <div>
                                                                                <input type="radio" name="vaccination_status" id="vaccinatedYes" value="vaccinated">
                                                                                <label for="vaccinatedYes">Vaccinated</label>
                                                                            </div>
                                                                            <div>
                                                                                <input type="radio" name="vaccination_status" id="vaccinatedNo" value="not_vaccinated">
                                                                                <label for="vaccinatedNo">Not Vaccinated</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="dateAdministered" class="form-label">Date Administered</label>
                                                                        <input type="date" id="dateAdministered" name="date_administered" class="form-control">
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="expiryDate" class="form-label">Expiry Date</label>
                                                                        <input type="date" id="expiryDate" name="expiry_date" class="form-control">
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="specialInstructions" class="form-label">Special Instructions</label>
                                                                        <textarea id="specialInstructions" name="special_instructions" class="form-control" placeholder="e.g., Medications" rows="3"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row mt-3">
                                                                <div class="col-12 text-center">
                                                                    <button type="submit" class="btn" id="saveButton">Save and Go Back</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Payment Modal -->
                                <!-- Payment Modal Button -->
                                <div class="proctopayment">
                                    <button type="button" class="btn payment-btn" data-bs-toggle="modal" data-bs-target="#petPaymentModal">
                                        Proceed to Payment
                                    </button>
                                </div>

                                <!-- Payment Modal -->
                                <div class="modal fade" id="petPaymentModal" tabindex="-1" aria-labelledby="petPaymentModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-body p-0">
                                                <div class="payment-modal-content">
                                                    <h1>Let's Seal the Deal!</h1>
                                                    <p class="subtitle">To finalize your pet's stay, please scan the QR code below to securely process your payment.</p>

                                                    <div class="modal-grid">
                                                        <div class="details-section">
                                                            <p class="transaction-no">Transaction No. 4565789</p>
                                                            <h2 class="pet-name">Good Boi</h2>
                                                            <p class="dates">October 5, 12:00 NN - 6:00 PM</p>

                                                            <div class="info-grid">
                                                                <div class="info-row"><span class="label">Service:</span><span class="value">Pet Daycare</span></div>
                                                                <div class="info-row"><span class="label">Breed:</span><span class="value">Shih Tzu</span></div>
                                                                <div class="info-row"><span class="label">Gender:</span><span class="value">Male</span></div>
                                                                <div class="info-row"><span class="label">Age:</span><span class="value">7 years old</span></div>
                                                                <div class="info-row"><span class="label">Owner:</span><span class="value">Jude Emmanuel Flores</span></div>
                                                                <div class="info-row"><span class="label">Amount to pay:</span><span class="value">₱ 250.00</span></div>
                                                                <div class="info-row"><span class="label">Remaining Balance:</span><span class="value">₱ 250.00</span></div>
                                                            </div>

                                                            <form method="POST" enctype="multipart/form-data">
                                                                <div class="payment-section">
                                                                    <p class="section-label">Mode of Payment</p>
                                                                    <div class="radio-group">
                                                                        <label><input type="radio" name="payment_method" value="Maya" checked> <span>Maya</span></label>
                                                                        <label><input type="radio" name="payment_method" value="GCash"> <span>GCash</span></label>
                                                                    </div>

                                                                    <p class="section-label">Reference No. of Your Payment</p>
                                                                    <input type="text" name="reference_no" placeholder="Enter Reference Number" class="reference-input" required>

                                                                    <p class="section-label">Proof of Payment</p>
                                                                    <input type="file" name="payment_proof" accept="image/*" required>
                                                                </div>

                                                                
                                                            </form>
                                                        </div>

                                                        <div class="qr-section">
                                                            <div class="qr-codes">
                                                                <img src="gcash.png" alt="GCash QR Code" class="qr-code">
                                                                <img src="maya.png" alt="Maya QR Code" class="qr-code">
                                                            </div>
                                                            <p class="qr-instruction">We accept bank transfer to our GCash/Maya account or just scan the QR Code!</p>
                                                            <div class="account-info">
                                                                <p>Account Number: <span>987654321</span></p>
                                                                <p>Account Name: <span>Veatrice Delos Santos</span></p>
                                                            </div>
                                                            <button type="submit" class="action-btn" style = "margin-bottom: 100px;">Complete Booking</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- /.main-container -->
        </div><!-- /.main -->

        <script>
            $(document).ready(function() {
                $(".pet-information-dog, .pet-information-cat").hide();
                $(".pet-info h3, .pet-info h6").hide();

                $("#petSelectionMenu + .dropdown-menu .dropdown-item").click(function() {
                    var selectedPet = $(this).text();
                    $("#petSelectionMenu").text(selectedPet);
                    $(".pet-information-dog, .pet-information-cat").hide();
                    if (selectedPet === "Dog") $(".pet-information-dog").fadeIn();
                    else if (selectedPet === "Cat") $(".pet-information-cat").fadeIn();
                });

                let selectedPet = null;
                $(".pet-info").hover(
                    function() {
                        $(this).find("h3, h6").fadeIn();
                    },
                    function() {
                        if (!$(this).hasClass("selected")) $(this).find("h3, h6").fadeOut();
                    }
                );

                $(".pet-info").click(function() {
                    const img = $(this).find("img");
                    if (selectedPet === this) {
                        $(this).removeClass("selected");
                        swapImage(img);
                        $(this).find("h3, h6").fadeOut();
                        selectedPet = null;
                    } else {
                        if (selectedPet) {
                            swapImage($(selectedPet).find("img"));
                            $(selectedPet).removeClass("selected");
                            $(selectedPet).find("h3, h6").fadeOut();
                        }
                        $(this).addClass("selected");
                        swapImage(img);
                        $(this).find("h3, h6").fadeIn();
                        selectedPet = this;
                    }
                });

                function swapImage(img) {
                    let tempSrc = img.attr("src");
                    img.attr("src", img.attr("data-selected-src"));
                    img.attr("data-selected-src", tempSrc);
                }

                $(".check-in-time").click(function() {
                    $("#checkInMenu").text($(this).text());
                });
                $(".check-out-time").click(function() {
                    $("#checkOutMenu").text($(this).text());
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                $(".pet-information-dog, .pet-information-cat").hide();
                $(".pet-info h3, .pet-info h6").hide();

                $("#petSelectionMenu + .dropdown-menu .dropdown-item").click(function() {
                    var selectedPet = $(this).text();
                    $("#petSelectionMenu").text(selectedPet);
                    $(".pet-information-dog, .pet-information-cat").hide();
                    if (selectedPet === "Dog") $(".pet-information-dog").fadeIn();
                    else if (selectedPet === "Cat") $(".pet-information-cat").fadeIn();
                });

                let selectedPet = null;
                $(".pet-info").hover(
                    function() {
                        $(this).find("h3, h6").fadeIn();
                    },
                    function() {
                        if (!$(this).hasClass("selected")) $(this).find("h3, h6").fadeOut();
                    }
                );

                $(".pet-info").click(function() {
                    const img = $(this).find("img");
                    if (selectedPet === this) {
                        $(this).removeClass("selected");
                        swapImage(img);
                        $(this).find("h3, h6").fadeOut();
                        selectedPet = null;
                    } else {
                        if (selectedPet) {
                            swapImage($(selectedPet).find("img"));
                            $(selectedPet).removeClass("selected");
                            $(selectedPet).find("h3, h6").fadeOut();
                        }
                        $(this).addClass("selected");
                        swapImage(img);
                        $(this).find("h3, h6").fadeIn();
                        selectedPet = this;
                    }
                });

                function swapImage(img) {
                    let tempSrc = img.attr("src");
                    img.attr("src", img.attr("data-selected-src"));
                    img.attr("data-selected-src", tempSrc);
                }

                $(".check-in-time").click(function() {
                    $("#checkInMenu").text($(this).text());
                });
                $(".check-out-time").click(function() {
                    $("#checkOutMenu").text($(this).text());
                });

                // Handle Book button click
                $(".book").click(function() {
                    $(".main-schedule-options").fadeOut(function() {
                        $(".book-1").fadeIn();
                    });
                });

                // Ensure book-1 is initially hidden
                $(".book-1").hide();
            });
        </script>
</body>

</html>