$(document).ready(function () {
    let selectedPet = null;
    let selectedDate = null;

    // Initially hide pet info and disable sections
    $(".pet-information-dog, .pet-information-cat").hide();
    $(".pet-info h3, .pet-info h6").hide();
    $(".calendar, .checkin-out, .book").addClass("disabled-section");

    console.log("Page loaded. Waiting for pet selection...");

    // Handle pet selection from dropdown
    $("#petSelectionMenu + .dropdown-menu .dropdown-item").click(function () {
        var selectedPetType = $(this).text();

        console.log("Pet selected:", selectedPetType);

        // Update button text
        $("#petSelectionMenu").text(selectedPetType);

        // Hide all pet information first
        $(".pet-information-dog, .pet-information-cat").hide();

        // Show the selected pet's information
        if (selectedPetType === "Dog") {
            $(".pet-information-dog").fadeIn();
        } else if (selectedPetType === "Cat") {
            $(".pet-information-cat").fadeIn();
        }

        // Enable calendar when a pet is selected
        $(".calendar").removeClass("disabled-section");

        // Store selection via AJAX
        $.ajax({
            type: "POST",
            url: window.location.href,
            data: { pet_type: selectedPetType },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    console.log(response.message);
                }
            },
            error: function () {
                console.log("Error sending pet selection via AJAX.");
            }
        });
    });

    // Handle pet selection within pet-info section
    $(".pet-info").click(function () {
        const img = $(this).find("img");

        if (selectedPet === this) {
            // Deselect pet
            $(this).removeClass("selected");
            swapImage(img);
            $(this).find("h3, h6").fadeOut();
            selectedPet = null;

            // Disable calendar when no pet is selected
            $(".calendar").addClass("disabled-section");

            console.log("Pet deselected. Calendar disabled.");
        } else {
            // Deselect previous pet
            if (selectedPet) {
                swapImage($(selectedPet).find("img"));
                $(selectedPet).removeClass("selected");
                $(selectedPet).find("h3, h6").fadeOut();
            }

            // Select new pet
            $(this).addClass("selected");
            swapImage(img);
            $(this).find("h3, h6").fadeIn();
            selectedPet = this;

            // Enable calendar
            $(".calendar").removeClass("disabled-section");

            console.log("Pet selected. Calendar enabled.");
        }
    });

    // Function to swap images
    function swapImage(img) {
        let tempSrc = img.attr("src");
        img.attr("src", img.attr("data-selected-src"));
        img.attr("data-selected-src", tempSrc);
    }

    // Handle date selection
    $(document).on("click", ".days-grid .day:not(.disabled)", function () {
        if ($(".calendar").hasClass("disabled-section")) return;

        console.log("Date selected:", $(this).data("date"));

        // Deselect previous date
        $(".days-grid .day").removeClass("selected");

        // Select new date
        $(this).addClass("selected");
        selectedDate = $(this).data("date");

        // Enable time selection
        $(".checkin-out").removeClass("disabled-section");

        // Store selected date via AJAX
        $.ajax({
            type: "POST",
            url: window.location.href,
            data: { selected_date: selectedDate },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    console.log(response.message);
                }
            },
            error: function () {
                console.log("Error sending date selection via AJAX.");
            }
        });
    });

    // Handle check-in and check-out time selection
    let checkInSelected = false;
    let checkOutSelected = false;

    $(".check-in-time").click(function () {
        if ($(".checkin-out").hasClass("disabled-section")) return;

        $("#checkInMenu").text($(this).text());
        checkInSelected = true;
        updateBookButton();

        console.log("Check-in time selected:", $(this).text());

        $.ajax({
            type: "POST",
            url: window.location.href,
            data: { check_in_time: $(this).text() },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    console.log(response.message);
                }
            },
            error: function () {
                console.log("Error sending check-in time via AJAX.");
            }
        });
    });

    $(".check-out-time").click(function () {
        if ($(".checkin-out").hasClass("disabled-section")) return;

        $("#checkOutMenu").text($(this).text());
        checkOutSelected = true;
        updateBookButton();

        console.log("Check-out time selected:", $(this).text());

        $.ajax({
            type: "POST",
            url: window.location.href,
            data: { check_out_time: $(this).text() },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    console.log(response.message);
                }
            },
            error: function () {
                console.log("Error sending check-out time via AJAX.");
            }
        });
    });

    function updateBookButton() {
        if (checkInSelected && checkOutSelected) {
            $(".book").removeClass("disabled-section");
            console.log("Both times selected. Book button enabled.");
        } else {
            console.log("Waiting for both times to be selected...");
        }
    }

    // Initialize sections based on PHP variables
    <?php if ($petSelected): ?>
        $(".calendar").removeClass("disabled-section");
    <?php endif; ?>

    <?php if ($dateSelected): ?>
        $(".checkin-out").removeClass("disabled-section");
    <?php endif; ?>

    <?php if ($timeSelected): ?>
        $(".book").removeClass("disabled-section");
    <?php endif; ?>
});
