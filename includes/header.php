<?php
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="NEXA Future Ready Lab - Empowering students through robotics, AI, and coding education">
  <title><?php echo ucfirst($current_page); ?> - NEXA Future Ready Lab</title>
  
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="assets/images/NEXA Logo.png">
  <link rel="shortcut icon" type="image/png" href="assets/images/NEXA Logo.png">
  <link rel="apple-touch-icon" href="assets/images/NEXA Logo.png">
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css">
  
  <!-- Swiper CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  
  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="<?php echo $current_page === 'index' ? 'page-hero-dark' : ''; ?>">
  <!-- Navigation -->
  <nav class="navbar">
    <div class="navbar-container">
      <a href="index" class="navbar-brand">
        <img src="assets/images/NEXA Logo.png" alt="NEXA Future Ready Lab" class="navbar-logo">
      </a>
      
      <!-- Mobile Toggle -->
      <button class="navbar-toggler">
        <span></span>
        <span></span>
        <span></span>
      </button>
      
      <!-- Navigation Links -->
      <ul class="navbar-nav">
        <li><a href="index" class="nav-link <?php echo $current_page == 'index' ? 'active' : ''; ?>">Home</a></li>
        <li><a href="programs" class="nav-link <?php echo $current_page == 'programs' ? 'active' : ''; ?>">Programs</a></li>
        <li><a href="about" class="nav-link <?php echo $current_page == 'about' ? 'active' : ''; ?>">About</a></li>
        <li><a href="register" class="nav-link <?php echo $current_page == 'register' ? 'active' : ''; ?>">Register</a></li>
        <li><a href="enquiry" class="nav-link <?php echo $current_page == 'enquiry' ? 'active' : ''; ?>">Enquiry</a></li>
        <li><a href="feedback" class="nav-link <?php echo $current_page == 'feedback' ? 'active' : ''; ?>">Feedback</a></li>
      </ul>
    </div>
  </nav>
  
  <!-- Main Content -->
  <main style="padding-top: 0px;">
