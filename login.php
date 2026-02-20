<?php
session_start();

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: admin.php');
    exit;
}

$error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : '';
unset($_SESSION['login_error']);

include 'includes/header.php';
?>

<section class="login-section">
  <div class="login-bg">
    <div class="login-bg-gradient"></div>
    <div class="login-bg-grid"></div>
  </div>

  <div class="login-container">
    <a href="index" class="login-back">
      <i class="bi bi-arrow-left"></i>
      <span>Back to site</span>
    </a>

    <div class="login-card" data-animate>
      <div class="login-card-inner">
        <div class="login-brand">
          <div class="login-brand-icon">
            <i class="bi bi-shield-lock-fill"></i>
          </div>
          <h1 class="login-title">Admin Login</h1>
          <p class="login-subtitle">Sign in to access the NEXA admin panel</p>
        </div>

        <?php if ($error): ?>
        <div class="login-alert" role="alert">
          <i class="bi bi-exclamation-circle-fill"></i>
          <span><?php echo htmlspecialchars($error); ?></span>
        </div>
        <?php endif; ?>

        <form action="backend/login.php" method="POST" class="login-form">
          <div class="login-field">
            <label for="username" class="login-label">Username</label>
            <div class="login-input-wrap">
              <i class="bi bi-person login-input-icon"></i>
              <input type="text" id="username" name="username" class="login-input" required
                     placeholder="Enter your username" autocomplete="username">
            </div>
          </div>
          <div class="login-field">
            <label for="password" class="login-label">Password</label>
            <div class="login-input-wrap">
              <i class="bi bi-lock login-input-icon"></i>
              <input type="password" id="password" name="password" class="login-input" required
                     placeholder="Enter your password" autocomplete="current-password">
            </div>
          </div>
          <button type="submit" class="login-submit">
            <span>Sign in</span>
            <i class="bi bi-arrow-right"></i>
          </button>
        </form>
      </div>
    </div>
  </div>
</section>

  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="assets/js/main.js"></script>
</body>
</html>
