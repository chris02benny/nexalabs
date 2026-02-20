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
          <div class="login-brand-icon login-brand-icon--success">
            <i class="bi bi-check-lg"></i>
          </div>
          <h1 class="login-title">Registration Successful</h1>
          <p class="login-subtitle">Your admin account has been created. Sign in with your credentials.</p>
        </div>
        <a href="login" class="login-submit" style="text-decoration: none; margin-top: 0;">
          <span>Go to Login</span>
          <i class="bi bi-arrow-right"></i>
        </a>
      </div>
    </div>
  </div>
</section>
<?php else: ?>

<section class="login-section">
  <div class="login-bg">
    <div class="login-bg-gradient"></div>
    <div class="login-bg-grid"></div>
  </div>

  <div class="login-container login-container--wide">
    <a href="index" class="login-back">
      <i class="bi bi-arrow-left"></i>
      <span>Back to site</span>
    </a>

    <div class="login-card login-card--scroll" data-animate>
      <div class="login-card-inner">
        <div class="login-brand">
          <div class="login-brand-icon">
            <i class="bi bi-person-plus-fill"></i>
          </div>
          <h1 class="login-title">Admin Registration</h1>
          <p class="login-subtitle">Create a new admin account (development / initial setup)</p>
          <div class="login-info">
            <i class="bi bi-info-circle-fill"></i>
            <span>This page is for development and initial setup only.</span>
          </div>
        </div>

        <?php if ($error): ?>
        <div class="login-alert" role="alert">
          <i class="bi bi-exclamation-circle-fill"></i>
          <span><?php echo htmlspecialchars($error); ?></span>
        </div>
        <?php endif; ?>

        <form action="backend/admin_register.php" method="POST" id="registerForm" class="login-form register-form">
          <div class="register-form-grid">
            <div class="login-field">
              <label for="username" class="login-label">Username</label>
              <div class="login-input-wrap">
                <i class="bi bi-person login-input-icon"></i>
                <input type="text" id="username" name="username" class="login-input" required
                       placeholder="Choose a username" autocomplete="username" minlength="3" maxlength="50">
              </div>
              <span class="login-hint">3–50 characters, alphanumeric and underscores only</span>
            </div>
            <div class="login-field">
              <label for="email" class="login-label">Email</label>
              <div class="login-input-wrap">
                <i class="bi bi-envelope login-input-icon"></i>
                <input type="email" id="email" name="email" class="login-input" required
                       placeholder="admin@nexalabs.com" autocomplete="email">
              </div>
            </div>
            <div class="login-field">
              <label for="password" class="login-label">Password</label>
              <div class="login-input-wrap">
                <i class="bi bi-lock login-input-icon"></i>
                <input type="password" id="password" name="password" class="login-input" required
                       placeholder="Enter a strong password" autocomplete="new-password" minlength="6">
              </div>
              <span class="login-hint">Minimum 6 characters</span>
            </div>
            <div class="login-field">
              <label for="confirm_password" class="login-label">Confirm Password</label>
              <div class="login-input-wrap">
                <i class="bi bi-lock-fill login-input-icon"></i>
                <input type="password" id="confirm_password" name="confirm_password" class="login-input" required
                       placeholder="Confirm your password" autocomplete="new-password">
              </div>
            </div>
          </div>
          <button type="submit" class="login-submit">
            <span>Create Admin Account</span>
            <i class="bi bi-person-plus"></i>
          </button>
        </form>

        <div class="login-links">
          <a href="login">Go to Login</a>
          <span class="login-links-sep">·</span>
          <a href="index">Back to Home</a>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
document.getElementById('registerForm').addEventListener('submit', function(e) {
  var password = document.getElementById('password').value;
  var confirmPassword = document.getElementById('confirm_password').value;
  if (password !== confirmPassword) {
    e.preventDefault();
    alert('Passwords do not match.');
    return false;
  }
  var username = document.getElementById('username').value;
  if (!/^[a-zA-Z0-9_]+$/.test(username)) {
    e.preventDefault();
    alert('Username can only contain letters, numbers, and underscores.');
    return false;
  }
});
</script>

<?php endif; ?>

  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="assets/js/main.js"></script>
</body>
</html>
