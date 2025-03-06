document.addEventListener("DOMContentLoaded", function () {
    const monthEl = document.getElementById("month");
    const yearEl = document.getElementById("year");
    const daysContainer = document.getElementById("days");
    const prevMonthBtn = document.getElementById("prevMonth");
    const nextMonthBtn = document.getElementById("nextMonth");
    const bookButton = document.querySelector(".book"); // Assuming you have a book button in your HTML

    const months = [
        "JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE",
        "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER"
    ];

    let currentDate = new Date();
    let selectedDate = null; // Only one date can be selected

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
    }

    function handleDateSelection(day, dayElement) {
        const thisDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), day);
        if (thisDate < new Date().setHours(0, 0, 0, 0)) return; // Prevent past selection

        // Reset previous selection
        if (selectedDate) {
            selectedDate.classList.remove("selected-date");
        }

        // Highlight the newly selected date
        selectedDate = dayElement;
        selectedDate.classList.add("selected-date");

        // Enable the book button if a date is selected
        bookButton.classList.remove("disabled-section");
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