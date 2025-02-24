<?php
 
 include("connect.php");

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
   $firstName = $_POST['firstName'];
   $lastName = $_POST['lastName'];
   $email = $_POST['email'];
   $contactNumber = $_POST['contactNumber'];
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
 
   $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
   $stmt->bindParam(':email', $email);
   $stmt->execute();
 
   if ($stmt->rowCount() > 0) {
       echo "Email already registered.";
       return;
   }
 
   $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
   $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, contact_number, password) VALUES (:firstName, :lastName, :email, :contactNumber, :password)");
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
   $email = $_POST['email'];
   $password = $_POST['password'];
 
   $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id']; 
    } else {
        echo "Invalid email or password.";
    }
 }

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <title>Adorafur Happy Stay</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="header.css">
</head>
<body >
  <div class="lHead">
    <img src="Header-Pics/PIC4.png" alt="pic4" class="paws1">
    <img src="Header-Pics/PIC2.png" alt="pic2" class="paw1">
    <img src="Header-Pics/logo.png" alt="LOGO" class="logos">
    <img src="Header-Pics/PIC3.png" alt="pic3" class="paw2">
    <img src="Header-Pics/PIC5.png" alt="pic5" class="paws2">
  </div>

  <nav class="navbar navbar-expand-lg navbar-dark ">
  <div class="container">
    <button class="navbar-toggler shadow-none border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="sidebar offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      
    <div class="offcanvas-header text-white border-bottom">
        <!-- <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Offcanvas</h5> -->
        <img src="logo.png" alt="LOGO" class="log">
        <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>

      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-between flex-grow-1 pe-3">
          
        <!-- about us  -->
          <li class="nav-item dropdown ">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              ABOUT US </a>
            <ul class="dropdown-menu ">
              <li><a class="dropdown-item" href="aboutus.php">House Rules</a></li>
              <li><a class="dropdown-item" href="#ourstory">Our Story</a></li>
              <li><a class="dropdown-item" href="#time">Opening Hours</a></li>
            </ul>
          </li>

        <!-- book  -->
          <li class="nav-item dropdown ">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              BOOK </a>
            <ul class="dropdown-menu ">
              <li><a class="dropdown-item" href="#second-scroll">Book</a></li>
              <li><a class="dropdown-item" href="#inclusions">Inclusion and Perks</a></li>
            </ul>
          </li>

          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="home.php">HOME</a>
          </li>

          <li class="nav-item dropdown ">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              CONTACT US
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="Contact_Us.php">Contact Us</a></li>
              <li><a class="dropdown-item" href="#faqs">FAQs</a></li>  
            </ul>
          </li>

          <li class="nav-item">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal" data-backdrop="false">LOGIN</button>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>


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