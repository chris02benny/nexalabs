<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section class="py-5 grid-bg" style="padding: 6rem 0 4rem;">
  <div class="section-container">
    <div class="text-center mx-auto slide-in-left" style="max-width: 800px;">
      <span class="badge badge-purple mb-4">
        🎓 All Programmes
      </span>
      
      <h1 class="display-3 fw-bold mb-4">
        Programmes <span class="gradient-text-purple">Offered</span>
      </h1>
      
      <p class="text-muted fs-5">
        All programmes follow a <strong>Learn – Build – Deploy</strong> approach, combining conceptual understanding with hands-on practice and real-world application.
      </p>
    </div>
  </div>
</section>

<!-- All Programs Grid -->
<section class="py-5" style="padding: 5rem 0;">
  <div class="section-container">
    <div class="row g-4">
      <?php
      $allPrograms = [
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
        [
          'title' => 'Data & Artificial Intelligence',
          'focusAreas' => [
            'Data Analytics with Excel, SQL, Python & Power BI',
            'Practical Machine Learning & Deep Learning Bootcamp',
            'Generative AI Bootcamp',
            'AI in Content Creation',
            'AI in Film Making'
          ],
          'applications' => [
            'Predictive Analytics',
            'Intelligent Decision Systems',
            'Content & Media Automation',
            'Data-Driven Business Solutions'
          ],
          'outcome' => 'Enables learners to design, build, and deploy AI-powered solutions using real-world data and industry tools.',
          'icon' => 'brain',
          'color' => 'purple'
        ],
        [
          'title' => 'AI Mastery Program (Flagship)',
          'focusAreas' => [
            'Machine Learning & Deep Learning',
            'Computer Vision',
            'Natural Language Processing (NLP)',
            'Generative AI & Foundation Models',
            'Reinforcement Learning',
            'Edge AI',
            'AI integration with Robotics, XR & Digital Twin applications'
          ],
          'applications' => [
            'Advanced AI Systems',
            'Intelligent Automation',
            'Robotics & Autonomous Systems',
            'XR-based Intelligent Applications',
            'Research & Product Development'
          ],
          'outcome' => 'Prepares learners for advanced AI roles, research pathways, and real-world industry deployment.',
          'icon' => 'stars',
          'color' => 'cyan'
        ],
        [
          'title' => 'Robotics & Embedded Systems',
          'focusAreas' => [
            'Arduino Robot Maker',
            'Circuit Simulation & Design',
            'Mastering Arduino (Beginner to Pro)',
            'AVR Bare-Metal Programming',
            'ARM Register-Level Programming & Driver Development',
            'Mastering RTOS',
            'Mastering IoT from Scratch',
            'IoT & Edge AI Workshop',
            'Raspberry Pi Mastery'
          ],
          'applications' => [
            'Embedded Product Development',
            'IoT Systems & Smart Devices',
            'Automation & Control Systems',
            'Edge AI Solutions'
          ],
          'outcome' => 'Builds industry-relevant skills in embedded systems, automation, and connected intelligent devices.',
          'icon' => 'cpu',
          'color' => 'orange'
        ],
        [
          'title' => 'Advanced & Specialized Workshops',
          'focusAreas' => [
            'Robotic Manipulator Workshop with ROS2',
            'Unitree GO2 Hands-on Workshop with ROS2',
            'Python Django Development Workshop',
            'STEM Trainer Certification'
          ],
          'applications' => [
            'Advanced Research & Prototyping',
            'Industrial Deployment',
            'Technical Training & Certification'
          ],
          'outcome' => 'Prepares participants for advanced research, industrial deployment, and professional training roles.',
          'icon' => 'gear',
          'color' => 'purple'
        ],
      ];
      
      foreach ($allPrograms as $program):
      ?>
      <div class="col-lg-6 col-xl-4" data-animate>
        <div class="glass-card program-detail-card p-4 h-100">
          <div class="program-icon-large mb-3">
            <i class="bi bi-<?php echo $program['icon']; ?>" style="font-size: 2.5rem; color: var(--<?php echo $program['color']; ?>);"></i>
          </div>
          <h4 class="program-detail-title mb-3"><?php echo $program['title']; ?></h4>
          
          <div class="program-section mb-3">
            <h6 class="program-section-title">Programmes / Focus Areas</h6>
            <ul class="program-list">
              <?php foreach ($program['focusAreas'] as $area): ?>
              <li><?php echo $area; ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
          
          <div class="program-section mb-3">
            <h6 class="program-section-title">Applications</h6>
            <ul class="program-list">
              <?php foreach ($program['applications'] as $app): ?>
              <li><?php echo $app; ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
          
          <div class="program-section mb-4">
            <h6 class="program-section-title">Outcome</h6>
            <p class="program-outcome"><?php echo $program['outcome']; ?></p>
          </div>
          
          <a href="register" class="btn-primary w-100 mt-auto">Register Now</a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>


<?php include 'includes/footer.php'; ?>
