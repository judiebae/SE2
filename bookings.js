// Declare variables
const currentDate = new Date()
let startDate = null
let endDate = null

// Declare functions
function resetHighlights() {
  // Implementation (replace with actual implementation if available)
  console.log("resetHighlights function called")
  const days = document.querySelectorAll(".day")
  days.forEach((day) => {
    day.classList.remove("selected-date", "range-date")
  })
}

function highlightDateRange() {
  // Implementation (replace with actual implementation if available)
  console.log("highlightDateRange function called")
  if (!startDate || !endDate) return

  const start = Math.min(startDate, endDate)
  const end = Math.max(startDate, endDate)

  const days = document.querySelectorAll(".day")
  days.forEach((dayElement) => {
    const day = Number.parseInt(dayElement.textContent)
    if (day >= start && day <= end) {
      dayElement.classList.add("range-date")
    }
  })
}

// Update the handleDateSelection function
function handleDateSelection(day, dayElement) {
  const selectedDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), day)
  if (selectedDate < new Date().setHours(0, 0, 0, 0)) return // Prevent past selection

  if (!startDate || (startDate && endDate)) {
    // Reset selection
    startDate = day
    endDate = null
    resetHighlights()
    dayElement.classList.add("selected-date")

    // Update the booking data with check-in date
    const formattedDate = selectedDate.toLocaleDateString("en-US", {
      month: "long",
      day: "numeric",
    })
    window.bookingData.checkInDate = formattedDate
    window.bookingData.checkOutDate = formattedDate // Set same date for single-day booking

    updateBookingSummary()
  } else if (day > startDate) {
    // Set endDate and highlight range
    endDate = day
    highlightDateRange()

    // Update the booking data with check-out date
    const checkOutDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), day)
    const formattedDate = checkOutDate.toLocaleDateString("en-US", {
      month: "long",
      day: "numeric",
    })
    window.bookingData.checkOutDate = formattedDate

    updateBookingSummary()
  }
}

// Update the updateBookingSummary function
function updateBookingSummary() {
  // Get selected dates from calendar
  const selectedDays = document.querySelectorAll(".day.selected-date, .day.range-date")
  if (selectedDays.length > 0) {
    // Sort the selected days by their date attribute
    const sortedDays = Array.from(selectedDays).sort((a, b) => {
      const dateA = new Date(a.getAttribute("data-date"))
      const dateB = new Date(b.getAttribute("data-date"))
      return dateA - dateB
    })

    // First date is check-in, last date is check-out
    if (sortedDays.length > 0) {
      const checkInDateAttr = sortedDays[0].getAttribute("data-date")
      const checkOutDateAttr = sortedDays[sortedDays.length - 1].getAttribute("data-date")

      if (checkInDateAttr) {
        const checkInDate = new Date(checkInDateAttr)
        const formattedCheckInDate = checkInDate.toLocaleDateString("en-US", {
          month: "long",
          day: "numeric",
        })
        window.bookingData.checkInDate = formattedCheckInDate
      }

      if (checkOutDateAttr) {
        const checkOutDate = new Date(checkOutDateAttr)
        const formattedCheckOutDate = checkOutDate.toLocaleDateString("en-US", {
          month: "long",
          day: "numeric",
        })
        window.bookingData.checkOutDate = formattedCheckOutDate
      }
    }
  }

  // Update pet details
  if (window.bookingData.pets.length > 0) {
    let petDetailsHtml = ""
    window.bookingData.pets.forEach((pet, index) => {
      petDetailsHtml += `
                <div class="pet-summary-item">
                    <h4>${pet.name}</h4>
                    <div class="info-row"><span class="label">Breed:</span><span class="value">${pet.breed}</span></div>
                    <div class="info-row"><span class="label">Gender:</span><span class="value">${pet.gender}</span></div>
                    <div class="info-row"><span class="label">Age:</span><span class="value">${pet.age} years old</span></div>
                </div>
            `
    })

    // Update pet count in title
    $("#summaryPetName").text(`${window.bookingData.pets.length} Pet${window.bookingData.pets.length > 1 ? "s" : ""}`)

    // Update pet details section
    $("#petSummaryDetails").html(petDetailsHtml)
  }

  // Update dates
  if (window.bookingData.checkInDate && window.bookingData.checkInTime) {
    $("#summaryCheckIn").text(`${window.bookingData.checkInDate}, ${window.bookingData.checkInTime}`)
  }

  if (window.bookingData.checkOutDate && window.bookingData.checkOutTime) {
    $("#summaryCheckOut").text(`${window.bookingData.checkOutDate}, ${window.bookingData.checkOutTime}`)
  }

  // Calculate and update total price
  calculateTotalPrice()
}

// Update payment method handling
$(document).on("change", 'input[name="payment_method"]', function () {
  const selectedPayment = $(this).val()

  if (selectedPayment === "GCash") {
    $("#gcashQR").show()
    $("#mayaQR").hide()
  } else {
    $("#gcashQR").hide()
    $("#mayaQR").show()
  }
})

// Update form validation
function validatePaymentForm() {
  console.log("Validating payment form")
  const referenceNo = $('input[name="reference_no"]').val().trim()
  const paymentProof = $('input[name="payment_proof"]').prop("files").length

  console.log("Reference No:", referenceNo, "Payment Proof:", paymentProof)

  // Enable button only if both fields are filled
  if (referenceNo && paymentProof > 0) {
    console.log("Enabling proceed-to-waiver button")
    $("#proceed-to-waiver").prop("disabled", false)
  } else {
    console.log("Disabling proceed-to-waiver button")
    $("#proceed-to-waiver").prop("disabled", true)
  }
}

// Attach validation handlers with more specific selectors
$(document).on("input", 'input[name="reference_no"]', validatePaymentForm)
$(document).on("change", 'input[name="payment_proof"]', validatePaymentForm)

// Initialize payment modal
$("#petPaymentModal").on("show.bs.modal", () => {
  // Reset form
  $("#paymentForm")[0].reset()
  $("#proceed-to-waiver").prop("disabled", true)

  // Show default QR code (Maya)
  $("#gcashQR").hide()
  $("#mayaQR").show()

  // Update summary
  updateBookingSummary()
})

// Assuming jQuery is available, otherwise, you need to include it.
// For example, add this line to your HTML: <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
// If jQuery is not available, you need to replace jQuery selectors and methods with native JavaScript equivalents.

// Example calculateTotalPrice function (replace with your actual implementation)
function calculateTotalPrice() {
  // Example calculation (replace with your actual logic)
  let totalPrice = 100 // Base price
  if (window.bookingData.pets && window.bookingData.pets.length > 0) {
    totalPrice += window.bookingData.pets.length * 20 // Add price per pet
  }

  // Update the total price display (replace '#totalPrice' with your actual element ID)
  $("#totalPrice").text(`$${totalPrice}`)
}

// Ensure jQuery is available
if (typeof jQuery === "undefined") {
  console.error("jQuery is not loaded. Please include jQuery in your HTML.")
}

// Add this function to properly handle date selection from the calendar
function initializeCalendarSelection() {
  // When the calendar is rendered, attach click handlers to the days
  $(document).on("click", ".day:not(.past-day)", function () {
    const day = Number.parseInt($(this).text())
    const dateAttr = $(this).attr("data-date")

    // If no start date is selected or both start and end dates are selected
    if (!startDate || (startDate && endDate)) {
      // Reset selection
      startDate = day
      endDate = null
      $(".day").removeClass("selected-date highlighted")
      $(this).addClass("selected-date")
    }
    // If only start date is selected and clicked day is after start date
    else if (day > startDate) {
      // Set end date
      endDate = day

      // Highlight the range
      $(".day").each(function () {
        const currentDay = Number.parseInt($(this).text())
        if (currentDay >= startDate && currentDay <= endDate) {
          if (currentDay === startDate || currentDay === endDate) {
            $(this).addClass("selected-date")
          } else {
            $(this).addClass("highlighted")
          }
        }
      })
    }

    // Update booking data with selected dates
    updateBookingDatesFromCalendar()
  })
}

// Function to update booking dates based on calendar selection
function updateBookingDatesFromCalendar() {
  const selectedDays = $(".day.selected-date, .day.highlighted")

  if (selectedDays.length > 0) {
    // Get all selected dates and sort them
    const dates = []
    selectedDays.each(function () {
      const dateAttr = $(this).attr("data-date")
      if (dateAttr) {
        dates.push(new Date(dateAttr))
      }
    })

    // Sort dates chronologically
    dates.sort((a, b) => a - b)

    // First date is check-in, last date is check-out
    if (dates.length > 0) {
      const checkInDate = dates[0]
      const checkOutDate = dates[dates.length - 1]

      // Format dates for display
      const formattedCheckInDate = checkInDate.toLocaleDateString("en-US", {
        month: "long",
        day: "numeric",
      })

      const formattedCheckOutDate = checkOutDate.toLocaleDateString("en-US", {
        month: "long",
        day: "numeric",
      })

      // Update booking data
      window.bookingData.checkInDate = formattedCheckInDate
      window.bookingData.checkOutDate = formattedCheckOutDate

      // Update summary if times are selected
      if (window.bookingData.checkInTime) {
        $("#summaryCheckIn").text(`${formattedCheckInDate}, ${window.bookingData.checkInTime}`)
      }

      if (window.bookingData.checkOutTime) {
        $("#summaryCheckOut").text(`${formattedCheckOutDate}, ${window.bookingData.checkOutTime}`)
      }
    }
  }
}

// Fix the Complete Booking button functionality
$(document).ready(() => {
  initializeCalendarSelection()

  // Fix for complete booking button
  $(document).on("click", "#complete-booking", function (e) {
    e.preventDefault()
    console.log("Complete booking button clicked")

    // Check if waiver checkboxes are checked
    if (!$("#waiverForm-checkbox1").prop("checked") || !$("#waiverForm-checkbox2").prop("checked")) {
      alert("You must agree to the terms and conditions to complete your booking.")
      return
    }

    // Show processing notification
    alert("Your booking is being processed. Please wait...")

    // Disable the button to prevent multiple submissions
    $(this).prop("disabled", true).text("Processing...")

    // Get the payment form data
    var formData = new FormData($("#paymentForm")[0])
    formData.append("complete_booking", "true")

    // Add booking data to form
    if (window.bookingData) {
      formData.append("booking_data", JSON.stringify(window.bookingData))
    }

    $.ajax({
      type: "POST",
      url: window.location.href,
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: (response) => {
        if (response.success) {
          alert("Booking completed successfully!")
          $("#waiverForm").modal("hide")
          // Redirect to confirmation page
          window.location.href = "booking-confirmation.php"
        } else {
          alert("Error: " + (response.message || "Unknown error"))
          // Re-enable the button if there's an error
          $("#complete-booking").prop("disabled", false).text("Complete Booking")
        }
      },
      error: (xhr, status, error) => {
        console.error("AJAX Error:", error)
        alert("An error occurred while processing your booking. Please try again.")
        // Re-enable the button if there's an error
        $("#complete-booking").prop("disabled", false).text("Complete Booking")
      },
    })
  })

  // Ensure the proceed-to-waiver button works correctly
  $(document).on("click", "#proceed-to-waiver", (e) => {
    console.log("Proceed to waiver button clicked")
    // Close payment modal
    $("#petPaymentModal").modal("hide")
    // Show waiver modal
    setTimeout(() => {
      $("#waiverForm").modal("show")
    }, 500) // Small delay to ensure first modal is closed
  })

  $(document).on("click", "#proceed-to-waiver", () => {
    // Close payment modal and open waiver modal
    $("#petPaymentModal").modal("hide")
    $("#waiverForm").modal("show")
  })
})

