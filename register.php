<?php
session_start();
$success = isset($_SESSION['registration_success']) ? $_SESSION['registration_success'] : false;
unset($_SESSION['registration_success']);

include 'includes/header.php';
?>

<?php if ($success): ?>
<!-- Success Message -->
<section class="py-5 d-flex align-items-center" style="min-height: 80vh; padding: 6rem 0;">
  <div class="section-container">
    <div class="text-center mx-auto scale-in" style="max-width: 500px;">
      <div class="mx-auto mb-4 rounded-circle d-flex align-items-center justify-center" style="width: 80px; height: 80px; background: linear-gradient(135deg, hsla(190, 100%, 50%, 0.2), hsla(270, 80%, 60%, 0.2));">
        <i class="bi bi-check-circle" style="font-size: 2.5rem; color: var(--primary);"></i>
      </div>
      <h2 class="display-5 fw-bold mb-3">Registration Successful!</h2>
      <p class="text-muted mb-4">
        Thank you for registering. We'll contact you shortly with program details.
      </p>
      <a href="register.php" class="btn-outline">Register for Another Program</a>
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
          <label for="program" class="form-label d-flex align-items-center gap-2">
            <i class="bi bi-book" style="color: var(--primary);"></i>
            <span class="fw-medium">Select Program *</span>
          </label>
          <select class="form-input" id="program" name="program" required>
            <option value="">Select a program</option>
            <option value="Robotics Fundamentals">Robotics Fundamentals</option>
            <option value="AI & Machine Learning">AI & Machine Learning</option>
            <option value="Python Programming">Python Programming</option>
            <option value="Arduino Workshop">Arduino Workshop</option>
            <option value="Innovation Labs">Innovation Labs</option>
            <option value="Space Tech Explorers">Space Tech Explorers</option>
            <option value="3D Design & Printing">3D Design & Printing</option>
            <option value="Game Development">Game Development</option>
          </select>
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
