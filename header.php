<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <title>Adorafur Happy Stay</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="headers.css">
</head>
<body >
  <div class="lHead">
    <img src="Header-Pics/PIC4.png" alt="pic4" class="paws1">
    <img src="Header-Pics/PIC2.png" alt="pic2" class="paw1">
    <img src="Header-Pics/logo.png" alt="LOGO" class="logos">
    <img src="Header-Pics/PIC3.png" alt="pic3" class="paw2">
    <img src="Header-Pics/PIC5.png" alt="pic5" class="paws2">
  </div>

  <?php include 'login.php'?>
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
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal" data-backdrop="false">LOGIN</button>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>

</body>
</html>