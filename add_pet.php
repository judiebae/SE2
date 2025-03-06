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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pet_name = $_POST['pet_name'];
    $pet_size = $_POST['pet_size'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $description = $_POST['description'];
    $special_instructions = $_POST['special_instructions'];
    $vaccination_status = $_POST['vaccination_status'];
    $date_administered = $_POST['date_administered'];
    $expiry_date = $_POST['expiry_date'];
    
    // Handle pet photo upload
    $image_path = "";
    if (isset($_FILES['pet_photo']) && $_FILES['pet_photo']['error'] == 0) {
        $upload_dir = "uploads/pets/";
        
        // Create directory if it doesn't exist
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_name = $user_id . "_" . time() . "_" . basename($_FILES['pet_photo']['name']);
        $target_file = $upload_dir . $file_name;
        
        // Check if image file is a actual image
        $check = getimagesize($_FILES['pet_photo']['tmp_name']);
        if ($check !== false) {
            if (move_uploaded_file($_FILES['pet_photo']['tmp_name'], $target_file)) {
                $image_path = $target_file;
            }
        }
    }
    
    // Handle vaccination file upload
    $vaccination_file = "";
    if (isset($_FILES['vaccination_file']) && $_FILES['vaccination_file']['error'] == 0) {
        $upload_dir = "uploads/vaccinations/";
        
        // Create directory if it doesn't exist
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_name = $user_id . "_" . time() . "_" . basename($_FILES['vaccination_file']['name']);
        $target_file = $upload_dir . $file_name;
        
        if (move_uploaded_file($_FILES['vaccination_file']['tmp_name'], $target_file)) {
            $vaccination_file = $target_file;
        }
    }
    
    // Insert new pet
    $insert_query = "INSERT INTO pet (customer_id, pet_name, pet_size, pet_breed, pet_age, pet_gender, pet_description, 
                    pet_special_instructions, pet_vaccination_status, pet_vaccination_date_administered, pet_expiry_date, pet_picture, pet_vaccination_card) 
                    VALUES (:c_id, :pet_name, :pet_size, :breed, :age, :gender, :description, 
                    :special_instructions, :vaccination_status, :date_administered, :expiry_date, :image_path, :vaccination_file)";
    
    try {
        $stmt = $conn->prepare($insert_query);
        $stmt->bindParam(':c_id', $user_id);
        $stmt->bindParam(':pet_name', $pet_name);
        $stmt->bindParam(':pet_size', $pet_size);
        $stmt->bindParam(':breed', $breed);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':special_instructions', $special_instructions);
        $stmt->bindParam(':vaccination_status', $vaccination_status);
        $stmt->bindParam(':date_administered', $date_administered);
        $stmt->bindParam(':expiry_date', $expiry_date);
        $stmt->bindParam(':image_path', $image_path);
        $stmt->bindParam(':vaccination_file', $vaccination_file);
        $stmt->execute();
        $_SESSION['success_message'] = "Pet added successfully";
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Error adding pet: " . $e->getMessage();
    }
}

header("Location: profile.php");
exit();
?>