<?php 
require_once 'includes/db_connection.php';
require_once 'includes/programs_helper.php';

// Get PDO connection
$pdo = isset($GLOBALS['pdo']) ? $GLOBALS['pdo'] : require_once 'includes/db_connection.php';
$allPrograms = getActivePrograms($pdo);
$categorizedPrograms = categorizePrograms($allPrograms);

include 'includes/header.php'; 
?>

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

<!-- Registration Open Programs -->
<?php if (!empty($categorizedPrograms['registration_open'])): ?>
<section class="py-5" style="padding: 3rem 0;">
  <div class="section-container">
    <div class="text-center mb-5" data-animate>
      <span class="badge bg-success mb-3" style="font-size: 1rem; padding: 0.5rem 1rem;">
        <i class="bi bi-calendar-check me-2"></i>Registration Open
      </span>
      <h2 class="display-5 fw-bold mb-3">
        <span class="gradient-text-purple">Register Now</span>
      </h2>
      <p class="text-muted">Don't miss out! Registration is currently open for these programs.</p>
    </div>
    <div class="row g-4">
      <?php foreach ($categorizedPrograms['registration_open'] as $program): 
        $focusAreas = formatProgramText($program['focus_areas']);
        $applications = formatProgramText($program['applications']);
      ?>
      <div class="col-lg-6 col-xl-4" data-animate>
        <div class="glass-card program-detail-card p-4 h-100 d-flex flex-column">
          <div class="mb-2">
            <?php echo getProgramStatusBadge($program); ?>
          </div>
          <h4 class="program-detail-title mb-3"><?php echo htmlspecialchars($program['program_name']); ?></h4>
          
          <?php if (!empty($focusAreas)): ?>
          <div class="program-section mb-3">
            <h6 class="program-section-title">Programmes / Focus Areas</h6>
            <ul class="program-list">
              <?php foreach (array_slice($focusAreas, 0, 3) as $area): ?>
              <li><?php echo htmlspecialchars($area); ?></li>
              <?php endforeach; ?>
              <?php if (count($focusAreas) > 3): ?>
              <li class="text-muted">+<?php echo count($focusAreas) - 3; ?> more</li>
              <?php endif; ?>
            </ul>
          </div>
          <?php endif; ?>
          
          <?php if (!empty($applications)): ?>
          <div class="program-section mb-3">
            <h6 class="program-section-title">Applications</h6>
            <ul class="program-list">
              <?php foreach (array_slice($applications, 0, 3) as $app): ?>
              <li><?php echo htmlspecialchars($app); ?></li>
              <?php endforeach; ?>
              <?php if (count($applications) > 3): ?>
              <li class="text-muted">+<?php echo count($applications) - 3; ?> more</li>
              <?php endif; ?>
            </ul>
          </div>
          <?php endif; ?>
          
          <a href="program_details.php?id=<?php echo $program['id']; ?>" class="btn-primary w-100 mt-auto">View More <i class="bi bi-arrow-right ms-2"></i></a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- Ongoing Programs -->
<?php if (!empty($categorizedPrograms['ongoing'])): ?>
<section class="py-5" style="padding: 3rem 0; background: rgba(138, 43, 226, 0.02);">
  <div class="section-container">
    <div class="text-center mb-5" data-animate>
      <span class="badge bg-primary mb-3" style="font-size: 1rem; padding: 0.5rem 1rem;">
        <i class="bi bi-play-circle me-2"></i>Currently Running
      </span>
      <h2 class="display-5 fw-bold mb-3">
        <span class="gradient-text-purple">Ongoing Programs</span>
      </h2>
      <p class="text-muted">Programs currently in progress.</p>
    </div>
    <div class="row g-4">
      <?php foreach ($categorizedPrograms['ongoing'] as $program): 
        $focusAreas = formatProgramText($program['focus_areas']);
        $applications = formatProgramText($program['applications']);
      ?>
      <div class="col-lg-6 col-xl-4" data-animate>
        <div class="glass-card program-detail-card p-4 h-100 d-flex flex-column">
          <div class="mb-2">
            <?php echo getProgramStatusBadge($program); ?>
          </div>
          <h4 class="program-detail-title mb-3"><?php echo htmlspecialchars($program['program_name']); ?></h4>
          
          <div class="program-info mb-3">
            <?php if ($regStart && $regEnd): ?>
            <div class="mb-2">
              <div class="d-flex align-items-center mb-1">
                <i class="bi bi-calendar-event me-2 text-primary" style="font-size: 0.9rem;"></i>
                <strong class="text-muted small">Registration Period:</strong>
              </div>
              <div class="ms-4 text-dark small">
                <?php echo date('M d, Y', strtotime($regStart)); ?> - <?php echo date('M d, Y', strtotime($regEnd)); ?>
              </div>
            </div>
            <?php endif; ?>
            
            <?php if ($progStart && $progEnd): ?>
            <div class="mb-2">
              <div class="d-flex align-items-center mb-1">
                <i class="bi bi-calendar-check me-2 text-success" style="font-size: 0.9rem;"></i>
                <strong class="text-muted small">Course Period:</strong>
              </div>
              <div class="ms-4 text-dark small">
                <?php echo date('M d, Y', strtotime($progStart)); ?> - <?php echo date('M d, Y', strtotime($progEnd)); ?>
              </div>
            </div>
            <?php endif; ?>
            
            <?php if ($programDays): ?>
            <div class="mb-2">
              <div class="d-flex align-items-center mb-1">
                <i class="bi bi-clock me-2 text-info" style="font-size: 0.9rem;"></i>
                <strong class="text-muted small">Duration:</strong>
              </div>
              <div class="ms-4 text-dark small fw-bold">
                <?php echo $programDays; ?> <?php echo $programDays == 1 ? 'Day' : 'Days'; ?>
              </div>
            </div>
            <?php endif; ?>
          </div>
          
          <?php if (!empty($focusAreas)): ?>
          <div class="program-section mb-3">
            <h6 class="program-section-title">Programmes / Focus Areas</h6>
            <ul class="program-list">
              <?php foreach (array_slice($focusAreas, 0, 3) as $area): ?>
              <li><?php echo htmlspecialchars($area); ?></li>
              <?php endforeach; ?>
              <?php if (count($focusAreas) > 3): ?>
              <li class="text-muted">+<?php echo count($focusAreas) - 3; ?> more</li>
              <?php endif; ?>
            </ul>
          </div>
          <?php endif; ?>
          
          <?php if (!empty($applications)): ?>
          <div class="program-section mb-3">
            <h6 class="program-section-title">Applications</h6>
            <ul class="program-list">
              <?php foreach (array_slice($applications, 0, 3) as $app): ?>
              <li><?php echo htmlspecialchars($app); ?></li>
              <?php endforeach; ?>
              <?php if (count($applications) > 3): ?>
              <li class="text-muted">+<?php echo count($applications) - 3; ?> more</li>
              <?php endif; ?>
            </ul>
          </div>
          <?php endif; ?>
          
          <a href="program_details.php?id=<?php echo $program['id']; ?>" class="btn-primary w-100 mt-auto">View More <i class="bi bi-arrow-right ms-2"></i></a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- Upcoming Programs -->
<?php if (!empty($categorizedPrograms['upcoming']) || !empty($categorizedPrograms['upcoming_program'])): ?>
<section class="py-5" style="padding: 3rem 0;">
  <div class="section-container">
    <div class="text-center mb-5" data-animate>
      <span class="badge bg-info mb-3" style="font-size: 1rem; padding: 0.5rem 1rem;">
        <i class="bi bi-calendar-event me-2"></i>Coming Soon
      </span>
      <h2 class="display-5 fw-bold mb-3">
        <span class="gradient-text-purple">Upcoming Programs</span>
      </h2>
      <p class="text-muted">Programs starting soon. Stay tuned!</p>
    </div>
    <div class="row g-4">
      <?php 
      $upcomingAll = array_merge($categorizedPrograms['upcoming'], $categorizedPrograms['upcoming_program']);
      foreach ($upcomingAll as $program): 
        $focusAreas = formatProgramText($program['focus_areas']);
        $applications = formatProgramText($program['applications']);
      ?>
      <div class="col-lg-6 col-xl-4" data-animate>
        <div class="glass-card program-detail-card p-4 h-100 d-flex flex-column">
          <div class="mb-2">
            <?php echo getProgramStatusBadge($program); ?>
          </div>
          <h4 class="program-detail-title mb-3"><?php echo htmlspecialchars($program['program_name']); ?></h4>
          
          <div class="program-info mb-3">
            <?php if ($regStart && $regEnd): ?>
            <div class="mb-2">
              <div class="d-flex align-items-center mb-1">
                <i class="bi bi-calendar-event me-2 text-primary" style="font-size: 0.9rem;"></i>
                <strong class="text-muted small">Registration Period:</strong>
              </div>
              <div class="ms-4 text-dark small">
                <?php echo date('M d, Y', strtotime($regStart)); ?> - <?php echo date('M d, Y', strtotime($regEnd)); ?>
              </div>
            </div>
            <?php endif; ?>
            
            <?php if ($progStart && $progEnd): ?>
            <div class="mb-2">
              <div class="d-flex align-items-center mb-1">
                <i class="bi bi-calendar-check me-2 text-success" style="font-size: 0.9rem;"></i>
                <strong class="text-muted small">Course Period:</strong>
              </div>
              <div class="ms-4 text-dark small">
                <?php echo date('M d, Y', strtotime($progStart)); ?> - <?php echo date('M d, Y', strtotime($progEnd)); ?>
              </div>
            </div>
            <?php endif; ?>
            
            <?php if ($programDays): ?>
            <div class="mb-2">
              <div class="d-flex align-items-center mb-1">
                <i class="bi bi-clock me-2 text-info" style="font-size: 0.9rem;"></i>
                <strong class="text-muted small">Duration:</strong>
              </div>
              <div class="ms-4 text-dark small fw-bold">
                <?php echo $programDays; ?> <?php echo $programDays == 1 ? 'Day' : 'Days'; ?>
              </div>
            </div>
            <?php endif; ?>
          </div>
          
          <?php if (!empty($focusAreas)): ?>
          <div class="program-section mb-3">
            <h6 class="program-section-title">Programmes / Focus Areas</h6>
            <ul class="program-list">
              <?php foreach (array_slice($focusAreas, 0, 3) as $area): ?>
              <li><?php echo htmlspecialchars($area); ?></li>
              <?php endforeach; ?>
              <?php if (count($focusAreas) > 3): ?>
              <li class="text-muted">+<?php echo count($focusAreas) - 3; ?> more</li>
              <?php endif; ?>
            </ul>
          </div>
          <?php endif; ?>
          
          <?php if (!empty($applications)): ?>
          <div class="program-section mb-3">
            <h6 class="program-section-title">Applications</h6>
            <ul class="program-list">
              <?php foreach (array_slice($applications, 0, 3) as $app): ?>
              <li><?php echo htmlspecialchars($app); ?></li>
              <?php endforeach; ?>
              <?php if (count($applications) > 3): ?>
              <li class="text-muted">+<?php echo count($applications) - 3; ?> more</li>
              <?php endif; ?>
            </ul>
          </div>
          <?php endif; ?>
          
          <a href="program_details.php?id=<?php echo $program['id']; ?>" class="btn-primary w-100 mt-auto">View More <i class="bi bi-arrow-right ms-2"></i></a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- All Programs Grid (Fallback if no categorized programs) -->
<?php if (empty($categorizedPrograms['registration_open']) && empty($categorizedPrograms['ongoing']) && empty($categorizedPrograms['upcoming']) && empty($categorizedPrograms['upcoming_program']) && !empty($allPrograms)): ?>
<section class="py-5" style="padding: 5rem 0;">
  <div class="section-container">
    <div class="row g-4">
      <?php
      foreach ($allPrograms as $program):
        $focusAreas = formatProgramText($program['focus_areas']);
        $applications = formatProgramText($program['applications']);
      ?>
      <div class="col-lg-6 col-xl-4" data-animate>
        <div class="glass-card program-detail-card p-4 h-100 d-flex flex-column">
          <div class="mb-2">
            <?php echo getProgramStatusBadge($program); ?>
          </div>
          <h4 class="program-detail-title mb-3"><?php echo htmlspecialchars($program['program_name']); ?></h4>
          
          <?php if (!empty($focusAreas)): ?>
          <div class="program-section mb-3">
            <h6 class="program-section-title">Programmes / Focus Areas</h6>
            <ul class="program-list">
              <?php foreach (array_slice($focusAreas, 0, 3) as $area): ?>
              <li><?php echo htmlspecialchars($area); ?></li>
              <?php endforeach; ?>
              <?php if (count($focusAreas) > 3): ?>
              <li class="text-muted">+<?php echo count($focusAreas) - 3; ?> more</li>
              <?php endif; ?>
            </ul>
          </div>
          <?php endif; ?>
          
          <?php if (!empty($applications)): ?>
          <div class="program-section mb-3">
            <h6 class="program-section-title">Applications</h6>
            <ul class="program-list">
              <?php foreach (array_slice($applications, 0, 3) as $app): ?>
              <li><?php echo htmlspecialchars($app); ?></li>
              <?php endforeach; ?>
              <?php if (count($applications) > 3): ?>
              <li class="text-muted">+<?php echo count($applications) - 3; ?> more</li>
              <?php endif; ?>
            </ul>
          </div>
          <?php endif; ?>
          
          <a href="program_details.php?id=<?php echo $program['id']; ?>" class="btn-primary w-100 mt-auto">View More <i class="bi bi-arrow-right ms-2"></i></a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (empty($allPrograms)): ?>
<section class="py-5" style="padding: 5rem 0;">
  <div class="section-container">
    <div class="text-center py-5">
      <i class="bi bi-book" style="font-size: 3rem; color: var(--muted-foreground);"></i>
      <p class="text-muted mt-3">No programs available at the moment. Check back soon!</p>
    </div>
  </div>
</section>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
