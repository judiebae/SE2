<?php
session_start();
$host = "localhost";
$dbname = "fur_a_paw_intments";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'register':
                handleRegister($conn);
                break;
            case 'login':
                handleLogin($conn);
                break;
        }
    }
}

// Function to handle registration
function handleRegister($conn) {
    // Ensure required fields are set
    if (!isset($_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['contactNumber'], $_POST['password'], $_POST['repeatPassword'])) {
        die("All registration fields are required.");
    }

    $firstName = htmlspecialchars($_POST['firstName'], ENT_QUOTES, 'UTF-8');
    $lastName = htmlspecialchars($_POST['lastName'], ENT_QUOTES, 'UTF-8');
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $contactNumber = htmlspecialchars($_POST['contactNumber'], ENT_QUOTES, 'UTF-8');
    $password = $_POST['password'];
    $repeatPassword = $_POST['repeatPassword'];

    if ($password !== $repeatPassword) {
        die("<script>alert('Passwords do not match.'); window.location.href='lag.php';</script>");
    }

    if (!preg_match('/^09[0-9]{9}$/', $contactNumber)) {
        die("<script>alert('Invalid Philippine phone number format.'); window.location.href='lag.php';</script>");
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT * FROM customer WHERE customer_email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        die("<script>alert('Email already registered.'); window.location.href='lag.php';</script>");
    }

    // Hash password before storing
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO customer (customer_first_name, customer_last_name, customer_email, customer_contact_number, customer_password) 
                            VALUES (:firstName, :lastName, :email, :contactNumber, :password)");
    $stmt->bindParam(':firstName', $firstName);
    $stmt->bindParam(':lastName', $lastName);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':contactNumber', $contactNumber);
    $stmt->bindParam(':password', $hashedPassword);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! Please log in.'); window.location.href='lag.php';</script>";
    } else {
        echo "<script>alert('Error during registration.'); window.location.href='lag.php';</script>";
    }
}

// Function to handle login
function handleLogin($conn) {
    if (!isset($_POST['email'], $_POST['password'])) {
        die("<script>alert('Email and password are required.'); window.location.href='lag.php';</script>");
    }

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Retrieve user from the database
    $stmt = $conn->prepare("SELECT customer_id, customer_password FROM customer WHERE customer_email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['customer_password'])) {
        // Set session variables
        $_SESSION['customer_id'] = $user['customer_id'];
        $_SESSION['email'] = $email;

        echo "<script>alert('Login successful!'); window.location.href='pet.php';</script>";
    } else {
        echo "<script>alert('Invalid email or password.'); window.location.href='lag.php';</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <div class="container py-5">
        <h1>User Authentication</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
    </div>
    
<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="loginForm" action="lag.php" method="POST">
                    <input type="hidden" name="action" value="login">
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
                <p class="mt-3 text-center">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Not yet registered?</a>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Register</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="registerForm" action="lag.php" method="POST">
                    <input type="hidden" name="action" value="register">
                    <div class="mb-3">
                        <label>First Name</label>
                        <input type="text" class="form-control" name="firstName" placeholder="Enter your first name" required>
                    </div>
                    <div class="mb-3">
                        <label>Last Name</label>
                        <input type="text" class="form-control" name="lastName" placeholder="Enter your last name" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-3">
                        <label>Contact Number</label>
                        <input type="text" class="form-control" name="contactNumber" placeholder="09XXXXXXXXX" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Create a password" required>
                    </div>
                    <div class="mb-3">
                        <label>Repeat Password</label>
                        <input type="password" class="form-control" name="repeatPassword" placeholder="Repeat your password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                    <p class="mt-3 text-center">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Already have an account? Sign in</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- Bootstrap JS Bundle (for modal functionality) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>