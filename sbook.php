<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-Time Calendar</title>
    <link rel="stylesheet" href="about.css">
</head>
<body>
    <div class="calendar">
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

    <script>
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
        let startDate = null;  // Store the first clicked day
        let endDate = null;    // Store the second clicked day
        let isSelecting = false; // Flag to track if selection is in progress

        function renderCalendar() {
            const currentYear = currentDate.getFullYear();
            const currentMonth = currentDate.getMonth();
            const today = new Date();
            const todayCopy = new Date(today);  // Create a copy to avoid modifying the original `today` object
            todayCopy.setHours(0, 0, 0, 0);  // Set time to midnight for comparison

            monthEl.textContent = months[currentMonth];
            yearEl.textContent = currentYear;

            // Get first day and number of days in month
            const firstDay = new Date(currentYear, currentMonth, 1).getDay();
            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
            
            // Clear previous days
            daysContainer.innerHTML = "";

            // Add empty spaces for first day
            for (let i = 0; i < firstDay; i++) {
                const emptyDiv = document.createElement("div");
                daysContainer.appendChild(emptyDiv);
            }

            // Generate calendar days
            for (let day = 1; day <= daysInMonth; day++) {
                const dayElement = document.createElement("div");
                dayElement.textContent = day;
                dayElement.classList.add("day");
                dayElement.setAttribute("data-day", day); // Store the day data on the element

                // Check if the day is in the past
                const thisDate = new Date(currentYear, currentMonth, day);
                if (thisDate < todayCopy) {
                    dayElement.classList.add("past-day");
                } else if (
                    day === today.getDate() &&
                    currentMonth === today.getMonth() &&
                    currentYear === today.getFullYear()
                ) {
                    dayElement.classList.add("today");
                }

                // Add click event listener to start selecting date range
                dayElement.addEventListener("click", () => {
                    // If the day is already selected, allow it to be "unclicked"
                    if (startDate === day) {
                        startDate = null;
                        dayElement.classList.remove("selected");
                        resetHighlights();
                    } else if (endDate === day) {
                        endDate = null;
                        dayElement.classList.remove("selected");
                        resetHighlights();
                    } else {
                        // Handle new selections
                        if (!startDate) {
                            startDate = day;
                            dayElement.classList.add("selected");
                        } else if (startDate && !endDate) {
                            endDate = day;
                            highlightDateRange();
                        }
                    }
                });

                daysContainer.appendChild(dayElement);
            }
        }

        // Function to reset highlights (unhighlight any selected range)
        function resetHighlights() {
            const allDays = document.querySelectorAll(".day");
            allDays.forEach(dayElement => {
                dayElement.classList.remove("highlighted", "selected");
            });
        }

        // Function to highlight date range between startDate and endDate
        function highlightDateRange() {
            const allDays = document.querySelectorAll(".day");
            let inRange = false;

            allDays.forEach(dayElement => {
                const day = parseInt(dayElement.textContent);

                if (startDate && endDate) {
                    if (day === startDate || day === endDate) {
                        // If it's the start or end day, mark it as selected
                        dayElement.classList.add("selected");
                    } else if (day > startDate && day < endDate) {
                        // Highlight days between start and end
                        dayElement.classList.add("highlighted");
                    } else {
                        // Remove highlight if not in range
                        dayElement.classList.remove("highlighted");
                    }
                }
            });
        }

        // Previous month
        prevMonthBtn.addEventListener("click", () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        });

        // Next month
        nextMonthBtn.addEventListener("click", () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        });

        // Initial render
        renderCalendar();
    </script>
</body>
</html>
