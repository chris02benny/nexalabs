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

<!-- Login Section -->
<section class="py-5 grid-bg" style="padding: 35rem 0 8rem 0; min-height: 90vh; display: flex; align-items: center;">
  <div class="section-container" style="max-width: 500px; margin-top: 5rem;">
    <div class="glass-card no-hover p-4 p-md-5" data-animate>
      <div class="text-center mb-4">
        <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: linear-gradient(135deg, hsla(250, 70%, 55%, 0.2), hsla(270, 80%, 60%, 0.2));">
          <i class="bi bi-shield-lock" style="font-size: 2.5rem; color: hsl(250, 70%, 55%);"></i>
        </div>
        <h2 class="display-5 fw-bold mb-2">Admin Login</h2>
        <p class="text-muted">Enter your credentials to access the admin panel</p>
      </div>

      <?php if ($error): ?>
      <div class="alert alert-danger d-flex align-items-center gap-2 mb-4" role="alert" style="background: rgba(220, 53, 69, 0.1); border: 1px solid rgba(220, 53, 69, 0.3); color: #dc3545; border-radius: 0.5rem; padding: 0.75rem 1rem;">
        <i class="bi bi-exclamation-triangle"></i>
        <span><?php echo htmlspecialchars($error); ?></span>
      </div>
      <?php endif; ?>

      <form action="backend/login.php" method="POST">
        <!-- Username -->
        <div class="mb-4">
          <label for="username" class="form-label d-flex align-items-center gap-2">
            <i class="bi bi-person" style="color: hsl(250, 70%, 55%);"></i>
            <span class="fw-medium">Username *</span>
          </label>
          <input type="text" class="form-input" id="username" name="username" required placeholder="Enter your username" autocomplete="username">
        </div>
        
        <!-- Password -->
        <div class="mb-4">
          <label for="password" class="form-label d-flex align-items-center gap-2">
            <i class="bi bi-lock" style="color: hsl(250, 70%, 55%);"></i>
            <span class="fw-medium">Password *</span>
          </label>
          <input type="password" class="form-input" id="password" name="password" required placeholder="Enter your password" autocomplete="current-password">
        </div>
        
        <!-- Submit Button -->
        <button type="submit" class="btn-purple w-100 py-3 fs-5 mb-3">
          <i class="bi bi-box-arrow-in-right me-2"></i>
          Login
        </button>
      </form>
    </div>
  </div>
</section>

  </main>
  
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  
  <!-- Custom JS -->
  <script src="assets/js/main.js"></script>
</body>
</html>

