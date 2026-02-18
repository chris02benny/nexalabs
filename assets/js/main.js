// NEXA FUTURE READY LAB - Main JavaScript

// Mobile Navigation Toggle
document.addEventListener('DOMContentLoaded', function () {
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarNav = document.querySelector('.navbar-nav');

    if (navbarToggler && navbarNav) {
        navbarToggler.addEventListener('click', function () {
            navbarNav.classList.toggle('show');
            navbarToggler.classList.toggle('active');
        });

        // Close menu when clicking outside
        document.addEventListener('click', function (event) {
            if (!event.target.closest('.navbar')) {
                navbarNav.classList.remove('show');
                navbarToggler.classList.remove('active');
            }
        });
    }

    // Scroll-triggered animations using Intersection Observer
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe all elements with data-animate attribute
    document.querySelectorAll('[data-animate]').forEach(el => {
        observer.observe(el);
    });

    // Form validation enhancement
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
            let isValid = true;

            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.style.borderColor = 'hsl(0, 84%, 60%)';
                } else {
                    input.style.borderColor = '';
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});

// Floating element animation helper
function initFloatingElements() {
    const floatingElements = document.querySelectorAll('.floating-element');
    floatingElements.forEach((el, index) => {
        el.style.animationDelay = `${index * 0.5}s`;
    });
}

// Spotlight Card Effect
function initSpotlightCards() {
    const spotlightCards = document.querySelectorAll('.program-detail-card, .learner-group-card');

    spotlightCards.forEach(card => {
        card.addEventListener('mousemove', function (e) {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            card.style.setProperty('--mouse-x', `${x}px`);
            card.style.setProperty('--mouse-y', `${y}px`);
        });

        // Reset position when mouse leaves
        card.addEventListener('mouseleave', function () {
            card.style.setProperty('--mouse-x', '50%');
            card.style.setProperty('--mouse-y', '50%');
        });
    });
}

// Swiper Initialization
function initLearnerGroupsSwiper() {
    if (document.querySelector('.learnerGroupsSwiper')) {
        new Swiper('.learnerGroupsSwiper', {
            slidesPerView: 1,
            spaceBetween: 40,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.learner-groups-next',
                prevEl: '.learner-groups-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            }
        });
    }
}

// Initialize on page load
window.addEventListener('load', function () {
    initFloatingElements();
    initSpotlightCards();
    initLearnerGroupsSwiper();
});

// Display Program Modal from Database
function displayProgramModal(program) {
    const focusAreas = program.focus_areas_array || [];
    const applications = program.applications_array || [];
    
    // Set modal content
    document.getElementById('modalTitle').textContent = program.program_name;
    document.getElementById('modalIcon').className = 'bi bi-book';
    document.getElementById('modalOutcome').textContent = program.outcome || '';

    // Format and display dates
    const regStart = program.reg_start_date;
    const regEnd = program.reg_end_date;
    const progStart = program.program_start_date;
    const progEnd = program.program_end_date;
    
    // Registration Period
    const regPeriodEl = document.getElementById('modalRegPeriod');
    const regPeriodDatesEl = document.getElementById('modalRegPeriodDates');
    if (regStart && regEnd) {
        const startDate = new Date(regStart).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        const endDate = new Date(regEnd).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        regPeriodDatesEl.innerHTML = `${startDate} - ${endDate}`;
        regPeriodEl.style.display = 'block';
    } else {
        regPeriodEl.style.display = 'none';
    }
    
    // Course Period
    const coursePeriodEl = document.getElementById('modalCoursePeriod');
    const coursePeriodDatesEl = document.getElementById('modalCoursePeriodDates');
    if (progStart && progEnd) {
        const startDate = new Date(progStart).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        const endDate = new Date(progEnd).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        coursePeriodDatesEl.innerHTML = `${startDate} - ${endDate}`;
        coursePeriodEl.style.display = 'block';
    } else {
        coursePeriodEl.style.display = 'none';
    }
    
    // Duration
    const durationEl = document.getElementById('modalDuration');
    const durationDaysEl = document.getElementById('modalDurationDays');
    if (progStart && progEnd) {
        const start = new Date(progStart);
        const end = new Date(progEnd);
        const diffTime = Math.abs(end - start);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
        durationDaysEl.textContent = `${diffDays} ${diffDays === 1 ? 'Day' : 'Days'}`;
        durationEl.style.display = 'block';
    } else {
        durationEl.style.display = 'none';
    }
    
    // Show program info section if any date info exists
    const programInfoEl = document.getElementById('modalProgramInfo');
    if ((regStart && regEnd) || (progStart && progEnd)) {
        programInfoEl.style.display = 'block';
    } else {
        programInfoEl.style.display = 'none';
    }

    // Populate focus areas
    const focusAreasList = document.getElementById('modalFocusAreas');
    focusAreasList.innerHTML = '';
    if (focusAreas.length > 0) {
        focusAreas.forEach(area => {
            const li = document.createElement('li');
            li.textContent = area;
            focusAreasList.appendChild(li);
        });
    } else {
        focusAreasList.innerHTML = '<li class="text-muted">Not specified</li>';
    }

    // Populate applications
    const applicationsList = document.getElementById('modalApplications');
    applicationsList.innerHTML = '';
    if (applications.length > 0) {
        applications.forEach(app => {
            const li = document.createElement('li');
            li.textContent = app;
            applicationsList.appendChild(li);
        });
    } else {
        applicationsList.innerHTML = '<li class="text-muted">Not specified</li>';
    }

    // Show modal using Bootstrap
    const modalInstance = new bootstrap.Modal(document.getElementById('programModal'));
    modalInstance.show();
}

// Open Program Modal
function openProgramModal(programId) {
    // Convert to number if it's a string
    const id = parseInt(programId);
    
    // If programId is a valid number, fetch from database via AJAX
    if (!isNaN(id) && id > 0) {
        fetch(`get_program_details.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayProgramModal(data.program);
                } else {
                    alert('Program details not found.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error loading program details.');
            });
        return;
    }
    
    // Legacy support for index-based modals (fallback)
    const dataElement = document.getElementById(`program-data-${programId}`);
    if (!dataElement) {
        console.error('Program data element not found for ID:', programId);
        return;
    }

    const title = dataElement.querySelector('.program-modal-title')?.textContent || '';
    const icon = dataElement.querySelector('.program-modal-icon')?.textContent || 'book';
    const color = dataElement.querySelector('.program-modal-color')?.textContent || 'purple';
    const focusAreasEl = dataElement.querySelector('.program-modal-focus-areas');
    const applicationsEl = dataElement.querySelector('.program-modal-applications');
    const outcomeEl = dataElement.querySelector('.program-modal-outcome');
    
    if (!focusAreasEl || !applicationsEl || !outcomeEl) {
        console.error('Modal data elements not found');
        return;
    }

    const focusAreas = JSON.parse(focusAreasEl.textContent);
    const applications = JSON.parse(applicationsEl.textContent);
    const outcome = outcomeEl.textContent;

    // Set modal content
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalIcon').className = `bi bi-${icon}`;
    document.getElementById('modalOutcome').textContent = outcome;

    // Set color theme
    const modal = document.getElementById('programModal');
    if (modal) {
        modal.setAttribute('data-color', color);
    }

    // Populate focus areas
    const focusAreasList = document.getElementById('modalFocusAreas');
    if (focusAreasList) {
        focusAreasList.innerHTML = '';
        focusAreas.forEach(area => {
            const li = document.createElement('li');
            li.textContent = area;
            focusAreasList.appendChild(li);
        });
    }

    // Populate applications
    const applicationsList = document.getElementById('modalApplications');
    if (applicationsList) {
        applicationsList.innerHTML = '';
        applications.forEach(app => {
            const li = document.createElement('li');
            li.textContent = app;
            applicationsList.appendChild(li);
        });
    }

    // Show modal using Bootstrap
    const modalElement = document.getElementById('programModal');
    if (modalElement) {
        const modalInstance = new bootstrap.Modal(modalElement);
        modalInstance.show();
    }
}
