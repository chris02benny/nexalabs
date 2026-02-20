<?php
session_start();
require_once 'includes/auth.php';
requireAdminLogin();

$pdo = require_once 'includes/db_connection.php';

// Handle search and filters
$search = $_GET['search'] ?? '';
$filterGender = $_GET['filter_gender'] ?? '';
$filterEducation = $_GET['filter_education'] ?? '';
$filterProgram = $_GET['filter_program'] ?? '';

// Build query - get all registrations first
$where = [];
$params = [];

$query = "SELECT r.*, p.program_name 
          FROM registrations r 
          LEFT JOIN programs p ON CAST(r.program AS UNSIGNED) = p.id";

if (!empty($search)) {
    $where[] = "(r.student_name LIKE ? OR r.email LIKE ? OR r.phone LIKE ? OR p.program_name LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if (!empty($filterGender)) {
    $where[] = "r.gender = ?";
    $params[] = $filterGender;
}

if (!empty($filterEducation)) {
    $where[] = "r.education_level = ?";
    $params[] = $filterEducation;
}

if (!empty($filterProgram)) {
    $where[] = "r.program = ?";
    $params[] = $filterProgram;
}

$whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";
$query .= " $whereClause ORDER BY r.created_at DESC";

// Get unique values for filter dropdowns
try {
    $genderStmt = $pdo->query("SELECT DISTINCT gender FROM registrations WHERE gender IS NOT NULL AND gender != '' ORDER BY gender");
    $genders = $genderStmt->fetchAll(PDO::FETCH_COLUMN);
    
    $educationStmt = $pdo->query("SELECT DISTINCT education_level FROM registrations WHERE education_level IS NOT NULL AND education_level != '' ORDER BY education_level");
    $educationLevels = $educationStmt->fetchAll(PDO::FETCH_COLUMN);
    
    $programStmt = $pdo->query("SELECT DISTINCT id, program_name FROM programs WHERE isactive = 1 ORDER BY program_name");
    $programs = $programStmt->fetchAll();
} catch (PDOException $e) {
    $genders = [];
    $educationLevels = [];
    $programs = [];
}

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $registrations = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Registrations Query Error: " . $e->getMessage());
    $registrations = [];
}

include 'includes/admin_header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <h2 class="mb-0">Registrations Management</h2>
  <div class="d-flex gap-2">
    <?php if (!empty($registrations)): ?>
    <a href="backend/export_registrations.php?<?php echo http_build_query($_GET); ?>" class="btn btn-success">
      <i class="bi bi-file-earmark-excel me-2"></i>Export to Excel
    </a>
    <?php endif; ?>
  </div>
</div>

<!-- Search and Filter Bar -->
<div class="glass-card p-3 mb-4" style="background: linear-gradient(135deg, rgba(138, 43, 226, 0.05) 0%, rgba(190, 100%, 50%, 0.05) 100%); border: 2px solid rgba(138, 43, 226, 0.1);">
  <form method="GET" class="row g-2 align-items-end">
    <!-- Search Bar -->
    <div class="col-md-3">
      <label class="form-label small text-muted mb-1">Search</label>
      <div class="input-group">
        <span class="input-group-text" style="background: white; border-right: none; border-color: #e0e0e0;">
          <i class="bi bi-search" style="color: hsl(250, 70%, 55%);"></i>
        </span>
        <input type="text" 
               class="form-control" 
               name="search" 
               placeholder="Name, email, phone..." 
               value="<?php echo htmlspecialchars($search); ?>"
               style="border-left: none; border-color: #e0e0e0;">
      </div>
    </div>
    
    <!-- Gender Filter -->
    <div class="col-md-2">
      <label class="form-label small text-muted mb-1">Gender</label>
      <select class="form-select" name="filter_gender" style="border-color: #e0e0e0;">
        <option value="">All Gender</option>
        <?php foreach ($genders as $gender): ?>
        <option value="<?php echo htmlspecialchars($gender); ?>" <?php echo $filterGender === $gender ? 'selected' : ''; ?>>
          <?php echo ucfirst(htmlspecialchars($gender)); ?>
        </option>
        <?php endforeach; ?>
      </select>
    </div>
    
    <!-- Education Level Filter -->
    <div class="col-md-2">
      <label class="form-label small text-muted mb-1">Education Level</label>
      <select class="form-select" name="filter_education" style="border-color: #e0e0e0;">
        <option value="">All Education</option>
        <?php foreach ($educationLevels as $edu): ?>
        <option value="<?php echo htmlspecialchars($edu); ?>" <?php echo $filterEducation === $edu ? 'selected' : ''; ?>>
          <?php echo htmlspecialchars($edu); ?>
        </option>
        <?php endforeach; ?>
      </select>
    </div>
    
    <!-- Program Filter -->
    <div class="col-md-2">
      <label class="form-label small text-muted mb-1">Program</label>
      <select class="form-select" name="filter_program" style="border-color: #e0e0e0;">
        <option value="">All Programs</option>
        <?php foreach ($programs as $prog): ?>
        <option value="<?php echo $prog['id']; ?>" <?php echo $filterProgram == $prog['id'] ? 'selected' : ''; ?>>
          <?php echo htmlspecialchars($prog['program_name']); ?>
        </option>
        <?php endforeach; ?>
      </select>
    </div>
    
    <!-- Action Buttons -->
    <div class="col-md-3">
      <div class="d-flex gap-2">
        <button type="submit" class="btn-purple" title="Apply Filters">
          <i class="bi bi-funnel"></i>
        </button>
        <?php if (!empty($search) || !empty($filterGender) || !empty($filterEducation) || !empty($filterProgram)): ?>
        <a href="admin_registration.php" class="btn btn-outline-secondary" title="Reset Filters">
          <i class="bi bi-x-circle"></i>
        </a>
        <?php endif; ?>
      </div>
    </div>
  </form>
</div>

<!-- Registrations Table -->
<div class="glass-card p-4">
  <?php if (empty($registrations)): ?>
  <div class="text-center py-5">
    <i class="bi bi-person-plus" style="font-size: 3rem; color: var(--muted-foreground);"></i>
    <p class="text-muted mt-3">No registrations found.</p>
  </div>
  <?php else: ?>
  <div class="table-responsive">
    <table class="table table-hover" style="color: var(--foreground);">
      <thead style="background: rgba(138, 43, 226, 0.1);">
        <tr>
          <th style="font-weight: 600;">Sl No</th>
          <th style="font-weight: 600;">Student Name</th>
          <th style="font-weight: 600;">Email</th>
          <th style="font-weight: 600;">Phone</th>
          <th style="font-weight: 600;">Age</th>
          <th style="font-weight: 600;">Gender</th>
          <th style="font-weight: 600;">Education Level</th>
          <th style="font-weight: 600;">Institution</th>
          <th style="font-weight: 600;">Program</th>
          <th style="font-weight: 600;">Registered Date</th>
        </tr>
      </thead>
      <tbody>
        <?php $slNo = 1; foreach ($registrations as $registration): ?>
        <tr>
          <td>
            <span class="text-muted"><?php echo $slNo++; ?></span>
          </td>
          <td>
            <strong><?php echo htmlspecialchars($registration['student_name']); ?></strong>
          </td>
          <td>
            <a href="mailto:<?php echo htmlspecialchars($registration['email']); ?>" class="text-decoration-none">
              <?php echo htmlspecialchars($registration['email']); ?>
            </a>
          </td>
          <td>
            <?php if (!empty($registration['phone'])): ?>
            <a href="tel:<?php echo htmlspecialchars($registration['phone']); ?>" class="text-decoration-none">
              <?php echo htmlspecialchars($registration['phone']); ?>
            </a>
            <?php else: ?>
            <span class="text-muted">N/A</span>
            <?php endif; ?>
          </td>
          <td><?php echo htmlspecialchars($registration['age'] ?? 'N/A'); ?></td>
          <td>
            <?php 
            $gender = $registration['gender'] ?? '';
            if ($gender) {
              $badgeColor = $gender === 'male' ? 'bg-primary' : ($gender === 'female' ? 'bg-info' : 'bg-secondary');
              echo '<span class="badge ' . $badgeColor . '">' . ucfirst(htmlspecialchars($gender)) . '</span>';
            } else {
              echo '<span class="text-muted">N/A</span>';
            }
            ?>
          </td>
          <td><?php echo htmlspecialchars($registration['education_level'] ?? 'N/A'); ?></td>
          <td><?php echo htmlspecialchars($registration['institution'] ?? 'N/A'); ?></td>
          <td>
            <?php if (!empty($registration['program_name'])): ?>
            <span class="badge bg-success"><?php echo htmlspecialchars($registration['program_name']); ?></span>
            <?php elseif (!empty($registration['program'])): ?>
            <span class="badge bg-secondary">Program ID: <?php echo htmlspecialchars($registration['program']); ?></span>
            <?php else: ?>
            <span class="text-muted">N/A</span>
            <?php endif; ?>
          </td>
          <td>
            <div><?php echo date('M d, Y', strtotime($registration['created_at'])); ?></div>
            <small class="text-muted"><?php echo date('h:i A', strtotime($registration['created_at'])); ?></small>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  
  <!-- Summary -->
  <div class="mt-4 p-3 rounded" style="background: rgba(138, 43, 226, 0.05);">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <strong>Total Registrations:</strong> <span class="badge bg-primary"><?php echo count($registrations); ?></span>
      </div>
      <div class="text-muted small">
        Last updated: <?php echo date('M d, Y h:i A'); ?>
      </div>
    </div>
  </div>
  <?php endif; ?>
</div>

<?php include 'includes/admin_footer.php'; ?>

