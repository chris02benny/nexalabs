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

<!-- Hero Section: moving bg + coding / AI / robotics 3D elements -->
<section class="hero-3d hero-3d-flat">
  <!-- Keep: moving background (particles, glow, grid) -->
  <div class="hero-3d-bg">
    <div class="hero-3d-particles" id="heroParticles"></div>
    <div class="hero-3d-glow hero-3d-glow-1"></div>
    <div class="hero-3d-glow hero-3d-glow-2"></div>
    <div class="hero-3d-glow hero-3d-glow-3"></div>
    <div class="hero-3d-grid"></div>
  </div>

  <!-- Coding / AI / Robotics 3D theme elements -->
  <div class="hero-3d-theme-elements" aria-hidden="true">
    <!-- Coding: code snippet panel -->
    <div class="hero-3d-panel hero-3d-panel-code hero-3d-theme-coding">
      <div class="hero-3d-panel-header">Coding</div>
      <div class="hero-3d-code">
        <span class="code-line"><span class="code-num">1</span><span class="code-keyword">def</span> <span class="code-fn">train_model</span>(data):</span>
        <span class="code-line"><span class="code-num">2</span>  <span class="code-keyword">for</span> x <span class="code-keyword">in</span> data:</span>
        <span class="code-line"><span class="code-num">3</span>    <span class="code-keyword">yield</span> <span class="code-fn">predict</span>(<span class="code-string">"AI"</span>, x)</span>
        <span class="code-line"><span class="code-num">4</span>  <span class="code-comment"># NEXA Lab</span></span>
      </div>
    </div>
    <!-- AI: neural / sphere panel -->
    <div class="hero-3d-panel hero-3d-panel-sphere hero-3d-theme-ai">
      <div class="hero-3d-panel-header">AI</div>
      <div class="hero-3d-sphere-wrap">
        <div class="hero-3d-sphere">
          <div class="sphere-inner"></div>
          <div class="sphere-ring"></div>
          <div class="sphere-ring sphere-ring-2"></div>
          <div class="sphere-binary"></div>
        </div>
      </div>
    </div>
    <!-- Robotics: status panel + gear icon -->
    <div class="hero-3d-panel hero-3d-panel-compliance hero-3d-theme-robotics">
      <div class="hero-3d-panel-header">Robotics</div>
      <div class="hero-3d-progress">
        <div class="progress-row"><span>Arm</span><span>98%</span></div>
        <div class="eng-bar" style="--w: 98%;"></div>
        <div class="progress-row"><span>Vision</span><span>85%</span></div>
        <div class="eng-bar" style="--w: 85%;"></div>
        <div class="progress-row"><span>Logic</span><span>92%</span></div>
        <div class="eng-bar" style="--w: 92%;"></div>
      </div>
    </div>
    <div class="hero-3d-float-icon hero-3d-icon-code hero-3d-theme-icon-coding"><i class="bi bi-code-slash"></i></div>
    <div class="hero-3d-float-icon hero-3d-icon-ai hero-3d-theme-icon-ai"><i class="bi bi-cpu"></i></div>
    <div class="hero-3d-float-icon hero-3d-icon-robot hero-3d-theme-icon-robot"><i class="bi bi-robot"></i></div>
  </div>

  <div class="hero-3d-content">
    <div class="hero-3d-headline">
      <h1 class="hero-3d-title">Building Skills for <span class="hero-3d-gradient">Tomorrow's World</span></h1>
      <p class="hero-3d-subtitle">NEXA Future Ready Lab is a next-generation learning ecosystem that prepares students, educators, and professionals for emerging technologies through hands-on, industry-aligned learning.</p>
      <div class="hero-3d-cta-wrap">
        <a href="programs" class="hero-3d-cta">Explore Programs <i class="bi bi-arrow-right"></i></a>
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

<!-- Full-page dark theme: same design as hero for all index sections -->
<div class="page-dark-sections">
<!-- Stats Section -->
<section class="stats-section-fullscreen position-relative page-dark-section">
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
<section class="programs-section-fullscreen position-relative page-dark-section">
  <div class="section-container section-container-wide">
    <div class="programs-section-header text-center mb-5 d-flex flex-column align-items-center" data-animate>
      <span class="badge badge-purple mb-3">Our Programs</span>
      <h2 class="display-4 fw-bold mb-3">
        Programmes <span class="gradient-text-purple">Offered</span>
      </h2>
      <p class="text-muted fs-5 mx-auto" style="max-width: 800px;">
        All programmes follow a <strong>Learn – Build – Deploy</strong> approach, combining conceptual understanding with hands-on practice and real-world application.
      </p>
    </div>
    
    <div class="row g-4 justify-content-center align-items-stretch">
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
      <div class="col-12 col-sm-6 col-lg-6 d-flex" data-animate>
        <div class="glass-card program-detail-card p-4 w-100 d-flex flex-column">
          <div class="program-detail-card-badge mb-3 flex-shrink-0">
            <?php echo getProgramStatusBadge($program); ?>
          </div>
          
          <h4 class="program-detail-title mb-3 flex-shrink-0"><?php echo htmlspecialchars($program['program_name']); ?></h4>
          
          <div class="program-info flex-grow-1 mb-0">
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
          
          <a href="program_details.php?id=<?php echo $program['id']; ?>" class="btn-primary w-100 mt-auto flex-shrink-0" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
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
<section class="stats-section-fullscreen position-relative page-dark-section">
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
        <a href="enquiry" class="btn-secondary">
          Enquiry
        </a>
      </div>
    </div>
  </div>
</section>

</div><!-- .page-dark-sections -->

<?php include 'includes/footer.php'; ?>
