<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("connect.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];
    $reason = $_POST['reason'];
    
    // If reason is "Other", get the specified reason
    if ($reason == "Other" && isset($_POST['other_reason'])) {
        $other_reason = $_POST['other_reason'];
        $reason = "Other: " . $other_reason;
    }
    
    // Verify booking belongs to user
    $verify_query = "SELECT b_id FROM bookings WHERE b_id = :booking_id AND customer_id = :user_id";
    $verify_stmt = $conn->prepare($verify_query);
    $verify_stmt->bindParam(':booking_id', $booking_id);
    $verify_stmt->bindParam(':user_id', $user_id);
    $verify_stmt->execute();
    
    if ($verify_stmt->rowCount() == 0) {
        $_SESSION['error_message'] = "You don't have permission to cancel this booking";
        header("Location: profile.php");
        exit();
    }
    
    // Update booking status
    $update_query = "UPDATE bookings SET 
                    b_status = 'Cancelled',
                    cancellation_reason = :reason,
                    cancelled_at = NOW()
                    WHERE b_id = :booking_id AND customer_id = :user_id";
    
    try {
        $stmt = $conn->prepare($update_query);
        $stmt->bindParam(':reason', $reason);
        $stmt->bindParam(':booking_id', $booking_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $_SESSION['success_message'] = "Booking cancelled successfully";
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Error cancelling booking: " . $e->getMessage();
    }
}

header("Location: profile.php");
exit();
?>