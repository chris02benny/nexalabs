<?php
session_start();
require_once 'includes/auth.php';
requireAdminLogin();

$pdo = require_once 'includes/db_connection.php';

// Get all programs
try {
    $programsStmt = $pdo->query("SELECT * FROM programs ORDER BY created_at DESC");
    $programs = $programsStmt->fetchAll();
} catch (PDOException $e) {
    error_log("Programs Error: " . $e->getMessage());
    $programs = [];
}

$success = isset($_SESSION['program_success']) ? $_SESSION['program_success'] : false;
$error = isset($_SESSION['program_error']) ? $_SESSION['program_error'] : '';
unset($_SESSION['program_success']);
unset($_SESSION['program_error']);

include 'includes/admin_header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <h2 class="mb-0">Programmes Management</h2>
  <button type="button" class="btn-purple" data-bs-toggle="modal" data-bs-target="#addProgramModal">
    <i class="bi bi-plus-circle me-2"></i>
    Add Program
  </button>
</div>

<?php if ($success): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <i class="bi bi-check-circle me-2"></i>
  Program added successfully!
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if ($error): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <i class="bi bi-exclamation-triangle me-2"></i>
  <?php echo htmlspecialchars($error); ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<!-- Programs Table -->
<div class="glass-card p-4">
  <?php if (empty($programs)): ?>
  <div class="text-center py-5">
    <i class="bi bi-book" style="font-size: 3rem; color: var(--muted-foreground);"></i>
    <p class="text-muted mt-3">No programs found. Add your first program!</p>
  </div>
  <?php else: ?>
  <div class="table-responsive">
    <table class="table" style="color: var(--foreground);">
      <thead>
        <tr>
          <th>Program Name</th>
          <th>Status</th>
          <th>Registration Period</th>
          <th>Program Period</th>
          <th>Created</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($programs as $program): ?>
        <tr>
          <td>
            <strong><?php echo htmlspecialchars($program['program_name']); ?></strong>
          </td>
          <td>
            <?php if ($program['isactive']): ?>
            <span class="badge bg-success">Active</span>
            <?php else: ?>
            <span class="badge bg-secondary">Inactive</span>
            <?php endif; ?>
          </td>
          <td>
            <?php if ($program['reg_start_date'] && $program['reg_end_date']): ?>
            <?php echo date('M d, Y', strtotime($program['reg_start_date'])); ?> - 
            <?php echo date('M d, Y', strtotime($program['reg_end_date'])); ?>
            <?php else: ?>
            <span class="text-muted">Not set</span>
            <?php endif; ?>
          </td>
          <td>
            <?php if ($program['program_start_date'] && $program['program_end_date']): ?>
            <?php echo date('M d, Y', strtotime($program['program_start_date'])); ?> - 
            <?php echo date('M d, Y', strtotime($program['program_end_date'])); ?>
            <?php else: ?>
            <span class="text-muted">Not set</span>
            <?php endif; ?>
          </td>
          <td><?php echo date('M d, Y', strtotime($program['created_at'])); ?></td>
          <td>
            <button class="btn btn-sm btn-purple-outline" onclick="viewProgram(<?php echo $program['id']; ?>)">
              <i class="bi bi-eye me-1"></i>View
            </button>
            <button class="btn btn-sm btn-outline-secondary" onclick="editProgram(<?php echo $program['id']; ?>)">
              <i class="bi bi-pencil me-1"></i>Edit
            </button>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>

<!-- Add Program Modal -->
<div class="modal fade" id="addProgramModal" tabindex="-1" aria-labelledby="addProgramModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content" style="border-radius: 1rem; border: none; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);">
      <div class="modal-header" style="background: linear-gradient(135deg, hsl(250, 70%, 55%) 0%, hsl(270, 80%, 60%) 100%); color: white; border-radius: 1rem 1rem 0 0; padding: 1.5rem;">
        <h5 class="modal-title fw-bold" id="addProgramModalLabel" style="font-size: 1.5rem;">
          <i class="bi bi-plus-circle me-2"></i>Add New Program
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="filter: brightness(0) invert(1);"></button>
      </div>
      <form action="backend/add_program.php" method="POST" id="addProgramForm">
        <div class="modal-body" style="max-height: 70vh; overflow-y: auto; padding: 2rem;">
          <!-- Program Name - Full Width -->
          <div class="mb-4">
            <label for="program_name" class="form-label fw-semibold">
              <i class="bi bi-book me-2" style="color: hsl(250, 70%, 55%);"></i>
              Program Name <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control form-control-lg" id="program_name" name="program_name" required placeholder="Enter program name" style="border-radius: 0.5rem; border: 2px solid #e0e0e0; padding: 0.75rem 1rem;">
          </div>
          
          <!-- Two Column Layout -->
          <div class="row g-4">
            <!-- Left Column -->
            <div class="col-lg-6">
              <!-- Focus Areas -->
              <div class="mb-4">
                <label for="focus_areas" class="form-label fw-semibold">
                  <i class="bi bi-list-check me-2" style="color: hsl(250, 70%, 55%);"></i>
                  Programmes / Focus Areas
                </label>
                <textarea class="form-control" id="focus_areas" name="focus_areas" rows="6" placeholder="Enter each focus area on a new line&#10;Example:&#10;Item 1&#10;Item 2&#10;Item 3" style="border-radius: 0.5rem; border: 2px solid #e0e0e0; resize: vertical; min-height: 120px;"></textarea>
                <small class="text-muted d-flex align-items-center mt-2">
                  <i class="bi bi-info-circle me-1"></i>
                  Enter each item on a new line
                </small>
              </div>
              
              <!-- Applications -->
              <div class="mb-4">
                <label for="applications" class="form-label fw-semibold">
                  <i class="bi bi-app me-2" style="color: hsl(250, 70%, 55%);"></i>
                  Applications
                </label>
                <textarea class="form-control" id="applications" name="applications" rows="6" placeholder="Enter each application on a new line&#10;Example:&#10;Application 1&#10;Application 2&#10;Application 3" style="border-radius: 0.5rem; border: 2px solid #e0e0e0; resize: vertical; min-height: 120px;"></textarea>
                <small class="text-muted d-flex align-items-center mt-2">
                  <i class="bi bi-info-circle me-1"></i>
                  Enter each item on a new line
                </small>
              </div>
            </div>
            
            <!-- Right Column -->
            <div class="col-lg-6">
              <!-- Outcome -->
              <div class="mb-4">
                <label for="outcome" class="form-label fw-semibold">
                  <i class="bi bi-trophy me-2" style="color: hsl(250, 70%, 55%);"></i>
                  Outcome
                </label>
                <textarea class="form-control" id="outcome" name="outcome" rows="6" placeholder="Enter program outcome description" style="border-radius: 0.5rem; border: 2px solid #e0e0e0; resize: vertical; min-height: 120px;"></textarea>
              </div>
              
              <!-- Active Status -->
              <div class="mb-4">
                <label class="form-label fw-semibold d-block mb-2">
                  <i class="bi bi-toggle-on me-2" style="color: hsl(250, 70%, 55%);"></i>
                  Program Status
                </label>
                <div class="form-check form-switch" style="font-size: 1.1rem;">
                  <input class="form-check-input" type="checkbox" id="isactive" name="isactive" value="1" checked style="width: 3rem; height: 1.5rem; cursor: pointer;">
                  <label class="form-check-label ms-3" for="isactive" style="cursor: pointer;">
                    <strong>Active Program</strong>
                    <small class="text-muted d-block">Toggle to activate/deactivate this program</small>
                  </label>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Dates Section -->
          <div class="row g-4 mt-2">
            <!-- Registration Dates -->
            <div class="col-lg-6">
              <div class="glass-card p-4" style="background: #f8f9fa; border: 2px solid #e0e0e0;">
                <h6 class="fw-bold mb-3" style="color: hsl(250, 70%, 55%);">
                  <i class="bi bi-calendar-check me-2"></i>Registration Period
                </h6>
                <div class="row g-3">
                  <div class="col-12">
                    <label for="reg_start_date" class="form-label fw-semibold">Start Date</label>
                    <input type="date" class="form-control" id="reg_start_date" name="reg_start_date" style="border-radius: 0.5rem; border: 2px solid #e0e0e0;">
                  </div>
                  <div class="col-12">
                    <label for="reg_end_date" class="form-label fw-semibold">End Date</label>
                    <input type="date" class="form-control" id="reg_end_date" name="reg_end_date" style="border-radius: 0.5rem; border: 2px solid #e0e0e0;">
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Program Dates -->
            <div class="col-lg-6">
              <div class="glass-card p-4" style="background: #f8f9fa; border: 2px solid #e0e0e0;">
                <h6 class="fw-bold mb-3" style="color: hsl(250, 70%, 55%);">
                  <i class="bi bi-calendar-event me-2"></i>Program Period
                </h6>
                <div class="row g-3">
                  <div class="col-12">
                    <label for="program_start_date" class="form-label fw-semibold">Start Date</label>
                    <input type="date" class="form-control" id="program_start_date" name="program_start_date" style="border-radius: 0.5rem; border: 2px solid #e0e0e0;">
                  </div>
                  <div class="col-12">
                    <label for="program_end_date" class="form-label fw-semibold">End Date</label>
                    <input type="date" class="form-control" id="program_end_date" name="program_end_date" style="border-radius: 0.5rem; border: 2px solid #e0e0e0;">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="border-top: 2px solid #e0e0e0; padding: 1.5rem; border-radius: 0 0 1rem 1rem;">
          <button type="button" class="btn btn-secondary px-4 py-2" data-bs-dismiss="modal" style="border-radius: 0.5rem; font-weight: 600;">
            <i class="bi bi-x-circle me-2"></i>Cancel
          </button>
          <button type="submit" class="btn-purple px-4 py-2" style="border-radius: 0.5rem; font-weight: 600;">
            <i class="bi bi-check-circle me-2"></i>Add Program
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
/* Custom Scrollbar for Modal */
.modal-body::-webkit-scrollbar {
  width: 8px;
}

.modal-body::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

.modal-body::-webkit-scrollbar-thumb {
  background: hsl(250, 70%, 55%);
  border-radius: 10px;
}

.modal-body::-webkit-scrollbar-thumb:hover {
  background: hsl(250, 70%, 45%);
}

/* Form Control Focus Styles */
.modal-body .form-control:focus {
  border-color: hsl(250, 70%, 55%);
  box-shadow: 0 0 0 0.2rem rgba(138, 43, 226, 0.25);
}

/* Responsive adjustments */
@media (max-width: 991px) {
  .modal-dialog.modal-xl {
    max-width: 95%;
  }
  
  .row.g-4 > .col-lg-6 {
    margin-bottom: 1rem;
  }
}
</style>

<script>
function viewProgram(id) {
  // Implement view program details
  alert('View Program ID: ' + id + '\n\nFeature to be implemented: View full program details');
}

function editProgram(id) {
  // Implement edit program
  alert('Edit Program ID: ' + id + '\n\nFeature to be implemented: Edit program');
}

// Form validation
document.getElementById('addProgramForm').addEventListener('submit', function(e) {
  const regStart = document.getElementById('reg_start_date').value;
  const regEnd = document.getElementById('reg_end_date').value;
  const progStart = document.getElementById('program_start_date').value;
  const progEnd = document.getElementById('program_end_date').value;
  
  // Validate registration dates
  if (regStart && regEnd && regStart > regEnd) {
    e.preventDefault();
    alert('Registration start date must be before end date!');
    return false;
  }
  
  // Validate program dates
  if (progStart && progEnd && progStart > progEnd) {
    e.preventDefault();
    alert('Program start date must be before end date!');
    return false;
  }
});
</script>

<?php include 'includes/admin_footer.php'; ?>

