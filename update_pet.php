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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pet_id = $_POST['pet_id'];
    $name = $_POST['name'];
    $breed = $_POST['breed'];
    $pet_size = $_POST['pet_size'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $description = $_POST['description'];
    $special_instructions = $_POST['special_instructions'];
    $vaccination_status = $_POST['vaccination_status'];
    $date_administered = $_POST['date_administered'];
    $expiry_date = $_POST['expiry_date'];
    
    // Verify pet belongs to user
    $verify_query = "SELECT id FROM pets WHERE id = :pet_id AND customer_id = :user_id";
    $verify_stmt = $conn->prepare($verify_query);
    $verify_stmt->bindParam(':pet_id', $pet_id);
    $verify_stmt->bindParam(':user_id', $user_id);
    $verify_stmt->execute();
    
    if ($verify_stmt->rowCount() == 0) {
        $_SESSION['error_message'] = "You don't have permission to edit this pet";
        header("Location: profile.php");
        exit();
    }
    
    // Handle pet image upload
    $image_update = "";
    $params = [
        ':name' => $name,
        ':breed' => $breed,
        ':pet_size' => $pet_size,
        ':age' => $age,
        ':gender' => $gender,
        ':description' => $description,
        ':special_instructions' => $special_instructions,
        ':vaccination_status' => $vaccination_status,
        ':date_administered' => $date_administered,
        ':expiry_date' => $expiry_date,
        ':pet_id' => $pet_id,
        ':user_id' => $user_id
    ];
    
    if (isset($_FILES['pet_image']) && $_FILES['pet_image']['error'] == 0) {
        $upload_dir = "uploads/pets/";
        
        // Create directory if it doesn't exist
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_name = $user_id . "_" . time() . "_" . basename($_FILES['pet_image']['name']);
        $target_file = $upload_dir . $file_name;
        
        // Check if image file is a actual image
        $check = getimagesize($_FILES['pet_image']['tmp_name']);
        if ($check !== false) {
            if (move_uploaded_file($_FILES['pet_image']['tmp_name'], $target_file)) {
                $image_update = ", image_path = :image_path";
                $params[':image_path'] = $target_file;
            }
        }
    }
    
    // Update pet information
    $update_query = "UPDATE pets SET 
                    name = :name,
                    breed = :breed,
                    pet_size = :pet_size,
                    age = :age,
                    gender = :gender,
                    description = :description,
                    special_instructions = :special_instructions,
                    vaccination_status = :vaccination_status,
                    date_administered = :date_administered,
                    expiry_date = :expiry_date
                    $image_update
                    WHERE id = :pet_id AND customer_id = :user_id";
    
    try {
        $stmt = $conn->prepare($update_query);
        $stmt->execute($params);
        $_SESSION['success_message'] = "Pet information updated successfully";
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Error updating pet information: " . $e->getMessage();
    }
}

header("Location: profile.php");
exit();
?>