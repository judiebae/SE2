document.addEventListener("DOMContentLoaded", function () {
    const monthEl = document.getElementById("month");
    const yearEl = document.getElementById("year");
    const daysContainer = document.getElementById("days");
    const prevMonthBtn = document.getElementById("prevMonth");
    const nextMonthBtn = document.getElementById("nextMonth");

    const months = [
        "JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE",
        "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER"
    ];

    let currentDate = new Date();
    let startDate = null;
    let endDate = null;

    function renderCalendar() {
        const currentYear = currentDate.getFullYear();
        const currentMonth = currentDate.getMonth();
        const today = new Date();
        today.setHours(0, 0, 0, 0); // Normalize time

        monthEl.textContent = months[currentMonth];
        yearEl.textContent = currentYear;

        // Get first day of month & number of days
        const firstDay = new Date(currentYear, currentMonth, 1).getDay();
        const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

        // Clear previous content
        daysContainer.innerHTML = "";

        // Add empty placeholders before first day
        for (let i = 0; i < firstDay; i++) {
            const emptyDiv = document.createElement("div");
            emptyDiv.classList.add("empty");
            daysContainer.appendChild(emptyDiv);
        }

        // Generate days
        for (let day = 1; day <= daysInMonth; day++) {
            const dayElement = document.createElement("div");
            dayElement.textContent = day;
            dayElement.classList.add("day");
            dayElement.setAttribute("data-day", day);
            
            // Store full date for booking purposes (YYYY-MM-DD format)
            const fullDate = `${currentYear}-${(currentMonth + 1).toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
            dayElement.setAttribute("data-date", fullDate);

            const thisDate = new Date(currentYear, currentMonth, day);
            if (thisDate < today) {
                dayElement.classList.add("past-day"); // Disable past days
            } else if (
                day === today.getDate() &&
                currentMonth === today.getMonth() &&
                currentYear === today.getFullYear()
            ) {
                dayElement.classList.add("today");
            }

            // Handle selection
            dayElement.addEventListener("click", () => handleDateSelection(day, dayElement));

            daysContainer.appendChild(dayElement);
        }

        // Reapply highlights after re-rendering (optional)
        applyHighlights();
    }

    function handleDateSelection(day, dayElement) {
        const selectedDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), day);
        if (selectedDate < new Date().setHours(0, 0, 0, 0)) return; // Prevent past selection

        if (!startDate || (startDate && endDate)) {
            // Reset selection
            startDate = day;
            endDate = null;
            resetHighlights();
            dayElement.classList.add("selected-date");
            
            // Update the summary in the payment modal
            updateBookingSummary();
        } else if (day > startDate) {
            // Set endDate and highlight range
            endDate = day;
            highlightDateRange();
            
            // Update the summary in the payment modal
            updateBookingSummary();
        }
    }

    function resetHighlights() {
        document.querySelectorAll(".day").forEach(day => {
            day.classList.remove("highlighted", "selected-date");
        });
    }

    function highlightDateRange() {
        document.querySelectorAll(".day").forEach(dayElement => {
            const day = parseInt(dayElement.textContent);

            if (startDate && endDate) {
                if (day === startDate || day === endDate) {
                    dayElement.classList.add("selected-date");
                } else if (day > startDate && day < endDate) {
                    dayElement.classList.add("highlighted");
                }
            }
        });
    }

    function applyHighlights() {
        document.querySelectorAll(".day").forEach(dayElement => {
            const day = parseInt(dayElement.textContent);
            if (startDate && day === startDate) {
                dayElement.classList.add("selected-date");
            }
            if (endDate && day === endDate) {
                dayElement.classList.add("selected-date");
            }
            if (startDate && endDate && day > startDate && day < endDate) {
                dayElement.classList.add("highlighted");
            }
        });
    }
    
    function updateBookingSummary() {
        // First check if elements exist
        const summaryDates = document.getElementById("summaryDates");
        if (!summaryDates) return;
        
        // Get check-in and check-out times
        const checkInTime = document.getElementById("checkInMenu").textContent.trim();
        const checkOutTime = document.getElementById("checkOutMenu").textContent.trim();
        
        if (checkInTime === "Choose Time" || checkOutTime === "Choose Time") return;
        
        // Format the dates for display
        const startMonth = months[currentDate.getMonth()];
        const endMonth = months[currentDate.getMonth()]; // Same month for simplicity
        
        // Create formatted date string
        let dateString = "";
        if (startDate && !endDate) {
            dateString = `${startMonth} ${startDate}, ${checkInTime} - ${checkOutTime}`;
        } else if (startDate && endDate) {
            dateString = `${startMonth} ${startDate} - ${endMonth} ${endDate}, ${checkInTime} - ${checkOutTime}`;
        }
        
        // Update the summary text
        if (dateString) {
            summaryDates.textContent = dateString;
        }
    }

    // Change months
    prevMonthBtn.addEventListener("click", () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });

    nextMonthBtn.addEventListener("click", () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });
    
    // Update booking summary when a pet is selected
    document.addEventListener("petSelected", function(e) {
        const summaryPetName = document.getElementById("summaryPetName");
        const summaryBreed = document.getElementById("summaryBreed");
        const summaryGender = document.getElementById("summaryGender");
        const summaryAge = document.getElementById("summaryAge");
        
        if (summaryPetName && e.detail.name) {
            summaryPetName.textContent = e.detail.name;
        }
        
        if (summaryBreed && e.detail.breed) {
            summaryBreed.textContent = e.detail.breed;
        }
        
        if (summaryGender && e.detail.gender) {
            summaryGender.textContent = e.detail.gender;
        }
        
        if (summaryAge && e.detail.age) {
            summaryAge.textContent = e.detail.age + " years old";
        }
    });
    
    // Listen for payment method changes
    document.addEventListener('change', function(e) {
        // If the changed element is a payment method radio button
        if (e.target.name === 'payment_method') {
            // Show the appropriate QR code
            const gcashQR = document.getElementById('gcashQR');
            const mayaQR = document.getElementById('mayaQR');
            
            if (gcashQR && mayaQR) {
                if (e.target.value === 'GCash') {
                    gcashQR.style.display = 'block';
                    mayaQR.style.display = 'none';
                } else if (e.target.value === 'Maya') {
                    gcashQR.style.display = 'none';
                    mayaQR.style.display = 'block';
                }
            }
        }
    });

    // Initial render
    renderCalendar();
    
    // Initial state for QR codes (show Maya by default)
    const gcashQR = document.getElementById('gcashQR');
    const mayaQR = document.getElementById('mayaQR');
    if (gcashQR && mayaQR) {
        gcashQR.style.display = 'none';
        mayaQR.style.display = 'block';
    }
    
    // Trigger pet selection event when a pet is chosen from dropdown
    // Declare $ if it's not already in scope
    const $ = jQuery;

    $(document).on('change', '.petSelect', function() {
        const selectedOption = $(this).find('option:selected');
        const petName = selectedOption.text();
        
        if (petName && petName !== "Choose Pet") {
            // Get pet details from the JSON
            const petDetails = JSON.parse($(this).val());
            
            // Create a custom event with pet details
            const event = new CustomEvent('petSelected', {
                detail: {
                    name: petName,
                    breed: petDetails.pet_breed,
                    gender: petDetails.pet_gender,
                    age: petDetails.pet_age
                }
            });
            
            // Dispatch the event
            document.dispatchEvent(event);
        }
    });
});

