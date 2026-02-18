<?php include 'includes/header.php'; ?>

<!-- Hero Section - DataCore-style 3D Glassmorphism -->
<section class="hero-3d">
  <!-- Dark background with gradient glow -->
  <div class="hero-3d-bg">
    <div class="hero-3d-particles" id="heroParticles"></div>
    <div class="hero-3d-glow hero-3d-glow-1"></div>
    <div class="hero-3d-glow hero-3d-glow-2"></div>
    <div class="hero-3d-glow hero-3d-glow-3"></div>
    <div class="hero-3d-grid"></div>
  </div>

  <div class="hero-3d-content">
    <!-- Centered hero text -->
    <div class="hero-3d-headline">
      <h1 class="hero-3d-title">Building Skills for <span class="hero-3d-gradient">Tomorrow's World</span></h1>
      <p class="hero-3d-subtitle">NEXA Future Ready Lab is a next-generation learning ecosystem that prepares students, educators, and professionals for emerging technologies through hands-on, industry-aligned learning.</p>
      <div class="hero-3d-cta-wrap">
        <a href="programs" class="hero-3d-cta">Explore Programs <i class="bi bi-arrow-right"></i></a>
        <a href="register" class="hero-3d-cta hero-3d-cta-outline">Register Now</a>
      </div>
    </div>

    <!-- Left column panels -->
    <div class="hero-3d-panel hero-3d-panel-code">
      <div class="hero-3d-panel-header">// Type some code →</div>
      <div class="hero-3d-code">
        <span class="code-line"><span class="code-num">1</span><span class="code-keyword">const</span> lab = <span class="code-string">"NEXA"</span>;</span>
        <span class="code-line"><span class="code-num">2</span><span class="code-keyword">await</span> lab.<span class="code-fn">learn</span>(<span class="code-string">"XR"</span>, <span class="code-string">"AI"</span>);</span>
        <span class="code-line"><span class="code-num">3</span><span class="code-comment">// Future-ready skills</span></span>
      </div>
    </div>

    <div class="hero-3d-panel hero-3d-panel-logs">
      <div class="hero-3d-panel-header">Database Logs</div>
      <div class="hero-3d-logs">
        <div class="log-line"><span class="log-time">14:2:09</span> - <span class="log-info">INFO</span></div>
        <div class="log-line"><span class="log-time">14:2:09</span> - <span class="log-query">QUERY DATA</span></div>
        <div class="log-line"><span class="log-time">14:2:10</span> - <span class="log-info">CONNECTED</span></div>
      </div>
      <div class="hero-3d-scan-beam"></div>
    </div>

    <!-- Floating glass panels - center/right -->
    <div class="hero-3d-panel hero-3d-panel-pipeline">
      <div class="hero-3d-panel-header">Learning Pipeline</div>
      <div class="hero-3d-flow">
        <div class="flow-box">Ingest Sources</div>
        <div class="flow-box">Transform Data</div>
        <div class="flow-row">
          <div class="flow-box">Orchestrate</div>
          <div class="flow-box">Execute</div>
        </div>
        <a href="programs" class="flow-cta">Output via API</a>
      </div>
    </div>

    <div class="hero-3d-panel hero-3d-panel-compliance">
      <div class="hero-3d-panel-header">Progress Tracking</div>
      <div class="hero-3d-progress">
        <div class="progress-row"><span>Overdue</span><span>3%</span></div>
        <div class="progress-row"><span>Pending</span><span>14%</span></div>
        <div class="progress-row"><span>Completed</span><span>86%</span></div>
      </div>
    </div>

    <!-- 3D AI/Data sphere panel -->
    <div class="hero-3d-panel hero-3d-panel-sphere">
      <div class="hero-3d-panel-header">AI & Data Layer</div>
      <div class="hero-3d-sphere-wrap">
        <div class="hero-3d-sphere">
          <div class="sphere-inner"></div>
          <div class="sphere-ring"></div>
          <div class="sphere-ring sphere-ring-2"></div>
          <div class="sphere-binary"></div>
        </div>
      </div>
    </div>

    <!-- Engagement / Stats meter -->
    <div class="hero-3d-panel hero-3d-panel-engagement">
      <div class="hero-3d-engagement-value">82</div>
      <div class="hero-3d-engagement-title">Engagement</div>
      <div class="hero-3d-bars">
        <div class="eng-bar" style="--w: 70%"></div>
        <div class="eng-bar" style="--w: 85%"></div>
        <div class="eng-bar" style="--w: 60%"></div>
        <div class="eng-bar" style="--w: 90%"></div>
      </div>
    </div>

    <!-- Score dial -->
    <div class="hero-3d-panel hero-3d-panel-score">
      <div class="hero-3d-score-value">72</div>
      <div class="hero-3d-score-label">score</div>
      <svg class="hero-3d-score-ring" viewBox="0 0 100 100">
        <defs>
          <linearGradient id="scoreGradient" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#3b82f6"/>
            <stop offset="100%" style="stop-color:#6366f1"/>
          </linearGradient>
        </defs>
        <circle class="score-bg" cx="50" cy="50" r="45"/>
        <circle class="score-fill" cx="50" cy="50" r="45" style="stroke-dasharray: 212 283; stroke-dashoffset: 71; stroke: url(#scoreGradient)"/>
      </svg>
    </div>

    <!-- Floating 3D icons -->
    <div class="hero-3d-float-icon hero-3d-icon-cloud"><i class="bi bi-cloud"></i></div>
    <div class="hero-3d-float-icon hero-3d-icon-db"><i class="bi bi-database"></i></div>
    <div class="hero-3d-float-icon hero-3d-icon-gear"><i class="bi bi-gear"></i></div>
    <div class="hero-3d-float-icon hero-3d-icon-code"><i class="bi bi-code-slash"></i></div>
    <div class="hero-3d-float-icon hero-3d-icon-globe"><i class="bi bi-globe"></i></div>

    <!-- Stats bar at bottom -->
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
