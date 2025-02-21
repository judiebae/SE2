<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fur-a-paw-intments";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $size = $_POST['size'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $description = $_POST['description'];
    $vaccination_status = $_POST['vaccination_status'];
    $date_administered = $_POST['date_administered'];
    $expiry_date = $_POST['expiry_date'];
    $instructions = $_POST['instructions'];

    // Profile Photo Upload
    $profile_photo = $_FILES['profile_photo']['name'];
    $target_dir = "uploads/";
    $profile_target_file = $target_dir . basename($profile_photo);
    move_uploaded_file($_FILES['profile_photo']['tmp_name'], $profile_target_file);

    // Vaccination File Upload (optional)
    $vaccination_file = $_FILES['vaccination_file']['name'];
    if (!empty($vaccination_file)) {
        $vaccination_target_file = $target_dir . basename($vaccination_file);
        move_uploaded_file($_FILES['vaccination_file']['tmp_name'], $vaccination_target_file);
    } else {
        $vaccination_target_file = NULL;
    }

    $sql = "INSERT INTO pets (name, size, breed, age, description, vaccination_status, date_administered, expiry_date, instructions, profile_photo, vaccination_file)
            VALUES ('$name', '$size', '$breed', '$age', '$description', '$vaccination_status', '$date_administered', '$expiry_date', '$instructions', '$profile_photo', '$vaccination_file')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Pet details saved successfully!'); window.location.href='rex.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Details Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#petModal">Add Pet</button>
    </div>

    <div class="modal fade" id="petModal" tabindex="-1" aria-labelledby="petModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="petModalLabel">Pet Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="petForm" action="rex.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Name:</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        
                        <!-- Pet Size as Radio Buttons -->
                        <div class="mb-3">
                            <label class="form-label">Pet Size:</label>
                            <div class="form-check">
                                <input type="radio" name="size" value="Small Dog" class="form-check-input" required> Small Dog
                            </div>
                            <div class="form-check">
                                <input type="radio" name="size" value="Regular Dog" class="form-check-input" required> Regular Dog
                            </div>
                            <div class="form-check">
                                <input type="radio" name="size" value="Large Dog" class="form-check-input" required> Large Dog
                            </div>
                            <div class="form-check">
                                <input type="radio" name="size" value="Regular Cat" class="form-check-input" required> Regular Cat
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Breed:</label>
                            <input type="text" name="breed" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Age:</label>
                            <input type="number" name="age" class="form-control" required>
                        </div>

                        <!-- Description Instead of Gender -->
                        <div class="mb-3">
                            <label class="form-label">Description:</label>
                            <textarea name="description" class="form-control" required></textarea>
                        </div>
                        
                        <!-- Pet Profile Photo Upload -->
                        <div class="mb-3">
                            <label class="form-label">Profile Photo:</label>
                            <input type="file" name="profile_photo" class="form-control" accept="image/*" required>
                        </div>

                        <!-- Vaccination Status - Radio Buttons -->
                        <!-- Vaccination Proof Upload (Placed ABOVE the Radio Buttons) -->
                        <div class="mb-3">
                            <label class="form-label">Vaccination Status:</label>
                            <input type="file" name="vaccination_file" class="form-control" accept="image/*,application/pdf">
                            
                            <div class="form-check">
                                <input type="radio" id="vaccinated" name="vaccination_status" value="Vaccinated" class="form-check-input" required>
                                <label for="vaccinated" class="form-check-label">Vaccinated</label>
                            </div>

                            <div class="form-check">
                                <input type="radio" id="not_vaccinated" name="vaccination_status" value="Not Vaccinated" class="form-check-input" required>
                                <label for="not_vaccinated" class="form-check-label">Not Vaccinated</label>
                            </div>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Date Administered:</label>
                            <input type="date" name="date_administered" class="form-control">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Expiry Date:</label>
                            <input type="date" name="expiry_date" class="form-control">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Special Instructions:</label>
                            <textarea name="instructions" class="form-control"></textarea>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Pet</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
