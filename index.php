<?php 
require_once 'includes/db_connection.php';
require_once 'includes/programs_helper.php';

// Get PDO connection
$pdo = isset($GLOBALS['pdo']) ? $GLOBALS['pdo'] : require_once 'includes/db_connection.php';
$allPrograms = getActivePrograms($pdo);
$categorizedPrograms = categorizePrograms($allPrograms);

// Get featured programs (first 3 from registration_open or upcoming)
$featuredPrograms = array_merge(
    array_slice($categorizedPrograms['registration_open'], 0, 3),
    array_slice($categorizedPrograms['upcoming'], 0, 3 - count($categorizedPrograms['registration_open']))
);

include 'includes/header.php'; 
?>

<!-- Hero Section -->
<section class="hero-section">
  <!-- Background Decorative Elements -->
  <div class="hero-bg-pattern"></div>
  <div class="hero-gradient-orb hero-orb-1"></div>
  <div class="hero-gradient-orb hero-orb-2"></div>
  <div class="hero-gradient-orb hero-orb-3"></div>
  
  <div class="section-container">
    <div class="row align-items-center g-5">
      <!-- Content -->
      <div class="col-lg-6 mb-5 mb-lg-0 slide-in-left">
        <!-- Badge -->
        <div class="hero-badge mb-4">
          <span class="badge-text">Future-Ready Education</span>
          <i class="bi bi-arrow-right ms-2"></i>
        </div>
        
        <h1 class="hero-title mb-4">
          Building Skills for <span class="gradient-text">Tomorrow's World</span>
        </h1>
        
        <!-- Hero Image (Mobile only - appears after title) -->
        <div class="hero-image-mobile d-lg-none">
          <div class="hero-visual-container">
            <div class="hero-main-image">
              <div class="hero-image-glow"></div>
              <img src="assets/images/hero-robot.png" alt="Nexalabs Robot" class="img-fluid hero-robot-img">
            </div>
          </div>
        </div>
        
        <p class="hero-tagline mb-4">
          <i class="bi bi-shield-check me-2"></i>
          Powered by AJCE × Unique World Robotics (India & UAE)
        </p>
        
        <p class="hero-description mb-4">
          The NEXA Future Ready Lab is a next-generation learning and innovation ecosystem designed to prepare students, educators, and professionals for emerging technologies through hands-on, industry-aligned learning.
        </p>
        
        <p class="hero-description mb-5">
          Our programs span schools, colleges, and advanced learners, combining Extended Reality (XR), Artificial Intelligence, Robotics, Embedded Systems, and Digital Technologies into a unified, future-ready platform.
        </p>
        
        <!-- CTA Buttons -->
        <div class="hero-cta d-flex flex-column flex-sm-row gap-3 mb-5">
          <a href="programs" class="btn-hero-primary">
            <span>Explore Programs</span>
            <i class="bi bi-arrow-right ms-2"></i>
          </a>
          <a href="register" class="btn-hero-secondary">
            <span>Register Now</span>
            <i class="bi bi-rocket-takeoff ms-2"></i>
          </a>
        </div>
        
        <!-- Stats Row -->
        <div class="hero-stats d-flex flex-wrap gap-4">
          <div class="hero-stat-item">
            <div class="stat-value">5,000+</div>
            <div class="stat-label">Students</div>
          </div>
          <div class="hero-stat-item">
            <div class="stat-value">25+</div>
            <div class="stat-label">Programs</div>
          </div>
          <div class="hero-stat-item">
            <div class="stat-value">50+</div>
            <div class="stat-label">Mentors</div>
          </div>
        </div>
      </div>
      
      <!-- Hero Images & Visuals (Desktop only) -->
      <div class="col-lg-6 scale-in d-none d-lg-block">
        <div class="hero-visual-container">
          <!-- Main Robot Image -->
          <div class="hero-main-image">
            <div class="hero-image-glow"></div>
            <img src="assets/images/hero-robot.png" alt="Nexalabs Robot" class="img-fluid hero-robot-img">
          </div>
          
          <!-- Floating Tech Icons -->
          <div class="hero-floating-icon hero-icon-1">
            <div class="icon-wrapper">
              <i class="bi bi-cpu-fill"></i>
            </div>
            <span class="icon-label">AI & ML</span>
          </div>
          
          <div class="hero-floating-icon hero-icon-2">
            <div class="icon-wrapper">
              <i class="bi bi-robot"></i>
            </div>
            <span class="icon-label">Robotics</span>
          </div>
          
          <div class="hero-floating-icon hero-icon-3">
            <div class="icon-wrapper">
              <i class="bi bi-vr"></i>
            </div>
            <span class="icon-label">XR/VR</span>
          </div>
          
          <div class="hero-floating-icon hero-icon-4">
            <div class="icon-wrapper">
              <i class="bi bi-code-slash"></i>
            </div>
            <span class="icon-label">Coding</span>
          </div>
          
          <!-- Decorative Grid Pattern -->
          <div class="hero-grid-pattern"></div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Scroll Indicator -->
  <div class="scroll-indicator">
    <div class="scroll-indicator-box">
      <div class="scroll-indicator-dot"></div>
    </div>
  </div>
</section>

<!-- Stats Section -->
<section class="stats-section-fullscreen position-relative">
  <div class="section-container">
    <div class="text-center mb-5" data-animate>
      <span class="badge badge-purple mb-3">Our Impact</span>
      <h2 class="display-4 fw-bold mb-3">
        Transforming Lives Through <span class="gradient-text-purple">Education</span>
      </h2>
      <p class="text-muted fs-5 mx-auto" style="max-width: 600px;">
        We've helped thousands of students discover their passion for technology and innovation.
      </p>
    </div>
    
    <div class="row g-4">
      <?php
      $stats = [
        ['value' => '5,000+', 'label' => 'Students Trained', 'icon' => 'people'],
        ['value' => '25+', 'label' => 'Programs', 'icon' => 'book'],
        ['value' => '50+', 'label' => 'Expert Mentors', 'icon' => 'award'],
      ];
      
      foreach ($stats as $stat):
      ?>
      <div class="col-md-4" data-animate>
        <div class="glass-card stats-card no-hover">
          <div class="mb-3">
            <i class="bi bi-<?php echo $stat['icon']; ?>" style="font-size: 2.5rem; color: hsl(250, 70%, 55%);"></i>
          </div>
          <div class="stats-value gradient-text-purple"><?php echo $stat['value']; ?></div>
          <div class="stats-label"><?php echo $stat['label']; ?></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Programmes Offered Section -->
<section class="programs-section-fullscreen position-relative">
  <div class="section-container">
    <div class="text-center mb-5" data-animate>
      <span class="badge badge-purple mb-3">Our Programs</span>
      <h2 class="display-4 fw-bold mb-3">
        Programmes <span class="gradient-text-purple">Offered</span>
      </h2>
      <p class="text-muted fs-5 mx-auto" style="max-width: 800px;">
        All programmes follow a <strong>Learn – Build – Deploy</strong> approach, combining conceptual understanding with hands-on practice and real-world application.
      </p>
    </div>
    
    <div class="row g-4">
      <?php if (empty($featuredPrograms)): ?>
      <div class="col-12 text-center py-5">
        <i class="bi bi-book" style="font-size: 3rem; color: var(--muted-foreground);"></i>
        <p class="text-muted mt-3">No programs available at the moment. Check back soon!</p>
      </div>
      <?php else: ?>
      <?php foreach ($featuredPrograms as $index => $program): 
        $regStart = $program['reg_start_date'] ?? null;
        $regEnd = $program['reg_end_date'] ?? null;
        $progStart = $program['program_start_date'] ?? null;
        $progEnd = $program['program_end_date'] ?? null;
        $programDays = calculateProgramDays($progStart, $progEnd);
      ?>
      <div class="col-lg-8 col-xl-6" data-animate>
        <div class="glass-card program-detail-card p-4 h-100 d-flex flex-column">
          <div class="mb-3">
            <?php echo getProgramStatusBadge($program); ?>
          </div>
          
          <h4 class="program-detail-title mb-4"><?php echo htmlspecialchars($program['program_name']); ?></h4>
          
          <div class="program-info mb-4">
            <?php if ($regStart && $regEnd): ?>
            <div class="mb-3">
              <div class="d-flex align-items-center mb-1">
                <i class="bi bi-calendar-event me-2 text-primary"></i>
                <strong class="text-muted small">Registration Period:</strong>
              </div>
              <div class="ms-4">
                <span class="text-dark"><?php echo date('M d, Y', strtotime($regStart)); ?></span>
                <span class="mx-2">-</span>
                <span class="text-dark"><?php echo date('M d, Y', strtotime($regEnd)); ?></span>
              </div>
            </div>
            <?php endif; ?>
            
            <?php if ($progStart && $progEnd): ?>
            <div class="mb-3">
              <div class="d-flex align-items-center mb-1">
                <i class="bi bi-calendar-check me-2 text-success"></i>
                <strong class="text-muted small">Course Period:</strong>
              </div>
              <div class="ms-4">
                <span class="text-dark"><?php echo date('M d, Y', strtotime($progStart)); ?></span>
                <span class="mx-2">-</span>
                <span class="text-dark"><?php echo date('M d, Y', strtotime($progEnd)); ?></span>
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
                <span class="text-dark fw-bold"><?php echo $programDays; ?> <?php echo $programDays == 1 ? 'Day' : 'Days'; ?></span>
              </div>
            </div>
            <?php endif; ?>
          </div>
          
          <a href="program_details.php?id=<?php echo $program['id']; ?>" class="btn-primary w-100 mt-auto" style="flex-shrink: 0; text-decoration: none; display: inline-block; text-align: center;">
            View More <i class="bi bi-arrow-right ms-2"></i>
          </a>
        </div>
      </div>
      <?php endforeach; ?>
      <?php endif; ?>
    </div>
    
    <div class="text-center mt-5" data-animate>
      <a href="programs" class="btn-purple">
        View All Programmes <i class="bi bi-arrow-right ms-2"></i>
      </a>
    </div>
  </div>
</section>

<!-- Program Details Modal -->
<div class="modal fade robotics-modal" id="programModal" tabindex="-1" aria-labelledby="programModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content robotics-modal-content">
      <div class="modal-header robotics-modal-header">
        <div class="modal-icon-wrapper">
          <i class="bi" id="modalIcon"></i>
        </div>
        <h2 class="modal-title" id="modalTitle"></h2>
        <button type="button" class="btn-close robotics-close" data-bs-dismiss="modal" aria-label="Close">
          <i class="bi bi-x-lg"></i>
        </button>
      </div>
      <div class="modal-body robotics-modal-body">
        <div class="program-info-section mb-4" id="modalProgramInfo" style="display: none;">
          <div class="mb-3" id="modalRegPeriod" style="display: none;">
            <div class="d-flex align-items-center mb-1">
              <i class="bi bi-calendar-event me-2 text-primary"></i>
              <strong class="text-dark small">Registration Period:</strong>
            </div>
            <div class="ms-4 text-dark" id="modalRegPeriodDates"></div>
          </div>
          
          <div class="mb-3" id="modalCoursePeriod" style="display: none;">
            <div class="d-flex align-items-center mb-1">
              <i class="bi bi-calendar-check me-2 text-success"></i>
              <strong class="text-dark small">Course Period:</strong>
            </div>
            <div class="ms-4 text-dark" id="modalCoursePeriodDates"></div>
          </div>
          
          <div class="mb-3" id="modalDuration" style="display: none;">
            <div class="d-flex align-items-center mb-1">
              <i class="bi bi-clock me-2 text-info"></i>
              <strong class="text-dark small">Duration:</strong>
            </div>
            <div class="ms-4 text-dark fw-bold" id="modalDurationDays"></div>
          </div>
        </div>
        
        <div class="program-section mb-4">
          <h6 class="program-section-title">
            <i class="bi bi-gear-fill me-2"></i>Programmes / Focus Areas
          </h6>
          <ul class="program-list" id="modalFocusAreas"></ul>
        </div>
        
        <div class="program-section mb-4">
          <h6 class="program-section-title">
            <i class="bi bi-application me-2"></i>Applications
          </h6>
          <ul class="program-list" id="modalApplications"></ul>
        </div>
        
        <div class="program-section">
          <h6 class="program-section-title">
            <i class="bi bi-trophy-fill me-2"></i>Outcome
          </h6>
          <p class="program-outcome" id="modalOutcome"></p>
        </div>
      </div>
      <div class="modal-footer robotics-modal-footer">
        <a href="register" class="btn-robotics-primary">
          Register Now <i class="bi bi-arrow-right ms-2"></i>
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Learner Groups Section -->
<section class="stats-section-fullscreen position-relative">
  <div class="section-container-wide">
    <div class="text-center mb-5" data-animate>
      <span class="badge badge-purple mb-3">Who We Serve</span>
      <h2 class="display-4 fw-bold mb-3">
        <span class="gradient-text-purple">Learner Groups</span>
      </h2>
      <p class="text-muted fs-5 mx-auto" style="max-width: 800px;">
        Our programmes cater to a wide range of learners, ensuring age-appropriate depth, career relevance, and industry alignment.
      </p>
    </div>
    
    <div class="carousel-container position-relative px-lg-5">
      <div class="swiper learnerGroupsSwiper pb-5" data-animate>
        <div class="swiper-wrapper">
          <?php
          $learnerGroups = [
            [
              'title' => 'School Students',
              'description' => 'Foundation building, creativity, and early exposure to future technologies',
              'icon' => 'mortarboard',
              'color' => 'purple'
            ],
            [
              'title' => 'College Students',
              'description' => 'Skill development, project-based learning, and industry readiness',
              'icon' => 'book',
              'color' => 'cyan'
            ],
            [
              'title' => 'Faculty & Educators',
              'description' => 'Upskilling, research enablement, and trainer certification',
              'icon' => 'person-workspace',
              'color' => 'orange'
            ],
            [
              'title' => 'Professionals & Researchers',
              'description' => 'Advanced tools, specialization, and applied deployment',
              'icon' => 'briefcase',
              'color' => 'purple'
            ],
            [
              'title' => 'Career Restart Professionals',
              'description' => 'Flexible, guided learning to refresh skills, gain confidence, and re-enter the workforce in emerging technologies',
              'icon' => 'arrow-repeat',
              'color' => 'cyan'
            ],
          ];
          
          foreach ($learnerGroups as $index => $group):
          ?>
          <div class="swiper-slide h-auto">
            <div class="glass-card learner-group-card p-4 h-100">
              <div class="mb-3">
                <i class="bi bi-<?php echo $group['icon']; ?>" style="font-size: 2.5rem; color: var(--purple);"></i>
              </div>
              <h4 class="learner-group-title mb-3"><?php echo $group['title']; ?></h4>
              <p class="learner-group-description"><?php echo $group['description']; ?></p>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
      </div>
      
      <!-- Add Navigation Outside -->
      <div class="swiper-button-next learner-groups-next"></div>
      <div class="swiper-button-prev learner-groups-prev"></div>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="cta-section position-relative">
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
        <a href="enquiry" class="btn-secondary">
          Enquiry
        </a>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
