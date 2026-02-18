<?php
session_start();

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: admin.php');
    exit;
}

$error = isset($_SESSION['register_error']) ? $_SESSION['register_error'] : '';
$success = isset($_SESSION['register_success']) ? $_SESSION['register_success'] : false;
unset($_SESSION['register_error']);
unset($_SESSION['register_success']);

include 'includes/header.php';
?>

<?php if ($success): ?>
<!-- Success Message -->
<section class="py-5 d-flex align-items-center" style="min-height: 90vh; padding: 8rem 0;">
  <div class="section-container" style="max-width: 500px;">
    <div class="text-center mx-auto scale-in">
      <div class="mx-auto mb-4 rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: linear-gradient(135deg, hsla(190, 100%, 50%, 0.2), hsla(270, 80%, 60%, 0.2));">
        <i class="bi bi-check-circle" style="font-size: 2.5rem; color: var(--primary);"></i>
      </div>
      <h2 class="display-5 fw-bold mb-3">Registration Successful!</h2>
      <p class="text-muted mb-4">
        Your admin account has been created. You can now login with your credentials.
      </p>
      <a href="login.php" class="btn-purple">
        Go to Login <i class="bi bi-arrow-right ms-2"></i>
      </a>
    </div>
  </div>
</section>
<?php else: ?>

<!-- Registration Section -->
<section class="py-5 grid-bg" style="padding: 6rem 0; min-height: 90vh; display: flex; align-items: center;">
  <div class="section-container" style="max-width: 600px;">
    <div class="glass-card no-hover p-4 p-md-5" data-animate>
      <div class="text-center mb-4">
        <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: linear-gradient(135deg, hsla(250, 70%, 55%, 0.2), hsla(270, 80%, 60%, 0.2));">
          <i class="bi bi-person-plus" style="font-size: 2.5rem; color: hsl(250, 70%, 55%);"></i>
        </div>
        <h2 class="display-5 fw-bold mb-2">Admin Registration</h2>
        <p class="text-muted">Create a new admin account (Development/Initial Setup)</p>
        <div class="alert alert-info d-flex align-items-center gap-2 mt-3" role="alert" style="background: rgba(13, 110, 253, 0.1); border: 1px solid rgba(13, 110, 253, 0.3); color: #0d6efd; border-radius: 0.5rem; padding: 0.75rem 1rem; font-size: 0.875rem;">
          <i class="bi bi-info-circle"></i>
          <span>This page is for development and initial setup purposes only.</span>
        </div>
      </div>

      <?php if ($error): ?>
      <div class="alert alert-danger d-flex align-items-center gap-2 mb-4" role="alert" style="background: rgba(220, 53, 69, 0.1); border: 1px solid rgba(220, 53, 69, 0.3); color: #dc3545; border-radius: 0.5rem; padding: 0.75rem 1rem;">
        <i class="bi bi-exclamation-triangle"></i>
        <span><?php echo htmlspecialchars($error); ?></span>
      </div>
      <?php endif; ?>

      <form action="backend/admin_register.php" method="POST" id="registerForm">
        <!-- Username -->
        <div class="mb-4">
          <label for="username" class="form-label d-flex align-items-center gap-2">
            <i class="bi bi-person" style="color: hsl(250, 70%, 55%);"></i>
            <span class="fw-medium">Username *</span>
          </label>
          <input type="text" class="form-input" id="username" name="username" required placeholder="Choose a username" autocomplete="username" minlength="3" maxlength="50">
          <small class="text-muted">3-50 characters, alphanumeric and underscores only</small>
        </div>
        
        <!-- Email -->
        <div class="mb-4">
          <label for="email" class="form-label d-flex align-items-center gap-2">
            <i class="bi bi-envelope" style="color: hsl(250, 70%, 55%);"></i>
            <span class="fw-medium">Email Address *</span>
          </label>
          <input type="email" class="form-input" id="email" name="email" required placeholder="admin@nexalabs.com" autocomplete="email">
        </div>
        
        <!-- Password -->
        <div class="mb-4">
          <label for="password" class="form-label d-flex align-items-center gap-2">
            <i class="bi bi-lock" style="color: hsl(250, 70%, 55%);"></i>
            <span class="fw-medium">Password *</span>
          </label>
          <input type="password" class="form-input" id="password" name="password" required placeholder="Enter a strong password" autocomplete="new-password" minlength="6">
          <small class="text-muted">Minimum 6 characters</small>
        </div>
        
        <!-- Confirm Password -->
        <div class="mb-4">
          <label for="confirm_password" class="form-label d-flex align-items-center gap-2">
            <i class="bi bi-lock-fill" style="color: hsl(250, 70%, 55%);"></i>
            <span class="fw-medium">Confirm Password *</span>
          </label>
          <input type="password" class="form-input" id="confirm_password" name="confirm_password" required placeholder="Confirm your password" autocomplete="new-password">
        </div>
        
        <!-- Submit Button -->
        <button type="submit" class="btn-purple w-100 py-3 fs-5 mb-3">
          <i class="bi bi-person-plus me-2"></i>
          Create Admin Account
        </button>
      </form>

      <div class="text-center mt-4">
        <p class="text-muted small mb-2">Already have an account?</p>
        <a href="login.php" class="text-muted text-decoration-none small">
          <i class="bi bi-box-arrow-in-right me-1"></i>
          Go to Login
        </a>
        <span class="text-muted mx-2">|</span>
        <a href="index.php" class="text-muted text-decoration-none small">
          <i class="bi bi-arrow-left me-1"></i>
          Back to Home
        </a>
      </div>
    </div>
  </div>
</section>

<script>
// Client-side password confirmation validation
document.getElementById('registerForm').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    if (password !== confirmPassword) {
        e.preventDefault();
        alert('Passwords do not match!');
        return false;
    }
    
    // Username validation (alphanumeric and underscores only)
    const username = document.getElementById('username').value;
    const usernameRegex = /^[a-zA-Z0-9_]+$/;
    if (!usernameRegex.test(username)) {
        e.preventDefault();
        alert('Username can only contain letters, numbers, and underscores!');
        return false;
    }
});
</script>

<?php endif; ?>

<?php include 'includes/footer.php'; ?>

