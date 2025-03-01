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
    <link rel="stylesheet" href="Profiler.css">
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

                            <div class = "lower-section">               
                                <div class="newpet">
                                    <button type="button" class="btn" id="regPet" data-bs-toggle="modal" data-bs-target="#regPetModal">
                                        <h6 class="regnewpet">Need to register new pet?</h6>
                                    </button>
                                </div>
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
                                                                        <label for="pet_name" class="form-label">NAME</label>
                                                                        <input type="text" id="pet_name" name="pet_name" class="form-control" required>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label class="form-label">PET SIZE</label>
                                                                        <div class="radio-group">
                                                                            <div>
                                                                                <input type="radio" name="pet_size" id="small_dog" value="small_dog">
                                                                                <label for="small_dog">Small Dog</label>
                                                                            </div>
                                                                            <div>
                                                                                <input type="radio" name="pet_size" id="large_dog" value="large_dog">
                                                                                <label for="large_dog">Large Dog</label>
                                                                            </div>
                                                                            <div>
                                                                                <input type="radio" name="pet_size" id="regular_dog" value="regular_dog">
                                                                                <label for="regular_dog">Regular Dog</label>
                                                                            </div>
                                                                            <div>
                                                                                <input type="radio" name="pet_size" id="regular_cat" value="regular_cat">
                                                                                <label for="regular_cat">Regular Cat</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="breed" class="form-label">BREED</label>
                                                                        <input type="text" id="breed" name="breed" class="form-control" placeholder="Type Breed Here">
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="age" class="form-label">AGE</label>
                                                                        <input type="text" id="age" name="age" class="form-control" placeholder="Type Age Here">
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label class="form-label">GENDER</label>
                                                                        <div class="radio-group">
                                                                            <div>
                                                                                <input type="radio" name="gender" id="male" value="male">
                                                                                <label for="male">Male</label>
                                                                            </div>
                                                                            <div>
                                                                                <input type="radio" name="gender" id="female" value="female">
                                                                                <label for="female">Female</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="petDescription" class="form-label">DESCRIPTION</label>
                                                                        <textarea id="petDescription" name="description" class="form-control" placeholder="e.x. White Spots" rows="3"></textarea>
                                                                    </div>
                                                                </div>

                                                                <!-- Right Column -->
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="pet_photo" class="form-label">PET PROFILE PHOTO</label>
                                                                        <input type="file" id="pet_photo" name="pet_photo" class="form-control" accept="image/*,application/pdf">
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
                                                                        <label for="date_administered" class="form-label">DATE ADMINISTERED</label>
                                                                        <input type="date" id="date_administered" name="date_administered" class="form-control">
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="expiry_date" class="form-label">EXPIRY DATE</label>
                                                                        <input type="date" id="expiry_date" name="expiry_date" class="form-control">
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="petInstruction" class="form-label">SPECIAL INSTRUCTIONS</label>
                                                                        <textarea id="petInstruction" name="special_instructions" class="form-control" placeholder="e.x. Medications" rows="3"></textarea>
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

                                <div class = proctopayment>
                                    <div class="payment">Proceed to payment</div>
                                    
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