<?php
session_start();
require_once 'includes/auth.php';
requireAdminLogin();

$pdo = require_once 'includes/db_connection.php';

// Handle search and filters
$search = $_GET['search'] ?? '';
$filterProgram = $_GET['filter_program'] ?? '';
$filterRating = $_GET['filter_rating'] ?? '';

// Build query
$where = [];
$params = [];

$query = "SELECT f.*, p.program_name 
          FROM feedback f 
          LEFT JOIN programs p ON f.program_id = p.id";

if (!empty($search)) {
    $where[] = "(f.student_name LIKE ? OR f.email LIKE ? OR f.comments LIKE ? OR p.program_name LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if (!empty($filterProgram)) {
    $where[] = "f.program_id = ?";
    $params[] = $filterProgram;
}

if (!empty($filterRating)) {
    $where[] = "f.rating = ?";
    $params[] = $filterRating;
}

$whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";
$query .= " $whereClause ORDER BY f.created_at DESC";

// Get unique values for filter dropdowns
try {
    $programStmt = $pdo->query("SELECT DISTINCT id, program_name FROM programs WHERE isactive = 1 ORDER BY program_name");
    $programs = $programStmt->fetchAll();
} catch (PDOException $e) {
    $programs = [];
}

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $feedbacks = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Feedbacks Query Error: " . $e->getMessage());
    $feedbacks = [];
}

include 'includes/admin_header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <h2 class="mb-0">Feedback Management</h2>
  <div class="d-flex gap-2">
    <?php if (!empty($feedbacks)): ?>
    <a href="backend/export_feedback.php?<?php echo http_build_query($_GET); ?>" class="btn btn-success">
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
               placeholder="Name, email, comments..." 
               value="<?php echo htmlspecialchars($search); ?>"
               style="border-left: none; border-color: #e0e0e0;">
      </div>
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
    
    <!-- Rating Filter -->
    <div class="col-md-2">
      <label class="form-label small text-muted mb-1">Rating</label>
      <select class="form-select" name="filter_rating" style="border-color: #e0e0e0;">
        <option value="">All Ratings</option>
        <option value="5" <?php echo $filterRating == '5' ? 'selected' : ''; ?>>5 Stars</option>
        <option value="4" <?php echo $filterRating == '4' ? 'selected' : ''; ?>>4 Stars</option>
        <option value="3" <?php echo $filterRating == '3' ? 'selected' : ''; ?>>3 Stars</option>
        <option value="2" <?php echo $filterRating == '2' ? 'selected' : ''; ?>>2 Stars</option>
        <option value="1" <?php echo $filterRating == '1' ? 'selected' : ''; ?>>1 Star</option>
      </select>
    </div>
    
    <!-- Action Buttons -->
    <div class="col-md-3">
      <div class="d-flex gap-2">
        <button type="submit" class="btn-purple" title="Apply Filters">
          <i class="bi bi-funnel"></i>
        </button>
        <?php if (!empty($search) || !empty($filterProgram) || !empty($filterRating)): ?>
        <a href="admin_feedback.php" class="btn btn-outline-secondary" title="Reset Filters">
          <i class="bi bi-x-circle"></i>
        </a>
        <?php endif; ?>
      </div>
    </div>
  </form>
</div>

<!-- Feedbacks Table -->
<div class="glass-card p-4">
  <?php if (empty($feedbacks)): ?>
  <div class="text-center py-5">
    <i class="bi bi-chat-left-text" style="font-size: 3rem; color: var(--muted-foreground);"></i>
    <p class="text-muted mt-3">No feedback found.</p>
  </div>
  <?php else: ?>
  <div class="table-responsive">
    <table class="table table-hover" style="color: var(--foreground);">
      <thead style="background: rgba(138, 43, 226, 0.1);">
        <tr>
          <th style="font-weight: 600;">Sl No</th>
          <th style="font-weight: 600;">Student Name</th>
          <th style="font-weight: 600;">Email</th>
          <th style="font-weight: 600;">Program</th>
          <th style="font-weight: 600;">Rating</th>
          <th style="font-weight: 600;">Feedback</th>
          <th style="font-weight: 600;">Suggestions</th>
          <th style="font-weight: 600;">Submitted Date</th>
        </tr>
      </thead>
      <tbody>
        <?php $slNo = 1; foreach ($feedbacks as $feedback): ?>
        <tr>
          <td>
            <span class="text-muted"><?php echo $slNo++; ?></span>
          </td>
          <td>
            <strong><?php echo htmlspecialchars($feedback['student_name']); ?></strong>
          </td>
          <td>
            <a href="mailto:<?php echo htmlspecialchars($feedback['email']); ?>" class="text-decoration-none">
              <?php echo htmlspecialchars($feedback['email']); ?>
            </a>
          </td>
          <td>
            <?php if (!empty($feedback['program_name'])): ?>
            <span class="badge bg-success"><?php echo htmlspecialchars($feedback['program_name']); ?></span>
            <?php elseif (!empty($feedback['program'])): ?>
            <span class="badge bg-secondary"><?php echo htmlspecialchars($feedback['program']); ?></span>
            <?php else: ?>
            <span class="text-muted">N/A</span>
            <?php endif; ?>
          </td>
          <td>
            <?php 
            $rating = intval($feedback['rating']);
            for ($i = 1; $i <= 5; $i++): 
            ?>
            <i class="bi bi-star<?php echo $i <= $rating ? '-fill' : ''; ?>" style="color: <?php echo $i <= $rating ? '#ffc107' : '#dee2e6'; ?>;"></i>
            <?php endfor; ?>
            <span class="ms-1 text-muted">(<?php echo $rating; ?>)</span>
          </td>
          <td>
            <?php if (!empty($feedback['comments'])): ?>
            <div style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?php echo htmlspecialchars($feedback['comments']); ?>">
              <?php echo htmlspecialchars(substr($feedback['comments'], 0, 80)); ?>
              <?php echo strlen($feedback['comments']) > 80 ? '...' : ''; ?>
            </div>
            <?php else: ?>
            <span class="text-muted">No feedback</span>
            <?php endif; ?>
          </td>
          <td>
            <?php if (!empty($feedback['suggestions'])): ?>
            <div style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?php echo htmlspecialchars($feedback['suggestions']); ?>">
              <?php echo htmlspecialchars(substr($feedback['suggestions'], 0, 80)); ?>
              <?php echo strlen($feedback['suggestions']) > 80 ? '...' : ''; ?>
            </div>
            <?php else: ?>
            <span class="text-muted">No suggestions</span>
            <?php endif; ?>
          </td>
          <td>
            <div><?php echo date('M d, Y', strtotime($feedback['created_at'])); ?></div>
            <small class="text-muted"><?php echo date('h:i A', strtotime($feedback['created_at'])); ?></small>
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
        <strong>Total Feedbacks:</strong> <span class="badge bg-primary"><?php echo count($feedbacks); ?></span>
      </div>
      <div class="text-muted small">
        Last updated: <?php echo date('M d, Y h:i A'); ?>
      </div>
    </div>
  </div>
  <?php endif; ?>
</div>

<?php include 'includes/admin_footer.php'; ?>

