<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("connect.php");

if (!isset($_SESSION['c_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['c_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pet_id'])) {
    $pet_id = $_POST['pet_id'];
    
    // Verify pet belongs to user
    $verify_query = "SELECT id, image_path, vaccination_file FROM pets WHERE id = :pet_id AND customer_id = :c_id";
    $verify_stmt = $conn->prepare($verify_query);
    $verify_stmt->bindParam(':pet_id', $pet_id);
    $verify_stmt->bindParam(':c_id', $user_id);
    $verify_stmt->execute();
    
    if ($verify_stmt->rowCount() == 0) {
        $_SESSION['error_message'] = "You don't have permission to delete this pet";
        header("Location: profile.php");
        exit();
    }
    
    // Get file paths to delete
    $pet_data = $verify_stmt->fetch(PDO::FETCH_ASSOC);
    
    // Delete pet from database
    $delete_query = "DELETE FROM pets WHERE id = :pet_id AND customer_id = :c_id";
    
    try {
        $stmt = $conn->prepare($delete_query);
        $stmt->bindParam(':pet_id', $pet_id);
        $stmt->bindParam(':c_id', $user_id);
        $stmt->execute();
        
        // Delete associated files
        if (!empty($pet_data['image_path']) && file_exists($pet_data['image_path'])) {
            unlink($pet_data['image_path']);
        }
        
        if (!empty($pet_data['vaccination_file']) && file_exists($pet_data['vaccination_file'])) {
            unlink($pet_data['vaccination_file']);
        }
        
        $_SESSION['success_message'] = "Pet deleted successfully";
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Error deleting pet: " . $e->getMessage();
    }
}

header("Location: profile.php");
exit();
?>