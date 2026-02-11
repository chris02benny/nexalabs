<?php
session_start();
$success = isset($_SESSION['enquiry_success']) ? $_SESSION['enquiry_success'] : false;
unset($_SESSION['enquiry_success']);

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
      <h2 class="display-5 fw-bold mb-3">Message Sent!</h2>
      <p class="text-muted mb-4">
        Thank you for reaching out. Our team will get back to you within 24 hours.
      </p>
      <a href="enquiry.php" class="btn-outline">Send Another Enquiry</a>
    </div>
  </div>
</section>
<?php else: ?>

<!-- Hero Section -->
<section class="py-5 grid-bg" style="padding: 6rem 0 4rem;">
  <div class="section-container">
    <div class="text-center mx-auto slide-in-left" style="max-width: 800px;">
      <span class="badge badge-cyan mb-4">
        💬 Get in Touch
      </span>
      
      <h1 class="display-3 fw-bold mb-4">
        We'd Love to <span class="gradient-text">Hear from You</span>
      </h1>
      
      <p class="text-muted fs-5">
        Have questions about our programs? Want to partner with us? Drop us a message!
      </p>
    </div>
  </div>
</section>

<!-- Enquiry Form -->
<section class="py-5" style="padding: 4rem 0;">
  <div class="section-container" style="max-width: 600px;">
    <div class="glass-card no-hover p-4 p-md-5" data-animate>
      <form action="backend/submit_enquiry.php" method="POST">
        <!-- Name -->
        <div class="mb-4">
          <label for="name" class="form-label d-flex align-items-center gap-2">
            <i class="bi bi-person" style="color: var(--primary);"></i>
            <span class="fw-medium">Your Name *</span>
          </label>
          <input type="text" class="form-input" id="name" name="name" required placeholder="Enter your name">
        </div>
        
        <!-- Email -->
        <div class="mb-4">
          <label for="email" class="form-label d-flex align-items-center gap-2">
            <i class="bi bi-envelope" style="color: var(--primary);"></i>
            <span class="fw-medium">Email Address *</span>
          </label>
          <input type="email" class="form-input" id="email" name="email" required placeholder="you@email.com">
        </div>
        
        <!-- Phone -->
        <div class="mb-4">
          <label for="phone" class="form-label d-flex align-items-center gap-2">
            <i class="bi bi-telephone" style="color: var(--primary);"></i>
            <span class="fw-medium">Phone Number</span>
          </label>
          <input type="tel" class="form-input" id="phone" name="phone" placeholder="+91 98765 43210">
        </div>
        
        <!-- Message -->
        <div class="mb-4">
          <label for="message" class="form-label d-flex align-items-center gap-2">
            <i class="bi bi-chat-text" style="color: var(--primary);"></i>
            <span class="fw-medium">Your Message *</span>
          </label>
          <textarea class="form-input" id="message" name="message" required rows="5" placeholder="How can we help you?" style="resize: none;"></textarea>
        </div>
        
        <!-- Submit Button -->
        <button type="submit" class="btn-primary w-100 py-3 fs-5">
          Send Message
        </button>
      </form>
    </div>
  </div>
</section>

<!-- Contact Info -->
<section class="py-5" style="padding: 4rem 0;">
  <div class="section-container">
    <div class="row g-4">
      <?php
      $contactInfo = [
        ['icon' => 'envelope', 'title' => 'Email Us', 'info' => 'info@nexalab.com', 'link' => 'mailto:info@nexalab.com'],
        ['icon' => 'telephone', 'title' => 'Call Us', 'info' => '+91 1234567890', 'link' => 'tel:+911234567890'],
        ['icon' => 'chat-dots', 'title' => 'Live Chat', 'info' => 'Available 9 AM - 6 PM', 'link' => '#'],
      ];
      
      foreach ($contactInfo as $item):
      ?>
      <div class="col-md-4" data-animate>
        <a href="<?php echo $item['link']; ?>" class="glass-card rounded-3 p-4 text-center text-decoration-none d-block">
          <div class="mx-auto mb-3" style="width: 48px; height: 48px; border-radius: 0.75rem; background: linear-gradient(135deg, hsla(190, 100%, 50%, 0.2), hsla(270, 80%, 60%, 0.2)); display: flex; align-items: center; justify-content: center;">
            <i class="bi bi-<?php echo $item['icon']; ?>" style="font-size: 1.5rem; color: var(--primary);"></i>
          </div>
          <h5 class="fw-semibold mb-1" style="color: var(--foreground);"><?php echo $item['title']; ?></h5>
          <p class="text-muted small mb-0"><?php echo $item['info']; ?></p>
        </a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php endif; ?>

<?php include 'includes/footer.php'; ?>
