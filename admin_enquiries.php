<?php
session_start();
require_once 'includes/auth.php';
requireAdminLogin();

$pdo = require_once 'includes/db_connection.php';

// Handle search
$search = $_GET['search'] ?? '';

// Build query
$where = [];
$params = [];

$query = "SELECT * FROM enquiries";

if (!empty($search)) {
    $where[] = "(name LIKE ? OR email LIKE ? OR phone LIKE ? OR message LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";
$query .= " $whereClause ORDER BY created_at DESC";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $enquiries = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Enquiries Query Error: " . $e->getMessage());
    $enquiries = [];
}

include 'includes/admin_header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <h2 class="mb-0">Enquiries Management</h2>
  <div class="d-flex gap-2">
    <?php if (!empty($enquiries)): ?>
    <a href="backend/export_enquiries.php?<?php echo http_build_query($_GET); ?>" class="btn btn-success">
      <i class="bi bi-file-earmark-excel me-2"></i>Export to Excel
    </a>
    <?php endif; ?>
  </div>
</div>

<!-- Search Bar -->
<div class="glass-card p-3 mb-4" style="background: linear-gradient(135deg, rgba(138, 43, 226, 0.05) 0%, rgba(190, 100%, 50%, 0.05) 100%); border: 2px solid rgba(138, 43, 226, 0.1);">
  <form method="GET" class="row g-2 align-items-end">
    <!-- Search Bar -->
    <div class="col-md-6">
      <label class="form-label small text-muted mb-1">Search</label>
      <div class="input-group">
        <span class="input-group-text" style="background: white; border-right: none; border-color: #e0e0e0;">
          <i class="bi bi-search" style="color: hsl(250, 70%, 55%);"></i>
        </span>
        <input type="text" 
               class="form-control" 
               name="search" 
               placeholder="Name, email, phone, message..." 
               value="<?php echo htmlspecialchars($search); ?>"
               style="border-left: none; border-color: #e0e0e0;">
      </div>
    </div>
    
    <!-- Action Buttons -->
    <div class="col-md-3">
      <div class="d-flex gap-2">
        <button type="submit" class="btn-purple" title="Apply Filters">
          <i class="bi bi-funnel"></i>
        </button>
        <?php if (!empty($search)): ?>
        <a href="admin_enquiries.php" class="btn btn-outline-secondary" title="Reset Filters">
          <i class="bi bi-x-circle"></i>
        </a>
        <?php endif; ?>
      </div>
    </div>
  </form>
</div>

<!-- Enquiries Table -->
<div class="glass-card p-4">
  <?php if (empty($enquiries)): ?>
  <div class="text-center py-5">
    <i class="bi bi-envelope" style="font-size: 3rem; color: var(--muted-foreground);"></i>
    <p class="text-muted mt-3">No enquiries found.</p>
  </div>
  <?php else: ?>
  <div class="table-responsive">
    <table class="table table-hover" style="color: var(--foreground);">
      <thead style="background: rgba(138, 43, 226, 0.1);">
        <tr>
          <th style="font-weight: 600;">Sl No</th>
          <th style="font-weight: 600;">Name</th>
          <th style="font-weight: 600;">Email</th>
          <th style="font-weight: 600;">Phone</th>
          <th style="font-weight: 600;">Message</th>
          <th style="font-weight: 600;">Submitted Date</th>
        </tr>
      </thead>
      <tbody>
        <?php $slNo = 1; foreach ($enquiries as $enquiry): ?>
        <tr>
          <td>
            <span class="text-muted"><?php echo $slNo++; ?></span>
          </td>
          <td>
            <strong><?php echo htmlspecialchars($enquiry['name']); ?></strong>
          </td>
          <td>
            <a href="mailto:<?php echo htmlspecialchars($enquiry['email']); ?>" class="text-decoration-none">
              <?php echo htmlspecialchars($enquiry['email']); ?>
            </a>
          </td>
          <td>
            <?php if (!empty($enquiry['phone'])): ?>
            <a href="tel:<?php echo htmlspecialchars($enquiry['phone']); ?>" class="text-decoration-none">
              <?php echo htmlspecialchars($enquiry['phone']); ?>
            </a>
            <?php else: ?>
            <span class="text-muted">N/A</span>
            <?php endif; ?>
          </td>
          <td>
            <?php if (!empty($enquiry['message'])): ?>
            <div style="max-width: 400px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?php echo htmlspecialchars($enquiry['message']); ?>">
              <?php echo htmlspecialchars(substr($enquiry['message'], 0, 120)); ?>
              <?php echo strlen($enquiry['message']) > 120 ? '...' : ''; ?>
            </div>
            <?php else: ?>
            <span class="text-muted">No message</span>
            <?php endif; ?>
          </td>
          <td>
            <div><?php echo date('M d, Y', strtotime($enquiry['created_at'])); ?></div>
            <small class="text-muted"><?php echo date('h:i A', strtotime($enquiry['created_at'])); ?></small>
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
        <strong>Total Enquiries:</strong> <span class="badge bg-primary"><?php echo count($enquiries); ?></span>
      </div>
      <div class="text-muted small">
        Last updated: <?php echo date('M d, Y h:i A'); ?>
      </div>
    </div>
  </div>
  <?php endif; ?>
</div>

<?php include 'includes/admin_footer.php'; ?>

