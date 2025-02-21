<?php
// Database connection would go here
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'] ?? '';
    $lastName = $_POST['lastName'] ?? '';
    $email = $_POST['email'] ?? '';
    $contactNumber = $_POST['contactNumber'] ?? '';
    $password = $_POST['password'] ?? '';
    $repeatPassword = $_POST['repeatPassword'] ?? '';
    
    $errors = [];
    
    // Validation
    if (empty($firstName)) $errors[] = "First name is required";
    if (empty($lastName)) $errors[] = "Last name is required";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required";
    if (empty($contactNumber)) $errors[] = "Contact number is required";
    if (strlen($password) < 8) $errors[] = "Password must be at least 8 characters";
    if ($password !== $repeatPassword) $errors[] = "Passwords do not match";
    
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        // Database insertion would go here
        echo json_encode(["success" => true]);
        exit;
    } else {
        echo json_encode(["success" => false, "errors" => $errors]);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Adorafur Happy Stay</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="modal-overlay">
        <div class="modal show" tabindex="-1" style="display: block;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content border-0">
                    <div class="row g-0">
                        <!-- Form Side -->
                        <div class="col-md-6 form-side">
                            <button type="button" class="btn-close position-absolute top-3 end-3" aria-label="Close"></button>
                            
                            <div class="p-4 p-md-5">
                                <h2 class="fw-bold mb-2">Register</h2>
                                <p class="text-muted mb-4">Fill in this form to create an account</p>
                                
                                <form id="registerForm" method="POST">
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" required>
                                                <label for="firstName">First Name <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" required>
                                                <label for="lastName">Last Name <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="form-floating">
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                                <label for="email">Email <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="form-floating">
                                                <input type="tel" class="form-control" id="contactNumber" name="contactNumber" placeholder="Contact Number" required>
                                                <label for="contactNumber">Contact Number <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="form-floating password-input">
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                                <label for="password">Password <span class="text-danger">*</span></label>
                                                <span class="validation-icon"></span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="form-floating password-input">
                                                <input type="password" class="form-control" id="repeatPassword" name="repeatPassword" placeholder="Repeat Password" required>
                                                <label for="repeatPassword">Repeat Password <span class="text-danger">*</span></label>
                                                <span class="validation-icon"></span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <button type="submit" class="btn create-button w-100">Create</button>
                                        </div>
                                    </div>
                                    
                                    <p class="text-center mt-4 mb-0">
                                        Already have an account? 
                                        <a href="#" class="sign-in-link">Sign in</a>
                                    </p>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Image Side -->
                        <div class="col-md-6 d-none d-md-block image-side p-0">
                            <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/image-RojOVvtR9Y1kWXZmaifryN0pv7yQ83.png" alt="Happy dog" class="dog-image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const password = document.getElementById('password').value;
            const repeatPassword = document.getElementById('repeatPassword').value;
            
            if (password === repeatPassword) {
                document.querySelectorAll('.validation-icon').forEach(icon => {
                    icon.classList.add('valid');
                });
                
                // Form submission using fetch API
                fetch('register.php', {
                    method: 'POST',
                    body: new FormData(this)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Registration successful!');
                        // Redirect or close modal
                    } else {
                        alert(data.errors.join('\n'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            } else {
                document.querySelectorAll('.validation-icon').forEach(icon => {
                    icon.classList.remove('valid');
                });
            }
        });
    </script>
</body>
</html>