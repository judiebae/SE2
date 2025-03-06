<?php
// Database connection using PDO
try {
    $host = 'localhost';
    $dbname = 'fur_a_paw_intments';
    $username = 'root';
    $password = '';
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die(json_encode(['error' => 'Connection failed: ' . $e->getMessage()]));
}

// Get pet ID from request
$petId = isset($_GET['pet_id']) ? (int)$_GET['pet_id'] : 0;

if ($petId > 0) {
    // Fetch pet data
    $stmt = $pdo->prepare("SELECT * FROM pet WHERE pet_id = ?");
    $stmt->execute([$petId]);
    $pet = $stmt->fetch();
    
    if ($pet) {
        // Format dates for HTML input
        if ($pet['pet_vaccination_date_administered']) {
            $pet['pet_vaccination_date_administered'] = date('Y-m-d', strtotime($pet['pet_vaccination_date_administered']));
        }
        
        if ($pet['pet_vaccination_date_expiry']) {
            $pet['pet_vaccination_date_expiry'] = date('Y-m-d', strtotime($pet['pet_vaccination_date_expiry']));
        }
        
        // Return pet data as JSON
        echo json_encode($pet);
    } else {
        echo json_encode(['error' => 'Pet not found']);
    }
} else {
    echo json_encode(['error' => 'Invalid pet ID']);
}
?>