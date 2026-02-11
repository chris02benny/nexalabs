<?php
session_start();
$success = isset($_SESSION['feedback_success']) ? $_SESSION['feedback_success'] : false;
unset($_SESSION['feedback_success']);

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
      <h2 class="display-5 fw-bold mb-3">Thank You!</h2>
      <p class="text-muted mb-4">
        Your feedback helps us improve our programs and create better learning experiences.
      </p>
      <a href="feedback.php" class="btn-outline">Submit Another Feedback</a>
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
        <!-- Student Name -->
        <div class="mb-4">
          <label for="studentName" class="form-label d-flex align-items-center gap-2">
            <i class="bi bi-person" style="color: var(--primary);"></i>
            <span class="fw-medium">Student Name *</span>
          </label>
          <input type="text" class="form-input" id="studentName" name="studentName" required placeholder="Enter your name">
        </div>
        
        <!-- Program Attended -->
        <div class="mb-4">
          <label for="program" class="form-label d-flex align-items-center gap-2">
            <i class="bi bi-book" style="color: var(--primary);"></i>
            <span class="fw-medium">Program Attended *</span>
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
