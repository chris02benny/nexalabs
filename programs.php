<?php 
require_once 'includes/db_connection.php';
require_once 'includes/programs_helper.php';

// Get PDO connection
$pdo = isset($GLOBALS['pdo']) ? $GLOBALS['pdo'] : require_once 'includes/db_connection.php';
$allPrograms = getActivePrograms($pdo);
$categorizedPrograms = categorizePrograms($allPrograms);

include 'includes/header.php'; 
?>

<!-- Hero Section - flat (no 3D panels) -->
<section class="hero-programs">
  <div class="hero-programs-bg"></div>
  <div class="hero-programs-content">
    <div class="hero-programs-headline">
      <h1 class="hero-3d-title">Programmes <span class="hero-3d-gradient">Offered</span></h1>
      <p class="hero-3d-subtitle">All programmes follow a <strong>Learn – Build – Deploy</strong> approach, combining conceptual understanding with hands-on practice and real-world application.</p>
      <div class="hero-3d-cta-wrap">
        <a href="#programmes-list" class="hero-3d-cta">View Programmes <i class="bi bi-arrow-right"></i></a>
      </div>
    </div>
    <div class="hero-3d-stats">
      <div class="hero-3d-stat"><span class="hero-3d-stat-val">5,000+</span> STUDENTS</div>
      <div class="hero-3d-stat"><span class="hero-3d-stat-val">25+</span> PROGRAMS</div>
      <div class="hero-3d-stat"><span class="hero-3d-stat-val">50+</span> MENTORS</div>
    </div>
  </div>
  <div class="hero-3d-scroll">
    <div class="hero-3d-scroll-dot"></div>
  </div>
</section>

<div class="page-dark-sections" id="programmes-list">
<?php
$renderProgramCard = function ($program) {
  $regStart = $program['reg_start_date'] ?? null;
  $regEnd = $program['reg_end_date'] ?? null;
  $progStart = $program['program_start_date'] ?? null;
  $progEnd = $program['program_end_date'] ?? null;
  $programDays = calculateProgramDays($progStart, $progEnd);
  ?>
  <div class="col-lg-6" data-animate>
    <div class="glass-card program-detail-card p-4 h-100 d-flex flex-column">
      <div class="mb-3"><?php echo getProgramStatusBadge($program); ?></div>
      <h4 class="program-detail-title mb-4"><?php echo htmlspecialchars($program['program_name']); ?></h4>
      <div class="program-info mb-4">
        <?php if ($regStart && $regEnd): ?>
        <div class="mb-3">
          <div class="d-flex align-items-center mb-1">
            <i class="bi bi-calendar-event me-2 text-primary"></i>
            <strong class="text-muted small">Registration Period:</strong>
          </div>
          <div class="ms-4 program-info-values">
            <span class="program-info-value"><?php echo date('M d, Y', strtotime($regStart)); ?></span>
            <span class="program-date-sep"> – </span>
            <span class="program-info-value"><?php echo date('M d, Y', strtotime($regEnd)); ?></span>
          </div>
        </div>
        <?php endif; ?>
        <?php if ($progStart && $progEnd): ?>
        <div class="mb-3">
          <div class="d-flex align-items-center mb-1">
            <i class="bi bi-calendar-check me-2 text-success"></i>
            <strong class="text-muted small">Course Period:</strong>
          </div>
          <div class="ms-4 program-info-values">
            <span class="program-info-value"><?php echo date('M d, Y', strtotime($progStart)); ?></span>
            <span class="program-date-sep"> – </span>
            <span class="program-info-value"><?php echo date('M d, Y', strtotime($progEnd)); ?></span>
          </div>
        </div>
        <?php endif; ?>
        <?php if ($programDays): ?>
        <div class="mb-3">
          <div class="d-flex align-items-center mb-1">
            <i class="bi bi-clock me-2 text-info"></i>
            <strong class="text-muted small">Duration:</strong>
          </div>
          <div class="ms-4">
            <span class="program-info-value fw-bold"><?php echo $programDays; ?> <?php echo $programDays == 1 ? 'Day' : 'Days'; ?></span>
          </div>
        </div>
        <?php endif; ?>
      </div>
      <a href="program_details.php?id=<?php echo $program['id']; ?>" class="btn-primary w-100 mt-auto" style="flex-shrink: 0; text-decoration: none; display: inline-block; text-align: center;">
        View More <i class="bi bi-arrow-right ms-2"></i>
      </a>
    </div>
  </div>
  <?php
};
?>

<!-- Registration Open Programs -->
<?php if (!empty($categorizedPrograms['registration_open'])): ?>
<section class="programs-section-fullscreen position-relative page-dark-section">
  <div class="section-container section-container-wide">
    <div class="text-center mb-5 programs-section-header-stack" data-animate>
      <span class="badge badge-purple mb-3"><i class="bi bi-calendar-check me-2"></i>Registration Open</span>
      <h2 class="display-4 fw-bold mb-3">
        <span class="gradient-text-purple">Register Now</span>
      </h2>
      <p class="text-muted fs-5 mx-auto" style="max-width: 600px;">Don't miss out! Registration is currently open for these programs.</p>
    </div>
    <div class="row g-4">
      <?php foreach ($categorizedPrograms['registration_open'] as $program) $renderProgramCard($program); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- Ongoing Programs -->
<?php if (!empty($categorizedPrograms['ongoing'])): ?>
<section class="programs-section-fullscreen position-relative page-dark-section">
  <div class="section-container section-container-wide">
    <div class="text-center mb-5 programs-section-header-stack" data-animate>
      <span class="badge badge-purple mb-3"><i class="bi bi-play-circle me-2"></i>Currently Running</span>
      <h2 class="display-4 fw-bold mb-3">
        <span class="gradient-text-purple">Ongoing Programs</span>
      </h2>
      <p class="text-muted fs-5 mx-auto" style="max-width: 600px;">Programs currently in progress.</p>
    </div>
    <div class="row g-4">
      <?php foreach ($categorizedPrograms['ongoing'] as $program) $renderProgramCard($program); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- Upcoming Programs -->
<?php 
$upcomingAll = array_merge($categorizedPrograms['upcoming'], $categorizedPrograms['upcoming_program']);
if (!empty($upcomingAll)): 
?>
<section class="programs-section-fullscreen position-relative page-dark-section">
  <div class="section-container section-container-wide">
    <div class="text-center mb-5 programs-section-header-stack" data-animate>
      <span class="badge badge-purple mb-3"><i class="bi bi-calendar-event me-2"></i>Coming Soon</span>
      <h2 class="display-4 fw-bold mb-3">
        <span class="gradient-text-purple">Upcoming Programs</span>
      </h2>
      <p class="text-muted fs-5 mx-auto" style="max-width: 600px;">Programs starting soon. Stay tuned!</p>
    </div>
    <div class="row g-4">
      <?php foreach ($upcomingAll as $program) $renderProgramCard($program); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- All Programs Grid (fallback when nothing categorized) -->
<?php if (empty($categorizedPrograms['registration_open']) && empty($categorizedPrograms['ongoing']) && empty($upcomingAll) && !empty($allPrograms)): ?>
<section class="programs-section-fullscreen position-relative page-dark-section">
  <div class="section-container section-container-wide">
    <div class="text-center mb-5" data-animate>
      <span class="badge badge-purple mb-3">Our Programs</span>
      <h2 class="display-4 fw-bold mb-3">
        Programmes <span class="gradient-text-purple">Offered</span>
      </h2>
    </div>
    <div class="row g-4">
      <?php foreach ($allPrograms as $program) $renderProgramCard($program); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (empty($allPrograms)): ?>
<section class="programs-section-fullscreen position-relative page-dark-section">
  <div class="section-container section-container-wide">
    <div class="text-center py-5">
      <i class="bi bi-book program-empty-icon"></i>
      <p class="program-empty-text mt-3">No programs available at the moment. Check back soon!</p>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- CTA Section (same as index) -->
<section class="cta-section position-relative page-dark-section">
  <div class="section-container">
    <div class="text-center" data-animate>
      <h2 class="display-3 fw-bold mb-3">Ready to Start <span class="gradient-text">Your Journey?</span></h2>
      <p class="text-muted fs-5 mb-5 mx-auto" style="max-width: 700px;">
        Join our community of young innovators and take the first step towards becoming a tech leader of tomorrow.
      </p>
      <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
        <a href="register" class="btn-primary">
          Register Now <i class="bi bi-arrow-right ms-2"></i>
        </a>
        <a href="enquiry" class="btn-secondary">Enquiry</a>
      </div>
    </div>
  </div>
</section>

</div><!-- .page-dark-sections -->

<?php include 'includes/footer.php'; ?>
