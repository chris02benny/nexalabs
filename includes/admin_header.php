<?php
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="NEXA Future Ready Lab - Admin Panel">
  <title>Admin Panel - NEXA Future Ready Lab</title>
  
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
  
  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  
  <style>
    :root {
      --sidebar-width: 260px;
      --sidebar-collapsed-width: 80px;
      --sidebar-bg: #1a1d29;
      --sidebar-hover: #252836;
      --sidebar-active: hsl(250, 70%, 55%);
    }
    
    body {
      overflow-x: hidden;
    }
    
    .admin-wrapper {
      display: flex;
      min-height: 100vh;
    }
    
    /* Sidebar Styles */
    .admin-sidebar {
      width: var(--sidebar-width);
      background: var(--sidebar-bg);
      color: white;
      position: fixed;
      left: 0;
      top: 0;
      height: 100vh;
      overflow-y: auto;
      transition: all 0.3s ease;
      z-index: 1000;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    }
    
    .admin-sidebar.collapsed {
      width: var(--sidebar-collapsed-width);
    }
    
    .sidebar-header {
      padding: 1.5rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: relative;
    }
    
    .admin-sidebar.collapsed .sidebar-header {
      justify-content: center;
      padding: 1.5rem 0.5rem;
    }
    
    .sidebar-logo {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      color: white;
      text-decoration: none;
      font-weight: 700;
      font-size: 1.25rem;
      transition: opacity 0.3s ease;
    }
    
    .admin-sidebar.collapsed .sidebar-logo {
      opacity: 0;
      width: 0;
      overflow: hidden;
      position: absolute;
    }
    
    .sidebar-logo img {
      width: 40px;
      height: 40px;
    }
    
    .sidebar-logo-text {
      transition: opacity 0.3s ease;
    }
    
    .admin-sidebar.collapsed .sidebar-logo-text {
      opacity: 0;
      width: 0;
      overflow: hidden;
    }
    
    .sidebar-toggle {
      background: transparent;
      border: none;
      color: white;
      font-size: 1.25rem;
      cursor: pointer;
      padding: 0.5rem;
      border-radius: 0.5rem;
      transition: all 0.3s ease;
      flex-shrink: 0;
      z-index: 10;
    }
    
    .admin-sidebar.collapsed .sidebar-toggle {
      margin: 0 auto;
    }
    
    .sidebar-toggle:hover {
      background: var(--sidebar-hover);
    }
    
    .sidebar-menu {
      padding: 1rem 0;
    }
    
    .menu-item {
      display: flex;
      align-items: center;
      padding: 0.875rem 1.5rem;
      color: rgba(255, 255, 255, 0.7);
      text-decoration: none;
      transition: all 0.3s ease;
      position: relative;
    }
    
    .menu-item:hover {
      background: var(--sidebar-hover);
      color: white;
    }
    
    .menu-item.active {
      background: rgba(138, 43, 226, 0.2);
      color: var(--sidebar-active);
      border-left: 3px solid var(--sidebar-active);
    }
    
    .menu-item i {
      font-size: 1.25rem;
      width: 24px;
      text-align: center;
      margin-right: 0.75rem;
    }
    
    .menu-item-text {
      transition: opacity 0.3s ease;
    }
    
    .admin-sidebar.collapsed .menu-item-text {
      opacity: 0;
      width: 0;
      overflow: hidden;
    }
    
    .admin-sidebar.collapsed .menu-item {
      justify-content: center;
      padding: 0.875rem 0;
    }
    
    .admin-sidebar.collapsed .menu-item i {
      margin-right: 0;
    }
    
    /* Main Content Area */
    .admin-main {
      flex: 1;
      margin-left: var(--sidebar-width);
      transition: margin-left 0.3s ease;
      background: var(--background);
      min-height: 100vh;
    }
    
    .admin-main.sidebar-collapsed {
      margin-left: var(--sidebar-collapsed-width);
    }
    
    .admin-content {
      padding: 2rem;
    }
    
    .admin-topbar {
      background: white;
      padding: 1rem 2rem;
      border-bottom: 1px solid var(--border);
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    
    .admin-topbar h1 {
      font-size: 1.5rem;
      font-weight: 700;
      margin: 0;
    }
    
    .admin-user {
      display: flex;
      align-items: center;
      gap: 1rem;
    }
    
    .admin-user-info {
      text-align: right;
    }
    
    .admin-user-name {
      font-weight: 600;
      color: var(--foreground);
      font-size: 0.875rem;
    }
    
    .admin-user-role {
      font-size: 0.75rem;
      color: var(--muted-foreground);
    }
    
    .logout-btn {
      background: transparent;
      border: 1px solid var(--border);
      color: var(--foreground);
      padding: 0.5rem 1rem;
      border-radius: 0.5rem;
      text-decoration: none;
      font-size: 0.875rem;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    
    .logout-btn:hover {
      background: var(--navy-light);
      border-color: var(--cyan);
    }
    
    /* Mobile Overlay */
    .sidebar-overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 999;
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    
    .sidebar-overlay.active {
      display: block;
      opacity: 1;
    }
    
    @media (max-width: 768px) {
      .admin-sidebar {
        transform: translateX(-100%);
        width: var(--sidebar-width);
        z-index: 1000;
      }
      
      .admin-sidebar.mobile-open {
        transform: translateX(0);
      }
      
      /* Disable collapse on mobile - always show full sidebar with text */
      .admin-sidebar.collapsed {
        width: var(--sidebar-width);
      }
      
      /* Ensure menu text is visible on mobile */
      .admin-sidebar .menu-item-text {
        opacity: 1 !important;
        width: auto !important;
        overflow: visible !important;
      }
      
      .admin-sidebar .menu-item {
        justify-content: flex-start !important;
        padding: 0.875rem 1.5rem !important;
      }
      
      .admin-sidebar .menu-item i {
        margin-right: 0.75rem !important;
      }
      
      /* Ensure logo text is visible on mobile */
      .admin-sidebar .sidebar-logo-text {
        opacity: 1 !important;
        width: auto !important;
        overflow: visible !important;
      }
      
      .admin-sidebar .sidebar-logo {
        opacity: 1 !important;
        width: auto !important;
        overflow: visible !important;
        position: relative !important;
      }
      
      .admin-sidebar .sidebar-header {
        justify-content: space-between !important;
        padding: 1.5rem !important;
      }
      
      .admin-main {
        margin-left: 0 !important;
      }
      
      .admin-main.sidebar-collapsed {
        margin-left: 0 !important;
      }
      
      .mobile-menu-toggle {
        display: flex;
        align-items: center;
        justify-content: center;
        position: fixed;
        top: 1rem;
        left: 1rem;
        z-index: 1001;
        background: var(--sidebar-bg);
        color: white;
        border: none;
        padding: 0.75rem;
        border-radius: 0.5rem;
        font-size: 1.25rem;
        width: 44px;
        height: 44px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
      }
      
      .mobile-menu-toggle:hover {
        background: var(--sidebar-hover);
        transform: scale(1.05);
      }
      
      .admin-topbar {
        padding: 1rem;
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
      }
      
      .admin-topbar h1 {
        font-size: 1.25rem;
      }
      
      .admin-user {
        width: 100%;
        justify-content: space-between;
      }
      
      .admin-user-info {
        text-align: left;
      }
      
      .admin-content {
        padding: 1rem;
      }
      
      /* Hide sidebar toggle on mobile */
      .sidebar-toggle {
        display: none;
      }
      
      /* Make cards stack on mobile */
      .row.g-4 {
        margin: 0;
      }
      
      .row.g-4 > * {
        padding: 0;
        margin-bottom: 1rem;
      }
      
      /* Glass card adjustments for mobile */
      .glass-card {
        margin-bottom: 1rem;
      }
      
      /* Button adjustments */
      .btn-purple-outline {
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
      }
      
      /* Statistics cards */
      .display-5 {
        font-size: 2rem;
      }
      
      /* Table responsive */
      .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
      }
      
      .table {
        font-size: 0.875rem;
      }
      
      .table th,
      .table td {
        padding: 0.5rem;
        white-space: nowrap;
      }
    }
    
    @media (min-width: 769px) {
      .mobile-menu-toggle {
        display: none;
      }
      
      .sidebar-overlay {
        display: none !important;
      }
    }
    
    @media (min-width: 769px) and (max-width: 1024px) {
      .admin-content {
        padding: 1.5rem;
      }
      
      .admin-topbar {
        padding: 1rem 1.5rem;
      }
    }
  </style>
</head>
<body>
  <div class="admin-wrapper">
    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" onclick="toggleMobileMenu()" id="mobileMenuToggle">
      <i class="bi bi-list" id="mobileMenuIcon"></i>
    </button>
    
    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeMobileMenu()"></div>
    
    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
      <div class="sidebar-header">
        <a href="admin.php" class="sidebar-logo">
          <img src="assets/images/NEXA Logo.png" alt="NEXA">
          <span class="sidebar-logo-text">NEXA Admin</span>
        </a>
        <button class="sidebar-toggle" onclick="toggleSidebar()" title="Toggle Sidebar">
          <i class="bi bi-list" id="sidebarToggleIcon"></i>
        </button>
      </div>
      
      <nav class="sidebar-menu">
        <a href="admin.php" class="menu-item <?php echo $current_page == 'admin' ? 'active' : ''; ?>">
          <i class="bi bi-speedometer2"></i>
          <span class="menu-item-text">Dashboard</span>
        </a>
        <a href="admin_programmes.php" class="menu-item <?php echo $current_page == 'admin_programmes' ? 'active' : ''; ?>">
          <i class="bi bi-book"></i>
          <span class="menu-item-text">Programmes</span>
        </a>
        <a href="admin_enquiries.php" class="menu-item <?php echo $current_page == 'admin_enquiries' ? 'active' : ''; ?>">
          <i class="bi bi-envelope"></i>
          <span class="menu-item-text">Enquiries</span>
        </a>
        <a href="admin_feedback.php" class="menu-item <?php echo $current_page == 'admin_feedback' ? 'active' : ''; ?>">
          <i class="bi bi-star"></i>
          <span class="menu-item-text">Feedback</span>
        </a>
        <a href="admin_registration.php" class="menu-item <?php echo $current_page == 'admin_registration' ? 'active' : ''; ?>">
          <i class="bi bi-person-plus"></i>
          <span class="menu-item-text">Registration</span>
        </a>
      </nav>
    </aside>
    
    <!-- Main Content -->
    <main class="admin-main" id="adminMain">
      <div class="admin-topbar">
        <h1><?php 
          $pageTitles = [
            'admin' => 'Dashboard',
            'admin_programmes' => 'Programmes',
            'admin_enquiries' => 'Enquiries',
            'admin_feedback' => 'Feedback',
            'admin_registration' => 'Registration'
          ];
          echo $pageTitles[$current_page] ?? 'Admin Panel';
        ?></h1>
        <div class="admin-user">
          <div class="admin-user-info">
            <div class="admin-user-name"><?php echo htmlspecialchars(getAdminUsername()); ?></div>
            <div class="admin-user-role">Administrator</div>
          </div>
          <a href="backend/logout.php" class="logout-btn">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
          </a>
        </div>
      </div>
      
      <div class="admin-content">

