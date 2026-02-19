<?php
session_start();
require_once 'includes/db_connection.php';
require_once 'includes/programs_helper.php';

$success = isset($_SESSION['registration_success']) ? $_SESSION['registration_success'] : false;
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['registration_success']);
unset($_SESSION['error']);

// Get program ID from URL - required
$programId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Redirect to programs page if no program ID provided
if ($programId <= 0) {
    header('Location: programs.php');
    exit;
}

$program = null;
$programName = '';

$pdo = isset($GLOBALS['pdo']) ? $GLOBALS['pdo'] : require_once 'includes/db_connection.php';
try {
    $stmt = $pdo->prepare("SELECT * FROM programs WHERE id = ? AND isactive = 1 LIMIT 1");
    $stmt->execute([$programId]);
    $program = $stmt->fetch();
    if ($program) {
        $programName = htmlspecialchars($program['program_name']);
    } else {
        // Program not found or inactive, redirect to programs page
        header('Location: programs.php');
        exit;
    }
} catch (PDOException $e) {
    error_log("Get Program Error: " . $e->getMessage());
    header('Location: programs.php');
    exit;
}

include 'includes/header.php';
?>

<?php if ($success): ?>
<!-- Success Message -->
<section class="py-5 d-flex align-items-center" style="min-height: 80vh; padding: 6rem 0;">
  <div class="section-container">
    <div class="text-center mx-auto scale-in" style="max-width: 500px;">
      <div class="mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 120px; height: 120px; position: relative;">
        <div class="rounded-circle position-absolute" style="width: 120px; height: 120px; background: linear-gradient(135deg, hsla(190, 100%, 50%, 0.15), hsla(270, 80%, 60%, 0.15));"></div>
        <div class="rounded-circle d-flex align-items-center justify-content-center position-relative" style="width: 70px; height: 70px; background: #00d4ff; border: 3px solid #00d4ff; z-index: 1;">
          <i class="bi bi-check-lg" style="font-size: 2rem; color: #ffffff; line-height: 1;"></i>
        </div>
      </div>
      <h2 class="display-5 fw-bold mb-3">Registration Successful!</h2>
      <p class="text-muted mb-4">
        Thank you for registering. We'll contact you shortly with program details.
      </p>
      <a href="programs.php" class="btn-outline">Register for Another Program</a>
    </div>
  </div>
</section>
<?php else: ?>

<!-- Hero Section -->
<section class="py-5 grid-bg" style="padding: 6rem 0 4rem;">
  <div class="section-container">
    <div class="text-center mx-auto slide-in-left" style="max-width: 800px;">
      <span class="badge badge-orange mb-4">
        📝 Start Your Journey
      </span>
      
      <h1 class="display-3 fw-bold mb-4">
        Register for a <span class="gradient-text-orange">Program</span>
      </h1>
      
      <p class="text-muted fs-5">
        Fill in your details below and take the first step towards becoming a tech innovator.
      </p>
    </div>
  </div>
</section>

<!-- Registration Form -->
<section class="py-5" style="padding: 4rem 0;">
  <div class="section-container" style="max-width: 700px;">
    <div class="glass-card no-hover p-4 p-md-5" data-animate>
      <?php if (!empty($error)): ?>
      <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <div><?php echo htmlspecialchars($error); ?></div>
      </div>
      <?php endif; ?>
      <form action="backend/submit_register.php" method="POST">
        <!-- Student Name -->
        <div class="mb-4">
          <label for="studentName" class="form-label d-flex align-items-center gap-2">
            <i class="bi bi-person" style="color: var(--primary);"></i>
            <span class="fw-medium">Student Name *</span>
          </label>
          <input type="text" class="form-input" id="studentName" name="studentName" required placeholder="Enter full name">
        </div>
        
        <!-- Email -->
        <div class="mb-4">
          <label for="email" class="form-label d-flex align-items-center gap-2">
            <i class="bi bi-envelope" style="color: var(--primary);"></i>
            <span class="fw-medium">Email Address *</span>
          </label>
          <input type="email" class="form-input" id="email" name="email" required placeholder="student@email.com">
        </div>
        
        <!-- Phone -->
        <div class="mb-4">
          <label for="phone" class="form-label d-flex align-items-center gap-2">
            <i class="bi bi-phone" style="color: var(--primary);"></i>
            <span class="fw-medium">Phone Number</span>
          </label>
          <input type="tel" class="form-input" id="phone" name="phone" placeholder="Enter phone number">
        </div>
        
        <!-- Age & Gender Row -->
        <div class="row mb-4">
          <div class="col-md-6 mb-4 mb-md-0">
            <label for="age" class="form-label d-flex align-items-center gap-2">
              <i class="bi bi-calendar" style="color: var(--primary);"></i>
              <span class="fw-medium">Age *</span>
            </label>
            <input type="number" class="form-input" id="age" name="age" required min="5" max="25" placeholder="Enter age">
          </div>
          
          <div class="col-md-6">
            <label class="form-label fw-medium mb-3">Gender *</label>
            <div class="d-flex gap-3">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="male" value="male" required>
                <label class="form-check-label text-muted" for="male">Male</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="female" value="female" required>
                <label class="form-check-label text-muted" for="female">Female</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="other" value="other" required>
                <label class="form-check-label text-muted" for="other">Other</label>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Education Level -->
        <div class="mb-4">
          <label for="educationLevel" class="form-label d-flex align-items-center gap-2">
            <i class="bi bi-mortarboard" style="color: var(--primary);"></i>
            <span class="fw-medium">Education Level *</span>
          </label>
          <select class="form-input" id="educationLevel" name="educationLevel" required>
            <option value="">Select education level</option>
            <option value="Primary School (1-5)">Primary School (1-5)</option>
            <option value="Middle School (6-8)">Middle School (6-8)</option>
            <option value="High School (9-10)">High School (9-10)</option>
            <option value="Senior Secondary (11-12)">Senior Secondary (11-12)</option>
            <option value="Undergraduate">Undergraduate</option>
            <option value="Other">Other</option>
          </select>
        </div>
        
        <!-- Institution -->
        <div class="mb-4">
          <label for="institution" class="form-label d-flex align-items-center gap-2">
            <i class="bi bi-building" style="color: var(--primary);"></i>
            <span class="fw-medium">Institution Name *</span>
          </label>
          <input type="text" class="form-input" id="institution" name="institution" required placeholder="Enter school/college name">
        </div>
        
        <!-- Program Selection -->
        <div class="mb-4">
          <label class="form-label d-flex align-items-center gap-2">
            <i class="bi bi-book" style="color: var(--primary);"></i>
            <span class="fw-medium">Program</span>
          </label>
          <div class="form-input" style="background: #f8f9fa; color: #212529; cursor: default;">
            <?php echo $programName; ?>
          </div>
          <input type="hidden" name="program_id" value="<?php echo $programId; ?>">
        </div>
        
        <!-- Submit Button -->
        <button type="submit" class="btn-secondary w-100 py-3 fs-5">
          Submit Registration
        </button>
        
        <p class="text-muted text-center small mt-3 mb-0">
          By registering, you agree to our Terms of Service and Privacy Policy.
        </p>
      </form>
    </div>
  </div>
</section>

<?php endif; ?>

<?php include 'includes/footer.php'; ?>
