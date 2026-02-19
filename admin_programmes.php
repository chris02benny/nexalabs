<?php
session_start();
require_once 'includes/auth.php';
requireAdminLogin();

$pdo = require_once 'includes/db_connection.php';

// Handle filters and search
$search = $_GET['search'] ?? '';
$filterType = $_GET['filter_type'] ?? 'created_at';
$filterDate = $_GET['filter_date'] ?? '';
$regStartDate = $_GET['reg_start_date'] ?? '';
$regEndDate = $_GET['reg_end_date'] ?? '';
$progStartDate = $_GET['prog_start_date'] ?? '';
$progEndDate = $_GET['prog_end_date'] ?? '';
$statusFilter = $_GET['status_filter'] ?? '';

// Build query
$where = [];
$params = [];

if (!empty($search)) {
    $where[] = "program_name LIKE ?";
    $params[] = "%$search%";
}

if (!empty($filterDate) && $filterType == 'created_at') {
    $where[] = "DATE(created_at) = ?";
    $params[] = $filterDate;
}

if ($filterType == 'registration') {
    if (!empty($regStartDate)) {
        $where[] = "reg_start_date >= ?";
        $params[] = $regStartDate;
    }
    if (!empty($regEndDate)) {
        $where[] = "reg_end_date <= ?";
        $params[] = $regEndDate;
    }
}

if ($filterType == 'program') {
    if (!empty($progStartDate)) {
        $where[] = "program_start_date >= ?";
        $params[] = $progStartDate;
    }
    if (!empty($progEndDate)) {
        $where[] = "program_end_date <= ?";
        $params[] = $progEndDate;
    }
}

if (!empty($statusFilter) && ($statusFilter === '1' || $statusFilter === '0')) {
    $where[] = "isactive = ?";
    $params[] = intval($statusFilter);
}

$whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";
$query = "SELECT * FROM programs $whereClause ORDER BY created_at DESC";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $programs = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Programs Error: " . $e->getMessage());
    $programs = [];
}

$success = isset($_SESSION['program_success']) ? $_SESSION['program_success'] : false;
$error = isset($_SESSION['program_error']) ? $_SESSION['program_error'] : '';
$updateSuccess = isset($_SESSION['update_success']) ? $_SESSION['update_success'] : false;
unset($_SESSION['program_success']);
unset($_SESSION['program_error']);
unset($_SESSION['update_success']);

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

<?php if ($updateSuccess): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <i class="bi bi-check-circle me-2"></i>
  Program updated successfully!
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

<!-- Search and Filter Bar -->
<div class="glass-card p-3 mb-4" style="background: linear-gradient(135deg, rgba(138, 43, 226, 0.05) 0%, rgba(190, 100%, 50%, 0.05) 100%); border: 2px solid rgba(138, 43, 226, 0.1);">
  <div class="row g-2 align-items-center">
    <!-- Search Bar -->
    <div class="col-md-3">
      <div class="input-group">
        <span class="input-group-text" style="background: white; border-right: none; border-color: #e0e0e0;">
          <i class="bi bi-search" style="color: hsl(250, 70%, 55%);"></i>
        </span>
        <input type="text" class="form-control" id="search" placeholder="Search by program name..." style="border-left: none; border-color: #e0e0e0;" onkeyup="filterPrograms()">
      </div>
    </div>
    
    <!-- Status Filter Dropdown -->
    <div class="col-md-2">
      <select class="form-select" id="status_filter" onchange="filterPrograms()" style="border-color: #e0e0e0;">
        <option value="">All Status</option>
        <option value="1">Active</option>
        <option value="0">Inactive</option>
      </select>
    </div>
    
    <!-- Filter Type Dropdown -->
    <div class="col-md-2">
      <select class="form-select" id="filter_type" onchange="toggleFilterFields()" style="border-color: #e0e0e0;">
        <option value="created_at">Created At</option>
        <option value="registration">Registration Date</option>
        <option value="program">Program Period</option>
      </select>
    </div>
    
    <!-- Created At Date (Single) -->
    <div class="col-md-2" id="createdAtFilter">
      <input type="date" class="form-control" id="filter_date" style="border-color: #e0e0e0;" onchange="filterPrograms()">
    </div>
    
    <!-- Registration Date Range -->
    <div class="col-md-2" id="registrationFilter" style="display: none;">
      <input type="date" class="form-control" id="reg_start_date" placeholder="Start Date" style="border-color: #e0e0e0;" onchange="filterPrograms()">
    </div>
    <div class="col-md-2" id="registrationFilterEnd" style="display: none;">
      <input type="date" class="form-control" id="reg_end_date" placeholder="End Date" style="border-color: #e0e0e0;" onchange="filterPrograms()">
    </div>
    
    <!-- Program Period Date Range -->
    <div class="col-md-2" id="programFilter" style="display: none;">
      <input type="date" class="form-control" id="prog_start_date" placeholder="Start Date" style="border-color: #e0e0e0;" onchange="filterPrograms()">
    </div>
    <div class="col-md-2" id="programFilterEnd" style="display: none;">
      <input type="date" class="form-control" id="prog_end_date" placeholder="End Date" style="border-color: #e0e0e0;" onchange="filterPrograms()">
    </div>
    
    <!-- Action Buttons -->
    <div class="col-auto">
      <button type="button" class="btn btn-sm btn-purple" onclick="applyFilter()" title="Apply Filter">
        <i class="bi bi-check-lg"></i>
      </button>
    </div>
    <div class="col-auto">
      <button type="button" class="btn btn-sm btn-outline-secondary" onclick="resetFilter()" title="Reset Filter">
        <i class="bi bi-arrow-clockwise"></i>
      </button>
    </div>
  </div>
</div>

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
          <th>Sl No</th>
          <th>Program Name</th>
          <th>Status</th>
          <th>Registration Period</th>
          <th>Program Period</th>
          <th>Created</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php $slNo = 1; foreach ($programs as $program): ?>
        <tr>
          <td>
            <span class="text-muted"><?php echo $slNo++; ?></span>
          </td>
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
            <button class="btn btn-sm btn-purple-outline" onclick="viewProgram(<?php echo $program['id']; ?>)" title="View Details" style="padding: 0.375rem 0.5rem;">
              <i class="bi bi-eye"></i>
            </button>
            <button class="btn btn-sm btn-outline-secondary" onclick="editProgram(<?php echo $program['id']; ?>)" title="Edit Program" style="padding: 0.375rem 0.5rem;">
              <i class="bi bi-pencil"></i>
            </button>
            <button class="btn btn-sm btn-outline-success" onclick="shareFeedback(<?php echo $program['id']; ?>, this)" title="Share Feedback Link" style="padding: 0.375rem 0.5rem;">
              <i class="bi bi-share"></i>
            </button>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>

<!-- View Program Modal -->
<div class="modal fade" id="viewProgramModal" tabindex="-1" aria-labelledby="viewProgramModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content" style="border-radius: 1rem; border: none; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);">
      <div class="modal-header" style="background: linear-gradient(135deg, hsl(250, 70%, 55%) 0%, hsl(270, 80%, 60%) 100%); color: white; border-radius: 1rem 1rem 0 0; padding: 1.5rem;">
        <h5 class="modal-title fw-bold" id="viewProgramModalLabel" style="font-size: 1.5rem;">
          <i class="bi bi-eye me-2"></i>Program Details
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="filter: brightness(0) invert(1);"></button>
      </div>
      <div class="modal-body" style="max-height: 70vh; overflow-y: auto; padding: 2rem;" id="viewProgramContent">
        <!-- Content will be loaded via AJAX -->
        <div class="text-center py-5">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
      <div class="modal-footer" style="border-top: 2px solid #e0e0e0; padding: 1.5rem;">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Program Modal -->
<div class="modal fade" id="editProgramModal" tabindex="-1" aria-labelledby="editProgramModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content" style="border-radius: 1rem; border: none; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);">
      <div class="modal-header" style="background: linear-gradient(135deg, hsl(250, 70%, 55%) 0%, hsl(270, 80%, 60%) 100%); color: white; border-radius: 1rem 1rem 0 0; padding: 1.5rem;">
        <h5 class="modal-title fw-bold" id="editProgramModalLabel" style="font-size: 1.5rem;">
          <i class="bi bi-pencil me-2"></i>Edit Program
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="filter: brightness(0) invert(1);"></button>
      </div>
      <form action="backend/update_program.php" method="POST" id="editProgramForm">
        <input type="hidden" id="edit_program_id" name="program_id">
        <div class="modal-body" style="max-height: 70vh; overflow-y: auto; padding: 2rem;" id="editProgramContent">
          <!-- Content will be loaded via AJAX -->
          <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="border-top: 2px solid #e0e0e0; padding: 1.5rem; border-radius: 0 0 1rem 1rem;">
          <button type="button" class="btn btn-secondary px-4 py-2" data-bs-dismiss="modal" style="border-radius: 0.5rem; font-weight: 600;">
            <i class="bi bi-x-circle me-2"></i>Cancel
          </button>
          <button type="submit" class="btn-purple px-4 py-2" style="border-radius: 0.5rem; font-weight: 600;">
            <i class="bi bi-check-circle me-2"></i>Update Program
          </button>
        </div>
      </form>
    </div>
  </div>
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
                <textarea class="form-control" id="focus_areas" name="focus_areas" rows="6" placeholder="Enter each focus area on a new line" style="border-radius: 0.5rem; border: 2px solid #e0e0e0; resize: vertical; min-height: 120px;"></textarea>
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
                <textarea class="form-control" id="applications" name="applications" rows="6" placeholder="Enter each application on a new line" style="border-radius: 0.5rem; border: 2px solid #e0e0e0; resize: vertical; min-height: 120px;"></textarea>
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
// Form validation for add
document.getElementById('addProgramForm').addEventListener('submit', function(e) {
  const regStart = document.getElementById('reg_start_date').value;
  const regEnd = document.getElementById('reg_end_date').value;
  const progStart = document.getElementById('program_start_date').value;
  const progEnd = document.getElementById('program_end_date').value;
  
  if (regStart && regEnd && regStart > regEnd) {
    e.preventDefault();
    alert('Registration start date must be before end date!');
    return false;
  }
  
  if (progStart && progEnd && progStart > progEnd) {
    e.preventDefault();
    alert('Program start date must be before end date!');
    return false;
  }
});
</script>

<script>
// Store all programs data for JavaScript
const allProgramsData = <?php echo json_encode($programs); ?>;
let filteredPrograms = [...allProgramsData];

// Initialize filter type from URL or default
document.addEventListener('DOMContentLoaded', function() {
  const urlParams = new URLSearchParams(window.location.search);
  const filterType = urlParams.get('filter_type') || 'created_at';
  document.getElementById('filter_type').value = filterType;
  toggleFilterFields();
  
  // Restore filter values from URL
  if (urlParams.get('search')) {
    document.getElementById('search').value = urlParams.get('search');
  }
  if (urlParams.get('status_filter')) {
    document.getElementById('status_filter').value = urlParams.get('status_filter');
  }
  if (urlParams.get('filter_date')) {
    document.getElementById('filter_date').value = urlParams.get('filter_date');
  }
  if (urlParams.get('reg_start_date')) {
    document.getElementById('reg_start_date').value = urlParams.get('reg_start_date');
  }
  if (urlParams.get('reg_end_date')) {
    document.getElementById('reg_end_date').value = urlParams.get('reg_end_date');
  }
  if (urlParams.get('prog_start_date')) {
    document.getElementById('prog_start_date').value = urlParams.get('prog_start_date');
  }
  if (urlParams.get('prog_end_date')) {
    document.getElementById('prog_end_date').value = urlParams.get('prog_end_date');
  }
  
  filterPrograms();
});

function toggleFilterFields() {
  const filterType = document.getElementById('filter_type').value;
  
  // Hide all filter fields
  document.getElementById('createdAtFilter').style.display = 'none';
  document.getElementById('registrationFilter').style.display = 'none';
  document.getElementById('registrationFilterEnd').style.display = 'none';
  document.getElementById('programFilter').style.display = 'none';
  document.getElementById('programFilterEnd').style.display = 'none';
  
  // Show relevant fields
  if (filterType === 'created_at') {
    document.getElementById('createdAtFilter').style.display = 'block';
  } else if (filterType === 'registration') {
    document.getElementById('registrationFilter').style.display = 'block';
    document.getElementById('registrationFilterEnd').style.display = 'block';
  } else if (filterType === 'program') {
    document.getElementById('programFilter').style.display = 'block';
    document.getElementById('programFilterEnd').style.display = 'block';
  }
}

function filterPrograms() {
  const search = document.getElementById('search').value.toLowerCase();
  const filterType = document.getElementById('filter_type').value;
  const filterDate = document.getElementById('filter_date').value;
  const regStartDate = document.getElementById('reg_start_date').value;
  const regEndDate = document.getElementById('reg_end_date').value;
  const progStartDate = document.getElementById('prog_start_date').value;
  const progEndDate = document.getElementById('prog_end_date').value;
  const statusFilter = document.getElementById('status_filter').value;
  
  filteredPrograms = allProgramsData.filter(program => {
    // Search filter
    if (search && !program.program_name.toLowerCase().includes(search)) {
      return false;
    }
    
    // Status filter
    if (statusFilter !== '' && program.isactive != statusFilter) {
      return false;
    }
    
    // Created At filter
    if (filterType === 'created_at' && filterDate) {
      const programDate = new Date(program.created_at).toISOString().split('T')[0];
      if (programDate !== filterDate) return false;
    }
    
    // Registration Date filter
    if (filterType === 'registration') {
      if (regStartDate && program.reg_start_date && program.reg_start_date < regStartDate) {
        return false;
      }
      if (regEndDate && program.reg_end_date && program.reg_end_date > regEndDate) {
        return false;
      }
    }
    
    // Program Period filter
    if (filterType === 'program') {
      if (progStartDate && program.program_start_date && program.program_start_date < progStartDate) {
        return false;
      }
      if (progEndDate && program.program_end_date && program.program_end_date > progEndDate) {
        return false;
      }
    }
    
    return true;
  });
  
  renderTable();
}

function applyFilter() {
  filterPrograms();
  // Update URL without reload
  updateURL();
}

function resetFilter() {
  document.getElementById('search').value = '';
  document.getElementById('filter_type').value = 'created_at';
  document.getElementById('status_filter').value = '';
  document.getElementById('filter_date').value = '';
  document.getElementById('reg_start_date').value = '';
  document.getElementById('reg_end_date').value = '';
  document.getElementById('prog_start_date').value = '';
  document.getElementById('prog_end_date').value = '';
  
  toggleFilterFields();
  filteredPrograms = [...allProgramsData];
  renderTable();
  window.history.pushState({}, '', 'admin_programmes.php');
}

function updateURL() {
  const params = new URLSearchParams();
  const search = document.getElementById('search').value;
  const filterType = document.getElementById('filter_type').value;
  const statusFilter = document.getElementById('status_filter').value;
  const filterDate = document.getElementById('filter_date').value;
  const regStartDate = document.getElementById('reg_start_date').value;
  const regEndDate = document.getElementById('reg_end_date').value;
  const progStartDate = document.getElementById('prog_start_date').value;
  const progEndDate = document.getElementById('prog_end_date').value;
  
  if (search) params.set('search', search);
  if (filterType) params.set('filter_type', filterType);
  if (statusFilter) params.set('status_filter', statusFilter);
  if (filterDate) params.set('filter_date', filterDate);
  if (regStartDate) params.set('reg_start_date', regStartDate);
  if (regEndDate) params.set('reg_end_date', regEndDate);
  if (progStartDate) params.set('prog_start_date', progStartDate);
  if (progEndDate) params.set('prog_end_date', progEndDate);
  
  const queryString = params.toString();
  window.history.pushState({}, '', 'admin_programmes.php' + (queryString ? '?' + queryString : ''));
}

function renderTable() {
  const tbody = document.querySelector('table tbody');
  if (!tbody) return;
  
  if (filteredPrograms.length === 0) {
    tbody.innerHTML = `
      <tr>
        <td colspan="7" class="text-center py-5">
          <i class="bi bi-inbox" style="font-size: 2rem; color: var(--muted-foreground);"></i>
          <p class="text-muted mt-2">No programs found matching your criteria.</p>
        </td>
      </tr>
    `;
    return;
  }
  
  tbody.innerHTML = filteredPrograms.map((program, index) => {
    const statusBadge = program.isactive == 1 
      ? '<span class="badge bg-success">Active</span>' 
      : '<span class="badge bg-secondary">Inactive</span>';
    
    const regPeriod = program.reg_start_date && program.reg_end_date
      ? `${formatDate(program.reg_start_date)} - ${formatDate(program.reg_end_date)}`
      : '<span class="text-muted">Not set</span>';
    
    const progPeriod = program.program_start_date && program.program_end_date
      ? `${formatDate(program.program_start_date)} - ${formatDate(program.program_end_date)}`
      : '<span class="text-muted">Not set</span>';
    
    return `
      <tr>
        <td><span class="text-muted">${index + 1}</span></td>
        <td><strong>${escapeHtml(program.program_name)}</strong></td>
        <td>${statusBadge}</td>
        <td>${regPeriod}</td>
        <td>${progPeriod}</td>
        <td>${formatDate(program.created_at)}</td>
        <td>
          <button class="btn btn-sm btn-purple-outline" onclick="viewProgram(${program.id})" title="View Details" style="padding: 0.375rem 0.5rem;">
            <i class="bi bi-eye"></i>
          </button>
          <button class="btn btn-sm btn-outline-secondary" onclick="editProgram(${program.id})" title="Edit Program" style="padding: 0.375rem 0.5rem;">
            <i class="bi bi-pencil"></i>
          </button>
          <button class="btn btn-sm btn-outline-success" onclick="shareFeedback(${program.id}, this)" title="Share Feedback Link" style="padding: 0.375rem 0.5rem;">
            <i class="bi bi-share"></i>
          </button>
        </td>
      </tr>
    `;
  }).join('');
}

function formatDate(dateString) {
  if (!dateString) return 'Not set';
  const date = new Date(dateString);
  return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
}

function viewProgram(id) {
  const program = allProgramsData.find(p => p.id == id);
  if (!program) return;
  
  const content = `
    <div class="row g-4">
      <div class="col-12">
        <h4 class="fw-bold mb-3" style="color: hsl(250, 70%, 55%);">${escapeHtml(program.program_name)}</h4>
      </div>
      
      <div class="col-md-6">
        <div class="mb-4">
          <label class="form-label fw-semibold">
            <i class="bi bi-list-check me-2" style="color: hsl(250, 70%, 55%);"></i>Programmes / Focus Areas
          </label>
          <div class="glass-card p-3" style="background: #f8f9fa; min-height: 100px;">
            ${program.focus_areas ? nl2br(escapeHtml(program.focus_areas)) : '<span class="text-muted">Not specified</span>'}
          </div>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="mb-4">
          <label class="form-label fw-semibold">
            <i class="bi bi-app me-2" style="color: hsl(250, 70%, 55%);"></i>Applications
          </label>
          <div class="glass-card p-3" style="background: #f8f9fa; min-height: 100px;">
            ${program.applications ? nl2br(escapeHtml(program.applications)) : '<span class="text-muted">Not specified</span>'}
          </div>
        </div>
      </div>
      
      <div class="col-12">
        <div class="mb-4">
          <label class="form-label fw-semibold">
            <i class="bi bi-trophy me-2" style="color: hsl(250, 70%, 55%);"></i>Outcome
          </label>
          <div class="glass-card p-3" style="background: #f8f9fa; min-height: 80px;">
            ${program.outcome ? nl2br(escapeHtml(program.outcome)) : '<span class="text-muted">Not specified</span>'}
          </div>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="glass-card p-4" style="background: #f8f9fa;">
          <h6 class="fw-bold mb-3" style="color: hsl(250, 70%, 55%);">
            <i class="bi bi-calendar-check me-2"></i>Registration Period
          </h6>
          <p class="mb-1"><strong>Start:</strong> ${program.reg_start_date ? formatDate(program.reg_start_date) : 'Not set'}</p>
          <p class="mb-0"><strong>End:</strong> ${program.reg_end_date ? formatDate(program.reg_end_date) : 'Not set'}</p>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="glass-card p-4" style="background: #f8f9fa;">
          <h6 class="fw-bold mb-3" style="color: hsl(250, 70%, 55%);">
            <i class="bi bi-calendar-event me-2"></i>Program Period
          </h6>
          <p class="mb-1"><strong>Start:</strong> ${program.program_start_date ? formatDate(program.program_start_date) : 'Not set'}</p>
          <p class="mb-0"><strong>End:</strong> ${program.program_end_date ? formatDate(program.program_end_date) : 'Not set'}</p>
        </div>
      </div>
      
      <div class="col-12">
        <div class="d-flex gap-3">
          <div><strong>Status:</strong> 
            <span class="badge ${program.isactive == 1 ? 'bg-success' : 'bg-secondary'}">
              ${program.isactive == 1 ? 'Active' : 'Inactive'}
            </span>
          </div>
          <div><strong>Created:</strong> ${formatDate(program.created_at)}</div>
        </div>
      </div>
    </div>
  `;
  
  document.getElementById('viewProgramContent').innerHTML = content;
  new bootstrap.Modal(document.getElementById('viewProgramModal')).show();
}

function shareFeedback(programId, buttonElement) {
  // Get the base URL (protocol + host + path without filename)
  const pathParts = window.location.pathname.split('/');
  pathParts.pop(); // Remove the current filename (admin_programmes.php)
  const basePath = pathParts.join('/') + '/';
  const baseUrl = window.location.origin + basePath;
  // Use 'feedback' without .php extension (works with URL rewriting)
  const feedbackUrl = baseUrl + 'feedback?id=' + programId;
  
  // Copy to clipboard
  navigator.clipboard.writeText(feedbackUrl).then(() => {
    // Update button state
    if (buttonElement) {
      const originalHTML = buttonElement.innerHTML;
      const icon = buttonElement.querySelector('i');
      buttonElement.innerHTML = '<i class="bi bi-check-circle"></i>';
      buttonElement.classList.remove('btn-outline-success');
      buttonElement.classList.add('btn-success');
      buttonElement.title = 'Feedback link copied!';
      
      // Show toast notification
      showToast('Feedback link copied to clipboard!', 'success');
      
      // Reset button after 2 seconds
      setTimeout(() => {
        buttonElement.innerHTML = originalHTML;
        buttonElement.classList.remove('btn-success');
        buttonElement.classList.add('btn-outline-success');
        buttonElement.title = 'Share Feedback Link';
      }, 2000);
    } else {
      showToast('Feedback link copied to clipboard!', 'success');
    }
  }).catch(() => {
    // Fallback: show error toast
    showToast('Failed to copy link. Please copy manually: ' + feedbackUrl, 'error');
  });
}

function showToast(message, type) {
  // Remove existing toast if any
  const existingToast = document.getElementById('shareToast');
  if (existingToast) {
    existingToast.remove();
  }
  
  // Create toast element
  const toast = document.createElement('div');
  toast.id = 'shareToast';
  toast.className = `toast-notification toast-${type}`;
  toast.innerHTML = `
    <div class="toast-content">
      <i class="bi ${type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-circle-fill'}"></i>
      <span>${message}</span>
    </div>
  `;
  
  // Add styles
  toast.style.cssText = `
    position: fixed;
    top: 20px;
    right: 20px;
    background: ${type === 'success' ? '#28a745' : '#dc3545'};
    color: white;
    padding: 1rem 1.5rem;
    border-radius: 0.5rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    z-index: 10000;
    animation: slideInRight 0.3s ease-out;
    max-width: 400px;
  `;
  
  // Add animation
  const style = document.createElement('style');
  style.textContent = `
    @keyframes slideInRight {
      from {
        transform: translateX(100%);
        opacity: 0;
      }
      to {
        transform: translateX(0);
        opacity: 1;
      }
    }
    @keyframes slideOutRight {
      from {
        transform: translateX(0);
        opacity: 1;
      }
      to {
        transform: translateX(100%);
        opacity: 0;
      }
    }
    .toast-content {
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    .toast-content i {
      font-size: 1.25rem;
    }
  `;
  if (!document.getElementById('toastStyles')) {
    style.id = 'toastStyles';
    document.head.appendChild(style);
  }
  
  document.body.appendChild(toast);
  
  // Auto remove after 3 seconds
  setTimeout(() => {
    toast.style.animation = 'slideOutRight 0.3s ease-out';
    setTimeout(() => {
      toast.remove();
    }, 300);
  }, 3000);
}

function editProgram(id) {
  const program = allProgramsData.find(p => p.id == id);
  if (!program) return;
  
  const content = `
    <div class="mb-4">
      <label for="edit_program_name" class="form-label fw-semibold">
        <i class="bi bi-book me-2" style="color: hsl(250, 70%, 55%);"></i>
        Program Name <span class="text-danger">*</span>
      </label>
      <input type="text" class="form-control form-control-lg" id="edit_program_name" name="program_name" required value="${escapeHtml(program.program_name)}" style="border-radius: 0.5rem; border: 2px solid #e0e0e0;">
    </div>
    
    <div class="row g-4">
      <div class="col-lg-6">
        <div class="mb-4">
          <label for="edit_focus_areas" class="form-label fw-semibold">
            <i class="bi bi-list-check me-2" style="color: hsl(250, 70%, 55%);"></i>Programmes / Focus Areas
          </label>
          <textarea class="form-control" id="edit_focus_areas" name="focus_areas" rows="6" style="border-radius: 0.5rem; border: 2px solid #e0e0e0; resize: vertical;">${escapeHtml(program.focus_areas || '')}</textarea>
        </div>
        
        <div class="mb-4">
          <label for="edit_applications" class="form-label fw-semibold">
            <i class="bi bi-app me-2" style="color: hsl(250, 70%, 55%);"></i>Applications
          </label>
          <textarea class="form-control" id="edit_applications" name="applications" rows="6" style="border-radius: 0.5rem; border: 2px solid #e0e0e0; resize: vertical;">${escapeHtml(program.applications || '')}</textarea>
        </div>
      </div>
      
      <div class="col-lg-6">
        <div class="mb-4">
          <label for="edit_outcome" class="form-label fw-semibold">
            <i class="bi bi-trophy me-2" style="color: hsl(250, 70%, 55%);"></i>Outcome
          </label>
          <textarea class="form-control" id="edit_outcome" name="outcome" rows="6" style="border-radius: 0.5rem; border: 2px solid #e0e0e0; resize: vertical;">${escapeHtml(program.outcome || '')}</textarea>
        </div>
        
        <div class="mb-4">
          <label class="form-label fw-semibold d-block mb-2">
            <i class="bi bi-toggle-on me-2" style="color: hsl(250, 70%, 55%);"></i>Program Status
          </label>
          <div class="form-check form-switch" style="font-size: 1.1rem;">
            <input class="form-check-input" type="checkbox" id="edit_isactive" name="isactive" value="1" ${program.isactive == 1 ? 'checked' : ''} style="width: 3rem; height: 1.5rem;">
            <label class="form-check-label ms-3" for="edit_isactive">
              <strong>Active Program</strong>
            </label>
          </div>
        </div>
      </div>
    </div>
    
    <div class="row g-4 mt-2">
      <div class="col-lg-6">
        <div class="glass-card p-4" style="background: #f8f9fa; border: 2px solid #e0e0e0;">
          <h6 class="fw-bold mb-3" style="color: hsl(250, 70%, 55%);">
            <i class="bi bi-calendar-check me-2"></i>Registration Period
          </h6>
          <div class="row g-3">
            <div class="col-12">
              <label for="edit_reg_start_date" class="form-label fw-semibold">Start Date</label>
              <input type="date" class="form-control" id="edit_reg_start_date" name="reg_start_date" value="${program.reg_start_date || ''}" style="border-radius: 0.5rem; border: 2px solid #e0e0e0;">
            </div>
            <div class="col-12">
              <label for="edit_reg_end_date" class="form-label fw-semibold">End Date</label>
              <input type="date" class="form-control" id="edit_reg_end_date" name="reg_end_date" value="${program.reg_end_date || ''}" style="border-radius: 0.5rem; border: 2px solid #e0e0e0;">
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-lg-6">
        <div class="glass-card p-4" style="background: #f8f9fa; border: 2px solid #e0e0e0;">
          <h6 class="fw-bold mb-3" style="color: hsl(250, 70%, 55%);">
            <i class="bi bi-calendar-event me-2"></i>Program Period
          </h6>
          <div class="row g-3">
            <div class="col-12">
              <label for="edit_program_start_date" class="form-label fw-semibold">Start Date</label>
              <input type="date" class="form-control" id="edit_program_start_date" name="program_start_date" value="${program.program_start_date || ''}" style="border-radius: 0.5rem; border: 2px solid #e0e0e0;">
            </div>
            <div class="col-12">
              <label for="edit_program_end_date" class="form-label fw-semibold">End Date</label>
              <input type="date" class="form-control" id="edit_program_end_date" name="program_end_date" value="${program.program_end_date || ''}" style="border-radius: 0.5rem; border: 2px solid #e0e0e0;">
            </div>
          </div>
        </div>
      </div>
    </div>
  `;
  
  document.getElementById('edit_program_id').value = program.id;
  document.getElementById('editProgramContent').innerHTML = content;
  new bootstrap.Modal(document.getElementById('editProgramModal')).show();
}

function escapeHtml(text) {
  if (!text) return '';
  const map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
  };
  return text.replace(/[&<>"']/g, m => map[m]);
}

function nl2br(text) {
  if (!text) return '';
  return text.replace(/\n/g, '<br>');
}

function formatDate(dateString) {
  if (!dateString) return 'Not set';
  const date = new Date(dateString);
  return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
}

// Form validation for edit
document.getElementById('editProgramForm')?.addEventListener('submit', function(e) {
  const regStart = document.getElementById('edit_reg_start_date').value;
  const regEnd = document.getElementById('edit_reg_end_date').value;
  const progStart = document.getElementById('edit_program_start_date').value;
  const progEnd = document.getElementById('edit_program_end_date').value;
  
  if (regStart && regEnd && regStart > regEnd) {
    e.preventDefault();
    alert('Registration start date must be before end date!');
    return false;
  }
  
  if (progStart && progEnd && progStart > progEnd) {
    e.preventDefault();
    alert('Program start date must be before end date!');
    return false;
  }
});
</script>

<?php include 'includes/admin_footer.php'; ?>
