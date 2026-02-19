<?php
session_start();
require_once 'includes/db_connection.php';

$success = isset($_SESSION['feedback_success']) ? $_SESSION['feedback_success'] : false;
unset($_SESSION['feedback_success']);

// Get program ID from URL
$programId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// If no program ID, redirect to programs page
if ($programId <= 0) {
    header('Location: programs.php');
    exit;
}

$pdo = isset($GLOBALS['pdo']) ? $GLOBALS['pdo'] : require_once 'includes/db_connection.php';

// Get program details
try {
    $progStmt = $pdo->prepare("SELECT program_name FROM programs WHERE id = ? AND isactive = 1 LIMIT 1");
    $progStmt->execute([$programId]);
    $program = $progStmt->fetch();
    
    if (!$program) {
        header('Location: programs.php');
        exit;
    }
    
    // Get registered students for this program who haven't submitted feedback yet
    // Check by email and program_id instead of student_name
    $studentsStmt = $pdo->prepare("
        SELECT DISTINCT r.student_name, r.email 
        FROM registrations r
        WHERE r.program = ? 
        AND NOT EXISTS (
            SELECT 1 FROM feedback f 
            WHERE f.program_id = ? 
            AND f.email = r.email
        )
        ORDER BY r.student_name
    ");
    $studentsStmt->execute([$programId, $programId]);
    $students = $studentsStmt->fetchAll();
} catch (PDOException $e) {
    error_log("Feedback Page Error: " . $e->getMessage());
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
      <h2 class="display-5 fw-bold mb-3">Thank You!</h2>
      <p class="text-muted mb-4">
        Your feedback helps us improve our programs and create better learning experiences.
      </p>
      <a href="index" class="btn-primary">
        <i class="bi bi-house me-2"></i>Go to Home Page
      </a>
    </div>
  </div>
</section>
<?php else: ?>

<!-- Hero Section -->
<section class="py-5 grid-bg" style="padding: 6rem 0 4rem;">
  <div class="section-container">
    <div class="text-center mx-auto slide-in-left" style="max-width: 800px;">
      <span class="badge badge-orange mb-4">
        ⭐ Your Opinion Matters
      </span>
      
      <h1 class="display-3 fw-bold mb-4">
        Share Your <span class="gradient-text-orange">Feedback</span>
      </h1>
      
      <p class="text-muted fs-5">
        Help us improve by sharing your experience with our programs.
      </p>
    </div>
  </div>
</section>

<!-- Feedback Form -->
<section class="py-5" style="padding: 4rem 0;">
  <div class="section-container" style="max-width: 700px;">
    <div class="glass-card no-hover p-4 p-md-5" data-animate>
      <form action="backend/submit_feedback.php" method="POST" id="feedbackForm">
        <input type="hidden" name="program_id" value="<?php echo $programId; ?>">
        
        <!-- Program Name (Read-only) -->
        <div class="mb-4">
          <label class="form-label d-flex align-items-center gap-2">
            <i class="bi bi-book" style="color: var(--primary);"></i>
            <span class="fw-medium">Program</span>
          </label>
          <input type="text" class="form-input" value="<?php echo htmlspecialchars($program['program_name']); ?>" readonly style="background-color: #f8f9fa;">
        </div>
        
        <!-- Student Name Dropdown -->
        <div class="mb-4">
          <label for="studentName" class="form-label d-flex align-items-center gap-2">
            <i class="bi bi-person" style="color: var(--primary);"></i>
            <span class="fw-medium">Student Name *</span>
          </label>
          <?php if (!empty($students)): ?>
          <select class="form-input" id="studentName" name="studentName" required>
            <option value="">Select your name</option>
            <?php foreach ($students as $student): ?>
            <option value="<?php echo htmlspecialchars($student['student_name']); ?>" data-email="<?php echo htmlspecialchars($student['email']); ?>">
              <?php echo htmlspecialchars($student['student_name']); ?> (<?php echo htmlspecialchars($student['email']); ?>)
            </option>
            <?php endforeach; ?>
          </select>
          <input type="hidden" name="studentEmail" id="studentEmail" value="">
          <?php else: ?>
          <select class="form-input" id="studentName" name="studentName" required disabled>
            <option value="">No registered students found</option>
          </select>
          <small class="text-danger">No registered students found for this program. Please register students first.</small>
          <?php endif; ?>
        </div>
        
        <!-- Rating -->
        <div class="mb-4">
          <label class="form-label d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-star" style="color: var(--primary);"></i>
            <span class="fw-medium">Rating *</span>
          </label>
          <div class="d-flex gap-2 mb-2">
            <?php for ($i = 1; $i <= 5; $i++): ?>
            <button type="button" class="btn p-0 border-0 bg-transparent star-btn" data-rating="<?php echo $i; ?>">
              <i class="bi bi-star" style="font-size: 2rem; color: var(--muted-foreground); transition: all 0.3s;"></i>
            </button>
            <?php endfor; ?>
          </div>
          <input type="hidden" name="rating" id="ratingInput" required>
          <p class="text-muted small" id="ratingText">Click to rate</p>
        </div>
        
        <!-- Feedback -->
        <div class="mb-4">
          <label for="feedback" class="form-label d-flex align-items-center gap-2">
            <i class="bi bi-chat-text" style="color: var(--primary);"></i>
            <span class="fw-medium">Your Feedback *</span>
          </label>
          <textarea class="form-input" id="feedback" name="feedback" required rows="4" placeholder="Tell us about your experience..." style="resize: none;"></textarea>
        </div>
        
        <!-- Suggestions -->
        <div class="mb-4">
          <label for="suggestions" class="form-label d-flex align-items-center gap-2">
            <i class="bi bi-lightbulb" style="color: var(--primary);"></i>
            <span class="fw-medium">Suggestions for Improvement</span>
          </label>
          <textarea class="form-input" id="suggestions" name="suggestions" rows="3" placeholder="Any suggestions to make our programs better?" style="resize: none;"></textarea>
        </div>
        
        <!-- Submit Button -->
        <button type="submit" class="btn-secondary w-100 py-3 fs-5">
          Submit Feedback
        </button>
      </form>
    </div>
  </div>
</section>

<script>
// Star rating functionality
document.addEventListener('DOMContentLoaded', function() {
  const starBtns = document.querySelectorAll('.star-btn');
  const ratingInput = document.getElementById('ratingInput');
  const ratingText = document.getElementById('ratingText');
  const ratingTexts = ['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent!'];
  
  starBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      const rating = parseInt(this.dataset.rating);
      ratingInput.value = rating;
      ratingText.textContent = ratingTexts[rating];
      
      // Update star colors
      starBtns.forEach((star, index) => {
        const icon = star.querySelector('i');
        if (index < rating) {
          icon.classList.remove('bi-star');
          icon.classList.add('bi-star-fill');
          icon.style.color = 'var(--orange)';
        } else {
          icon.classList.remove('bi-star-fill');
          icon.classList.add('bi-star');
          icon.style.color = 'var(--muted-foreground)';
        }
      });
    });
    
    // Hover effect
    btn.addEventListener('mouseenter', function() {
      const rating = parseInt(this.dataset.rating);
      starBtns.forEach((star, index) => {
        const icon = star.querySelector('i');
        if (index < rating) {
          icon.style.transform = 'scale(1.1)';
        }
      });
    });
    
    btn.addEventListener('mouseleave', function() {
      starBtns.forEach(star => {
        const icon = star.querySelector('i');
        icon.style.transform = 'scale(1)';
      });
    });
  });
  
  // Update email field when student name is selected
  const studentNameSelect = document.getElementById('studentName');
  const studentEmailInput = document.getElementById('studentEmail');
  if (studentNameSelect && studentEmailInput) {
    studentNameSelect.addEventListener('change', function() {
      const selectedOption = this.options[this.selectedIndex];
      const email = selectedOption.getAttribute('data-email') || '';
      studentEmailInput.value = email;
    });
  }
  
  // Form validation
  document.getElementById('feedbackForm').addEventListener('submit', function(e) {
    if (!ratingInput.value) {
      e.preventDefault();
      alert('Please select a rating');
    }
  });
});
</script>

<?php endif; ?>

<?php include 'includes/footer.php'; ?>
