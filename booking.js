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
        } else if (day > startDate) {
            // Set endDate and highlight range
            endDate = day;
            highlightDateRange();
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

    // Change months
    prevMonthBtn.addEventListener("click", () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });

    nextMonthBtn.addEventListener("click", () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });

    // Initial render
    renderCalendar();
});
