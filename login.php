<?php
include("connect.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['login_error'])) {
    echo "<div class='alert alert-danger'>" . $_SESSION['login_error'] . "</div>";
    unset($_SESSION['login_error']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'register':
                handleRegister($conn);
                break;
            case 'login':
                handleLogin($conn);
                break;
            case 'forgotPassword':
                handleForgotPassword($conn);
                break;
        }
    }
}

function handleRegister($conn) {
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $email = trim($_POST['email']); // Matches 'customer_email' in the database
    $contactNumber = trim($_POST['contactNumber']);
    $password = $_POST['password'];
    $repeatPassword = $_POST['repeatPassword'];

    if ($password !== $repeatPassword) {
        echo "Passwords do not match.";
        return;
    }

    if (!preg_match('/^09[0-9]{9}$/', $contactNumber)) {
        echo "Invalid Philippine phone number format.";
        return;
    }

    // Change 'email' to 'customer_email'
    $stmt = $conn->prepare("SELECT * FROM customer WHERE customer_email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "Email already registered.";
        return;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Change column names to match the database
    $stmt = $conn->prepare("INSERT INTO customer (customer_first_name, customer_last_name, customer_email, customer_contact_number, customer_password) 
                            VALUES (:firstName, :lastName, :email, :contactNumber, :password)");
    $stmt->bindParam(':firstName', $firstName);
    $stmt->bindParam(':lastName', $lastName);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':contactNumber', $contactNumber);
    $stmt->bindParam(':password', $hashedPassword);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error during registration.";
    }
}

function handleLogin($conn) {
    $email = trim($_POST['email']); // Matches 'customer_email' in the database
    $password = $_POST['password'];

    // Fix: Change 'email' to 'customer_email'
    $stmt = $conn->prepare("SELECT * FROM customer WHERE customer_email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['customer_password'])) {
        $_SESSION['user_id'] = $user['customer_id']; // Fix: Use 'customer_id'
        $_SESSION['user_name'] = $user['customer_first_name']; // Optional: Store the first name
        header("Location: profile.php");
        exit();
    } else {
        $_SESSION['login_error'] = "Invalid email or password.";
        header("Location: login.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOG IN PAGE</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

    <!-- Login Modal -->
    <div class="modal" id="loginModal"  tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" >
                     <!-- <h5 class="modal-title">Welcome back to your pet’s favorite spot!</h5>  -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="login-body">
                  <h5 class="modal-title">Paw’s up, fur-furfriend</h5>
                  <h2 class="modal-title"> Welcome back to your pet's favorite spot!</h2>

                    <form id="loginForm" action="" method="POST">
                        <input type="hidden" name="action" value="login">
                        <div class="mb-3 d-flex justify-content-center">
                            <input type="email" class="form-control w-50" name="email" required placeholder="Enter Email">
                        </div>
                        <div class="mb-3  d-flex justify-content-center">
                            <input type="password" class="form-control w-50" name="password" required placeholder="Enter Password">
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                        <p class="mt-3 text-center" ><a href="#" data-bs-toggle="modal" data-bs-target="#registerModal" id="not-yet-register">Not yet registered?</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-dialog modal-xl">
                <div class="modal-content border-0 p-0">
                    <div class="row g-0">
                        <!-- Form Side -->
                        <div class="col-md-6 form-side">
                            
                            <div class="p-4 p-md-4">
                                <h2 class="fw-bold mb-2">Register</h2>
                                <p class="text-muted mb-2">Fill in this form to create an account</p>
                                <hr>
                                
                                <form id="registerForm" method="POST">
                                <input type="hidden" name="action" value="register">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="mb-1">
                                              <label for="firstName">First Name <span class="text-danger">*</span></label>
                                              <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter First Name" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-6">
                                            <div class="mb-3">
                                              <label for="lastName">Last Name <span class="text-danger">*</span></label>
                                              <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter Last Name" required>      
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="email">Email <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="mb-3">
                                              <label for="contactNumber">Contact Number <span class="text-danger">*</span></label>  
                                              <input type="tel" class="form-control" id="contactNumber" name="contactNumber" placeholder="Contact Number" required>  
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="mb-3 password-input">
                                              <label for="password">Password <span class="text-danger">*</span></label>
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>  
                                                <span class="validation-icon"></span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="mb-3 password-input">
                                                <label for="repeatPassword">Repeat Password <span class="text-danger">*</span></label>
                                                <input type="password" class="form-control" id="repeatPassword" name="repeatPassword" placeholder="Repeat Password" required>
                                                <span class="validation-icon"></span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary create-button w-100" id="create-but">Create</button>
                                        </div>
                                    </div>
                                    
                                    <p class="text-center mt-4 mb-0">
                                        Already have an account? 
                                        <a href="#" class="sign-in-link" id="sign-in">Sign in</a>
                                    </p>  
                                </form>
                            </div>
                        </div>
                        
                        <!-- Image Side -->
                        <div class="col-md-6 d-none d-md-block image-side p-0">
                            <img src="Register-dog.png" alt="Happy dog" class="dog-image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
