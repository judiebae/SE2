function updateClock() {
    const clockElement = document.getElementById("real-time-clock");
    if (!clockElement) return; // Prevents errors if the element is missing

    const now = new Date();
    let hours = now.getHours();
    let minutes = now.getMinutes();
    let amPm = hours >= 12 ? 'PM' : 'AM';

    // Convert to 12-hour format
    hours = hours % 12 || 12; 

    // Format minutes
    minutes = minutes < 10 ? '0' + minutes : minutes;

    clockElement.textContent = `${hours}:${minutes} ${amPm}`;
}

// Run immediately and update every second
document.addEventListener("DOMContentLoaded", () => {
    updateClock(); 
    setInterval(updateClock, 1000);
});

function updateDateTime() {
    const clockElement = document.getElementById("real-time-clock");
    const dateElement = document.querySelector(".date-and-day");

    if (!clockElement || !dateElement) return;

    const now = new Date();

    // Format the time (12-hour format with AM/PM)
    let hours = now.getHours();
    let minutes = now.getMinutes();
    let amPm = hours >= 12 ? "PM" : "AM";

    hours = hours % 12 || 12; // Convert 24-hour to 12-hour format
    minutes = minutes < 10 ? "0" + minutes : minutes; // Ensure two-digit minutes

    clockElement.textContent = `${hours}:${minutes} ${amPm}`;

    // Format the date (e.g., "Thursday, September 2")
    const options = { weekday: "long", month: "long", day: "numeric" };
    dateElement.textContent = now.toLocaleDateString("en-US", options);
}

// Run immediately and update every second
document.addEventListener("DOMContentLoaded", () => {
    updateDateTime();
    setInterval(updateDateTime, 1000);
});

