<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section class="py-5 grid-bg" style="padding: 6rem 0 4rem;">
  <div class="section-container">
    <div class="text-center mx-auto slide-in-left" style="max-width: 800px;">
      <span class="badge badge-purple mb-4">
        🌟 About Us
      </span>
      
      <h1 class="display-3 fw-bold mb-4">
        Shaping the <span class="gradient-text">Future</span> of Tech Education
      </h1>
      
      <p class="text-muted fs-5">
        A collaboration between global STEM education leaders and academic excellence.
      </p>
    </div>
  </div>
</section>

<!-- Tabbed Content Section -->
<section class="py-5" style="padding: 3rem 0 5rem;">
  <div class="section-container">
    <!-- Tab Navigation -->
    <div class="tab-navigation mb-5" data-animate>
      <div class="d-flex justify-content-center gap-3 flex-wrap">
        <button class="tab-btn active" onclick="switchTab('uwr')" id="tab-uwr">
          <i class="bi bi-robot me-2"></i>
          About Unique World Robotics
        </button>
        <button class="tab-btn" onclick="switchTab('ajce')" id="tab-ajce">
          <i class="bi bi-mortarboard me-2"></i>
          About Amal Jyothi College of Engineering
        </button>
      </div>
    </div>

    <!-- Tab Content -->
    <div class="tab-content-wrapper">
      <!-- Unique World Robotics Tab -->
      <div class="tab-content active" id="content-uwr">
        <div class="glass-card no-hover p-5" data-animate>
          <div class="row align-items-center mb-4">
            <div class="col-md-2 text-center mb-3 mb-md-0">
              <div class="program-icon mx-auto" style="width: 80px; height: 80px; background: linear-gradient(135deg, hsla(190, 100%, 50%, 0.2), hsla(270, 80%, 60%, 0.2));">
                <i class="bi bi-robot" style="font-size: 2.5rem; color: var(--cyan);"></i>
              </div>
            </div>
            <div class="col-md-10">
              <h2 class="h3 fw-bold mb-2">Unique World Robotics</h2>
              <p class="text-muted mb-0"><i class="bi bi-geo-alt me-2"></i>Founded 2019 • Headquartered in Dubai</p>
            </div>
          </div>

          <div class="content-section">
            <p class="lead mb-4">
              Founded in 2019 and headquartered in Dubai, Unique World Robotics is a global leader in STEM education, robotics, and emerging technology training, with active operations across India, the UAE, and the Middle East.
            </p>

            <div class="row g-4 mb-4">
              <div class="col-md-6">
                <div class="feature-box p-4 rounded-3" style="background: hsla(190, 100%, 50%, 0.05); border-left: 4px solid var(--cyan);">
                  <h5 class="fw-bold mb-2"><i class="bi bi-bullseye me-2 text-primary"></i>Our Focus</h5>
                  <p class="text-muted mb-0">Building socially responsible, future-ready learners through innovation-driven education.</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="feature-box p-4 rounded-3" style="background: hsla(270, 80%, 60%, 0.05); border-left: 4px solid var(--purple);">
                  <h5 class="fw-bold mb-2"><i class="bi bi-globe me-2 text-purple"></i>Global Reach</h5>
                  <p class="text-muted mb-0">Active operations across India, UAE, and the Middle East region.</p>
                </div>
              </div>
            </div>

            <div class="highlight-section p-4 rounded-3 mb-4" style="background: linear-gradient(135deg, hsla(250, 60%, 96%, 0.8), hsla(240, 50%, 94%, 0.8)); border: 1px solid hsla(270, 80%, 60%, 0.2);">
              <h5 class="fw-bold mb-3"><i class="bi bi-star-fill me-2" style="color: var(--orange);"></i>Recent Highlight</h5>
              <p class="mb-3">
                Unique World Robotics was recently in the news for hosting renowned <strong>NASA astronaut Sunita Williams</strong> during her visit to India. As part of the engagement, the organisation interacted with Williams to promote robotics, AI, and STEM education, inspiring students to pursue careers in science and technology.
              </p>
              <p class="text-muted mb-0">
                <i class="bi bi-lightbulb me-2"></i>
                The visit highlighted the growing role of Indian robotics initiatives in connecting global space achievements with grassroots innovation and learning.
              </p>
            </div>

            <div class="row g-3">
              <div class="col-md-4">
                <div class="stat-box text-center p-3 rounded-3" style="background: hsla(190, 100%, 50%, 0.1);">
                  <h4 class="fw-bold gradient-text mb-1">2019</h4>
                  <p class="text-muted small mb-0">Year Founded</p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="stat-box text-center p-3 rounded-3" style="background: hsla(270, 80%, 60%, 0.1);">
                  <h4 class="fw-bold gradient-text mb-1">3+</h4>
                  <p class="text-muted small mb-0">Countries</p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="stat-box text-center p-3 rounded-3" style="background: hsla(24, 100%, 60%, 0.1);">
                  <h4 class="fw-bold gradient-text mb-1">STEM</h4>
                  <p class="text-muted small mb-0">Education Focus</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Amal Jyothi College Tab -->
      <div class="tab-content" id="content-ajce">
        <div class="glass-card no-hover p-5" data-animate>
          <div class="row align-items-center mb-4">
            <div class="col-md-2 text-center mb-3 mb-md-0">
              <div class="program-icon mx-auto" style="width: 80px; height: 80px; background: linear-gradient(135deg, hsla(24, 100%, 60%, 0.2), hsla(270, 80%, 60%, 0.2));">
                <i class="bi bi-mortarboard" style="font-size: 2.5rem; color: var(--orange);"></i>
              </div>
            </div>
            <div class="col-md-10">
              <h2 class="h3 fw-bold mb-2">Amal Jyothi College of Engineering</h2>
              <p class="text-muted mb-0"><i class="bi bi-geo-alt me-2"></i>Kerala, India • NAAC A+ Accredited</p>
            </div>
          </div>

          <div class="content-section">
            <p class="lead mb-4">
              Amal Jyothi College of Engineering (AJCE) is an autonomous institution in Kerala, accredited with NAAC A+ and NBA, and approved by AICTE (affiliated to KTU). Set on one of the largest and most vibrant engineering campuses in the state, AJCE offers a learning environment where academic rigor meets innovation and real-world relevance.
            </p>

            <div class="mb-4">
              <h5 class="fw-bold mb-3"><i class="bi bi-lightbulb-fill me-2 text-primary"></i>Future-Ready Education</h5>
              <p class="text-muted">
                The college emphasizes future-ready education through interdisciplinary curricula, <strong>35+ B.Tech Major–Minor combinations</strong>, and hands-on exposure in emerging domains such as:
              </p>
              <div class="row g-2 mb-3">
                <div class="col-md-6">
                  <div class="d-flex align-items-center p-2 rounded" style="background: hsla(190, 100%, 50%, 0.05);">
                    <i class="bi bi-check-circle-fill me-2 text-primary"></i>
                    <span>Artificial Intelligence</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="d-flex align-items-center p-2 rounded" style="background: hsla(190, 100%, 50%, 0.05);">
                    <i class="bi bi-check-circle-fill me-2 text-primary"></i>
                    <span>Data Science</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="d-flex align-items-center p-2 rounded" style="background: hsla(270, 80%, 60%, 0.05);">
                    <i class="bi bi-check-circle-fill me-2 text-purple"></i>
                    <span>Cyber Security</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="d-flex align-items-center p-2 rounded" style="background: hsla(270, 80%, 60%, 0.05);">
                    <i class="bi bi-check-circle-fill me-2 text-purple"></i>
                    <span>Electric Vehicles</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="d-flex align-items-center p-2 rounded" style="background: hsla(24, 100%, 60%, 0.05);">
                    <i class="bi bi-check-circle-fill me-2 text-secondary"></i>
                    <span>Advanced Electronics</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="highlight-section p-4 rounded-3 mb-4" style="background: linear-gradient(135deg, hsla(250, 60%, 96%, 0.8), hsla(240, 50%, 94%, 0.8)); border: 1px solid hsla(270, 80%, 60%, 0.2);">
              <h5 class="fw-bold mb-3"><i class="bi bi-rocket-takeoff me-2" style="color: var(--orange);"></i>Innovation Ecosystem</h5>
              <p class="mb-2">
                A strong innovation ecosystem—powered by:
              </p>
              <ul class="mb-0">
                <li><strong>Startups Valley</strong> - Entrepreneurship incubation</li>
                <li><strong>AICTE IDEA Lab</strong> - Innovation and development</li>
                <li><strong>NEXA Future-Ready Labs</strong> - Cutting-edge technology training</li>
              </ul>
              <p class="text-muted mt-3 mb-0">
                <i class="bi bi-arrow-right-circle me-2"></i>
                Enables students to transform ideas into impactful solutions.
              </p>
            </div>

            <div class="mb-4">
              <h5 class="fw-bold mb-3"><i class="bi bi-trophy-fill me-2" style="color: var(--orange);"></i>Programs Offered</h5>
              <div class="d-flex flex-wrap gap-2">
                <span class="badge badge-cyan">B.Tech</span>
                <span class="badge badge-purple">M.Tech</span>
                <span class="badge badge-orange">BBA</span>
                <span class="badge badge-cyan">BCA</span>
                <span class="badge badge-purple">MCA</span>
                <span class="badge badge-orange">PhD</span>
              </div>
            </div>

            <div class="text-center p-4 rounded-3" style="background: hsla(190, 100%, 50%, 0.05);">
              <p class="mb-2 fw-semibold">Learn More</p>
              <a href="https://www.ajce.in" target="_blank" class="btn btn-primary">
                <i class="bi bi-globe me-2"></i>Visit www.ajce.in
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
/* Tab Navigation Styles */
.tab-navigation {
  position: relative;
}

.tab-btn {
  padding: 1rem 2rem;
  border: 2px solid hsla(270, 80%, 60%, 0.2);
  background: var(--glass-bg);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border-radius: 9999px;
  font-weight: 600;
  color: var(--muted-foreground);
  cursor: pointer;
  transition: all 0.3s ease;
  font-size: 1rem;
  white-space: nowrap;
}

.tab-btn:hover {
  border-color: var(--purple);
  color: var(--purple);
  transform: translateY(-2px);
  box-shadow: 0 4px 12px hsla(270, 80%, 60%, 0.15);
}

.tab-btn.active {
  background: linear-gradient(135deg, hsl(250, 70%, 55%) 0%, hsl(270, 80%, 60%) 100%);
  border-color: transparent;
  color: white;
  box-shadow: 0 4px 14px hsla(250, 70%, 55%, 0.3);
}

.tab-btn i {
  font-size: 1.1rem;
}

/* Tab Content Styles */
.tab-content-wrapper {
  position: relative;
  min-height: 600px;
}

.tab-content {
  display: none;
  opacity: 0;
  animation: fadeInContent 0.5s ease-out forwards;
}

.tab-content.active {
  display: block;
}

@keyframes fadeInContent {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Feature Box Styles */
.feature-box {
  transition: all 0.3s ease;
}

.feature-box:hover {
  transform: translateX(5px);
}

.highlight-section {
  transition: all 0.3s ease;
}

.highlight-section:hover {
  box-shadow: 0 8px 24px hsla(270, 80%, 60%, 0.15);
}

.stat-box {
  transition: all 0.3s ease;
}

.stat-box:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 12px hsla(0, 0%, 0%, 0.1);
}

.text-purple {
  color: var(--purple);
}

/* Responsive Design */
@media (max-width: 768px) {
  .tab-btn {
    padding: 0.75rem 1.5rem;
    font-size: 0.9rem;
  }
  
  .tab-btn i {
    font-size: 1rem;
  }
  
  .program-icon {
    width: 60px !important;
    height: 60px !important;
  }
  
  .program-icon i {
    font-size: 2rem !important;
  }
}
</style>

<script>
function switchTab(tabName) {
  // Remove active class from all tabs and content
  document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.classList.remove('active');
  });
  document.querySelectorAll('.tab-content').forEach(content => {
    content.classList.remove('active');
  });
  
  // Add active class to selected tab and content
  document.getElementById('tab-' + tabName).classList.add('active');
  document.getElementById('content-' + tabName).classList.add('active');
}
</script>

<?php include 'includes/footer.php'; ?>
