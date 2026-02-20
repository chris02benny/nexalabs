<?php
session_start();
require_once 'includes/auth.php';
requireAdminLogin();

$pdo = require_once 'includes/db_connection.php';

// Get statistics
try {
    // Count enquiries
    $enquiriesStmt = $pdo->query("SELECT COUNT(*) as count FROM enquiries");
    $enquiriesCount = $enquiriesStmt->fetch()['count'];
    
    // Count registrations
    $registrationsStmt = $pdo->query("SELECT COUNT(*) as count FROM registrations");
    $registrationsCount = $registrationsStmt->fetch()['count'];
    
    // Count feedback
    $feedbackStmt = $pdo->query("SELECT COUNT(*) as count FROM feedback");
    $feedbackCount = $feedbackStmt->fetch()['count'];
    
    // Recent enquiries
    $recentEnquiriesStmt = $pdo->query("SELECT * FROM enquiries ORDER BY created_at DESC LIMIT 5");
    $recentEnquiries = $recentEnquiriesStmt->fetchAll();
} catch (PDOException $e) {
    error_log("Admin Dashboard Error: " . $e->getMessage());
    $enquiriesCount = 0;
    $registrationsCount = 0;
    $feedbackCount = 0;
    $recentEnquiries = [];
}

include 'includes/admin_header.php';
?>

<!-- Statistics Cards -->
<div class="row g-4 mb-5">
  <div class="col-md-4" data-animate>
    <div class="glass-card p-4">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
          <h6 class="text-muted mb-1">Total Enquiries</h6>
          <h2 class="display-5 fw-bold gradient-text-purple mb-0"><?php echo $enquiriesCount; ?></h2>
        </div>
        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: linear-gradient(135deg, hsla(250, 70%, 55%, 0.2), hsla(270, 80%, 60%, 0.2));">
          <i class="bi bi-envelope" style="font-size: 1.5rem; color: hsl(250, 70%, 55%);"></i>
        </div>
      </div>
      <a href="admin_enquiries.php" class="text-decoration-none small text-muted">
        View All <i class="bi bi-arrow-right ms-1"></i>
      </a>
    </div>
  </div>
  
  <div class="col-md-4" data-animate>
    <div class="glass-card p-4">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
          <h6 class="text-muted mb-1">Total Registrations</h6>
          <h2 class="display-5 fw-bold gradient-text-purple mb-0"><?php echo $registrationsCount; ?></h2>
        </div>
        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: linear-gradient(135deg, hsla(190, 100%, 50%, 0.2), hsla(250, 70%, 55%, 0.2));">
          <i class="bi bi-person-plus" style="font-size: 1.5rem; color: var(--cyan);"></i>
        </div>
      </div>
      <a href="admin_registrations.php" class="text-decoration-none small text-muted">
        View All <i class="bi bi-arrow-right ms-1"></i>
      </a>
    </div>
  </div>
  
  <div class="col-md-4" data-animate>
    <div class="glass-card p-4">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
          <h6 class="text-muted mb-1">Total Feedback</h6>
          <h2 class="display-5 fw-bold gradient-text-purple mb-0"><?php echo $feedbackCount; ?></h2>
        </div>
        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: linear-gradient(135deg, hsla(30, 100%, 50%, 0.2), hsla(190, 100%, 50%, 0.2));">
          <i class="bi bi-star" style="font-size: 1.5rem; color: var(--orange);"></i>
        </div>
      </div>
      <a href="admin_feedback.php" class="text-decoration-none small text-muted">
        View All <i class="bi bi-arrow-right ms-1"></i>
      </a>
    </div>
  </div>
</div>

<!-- Recent Enquiries -->
<div class="glass-card p-4 p-md-5" data-animate>
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0">Recent Enquiries</h3>
    <a href="admin_enquiries.php" class="btn-purple-outline btn-sm">
      View All
    </a>
  </div>
  
  <?php if (empty($recentEnquiries)): ?>
  <div class="text-center py-5">
    <i class="bi bi-inbox" style="font-size: 3rem; color: var(--muted-foreground);"></i>
    <p class="text-muted mt-3">No enquiries yet</p>
  </div>
  <?php else: ?>
  <div class="table-responsive">
    <table class="table" style="color: var(--foreground);">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($recentEnquiries as $enquiry): ?>
        <tr>
          <td><?php echo htmlspecialchars($enquiry['name']); ?></td>
          <td><?php echo htmlspecialchars($enquiry['email']); ?></td>
          <td><?php echo htmlspecialchars($enquiry['phone'] ?? 'N/A'); ?></td>
          <td><?php echo date('M d, Y', strtotime($enquiry['created_at'])); ?></td>
          <td>
            <button class="btn btn-sm btn-purple-outline" onclick="viewEnquiry(<?php echo $enquiry['id']; ?>)">
              View
            </button>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>

<script>
function viewEnquiry(id) {
    // You can implement a modal or redirect to detail page
    alert('Enquiry ID: ' + id + '\n\nFeature to be implemented: View full enquiry details');
    // Or redirect: window.location.href = 'admin_enquiry_detail.php?id=' + id;
}
</script>

<?php include 'includes/admin_footer.php'; ?>

