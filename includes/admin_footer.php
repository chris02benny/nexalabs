      </div>
    </main>
  </div>
  
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- Custom JS -->
  <script src="assets/js/main.js"></script>
  
  <script>
    // Sidebar Toggle Functionality
    function toggleSidebar() {
      const sidebar = document.getElementById('adminSidebar');
      const main = document.getElementById('adminMain');
      const toggleIcon = document.getElementById('sidebarToggleIcon');
      
      sidebar.classList.toggle('collapsed');
      main.classList.toggle('sidebar-collapsed');
      
      // Change icon - hamburger when collapsed, X when expanded
      if (sidebar.classList.contains('collapsed')) {
        toggleIcon.className = 'bi bi-list';
      } else {
        toggleIcon.className = 'bi bi-x-lg';
      }
      
      // Save state to localStorage
      localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
    }
    
    // Load sidebar state on page load
    document.addEventListener('DOMContentLoaded', function() {
      const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
      if (isCollapsed) {
        const sidebar = document.getElementById('adminSidebar');
        const main = document.getElementById('adminMain');
        const toggleIcon = document.getElementById('sidebarToggleIcon');
        
        sidebar.classList.add('collapsed');
        main.classList.add('sidebar-collapsed');
        toggleIcon.className = 'bi bi-list';
      }
    });
    
    // Mobile menu toggle
    function toggleMobileMenu() {
      const sidebar = document.getElementById('adminSidebar');
      const overlay = document.getElementById('sidebarOverlay');
      const menuIcon = document.getElementById('mobileMenuIcon');
      
      sidebar.classList.toggle('mobile-open');
      overlay.classList.toggle('active');
      
      // Change icon
      if (sidebar.classList.contains('mobile-open')) {
        menuIcon.className = 'bi bi-x-lg';
      } else {
        menuIcon.className = 'bi bi-list';
      }
    }
    
    // Close mobile menu
    function closeMobileMenu() {
      const sidebar = document.getElementById('adminSidebar');
      const overlay = document.getElementById('sidebarOverlay');
      const menuIcon = document.getElementById('mobileMenuIcon');
      
      sidebar.classList.remove('mobile-open');
      overlay.classList.remove('active');
      menuIcon.className = 'bi bi-list';
    }
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
      const sidebar = document.getElementById('adminSidebar');
      const mobileToggle = document.getElementById('mobileMenuToggle');
      const overlay = document.getElementById('sidebarOverlay');
      
      if (window.innerWidth <= 768) {
        if (!sidebar.contains(event.target) && 
            !mobileToggle.contains(event.target) && 
            event.target !== overlay) {
          closeMobileMenu();
        }
      }
    });
    
    // Close mobile menu when window is resized to desktop
    window.addEventListener('resize', function() {
      if (window.innerWidth > 768) {
        closeMobileMenu();
      }
    });
    
    // Close mobile menu when menu item is clicked
    document.querySelectorAll('.menu-item').forEach(function(item) {
      item.addEventListener('click', function() {
        if (window.innerWidth <= 768) {
          setTimeout(closeMobileMenu, 300);
        }
      });
    });
  </script>
</body>
</html>

