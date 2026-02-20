<?php
session_start();
$success = isset($_SESSION['enquiry_success']) ? $_SESSION['enquiry_success'] : false;
unset($_SESSION['enquiry_success']);

include 'includes/header.php';
?>

<?php if ($success): ?>
<div class="page-dark-sections">
<section class="py-5 page-dark-section stats-section-fullscreen position-relative d-flex align-items-center" style="min-height: 80vh; padding: 6rem 0;">
  <div class="section-container">
    <div class="text-center mx-auto scale-in" style="max-width: 500px;" data-animate>
      <div class="mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 120px; height: 120px; position: relative;">
        <div class="rounded-circle position-absolute" style="width: 120px; height: 120px; background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(139, 92, 246, 0.2));"></div>
        <div class="rounded-circle d-flex align-items-center justify-content-center position-relative" style="width: 70px; height: 70px; background: linear-gradient(135deg, #3b82f6, #6366f1); border: 3px solid rgba(59, 130, 246, 0.5); z-index: 1;">
          <i class="bi bi-check-lg" style="font-size: 2rem; color: #fff; line-height: 1;"></i>
        </div>
      </div>
      <h2 class="display-5 fw-bold mb-3" style="color: #fff !important;">Message Sent!</h2>
      <p class="text-muted mb-4">
        Thank you for reaching out. Our team will get back to you within 24 hours.
      </p>
      <a href="index" class="btn-primary">
        <i class="bi bi-house me-2"></i>Go to Home Page
      </a>
    </div>
  </div>
</section>
</div>
<?php else: ?>

<div class="page-dark-sections">
<!-- First section: headline + contact form -->
<section class="enquiry-hero-section page-dark-section position-relative">
  <div class="hero-3d-bg">
    <div class="hero-3d-particles" id="heroParticles"></div>
    <div class="hero-3d-glow hero-3d-glow-1"></div>
    <div class="hero-3d-glow hero-3d-glow-2"></div>
    <div class="hero-3d-grid"></div>
  </div>
  <div class="section-container enquiry-hero-container">
    <div class="text-center mb-4 mb-md-4" data-animate>
      <h1 class="enquiry-title mb-2">We'd Love to <span class="gradient-text-purple">Hear</span> from You</h1>
      <p class="enquiry-subtitle text-muted">Have questions about our programs? Want to partner with us? Drop us a message!</p>
    </div>
    <div class="enquiry-form-wrap" data-animate>
      <div class="glass-card enquiry-form-card no-hover p-4 p-md-5">
        <form action="backend/submit_enquiry.php" method="POST">
          <div class="row g-3 g-md-4">
            <div class="col-12">
              <label for="name" class="form-label d-flex align-items-center gap-2">
                <i class="bi bi-person enquiry-icon"></i>
                <span class="fw-medium">Your Name *</span>
              </label>
              <input type="text" class="form-input" id="name" name="name" required placeholder="Enter your name">
            </div>
            <div class="col-md-6">
              <label for="email" class="form-label d-flex align-items-center gap-2">
                <i class="bi bi-envelope enquiry-icon"></i>
                <span class="fw-medium">Email Address *</span>
              </label>
              <input type="email" class="form-input" id="email" name="email" required placeholder="you@email.com">
            </div>
            <div class="col-md-6">
              <label for="phone" class="form-label d-flex align-items-center gap-2">
                <i class="bi bi-telephone enquiry-icon"></i>
                <span class="fw-medium">Phone Number</span>
              </label>
              <input type="tel" class="form-input" id="phone" name="phone" placeholder="+91 99999 99999">
            </div>
            <div class="col-12">
              <label for="message" class="form-label d-flex align-items-center gap-2">
                <i class="bi bi-chat-text enquiry-icon"></i>
                <span class="fw-medium">Your Message *</span>
              </label>
              <textarea class="form-input" id="message" name="message" required rows="4" placeholder="How can we help you?" style="resize: none;"></textarea>
            </div>
            <div class="col-12 mt-2">
              <button type="submit" class="btn-primary w-100 py-3">
                Send Message
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
</div>

<?php endif; ?>

<?php include 'includes/footer.php'; ?>
