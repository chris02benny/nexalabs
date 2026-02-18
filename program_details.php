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

<!-- Hero Section -->
<section class="py-5 grid-bg" style="padding: 6rem 0 4rem;">
  <div class="section-container">
    <div class="text-center mx-auto slide-in-left" style="max-width: 800px;">
      <span class="badge badge-purple mb-4">
        🎓 Program Details
      </span>
      
      <h1 class="display-3 fw-bold mb-4">
        <?php echo htmlspecialchars($program['program_name']); ?>
      </h1>
    </div>
  </div>
</section>

<!-- Program Details Section -->
<section class="py-5" style="padding: 3rem 0;">
  <div class="section-container">
    <div class="row">
      <div class="col-lg-8 mx-auto">
        <div class="glass-card p-5">
          <!-- Status Badge -->
          <div class="mb-4">
            <?php echo getProgramStatusBadge($program); ?>
          </div>
          
          <!-- Program Information -->
          <div class="program-info mb-5">
            <?php if ($regStart && $regEnd): ?>
            <div class="mb-4">
              <div class="d-flex align-items-center mb-2">
                <i class="bi bi-calendar-event me-2 text-primary" style="font-size: 1.1rem;"></i>
                <strong class="text-dark">Registration Period:</strong>
              </div>
              <div class="ms-4 text-dark">
                <?php echo date('M d, Y', strtotime($regStart)); ?> - <?php echo date('M d, Y', strtotime($regEnd)); ?>
              </div>
            </div>
            <?php endif; ?>
            
            <?php if ($progStart && $progEnd): ?>
            <div class="mb-4">
              <div class="d-flex align-items-center mb-2">
                <i class="bi bi-calendar-check me-2 text-success" style="font-size: 1.1rem;"></i>
                <strong class="text-dark">Course Period:</strong>
              </div>
              <div class="ms-4 text-dark">
                <?php echo date('M d, Y', strtotime($progStart)); ?> - <?php echo date('M d, Y', strtotime($progEnd)); ?>
              </div>
            </div>
            <?php endif; ?>
            
            <?php if ($programDays): ?>
            <div class="mb-4">
              <div class="d-flex align-items-center mb-2">
                <i class="bi bi-clock me-2 text-info" style="font-size: 1.1rem;"></i>
                <strong class="text-dark">Duration:</strong>
              </div>
              <div class="ms-4 text-dark fw-bold fs-5">
                <?php echo $programDays; ?> <?php echo $programDays == 1 ? 'Day' : 'Days'; ?>
              </div>
            </div>
            <?php endif; ?>
          </div>
          
          <!-- Focus Areas -->
          <?php if (!empty($focusAreas)): ?>
          <div class="program-section mb-5">
            <h3 class="program-section-title mb-4" style="font-size: 1.25rem; color: #000;">
              <i class="bi bi-gear-fill me-2"></i>Programmes / Focus Areas
            </h3>
            <ul class="program-list">
              <?php foreach ($focusAreas as $area): ?>
              <li style="color: #000; font-size: 1rem; margin-bottom: 0.75rem;"><?php echo htmlspecialchars($area); ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endif; ?>
          
          <!-- Applications -->
          <?php if (!empty($applications)): ?>
          <div class="program-section mb-5">
            <h3 class="program-section-title mb-4" style="font-size: 1.25rem; color: #000;">
              <i class="bi bi-application me-2"></i>Applications
            </h3>
            <ul class="program-list">
              <?php foreach ($applications as $app): ?>
              <li style="color: #000; font-size: 1rem; margin-bottom: 0.75rem;"><?php echo htmlspecialchars($app); ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endif; ?>
          
          <!-- Outcome -->
          <?php if (!empty($program['outcome'])): ?>
          <div class="program-section mb-5">
            <h3 class="program-section-title mb-4" style="font-size: 1.25rem; color: #000;">
              <i class="bi bi-trophy-fill me-2"></i>Outcome
            </h3>
            <p class="program-outcome" style="color: #000; font-size: 1rem; line-height: 1.8;">
              <?php echo nl2br(htmlspecialchars($program['outcome'])); ?>
            </p>
          </div>
          <?php endif; ?>
          
          <!-- Register Button -->
          <div class="text-center mt-5">
            <a href="register" class="btn-primary btn-lg px-5 py-3">
              Register Now <i class="bi bi-arrow-right ms-2"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>

