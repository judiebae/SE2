// Function to update real-time clock
function updateClock() {
  const clockElement = document.getElementById("real-time-clock");
  const dateElement = document.querySelector(".date-and-day");

  if (!clockElement || !dateElement) return;

  const now = new Date();

  // Format time in 12-hour format with AM/PM
  let hours = now.getHours();
  let minutes = now.getMinutes();
  let amPm = hours >= 12 ? "PM" : "AM";

  hours = hours % 12 || 12; // Convert 24-hour to 12-hour format
  minutes = minutes < 10 ? "0" + minutes : minutes; // Ensure two-digit minutes

  clockElement.textContent = `${hours}:${minutes} ${amPm}`;

  // Format date (e.g., "Monday, February 26")
  const options = { weekday: "long", month: "long", day: "numeric" };
  dateElement.textContent = now.toLocaleDateString("en-US", options);
}

// Run clock immediately and update every second
document.addEventListener("DOMContentLoaded", () => {
  updateClock();
  setInterval(updateClock, 1000);
});


