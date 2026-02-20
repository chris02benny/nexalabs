<?php 
require_once 'includes/db_connection.php';
require_once 'includes/programs_helper.php';

// Get program ID from URL
$programId = intval($_GET['id'] ?? 0);

if ($programId <= 0) {
    header('Location: programs.php');
    exit;
}

// Get PDO connection
$pdo = isset($GLOBALS['pdo']) ? $GLOBALS['pdo'] : require_once 'includes/db_connection.php';

// Fetch program details
try {
    $stmt = $pdo->prepare("SELECT * FROM programs WHERE id = ? AND isactive = 1 LIMIT 1");
    $stmt->execute([$programId]);
    $program = $stmt->fetch();
    
    if (!$program) {
        header('Location: programs.php');
        exit;
    }
    
    $focusAreas = formatProgramText($program['focus_areas']);
    $applications = formatProgramText($program['applications']);
    $regStart = $program['reg_start_date'] ?? null;
    $regEnd = $program['reg_end_date'] ?? null;
    $progStart = $program['program_start_date'] ?? null;
    $progEnd = $program['program_end_date'] ?? null;
    $programDays = calculateProgramDays($progStart, $progEnd);
} catch (PDOException $e) {
    error_log("Get Program Details Error: " . $e->getMessage());
    header('Location: programs.php');
    exit;
}

include 'includes/header.php'; 
?>

<style>
.program-details-hero {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  padding: 5rem 0 3rem;
  position: relative;
  overflow: hidden;
}

.program-details-hero::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M 100 0 L 0 0 0 100" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
  opacity: 0.3;
}

.program-details-hero-content {
  position: relative;
  z-index: 1;
}

.info-card {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
  border-radius: 16px;
  padding: 1.5rem;
  margin-bottom: 1.5rem;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.2);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.info-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.info-card-icon {
  width: 50px;
  height: 50px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  margin-bottom: 1rem;
}

.info-card-icon.primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
.info-card-icon.success { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white; }
.info-card-icon.info { background: linear-gradient(135deg, #3494E6 0%, #EC6EAD 100%); color: white; }
.info-card-icon.warning { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; }

.info-card-label {
  font-size: 0.875rem;
  color: #6c757d;
  margin-bottom: 0.5rem;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.info-card-value {
  font-size: 1.1rem;
  color: #212529;
  font-weight: 600;
}

.content-section {
  background: #ffffff;
  border-radius: 16px;
  padding: 2rem;
  margin-bottom: 2rem;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  border: 1px solid #e9ecef;
}

.content-section-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: #212529;
  margin-bottom: 1.5rem;
  display: flex;
  align-items: center;
  padding-bottom: 1rem;
  border-bottom: 2px solid #f0f0f0;
}

.content-section-title i {
  margin-right: 0.75rem;
  color: #667eea;
  font-size: 1.75rem;
}

.content-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.content-list li {
  padding: 1rem;
  margin-bottom: 0.75rem;
  background: #f8f9fa;
  border-radius: 10px;
  border-left: 4px solid #667eea;
  color: #212529;
  font-size: 1rem;
  line-height: 1.6;
  transition: all 0.3s ease;
}

.content-list li:hover {
  background: #e9ecef;
  transform: translateX(5px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.content-outcome {
  color: #212529;
  font-size: 1rem;
  line-height: 1.8;
  padding: 1.5rem;
  background: #f8f9fa;
  border-radius: 10px;
  border-left: 4px solid #38ef7d;
}

.sticky-sidebar {
  position: sticky;
  top: 2rem;
}

.register-card {
  background: #ffffff;
  border-radius: 16px;
  padding: 2.5rem 2rem;
  text-align: center;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
  border: 2px solid #e9ecef;
  position: relative;
  overflow: hidden;
}

.register-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
}

.register-card h3 {
  font-size: 1.5rem;
  font-weight: 700;
  color: #212529;
  margin-bottom: 0.75rem;
}

.register-card p {
  color: #6c757d;
  margin-bottom: 2rem;
  font-size: 0.95rem;
  line-height: 1.6;
}

.btn-register-large {
  background: #212529;
  color: #ffffff;
  padding: 1.25rem 3rem;
  font-size: 1.1rem;
  font-weight: 600;
  border-radius: 12px;
  border: 2px solid #212529;
  transition: all 0.3s ease;
  display: inline-block;
  text-decoration: none;
  width: 100%;
  text-align: center;
  position: relative;
  overflow: hidden;
}

.btn-register-large::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
  transition: left 0.5s ease;
}

.btn-register-large:hover::before {
  left: 100%;
}

.btn-register-large:hover {
  background: #000000;
  border-color: #000000;
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
  color: #ffffff;
}

.btn-register-large:active {
  transform: translateY(0);
}

.register-card-icon {
  width: 64px;
  height: 64px;
  margin: 0 auto 1.5rem;
  background: #f8f9fa;
  border-radius: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2rem;
  color: #667eea;
  border: 2px solid #e9ecef;
}

@media (max-width: 991px) {
  .sticky-sidebar {
    position: relative;
    top: 0;
    margin-top: 2rem;
  }
}
</style>

<!-- Hero Section -->
<section class="program-details-hero">
  <div class="section-container">
    <div class="program-details-hero-content">
      <div class="row align-items-center">
        <div class="col-lg-8">
          <div class="mb-3">
            <?php echo getProgramStatusBadge($program); ?>
          </div>
          <h1 class="display-3 fw-bold text-white mb-3">
            <?php echo htmlspecialchars($program['program_name']); ?>
          </h1>
          <p class="lead text-white-50 mb-0">
            Comprehensive program designed to build future-ready skills through hands-on learning
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Main Content Section -->
<section class="py-5" style="padding: 4rem 0; background: #f8f9fa;">
  <div class="section-container">
    <div class="row g-4">
      <!-- Left Column - Key Information -->
      <div class="col-lg-4 order-lg-1 order-2">
        <div class="sticky-sidebar">
          <!-- Quick Info Cards - Hidden on mobile, shown on desktop -->
          <div class="d-none d-lg-block">
            <?php if ($regStart && $regEnd): ?>
            <div class="info-card">
              <div class="info-card-icon primary">
                <i class="bi bi-calendar-event"></i>
              </div>
              <div class="info-card-label">Registration Period</div>
              <div class="info-card-value">
                <?php echo date('M d, Y', strtotime($regStart)); ?><br>
                <small class="text-muted">to</small><br>
                <?php echo date('M d, Y', strtotime($regEnd)); ?>
              </div>
            </div>
            <?php endif; ?>
            
            <?php if ($progStart && $progEnd): ?>
            <div class="info-card">
              <div class="info-card-icon success">
                <i class="bi bi-calendar-check"></i>
              </div>
              <div class="info-card-label">Course Period</div>
              <div class="info-card-value">
                <?php echo date('M d, Y', strtotime($progStart)); ?><br>
                <small class="text-muted">to</small><br>
                <?php echo date('M d, Y', strtotime($progEnd)); ?>
              </div>
            </div>
            <?php endif; ?>
            
            <?php if ($programDays): ?>
            <div class="info-card">
              <div class="info-card-icon info">
                <i class="bi bi-clock"></i>
              </div>
              <div class="info-card-label">Duration</div>
              <div class="info-card-value">
                <?php echo $programDays; ?> <?php echo $programDays == 1 ? 'Day' : 'Days'; ?>
              </div>
            </div>
            <?php endif; ?>
          </div>
          
          <!-- Register Card - Hidden on mobile, shown in sidebar on desktop -->
          <div class="register-card d-none d-lg-block">
            <div class="register-card-icon">
              <i class="bi bi-rocket-takeoff"></i>
            </div>
            <h3>Ready to Join?</h3>
            <p>Start your journey towards mastering future technologies and building innovative solutions</p>
            <a href="register.php?id=<?php echo $program['id']; ?>" class="btn-register-large">
              Register Now <i class="bi bi-arrow-right ms-2"></i>
            </a>
            <div class="mt-3 pt-3" style="border-top: 1px solid #e9ecef;">
              <small class="text-muted d-block mb-2">
                <i class="bi bi-shield-check me-1"></i>
                Secure Registration
              </small>
              <small class="text-muted">
                <i class="bi bi-clock me-1"></i>
                Limited Seats Available
              </small>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Right Column - Detailed Content -->
      <div class="col-lg-8 order-lg-2 order-1">
        <!-- Focus Areas -->
        <?php if (!empty($focusAreas)): ?>
        <div class="content-section">
          <h3 class="content-section-title">
            <i class="bi bi-gear-fill"></i>
            Programmes / Focus Areas
          </h3>
          <ul class="content-list">
            <?php foreach ($focusAreas as $area): ?>
            <li>
              <i class="bi bi-check-circle-fill me-2 text-success"></i>
              <?php echo htmlspecialchars($area); ?>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>
        
        <!-- Applications -->
        <?php if (!empty($applications)): ?>
        <div class="content-section">
          <h3 class="content-section-title">
            <i class="bi bi-application"></i>
            Applications
          </h3>
          <ul class="content-list">
            <?php foreach ($applications as $app): ?>
            <li>
              <i class="bi bi-check-circle-fill me-2 text-primary"></i>
              <?php echo htmlspecialchars($app); ?>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>
        
        <!-- Outcome -->
        <?php if (!empty($program['outcome'])): ?>
        <div class="content-section">
          <h3 class="content-section-title">
            <i class="bi bi-trophy-fill"></i>
            Expected Outcome
          </h3>
          <div class="content-outcome">
            <?php echo nl2br(htmlspecialchars($program['outcome'])); ?>
          </div>
        </div>
        <?php endif; ?>
        
        <!-- Info Cards - Mobile View (shown after content sections) -->
        <div class="d-lg-none">
          <?php if ($regStart && $regEnd): ?>
          <div class="info-card">
            <div class="info-card-icon primary">
              <i class="bi bi-calendar-event"></i>
            </div>
            <div class="info-card-label">Registration Period</div>
            <div class="info-card-value">
              <?php echo date('M d, Y', strtotime($regStart)); ?><br>
              <small class="text-muted">to</small><br>
              <?php echo date('M d, Y', strtotime($regEnd)); ?>
            </div>
          </div>
          <?php endif; ?>
          
          <?php if ($progStart && $progEnd): ?>
          <div class="info-card">
            <div class="info-card-icon success">
              <i class="bi bi-calendar-check"></i>
            </div>
            <div class="info-card-label">Course Period</div>
            <div class="info-card-value">
              <?php echo date('M d, Y', strtotime($progStart)); ?><br>
              <small class="text-muted">to</small><br>
              <?php echo date('M d, Y', strtotime($progEnd)); ?>
            </div>
          </div>
          <?php endif; ?>
          
          <?php if ($programDays): ?>
          <div class="info-card">
            <div class="info-card-icon info">
              <i class="bi bi-clock"></i>
            </div>
            <div class="info-card-label">Duration</div>
            <div class="info-card-value">
              <?php echo $programDays; ?> <?php echo $programDays == 1 ? 'Day' : 'Days'; ?>
            </div>
          </div>
          <?php endif; ?>
        </div>
        
        <!-- Register Card - Shown on mobile, hidden on desktop (duplicate for mobile positioning) -->
        <div class="register-card d-lg-none">
          <div class="register-card-icon">
            <i class="bi bi-rocket-takeoff"></i>
          </div>
          <h3>Ready to Join?</h3>
          <p>Start your journey towards mastering future technologies and building innovative solutions</p>
          <a href="register.php?id=<?php echo $program['id']; ?>" class="btn-register-large">
            Register Now <i class="bi bi-arrow-right ms-2"></i>
          </a>
          <div class="mt-3 pt-3" style="border-top: 1px solid #e9ecef;">
            <small class="text-muted d-block mb-2">
              <i class="bi bi-shield-check me-1"></i>
              Secure Registration
            </small>
            <small class="text-muted">
              <i class="bi bi-clock me-1"></i>
              Limited Seats Available
            </small>
          </div>
        </div>
        
        <!-- Additional CTA - Mobile Only -->
        <div class="content-section text-center d-lg-none" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
          <h4 class="mb-3">Have Questions?</h4>
          <p class="text-muted mb-4">Feel free to reach out to us for more information about this program</p>
          <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
            <a href="enquiry" class="btn-primary">
              <i class="bi bi-envelope me-2"></i>Send Enquiry
            </a>
            <a href="programs" class="btn-secondary">
              <i class="bi bi-arrow-left me-2"></i>View All Programs
            </a>
          </div>
        </div>
        <!-- Additional CTA - Desktop View (shown in content area on desktop) -->
        <div class="content-section text-center d-none d-lg-block" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
          <h4 class="mb-3">Have Questions?</h4>
          <p class="text-muted mb-4">Feel free to reach out to us for more information about this program</p>
          <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
            <a href="enquiry" class="btn-primary">
              <i class="bi bi-envelope me-2"></i>Send Enquiry
            </a>
            <a href="programs" class="btn-secondary">
              <i class="bi bi-arrow-left me-2"></i>View All Programs
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
