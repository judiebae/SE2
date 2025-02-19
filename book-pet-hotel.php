<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adorafu Happy Stay/Book/Pet Hotel</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">

    <!-- Your custom CSS -->
    <link rel="stylesheet" href="pet-hotels.css">

    <!-- jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Your custom JavaScript -->
    <script src="booking.js" defer></script>
</head>

<body>
    <div id="header">
        <?php include 'header.php'; ?>
    </div>

    <div class="main">
        <div class="main-container">
            <div class="pet-hotel-title" id="flex">PET HOTEL</div>
            <hr class="hr" id="flex">
            <div class = "content-wrapper">
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
            <div class = "main-schedule-options"> 
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
                        </div>
                        
                        <div class="pet-info dog-info">
                            <img src="Booking/reg_dog.png" alt="Regular Dog" class="reg-dog" data-selected-src="Booking/reg_dog(selected).png">
                            <h3>Regular Dog</h3>
                        </div>

                        <div class="pet-info dog-info">
                            <img src="Booking/large_dog.png" alt="Large Dog" class="large-dog" data-selected-src="Booking/large_dog(selected).png">
                            <h3>Large Dog</h3>
                        </div>
                    </div>

                    <div class="pet-information-cat">
                        <div class="pet-info cat-info">
                            <img src="Booking/reg_cat.png" alt="Cat" class="cat" data-selected-src="Booking/reg_cat(selected).png">
                            <h3>Cat</h3>
                        </div>
                    </div>
                </div>
                <div class = "checkin-out">
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
                </div>
            </div> 
        </div><!-- /.main-container -->
    </div><!-- /.main -->

    <script>
     $(document).ready(function () {
    // Hide all pet sections initially
    $(".pet-information-dog, .pet-information-cat").hide();

    // Handle pet type dropdown selection
    $("#petSelectionMenu + .dropdown-menu .dropdown-item").click(function () {
        var selectedPet = $(this).text();
        $("#petSelectionMenu").text(selectedPet);

        // Hide all pet sections first
        $(".pet-information-dog, .pet-information-cat").hide();

        // Show the appropriate section based on selection
        if (selectedPet === "Dog") {
            $(".pet-information-dog").fadeIn();
        } else if (selectedPet === "Cat") {
            $(".pet-information-cat").fadeIn();
        }
    });

    // Handle pet selection and image toggle
    let selectedPet = null;

    $(".pet-info").click(function () {
        const img = $(this).find("img");

        if (selectedPet === this) {
            $(this).removeClass("selected");
            swapImage(img);
            selectedPet = null;
        } else {
            if (selectedPet) {
                swapImage($(selectedPet).find("img"));
                $(selectedPet).removeClass("selected");
            }
            $(this).addClass("selected");
            swapImage(img);
            selectedPet = this;
        }
    });

    function swapImage(img) {
        let tempSrc = img.attr("src");
        img.attr("src", img.attr("data-selected-src"));
        img.attr("data-selected-src", tempSrc);
    }

    // Check-in dropdown functionality
    $("#checkInMenu + .dropdown-menu .dropdown-item").click(function () {
        $("#checkInMenu").text($(this).text());
    });

    // Check-out dropdown functionality
    $("#checkOutMenu + .dropdown-menu .dropdown-item").click(function () {
        $("#checkOutMenu").text($(this).text());
    });

    
});

</script>

</body>

</html>
