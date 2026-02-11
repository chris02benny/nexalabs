<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section class="hero-section">
  <div class="section-container">
    <div class="row align-items-center">
      <!-- Content -->
      <div class="col-lg-6 mb-5 mb-lg-0 slide-in-left">
        <h1 class="display-3 fw-bold mb-3">
          Building Skills for <span class="gradient-text">Tomorrow's World</span>
        </h1>
        
        <p class="hero-tagline mb-3" style="font-size: 1.1rem; font-weight: 600; color: var(--cyan);">
           Powered by AJCE × Unique World Robotics (India & UAE)
        </p>
        
        <p class="text-muted mb-3" style="max-width: 600px; line-height: 1.7;">
          The NEXA Future Ready Lab is a next-generation learning and innovation ecosystem designed to prepare students, educators, and professionals for emerging technologies through hands-on, industry-aligned learning.
        </p>
        
        <p class="text-muted mb-4" style="max-width: 600px; line-height: 1.7;">
          Our programs span schools, colleges, and advanced learners, combining Extended Reality (XR), Artificial Intelligence, Robotics, Embedded Systems, and Digital Technologies into a unified, future-ready platform.
        </p>
        
        <div class="d-flex flex-column flex-sm-row gap-3">
          <a href="programs.php" class="btn-primary">
            Explore Programs </i>
          </a>
          <a href="register.php" class="btn-secondary">
            Register Now</i>
          </a>
        </div>
      </div>
      
      <!-- Hero Image -->
      <div class="col-lg-6 scale-in">
        <div class="hero-glow text-center">
          <img src="assets/images/hero-robot.png" alt="Nexalabs Robot" class="img-fluid rounded-3 float-animation">
          
          <!-- Floating Badges -->
          <div class="position-absolute top-0 end-0 glass-card p-3 rounded-3 float-animation-delayed" style="margin: -1rem;">
            <i class="bi bi-cpu" style="font-size: 2rem; color: var(--cyan);"></i>
          </div>
          
          <div class="position-absolute bottom-0 start-0 glass-card p-3 rounded-3 float-animation" style="margin: 2rem 0 0 -1rem;">
            <i class="bi bi-lightning-charge" style="font-size: 2rem; color: var(--orange);"></i>
          </div>
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
      
      foreach ($featuredPrograms as $program):
      ?>
      <div class="col-lg-4" data-animate>
        <div class="glass-card program-detail-card p-4 h-100">
          <div class="program-icon-large mb-3">
            <i class="bi bi-<?php echo $program['icon']; ?>" style="font-size: 2.5rem; color: var(--<?php echo $program['color']; ?>);"></i>
          </div>
          <h4 class="program-detail-title mb-3"><?php echo $program['title']; ?></h4>
          
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
          
          <div class="program-section mb-3">
            <h6 class="program-section-title">Outcome</h6>
            <p class="program-outcome"><?php echo $program['outcome']; ?></p>
          </div>
          
          <a href="programs.php" class="btn-outline w-100 mt-auto">View All Details</a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    
    <div class="text-center mt-5" data-animate>
      <a href="programs.php" class="btn-primary">
        View All Programmes <i class="bi bi-arrow-right ms-2"></i>
      </a>
    </div>
  </div>
</section>

<!-- Learner Groups Section -->
<section class="stats-section-fullscreen position-relative">
  <div class="section-container">
    <div class="text-center mb-5" data-animate>
      <span class="badge badge-purple mb-3">Who We Serve</span>
      <h2 class="display-4 fw-bold mb-3">
        <span class="gradient-text-purple">Learner Groups</span>
      </h2>
      <p class="text-muted fs-5 mx-auto" style="max-width: 800px;">
        Our programmes cater to a wide range of learners, ensuring age-appropriate depth, career relevance, and industry alignment.
      </p>
    </div>
    
    <div class="row g-4">
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
      <div class="col-lg-4 col-md-6" data-animate style="animation-delay: <?php echo 0.2 + ($index * 0.1); ?>s;">
        <div class="glass-card learner-group-card p-4 h-100">
          <div class="mb-3">
            <i class="bi bi-<?php echo $group['icon']; ?>" style="font-size: 2.5rem; color: var(--<?php echo $group['color']; ?>);"></i>
          </div>
          <h4 class="learner-group-title mb-3"><?php echo $group['title']; ?></h4>
          <p class="learner-group-description"><?php echo $group['description']; ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="py-5 position-relative" style="padding: 5rem 0;">
  <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to right, hsla(190, 100%, 50%, 0.1), hsla(270, 80%, 60%, 0.1), hsla(24, 100%, 60%, 0.1)); z-index: -1;"></div>
  
  <div class="section-container">
    <div class="glass-card no-hover p-5 text-center" data-animate>
      <h2 class="display-5 fw-bold mb-3">Ready to Start Your Journey?</h2>
      <p class="text-muted fs-5 mb-4 mx-auto" style="max-width: 700px;">
        Join our community of young innovators and take the first step towards becoming a tech leader of tomorrow.
      </p>
      <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
        <a href="register.php" class="btn-primary">
          Register Now <i class="bi bi-arrow-right ms-2"></i>
        </a>
        <a href="enquiry.php" class="btn-outline">
          Contact Us
        </a>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
