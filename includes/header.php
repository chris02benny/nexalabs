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
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css">
  
  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <!-- Navigation -->
  <nav class="navbar">
    <div class="navbar-container">
      <a href="index.php" class="navbar-brand">
        NEXA <span class="gradient-text">Future Ready Lab</span>
      </a>
      
      <!-- Mobile Toggle -->
      <button class="navbar-toggler">
        <span></span>
        <span></span>
        <span></span>
      </button>
      
      <!-- Navigation Links -->
      <ul class="navbar-nav">
        <li><a href="index.php" class="nav-link <?php echo $current_page == 'index' ? 'active' : ''; ?>">Home</a></li>
        <li><a href="programs.php" class="nav-link <?php echo $current_page == 'programs' ? 'active' : ''; ?>">Programs</a></li>
        <li><a href="about.php" class="nav-link <?php echo $current_page == 'about' ? 'active' : ''; ?>">About</a></li>
        <li><a href="register.php" class="nav-link <?php echo $current_page == 'register' ? 'active' : ''; ?>">Register</a></li>
        <li><a href="enquiry.php" class="nav-link <?php echo $current_page == 'enquiry' ? 'active' : ''; ?>">Enquiry</a></li>
        <li><a href="feedback.php" class="nav-link <?php echo $current_page == 'feedback' ? 'active' : ''; ?>">Feedback</a></li>
      </ul>
    </div>
  </nav>
  
  <!-- Main Content -->
  <main style="padding-top: 0px;">
