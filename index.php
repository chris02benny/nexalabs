<?php include 'includes/header.php'; ?>

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
      <?php
      $featuredPrograms = [
        [
          'title' => 'Extended Reality (XR): AR & VR',
          'focusAreas' => [
            'Augmented Reality (AR) Development',
            'Virtual Reality (VR) Development',
            'Immersive Simulations & Interactive Experiences'
          ],
          'applications' => [
            'Education & Training',
            'Industrial Visualization',
            'Smart Maintenance & Field Services',
            'Cultural & Heritage Experiences',
            'Engineering & Scientific Simulations',
            'Skill Training & Safety Drills',
            'Healthcare & Rehabilitation',
            'Design Visualization & Gaming'
          ],
          'outcome' => 'Develops immersive application design skills, spatial thinking, and the ability to build interactive XR-based learning, training, and visualization solutions.',
          'icon' => 'badge-vr',
          'color' => 'purple'
        ],
        [
          'title' => 'Robotics & Intelligent Systems',
          'focusAreas' => [
            'Industrial Robotics',
            'Humanoid Robots',
            'Drones & Autonomous Systems',
            'AI-Enabled Robotics',
            'Robot Operating System (ROS & ROS2)'
          ],
          'applications' => [
            'Industrial Automation',
            'Smart Manufacturing',
            'Autonomous Navigation',
            'Human–Robot Interaction',
            'Research & Development'
          ],
          'outcome' => 'Builds hands-on expertise in robotics systems, automation, autonomy, and intelligent machine control using industry-grade platforms.',
          'icon' => 'robot',
          'color' => 'cyan'
        ],
        [
          'title' => 'Programming Foundations',
          'focusAreas' => [
            'C Programming Essentials',
            'Python for Beginners',
            'MySQL Mastery Bootcamp'
          ],
          'applications' => [
            'Software Development Foundations',
            'Data Processing & Automation',
            'Backend and Database Systems'
          ],
          'outcome' => 'Develops strong algorithmic thinking, problem-solving ability, and database fundamentals essential for advanced technology domains.',
          'icon' => 'code-slash',
          'color' => 'orange'
        ],
      ];
      
      foreach ($featuredPrograms as $index => $program):
      ?>
      <div class="col-lg-4" data-animate>
        <div class="glass-card program-detail-card p-4 robotics-card">
          <h4 class="program-detail-title mb-3"><?php echo $program['title']; ?></h4>
          
          <div class="program-preview mb-4">
            <div class="program-section mb-3">
              <h6 class="program-section-title">Programmes / Focus Areas</h6>
              <ul class="program-list">
                <?php foreach (array_slice($program['focusAreas'], 0, 3) as $area): ?>
                <li><?php echo $area; ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
            
            <div class="program-section mb-3">
              <h6 class="program-section-title">Applications</h6>
              <ul class="program-list">
                <?php foreach (array_slice($program['applications'], 0, 4) as $app): ?>
                <li><?php echo $app; ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
          
          <button class="btn-robotics-details w-100 mt-auto" onclick="openProgramModal(<?php echo $index; ?>)">
            <span>More Details</span>
            <i class="bi bi-arrow-right"></i>
          </button>
        </div>
      </div>
      
      <!-- Modal Data (hidden) -->
      <div class="program-modal-data" id="program-data-<?php echo $index; ?>" style="display: none;">
        <div class="program-modal-title"><?php echo $program['title']; ?></div>
        <div class="program-modal-icon"><?php echo $program['icon']; ?></div>
        <div class="program-modal-color"><?php echo $program['color']; ?></div>
        <div class="program-modal-focus-areas"><?php echo json_encode($program['focusAreas']); ?></div>
        <div class="program-modal-applications"><?php echo json_encode($program['applications']); ?></div>
        <div class="program-modal-outcome"><?php echo $program['outcome']; ?></div>
      </div>
      <?php endforeach; ?>
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
