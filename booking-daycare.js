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
    let selectedDate = null;

    function renderCalendar() {
        const currentYear = currentDate.getFullYear();
        const currentMonth = currentDate.getMonth();
        const today = new Date();
        today.setHours(0, 0, 0, 0); 

        monthEl.textContent = months[currentMonth];
        yearEl.textContent = currentYear;

        const firstDay = new Date(currentYear, currentMonth, 1).getDay();
        const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

        daysContainer.innerHTML = "";

        for (let i = 0; i < firstDay; i++) {
            const emptyDiv = document.createElement("div");
            emptyDiv.classList.add("empty");
            daysContainer.appendChild(emptyDiv);
        }

        for (let day = 1; day <= daysInMonth; day++) {
            const dayElement = document.createElement("div");
            dayElement.textContent = day;
            dayElement.classList.add("day");
            dayElement.setAttribute("data-day", day);

            const thisDate = new Date(currentYear, currentMonth, day);
            if (thisDate < today) {
                dayElement.classList.add("past-day");
            } else if (
                day === today.getDate() &&
                currentMonth === today.getMonth() &&
                currentYear === today.getFullYear()
            ) {
                dayElement.classList.add("today");
            }

            dayElement.addEventListener("click", () => handleDateSelection(dayElement, day));

            daysContainer.appendChild(dayElement);
        }
    }

    function handleDateSelection(dayElement, day) {
        const newSelectedDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), day);
        if (newSelectedDate < new Date().setHours(0, 0, 0, 0)) return;

        if (selectedDate) {
            selectedDate.classList.remove("selected-date");
        }
        
        selectedDate = dayElement;
        selectedDate.classList.add("selected-date");
    }

    prevMonthBtn.addEventListener("click", () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });

    nextMonthBtn.addEventListener("click", () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });

    renderCalendar();
});